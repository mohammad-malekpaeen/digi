<?php

namespace App\Http\Controllers\API;

use App\Contracts\Mediator\DtoMediatorContract;
use App\Contracts\Services\OtpServiceContract;
use App\Contracts\Services\UserServiceContract;
use App\Enum\FieldEnum;
use App\Exceptions\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Auth\LoginRequest;
use App\Http\Requests\API\Auth\RegisterRequest;
use App\Http\Requests\API\Auth\ResetPasswordRequest;
use App\Http\Requests\BaseRequest;
use App\Http\Resources\API\Auth\LoginResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct(
        protected DtoMediatorContract $dtoMediator,
        protected UserServiceContract $userService,
        protected OtpServiceContract  $otpService,
    )
    {
    }

    public function login(LoginRequest $request): LoginResource
    {
        $token = $this->LoginByJwt($request);

        return LoginResource::make([
            'message' => trans('message.login-success'),
            'user' => JWTAuth::user(),
            'token' => $token,
        ]);
    }

    public function register(RegisterRequest $request): LoginResource
    {
        $userDto = $this->dtoMediator->convertDataToUserDto(
            email: $request->getInputEmail()
        );

        $user = $this->userService->findOrCreateByEmail($userDto);

        throw_if(empty($user),ModelNotFoundException::class); //User Not Found

        $isRegisteredBefore = !empty(data_get($user, FieldEnum::name->value)) &&
                              !empty(data_get($user, FieldEnum::password->value));

        throw_if($isRegisteredBefore,ModelNotFoundException::class); //User is Registered Before Please Login

        if ($this->otpService->check($request->getInputEmail(), $request->getInputCode())) {

            $userDto->setName($request->getInputName())
                    ->setPassword($request->getInputPassword());


            $this->userService->updateByEmail($userDto);

            RateLimiter::clear($request->getInputEmail());

            $token = $this->LoginByJwt($request);

            return LoginResource::make([
                'message' => trans('message.register-success'),
                'user' => JWTAuth::user(),
                'token' => $token,
            ]);

        }

        return throw new ModelNotFoundException(); //Otp is Not Correct
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {

        $email = $request->input(FieldEnum::email->name);
        $code = $request->input(FieldEnum::code->name);
        $password = $request->input(FieldEnum::password->name);

        $userDto = $this->dtoMediator->convertDataToUserDto(
            email: $request->getInputEmail()
        );

        if ($this->otpService->check($request->getInputEmail(), $code)) {
            $user = $this->userService->findOrCreateByEmail($userDto);
            $userDto->setPassword($password);
            $this->userService->updateByEmail($userDto);

            RateLimiter::clear($request->getInputEmail());

            return response()->json([
                'message' => 'Successfully Reset Password',
            ]);
        }
        return response()->json([
            'message' => 'Not Found Valid OTP',
        ]);
    }

    private function LoginByJwt(BaseRequest $request){
        $token = JWTAuth::attempt($request->only(
            FieldEnum::email->value,
            FieldEnum::password->value)
        );
        throw_if(!$token,ModelNotFoundException::class); //Invalid credentials
        return $token;
    }


    public function logout(): JsonResponse
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json([
            'message' => trans('message.logout-success'),
        ]);
    }
}

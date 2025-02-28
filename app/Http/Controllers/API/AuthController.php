<?php

namespace App\Http\Controllers\API;

use App\Contracts\Mediator\DtoMediatorContract;
use App\Contracts\Services\OtpServiceContract;
use App\Contracts\Services\UserServiceContract;
use App\Enum\FieldEnum;
use App\Exceptions\OtpInvalidException;
use App\Exceptions\UserInvalidCredentialException;
use App\Exceptions\UserNotFoundException;
use App\Exceptions\UserRegisteredException;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Auth\LoginRequest;
use App\Http\Requests\API\Auth\RegisterRequest;
use App\Http\Requests\API\Auth\ResetPasswordRequest;
use App\Http\Requests\BaseRequest;
use App\Http\Resources\API\Auth\LoginResource;
use Illuminate\Http\JsonResponse;
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

    /**
     * @throws OtpInvalidException
     */
    public function register(RegisterRequest $request): LoginResource
    {
        $userDto = $this->dtoMediator->convertDataToUserDto(
            email: $request->getInputEmail()
        );

        $user = $this->userService->findOrCreateByEmail($userDto);

        throw_if(empty($user), UserNotFoundException::class);

        $isRegisteredBefore = !empty(data_get($user, FieldEnum::name->value)) &&
            !empty(data_get($user, FieldEnum::password->value));

        throw_if($isRegisteredBefore, UserRegisteredException::class);

        if ($this->otpService->check($request->getInputEmail(), $request->getInputCode())) {

            $userDto->setName($request->getInputName())->setPassword($request->getInputPassword());

            $this->userService->updateByEmail($userDto);

            RateLimiter::clear($request->getInputEmail());

            $token = $this->LoginByJwt($request);

            return LoginResource::make([
                'message' => trans('message.register-success'),
                'user' => JWTAuth::user(),
                'token' => $token,
            ]);

        }

        return throw new OtpInvalidException();
    }

    /**
     * @throws OtpInvalidException
     */
    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $userDto = $this->dtoMediator->convertDataToUserDto(
            email: $request->getInputEmail()
        );

        if ($this->otpService->check($request->getInputEmail(), $request->getInputCode())) {
            $userDto->setPassword($request->getInputPassword());
            $this->userService->updateByEmail($userDto);

            RateLimiter::clear($request->getInputEmail());

            return response()->json([
                'message' => trans('message.reset-success'),
            ]);
        }

        return throw new OtpInvalidException();
    }

    private function LoginByJwt(BaseRequest $request)
    {
        $token = JWTAuth::attempt($request->only(
            FieldEnum::email->value,
            FieldEnum::password->value)
        );
        throw_if(!$token, UserInvalidCredentialException::class);

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

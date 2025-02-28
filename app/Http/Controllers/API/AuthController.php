<?php

namespace App\Http\Controllers\API;

use App\Contracts\Mediator\DtoMediatorContract;
use App\Contracts\Services\OtpServiceContract;
use App\Contracts\Services\UserServiceContract;
use App\Enum\FieldEnum;
use App\Exceptions\BaseException;
use App\Exceptions\ModelNotFoundException;
use App\Http\Controllers\Controller;
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

    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');
        $token = JWTAuth::attempt($credentials);
        if (!$token) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        return response()->json([
            'message' => 'Login successful',
            'user' => JWTAuth::user(),
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ],
        ]);
    }

    public function register(Request $request): JsonResponse
    {
        $request->validate([
            FieldEnum::name->name => 'required|string|max:255',
            FieldEnum::email->name => 'required|string|email|max:255|exists:users,email',
            FieldEnum::password->name => 'required|string|min:3',
            FieldEnum::code->name => 'required|string|min:6',
        ]);

        $name = $request->input(FieldEnum::name->name);
        $email = $request->input(FieldEnum::email->name);
        $code = $request->input(FieldEnum::code->name);
        $password = $request->input(FieldEnum::password->name);

        $userDto = $this->dtoMediator->convertDataToUserDto(
            email: $email
        );

        $user = $this->userService->findOrCreateByEmail($userDto);
        if(empty($user)){
            return response()->json([
                'message' => 'User Not Found',
            ]);
          //  throw_if(empty($user), ModelNotFoundException::class);
        }

        if(!empty(data_get($user,FieldEnum::name->value)) && !empty(data_get($user,FieldEnum::password->value))){
            return response()->json([
                'message' => 'User is Registered Before Please Login',
            ]);
        }

        if ($this->otpService->check($email, $code)) {
            $userDto->setName($name);
            $userDto->setPassword($password);
            $this->userService->updateByEmail($userDto);

            //Auth::login($user);
            RateLimiter::clear($email);

            return response()->json([
                'user' => $user,
                'authorization' => [
                    'token' => JWTAuth::fromUser($user),
                    'type' => 'bearer',
                ],
            ]);
        }
        return response()->json([
            'message' => 'Otp is Not Correct',
        ]);
    }

    public function logout(): JsonResponse
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }

    public function resetPassword(Request $request): JsonResponse
    {
        $request->validate([
            FieldEnum::email->name => 'required|string|email|max:255|unique:users',
            FieldEnum::password->name => 'required|string|min:3',
            FieldEnum::code->name => 'required|string|min:6',
        ]);

        $email = $request->input(FieldEnum::email->name);
        $code = $request->input(FieldEnum::code->name);
        $password = $request->input(FieldEnum::password->name);

        $userDto = $this->dtoMediator->convertDataToUserDto(
            email: $email
        );

        if ($this->otpService->check($email, $code)) {
            $user = $this->userService->findOrCreateByEmail($userDto);
            $userDto->setPassword($password);
            $this->userService->updateByEmail($userDto);

            RateLimiter::clear($email);

            return response()->json([
                'message' => 'Successfully Reset Password',
            ]);
        }
        return response()->json([
            'message' => 'Not Found Valid OTP',
        ]);
    }
}

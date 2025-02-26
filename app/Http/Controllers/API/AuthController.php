<?php

namespace App\Http\Controllers\API;

use App\Contracts\Mediator\DtoMediatorContract;
use App\Contracts\Services\OtpServiceContract;
use App\Contracts\Services\UserServiceContract;
use App\Enum\FieldEnum;
use App\Exceptions\BaseException;
use App\Exceptions\ModelNotFoundException;
use App\Facades\StringFacade;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            FieldEnum::family->name => 'required|string|max:255',
            FieldEnum::email->name => 'required|string|email|max:255|unique:users',
            FieldEnum::password->name => 'required|string|min:3',
            FieldEnum::code->name => 'required|string|min:4',
        ]);

        $email = $request->input(FieldEnum::email->name);
        $code = $request->input(FieldEnum::code->name);

        if ($this->otpService->check($email, $code)) {
            $user = $this->userService->findOrCreateByEmail(
                $this->dtoMediator->convertDataToUserDto(
                    email: $email
                )
            );
            throw_if(empty($user), ModelNotFoundException::class);
            $user->update(
                [
                    FieldEnum::name->name =>
                       StringFacade::normalizePersianAndArabicCharacters($request->input(FieldEnum::name->name)) ,
                    FieldEnum::family->name =>
                        StringFacade::normalizePersianAndArabicCharacters($request->input(FieldEnum::family->name)),
                    FieldEnum::email->name => $request->input(FieldEnum::email->name),
                    FieldEnum::password->name => $request->input(FieldEnum::password->name),
                ]
            );

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
      return throw new BaseException::class ;
    }

    public function logout(): JsonResponse
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }

    public function reset(Request $request): JsonResponse
    {
        $request->validate([
            FieldEnum::email->name => 'required|string|email|max:255|unique:users',
            FieldEnum::password->name => 'required|string|min:3',
            FieldEnum::code->name => 'required|string|min:4',
        ]);

        $email = $request->input(FieldEnum::email->name);
        $code = $request->input(FieldEnum::code->name);

        if ($this->otpService->check($email, $code)) {
            $userDto = $this->dtoMediator->convertDataToUserDto(
                email: $email
            );
            $user = $this->userService->findByCondition(
                conditions: [
                    FieldEnum::email->value => $userDto->getEmail()
                ]
            );

            $user->update(
                [
                    FieldEnum::password->name => $request->input(FieldEnum::password->name),
                ]
            );

            RateLimiter::clear($email);

            return response()->json([
                'message' => 'Successfully Reset Password',
            ]);
        }
        return throw new BaseException::class ;
    }
}

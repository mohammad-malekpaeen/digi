<?php

namespace App\Http\Controllers\API;

use App\Contracts\Mediator\DtoMediatorContract;
use App\Contracts\Services\OtpServiceContract;
use App\Contracts\Services\UserServiceContract;
use App\Enum\FieldEnum;
use App\Exceptions\ModelNotFoundException;
use App\Facades\StringFacade;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

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
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            return response()->json([
                'user' => $user,
                'authorization' => [
                    'token' => $user->createToken('ApiToken')->plainTextToken,
                    'type' => 'bearer',
                ],
            ]);
        }

        return response()->json([
            'message' => 'Invalid credentials',
        ], 401);
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

            Auth::login($user);
            RateLimiter::clear($email);

            return response()->json([
                'user' => $user,
                'authorization' => [
                    'token' => $user->createToken('ApiToken')->plainTextToken,
                    'type' => 'bearer',
                ],
            ]);
        }
      return throw new ModelNotFoundException::class ;
    }

    public function logout(): JsonResponse
    {
        Auth::user()->tokens()->delete();

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
                'user' => $user,
                'authorization' => [
                    'token' => $user->createToken('ApiToken')->plainTextToken,
                    'type' => 'bearer',
                ],
            ]);
        }
        return throw new ModelNotFoundException::class ;
    }
}

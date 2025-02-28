<?php

namespace App\Http\Controllers\API;

use App\Contracts\Mediator\DtoMediatorContract;
use App\Contracts\Services\OtpServiceContract;
use App\Contracts\Services\UserServiceContract;
use App\Dto\UserDto;
use App\Enum\FieldEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Auth\ForgetRequest;
use App\Http\Requests\API\Auth\OtpRequest;
use App\Http\Resources\API\Auth\OtpResource;
use App\Notifications\SendOtpNotification;
use Illuminate\Support\Facades\Log;

class OtpController extends Controller
{

    public function __construct(
        protected DtoMediatorContract $dtoMediator,
        protected OtpServiceContract  $otpService,
        protected UserServiceContract $userService
    )
    {
    }

    public function create(OtpRequest $request)
    {
        $userDto = $this->dtoMediator->convertDataToUserDto(
            email: $request->input(FieldEnum::email->name)
        );

        return $this->sendOtp($userDto);
    }

    public function forget(ForgetRequest $request)
    {
        $userDto = $this->dtoMediator->convertDataToUserDto(
            email: $request->input(FieldEnum::email->name)
        );

        return $this->sendOtp($userDto);

    }

    private function sendOtp(UserDto $userDto): OtpResource
    {
        $user = $this->userService->findOrCreateByEmail($userDto);
        $otp = $this->otpService->create($userDto->getEmail());
        $user->notify(new SendOtpNotification($userDto->getEmail(), $otp));
        Log::info("-- OTP : Email : {$userDto->getEmail()} | code : {$otp}");

        return OtpResource::make([
            'message' => trans('message.otp-send'),
        ]);
    }

}

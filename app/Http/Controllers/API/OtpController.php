<?php

namespace App\Http\Controllers\API;

use App\Contracts\Mediator\DtoMediatorContract;
use App\Contracts\Services\OtpServiceContract;
use App\Contracts\Services\UserServiceContract;
use App\Enum\FieldEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\OtpStoreRequest;
use App\Http\Resources\API\OtpResource;
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

    public function create(OtpStoreRequest $request)
    {
        $userDto = $this->dtoMediator->convertDataToUserDto(
            email: $request->input(FieldEnum::email->name)
        );
        $user = $this->userService->findOrCreateByEmail($userDto);
        $otp = $this->otpService->create($userDto->getEmail());
        $user->notify(new SendOtpNotification($userDto->getEmail(), $otp));
        Log::info("-- OTP : Email : {$userDto->getEmail()} | code : {$otp}");

        return OtpResource::make([
            'message' => trans('message.otp-send'),
        ]);
    }

}

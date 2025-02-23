<?php

namespace App\Http\Controllers\API;

use App\Contracts\Mediator\DtoMediatorContract;
use App\Contracts\Services\OtpServiceContract;
use App\Contracts\Services\UserServiceContract;
use App\Enum\FieldEnum;
use App\Exceptions\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\OtpStoreRequest;
use App\Notifications\SendOtpNotification;
use Illuminate\Http\Response;

class OtpController extends Controller {

	public function __construct(
		protected DtoMediatorContract $dtoMediator,
		protected OtpServiceContract $otpService,
		protected UserServiceContract $userService
	) {}

	public function create(OtpStoreRequest $request): Response {
		$userDto = $this->dtoMediator->convertDataToUserDto(
			email: $request->input(FieldEnum::email->name)
		);
		$user = $this->userService->findOrCreateByEmail($userDto);
		$otp = $this->otpService->create($userDto->getEmail());
		$user->notify(new SendOtpNotification($userDto->getEmail(),$otp));
		return response(null, Response::HTTP_CREATED);
	}

    public function forget(OtpStoreRequest $request): Response {
        $userDto = $this->dtoMediator->convertDataToUserDto(
            email: $request->input(FieldEnum::email->name)
        );
        $user = $this->userService->findByCondition( conditions: [
          FieldEnum::email->value => $userDto->getEmail()
        ] );
        throw_if(empty($user),ModelNotFoundException::class);
        $otp = $this->otpService->create($userDto->getEmail());
        $user->notify(new SendOtpNotification($userDto->getEmail(),$otp));
        return response(null, Response::HTTP_CREATED);
    }
}

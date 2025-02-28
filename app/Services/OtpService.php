<?php

namespace App\Services;

use App\Contracts\Services\OtpServiceContract;
use App\Enum\FieldEnum;
use App\Exceptions\OtpRateLimitException;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Support\Facades\RateLimiter;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpFoundation\Response;

final class OtpService implements OtpServiceContract
{

    /**
     * @var int|mixed
     */
    protected int $otpLength;
    /**
     * @var int|mixed
     */
    protected int $otpLifetimeInSeconds;
    /**
     * @var int|mixed
     */
    protected int $otpCountPerLifetime = 1;

    /**
     * @param ConfigRepository $config
     */
    public function __construct(protected ConfigRepository $config)
    {
        $this->otpCountPerLifetime = $config->get('services.otp.count_per_lifetime');
        $this->otpLifetimeInSeconds = $config->get('services.otp.lifetime');
        $this->otpLength = $config->get('services.otp.length');
    }

    /**
     * @param int $code
     * @return bool
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function check(string $email, int $code): bool
    {
        $key = "{$email}:{$code}";
        if (!cache()->has($email)) {
            return false;
        }

        $otp = cache()->get($email);
        $diffLastOtpCreatedAt = Carbon::now()->diffInSeconds(Carbon::parse($otp['created_at']));
        if ($diffLastOtpCreatedAt <= $this->otpLifetimeInSeconds && $otp[FieldEnum::code->value] === $code) {
            cache()->forget($email);
            return true;
        }

        return false;
    }

    /**
     * @param string $email
     * @return int
     * @throws Exception
     */
    public function create(string $email): int
    {
        $key = $email;

        if (RateLimiter::attempt(
            key: $key,
            maxAttempts: $this->otpCountPerLifetime,
            callback: function () {
            },
            decaySeconds: $this->otpLifetimeInSeconds
        )) {
            $otp = $this->createOtp();

            cache()->put($email, [
                FieldEnum::email->value => $email,
                FieldEnum::createdAt->value => Carbon::now()->toDateTimeString() ?? null,
                FieldEnum::code->value => $otp
            ]);

            return $otp;
        }

        throw new OtpRateLimitException();
    }

    /**
     * @return int
     * @throws Exception
     */
    protected function createOtp(): int
    {
        return random_int(str_repeat(1, $this->otpLength), str_repeat(9, $this->otpLength));
    }

}

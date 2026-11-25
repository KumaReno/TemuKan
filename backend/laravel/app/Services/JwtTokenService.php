<?php

namespace App\Services;

use App\Models\User;
use App\Exceptions\JwtConfigurationException;
use Firebase\JWT\Key;
use Firebase\JWT\JWT;

class JwtTokenService
{
    public function issueFor(User $user): string
    {
        $ttlMinutes = (int) config('jwt.ttl_minutes');

        if ($ttlMinutes < 1) {
            throw new JwtConfigurationException('JWT_TTL_MINUTES must be at least 1.');
        }

        $issuedAt = time();

        return JWT::encode([
            'iss' => config('jwt.issuer'),
            'sub' => (string) $user->getAuthIdentifier(),
            'iat' => $issuedAt,
            'nbf' => $issuedAt,
            'exp' => $issuedAt + ($ttlMinutes * 60),
        ], $this->secret(), config('jwt.algorithm'));
    }

    public function authenticate(string $token): ?User
    {
        $payload = JWT::decode(
            $token,
            new Key($this->secret(), config('jwt.algorithm'))
        );

        if (($payload->iss ?? null) !== config('jwt.issuer')) {
            return null;
        }

        $userId = filter_var($payload->sub ?? null, FILTER_VALIDATE_INT);

        if ($userId === false || $userId < 1) {
            return null;
        }

        return User::query()->find($userId);
    }

    private function secret(): string
    {
        $secret = config('jwt.secret');

        if (! is_string($secret) || strlen($secret) < 32) {
            throw new JwtConfigurationException('JWT_SECRET must contain at least 32 characters.');
        }

        return $secret;
    }
}

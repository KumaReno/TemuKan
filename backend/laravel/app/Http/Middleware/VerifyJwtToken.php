<?php

namespace App\Http\Middleware;

use App\Exceptions\JwtConfigurationException;
use App\Services\JwtTokenService;
use Closure;
use DomainException;
use Firebase\JWT\ExpiredException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use UnexpectedValueException;

class VerifyJwtToken
{
    public function __construct(private readonly JwtTokenService $tokens)
    {
    }

    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if ($token === null || $token === '') {
            return $this->unauthorized('Bearer token wajib disertakan.');
        }

        try {
            $user = $this->tokens->authenticate($token);
        } catch (ExpiredException) {
            return $this->unauthorized('Token sudah kedaluwarsa. Silakan login kembali.');
        } catch (JwtConfigurationException $exception) {
            report($exception);

            return response()->json([
                'message' => 'Autentikasi API belum dikonfigurasi dengan benar.',
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        } catch (UnexpectedValueException | DomainException | InvalidArgumentException) {
            return $this->unauthorized('Token tidak valid.');
        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'message' => 'Terjadi kesalahan saat memeriksa token.',
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        if ($user === null) {
            return $this->unauthorized('Token tidak valid atau pengguna tidak ditemukan.');
        }

        $request->setUserResolver(static fn () => $user);

        return $next($request);
    }

    private function unauthorized(string $message): JsonResponse
    {
        return response()->json(['message' => $message], JsonResponse::HTTP_UNAUTHORIZED);
    }
}

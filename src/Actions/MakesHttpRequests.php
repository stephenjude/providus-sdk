<?php

declare(strict_types=1);

namespace Providus\Providus\Actions;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;
use Providus\Providus\Exceptions\AuthSignatureException;
use Providus\Providus\Exceptions\BadRequestException;
use Providus\Providus\Exceptions\UnsuportedHttpMethodException;

trait MakesHttpRequests
{
    public function get(string $uri): ?array
    {
        return $this->send('GET', $uri);
    }

    public function post(string $uri, array $payload = []): ?array
    {
        return $this->send('POST', $uri, $payload);
    }

    private function createAuthSignature(string $secret): bool|string
    {
        if (config('providus-sdk.demo_mode')) {
            return config('providus-sdk.demo_signature');
        }

        if ($hash = hash('sha512', $secret)) {
            return $hash;
        }

        throw new AuthSignatureException();
    }

    public function send(string $verb, string $uri, array $payload = []): array|string|null
    {
        $response = match (strtoupper($verb)) {
            'POST' => $this->request->post($uri, $payload),
            'GET' => $this->request->get($uri, $payload),
            default => throw new UnsuportedHttpMethodException(),
        };

        if ($response->failed() || is_string($response->json())) {
            $this->handleRequestError($response);
        }

        return $response->json();
    }

    public function handleRequestError(Response $response): void
    {
        match ($response->status()) {
            400, 401, 403, 404 => throw new BadRequestException($response->reason()),
            default => throw new Exception(($response->reason() ?? (string)$response->getBody())),
        };
    }

    public function checkAndHandleProvidusError(array $data, $key): void
    {
        $fieldData = Arr::get($data, $key);

        if (empty($fieldData)) {
            $message = Arr::get($data, 'responseMessage') ?? Arr::get($data, 'tranRemarks');

            throw new BadRequestException($message);
        }
    }
}

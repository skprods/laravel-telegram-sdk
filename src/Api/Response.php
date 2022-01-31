<?php

namespace SKprods\Telegram\Api;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class Response
{
    /** The HTTP status code response from API. */
    public int $statusCode;

    /** The headers returned from API request. */
    public array $headers;

    /** The raw body of the response from API request. */
    public string $rawBody;

    /** The decoded body of the API response. */
    public array $body = [];

    /** The original request that returned this response. */
    public Request $request;

    public function __construct(int $statusCode, array $headers, StreamInterface $body, Request $request)
    {
        $this->statusCode = $statusCode;
        $this->rawBody = $body;
        $this->headers = $headers;
        $this->request = $request;

        $decodedBody = json_decode($body, true);
        if ($decodedBody === null) {
            $decodedBody = [];
            parse_str($body, $decodedBody);
        }

        if (!is_array($decodedBody)) {
            $decodedBody = [];
        }

        $this->body = $decodedBody;
    }

    public static function make(Request $request, ResponseInterface $response): self
    {
        return new self(
            $response->getStatusCode(),
            $response->getHeaders(),
            $response->getBody(),
            $request
        );
    }

    public function getResult(): array|string|int|bool|null
    {
        return $this->body['result'] ?? null;
    }
}
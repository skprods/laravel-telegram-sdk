<?php

namespace SKprods\Telegram\Clients;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use GuzzleHttp\Psr7\Utils;
use SKprods\Telegram\Api\Request;
use SKprods\Telegram\Api\Response;

class SkprodsHttpClient implements ClientInterface
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    /** @throws GuzzleException */
    public function get(Request $request): Response
    {
        $url = $request->url;

        if (!$request->hasHeader('Content-Type')) {
            $request = $request->addHeader('Content-Type', 'application/json');
        }

        if (!$request->hasEmptyParams()) {
            $url .= '?' . $request->getParamsString();
        }

        $guzzleRequest = new GuzzleRequest($request->method, $url, $request->headers);

        $response = $this->client->send($guzzleRequest);
        return Response::make($request, $response);
    }

    /** @throws GuzzleException */
    public function post(Request $request): Response
    {
        if (!$request->hasHeader('Content-Type')) {
            $request = $request->addHeader('Content-Type', 'application/json');
        }

        $guzzleRequest = new GuzzleRequest(
            $request->method,
            $request->url,
            $request->headers,
            json_encode($request->params)
        );

        $response = $this->client->send($guzzleRequest);
        return Response::make($request, $response);
    }

    public function file(Request $request): Response
    {
        $response = $this->client->request($request->method, $request->url, $request->params);
        return Response::make($request, $response);
    }
}
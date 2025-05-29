<?php

declare(strict_types=1);

namespace Capsolver\Abstracts;

use Capsolver\Exceptions\RequestException;
use Capsolver\Exceptions\ResponseException;

abstract class CommunicatorAbstract
{
    private const HOST = 'https://api.capsolver.com/';
    private const APP_ID = '3A2DF11F-5973-4A8C-A167-919A0753EFA3';

    private string $key;

    /**
     * @param string $key
     */
    public function __construct(
        string $key
    ) {
        $this->key = $key;
    }

    /**
     * @param string $address
     * @param string $body
     * @return array
     *
     * @throws ResponseException
     */
    protected function sendRequest(
        string $address,
        string $body
    ): array {
        $curl = curl_init();

        $headers = [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($body)
        ];

        $options = [
            CURLOPT_URL             => self::HOST . $address,
            CURLOPT_POST            => true,
            CURLOPT_POSTFIELDS      => $body,
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_HEADER          => false,
            CURLOPT_FOLLOWLOCATION  => true,
            CURLOPT_TIMEOUT         => 60,
            CURLOPT_SSL_VERIFYHOST  => false,
            CURLOPT_SSL_VERIFYPEER  => false,
            CURLOPT_HTTPHEADER      => $headers
        ];

        curl_setopt_array($curl, $options);

        $result = $this->executeCurl($curl);

        curl_close($curl);

        return $result;
    }

    /**
     * @param array $params
     * @param bool $isTask
     * @return array
     */
    protected function hydrateParams(
        array $params,
        bool $isTask = true
    ): array {
        $request = $isTask
            ? ['task' => $params]
            : $params;

        $request['clientKey'] = $this->key;
        $request['appId'] = self::APP_ID;

        return $request;
    }

    /**
     * @param array $params
     * @return string
     *
     * @throws RequestException
     */
    protected function encodeParams(array $params): string
    {
        $paramsEncoded = json_encode($params, JSON_FORCE_OBJECT);

        if (!is_string($paramsEncoded)) {
            throw new RequestException('Incorrect request params');
        }

        return $paramsEncoded;
    }

    /**
     * @param $curl
     * @return array
     *
     * @throws ResponseException
     */
    private function executeCurl($curl): array
    {
        $response = (string)curl_exec($curl);
        $error = curl_error($curl);

        $this->validateResponse($curl, $response, $error);

        return json_decode($response, true);
    }

    /**
     * @param $curl
     * @param string $response
     * @param string $curlError
     * @return void
     *
     * @throws ResponseException
     */
    private function validateResponse(
        $curl,
        string $response,
        string $curlError
    ): void {
        if ($curlError) {
            throw new ResponseException($curlError);
        }

        $responseCode = curl_getinfo($curl,CURLINFO_RESPONSE_CODE);
        $responseBody = json_decode($response, true);

        if (!is_numeric($responseCode) || !in_array((int)$responseCode, [200, 400, 401])) {
            throw new ResponseException(sprintf(
                'Unknown response code [%d]',
                (int)$responseCode
            ));
        }

        if (!is_array($responseBody)) {
            throw new ResponseException(sprintf(
                'Incorrect response body type [%s]',
                gettype($responseBody)
            ));
        }

        $errorId = (int)($responseBody['errorId'] ?? 0);
        $errorCode = $responseBody['errorId'] ?? '';
        $errorDescription = $responseBody['errorDescription'] ?? '';

        if ($errorId !== 0 && $errorCode && $errorDescription) {
            throw new ResponseException($errorDescription);
        }
    }
}

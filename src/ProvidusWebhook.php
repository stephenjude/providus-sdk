<?php

declare(strict_types=1);

namespace Providus;

require_once __DIR__.'/Http/ApiException.php';
require_once __DIR__.'/Http/Request.php';
require_once __DIR__.'/ProvidusApi.php';
require_once __DIR__.'/Enum.php';

use Providus\Enum;
use Providus\Http\ApiException;
use Providus\Http\Request;
use Providus\ProvidusApi;

class ProvidusWebhook
{
    private Request $request;
    private array $headers;
    private array $data;

    /**
     * @param  array  $headers
     * @param  array  $data
     */
    public function __construct(array $headers, array $data)
    {
        $this->headers = $headers;
        $this->data = $data;
        $this->request = new Request(
            'dGVzdF9Qcm92aWR1cw==',
            '29A492021F4B709A8D1152C3EF4D32DC5A7092723ECAC4C511781003584B48873CCBFEBDEAE89CF22ED1CB1A836213549BC6638A3B563CA7FC009BEB3BC30CF8',
            'http://154.113.16.142:8088/AppDevAPI/api/',
        );

        // $this->request->fakeClient(); // This is used to toggle the development auth signature;
    }

    /**
     * @return array
     */
    public function verifyTransaction(): array
    {
        if ($this->hasValidHeaders() === false || $this->hasValidFields() === false) {
            return static::buildResponse("", Enum::STATUS_CODE_REJECTED);
        }

        $sessionId = $this->data[Enum::REQUIRED_FIELD_SESSION_ID];

        try {
            $transaction = (new ProvidusApi())->verifyTransactionBySessionId($sessionId);

            // Add more checks here to be sure that customer sent the correct payment amount.
            // You can check out information returned from this transaction.

            return static::buildResponse($sessionId, Enum::STATUS_CODE_SUCCESS);
        } catch (\Exception $exception) {
            return static::buildResponse($sessionId, Enum::STATUS_CODE_REJECTED);
        }
    }

    /**
     * @return bool
     */
    public function hasValidHeaders(): bool
    {
        if ($this->request->isFakeClient()) {
            return true;
        }

        if (false === array_key_exists(Enum::REQUIRED_HEADER_CLIENT_ID, $this->headers)) {
            return false;
        }

        if (false === array_key_exists(Enum::REQUIRED_HEADER_AUTH_SIGNATURE, $this->headers)) {
            return false;
        }

        if ($this->request->getClientId() !== $this->headers[Enum::REQUIRED_HEADER_CLIENT_ID]) {
            return false;
        }

        if (
            false === hash_equals(
                $this->request->createAuthSignature(),
                $this->headers[Enum::REQUIRED_HEADER_AUTH_SIGNATURE]
            )
        ) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function hasValidFields()
    {
        if ($this->request->isFakeClient()) {
            return true;
        }

        $requiredFields = [
            Enum::REQUIRED_FIELD_SESSION_ID,
            Enum::REQUIRED_FIELD_ACCOUNT_NUMBER,
            Enum::REQUIRED_FIELD_REMARK,
            Enum::REQUIRED_FIELD_AMOUNT,
            Enum::REQUIRED_FIELD_SETTLED_AMOUNT,
            Enum::REQUIRED_FIELD_FEE_AMOUNT,
            Enum::REQUIRED_FIELD_VAT_AMOUNT,
            Enum::REQUIRED_FIELD_CURRENCY,
            Enum::REQUIRED_FIELD_TRANSACTION_REFERENCE,
            Enum::REQUIRED_FIELD_SETTLEMENT_ID,
            Enum::REQUIRED_FIELD_SOURCE_ACCOUNT_NUMBER,
            Enum::REQUIRED_FIELD_SOURCE_ACCOUNT_NAME,
            Enum::REQUIRED_FIELD_SOURCE_BANK_NAME,
            Enum::REQUIRED_FIELD_CHANNEL_ID,
            Enum::REQUIRED_FIELD_TRANSACTION_DATE,
        ];

        return true === empty(array_diff($requiredFields, array_keys($this->data)));
    }

    /**
     * @param  string  $sessionId
     * @param  string  $status
     * @return array
     */
    private static function buildResponse(string $sessionId, string $status): array
    {
        switch ($status) {
            case Enum::STATUS_CODE_DUPLICATE:
                $statusCode = Enum::STATUS_CODE_DUPLICATE;
                $statusText = Enum::STATUS_TEXT_DUPLICATE;
                break;
            case Enum::STATUS_CODE_REJECTED:
                $statusCode = Enum::STATUS_CODE_REJECTED;
                $statusText = Enum::STATUS_TEXT_REJECTED;
                break;
            default:
                $statusCode = Enum::STATUS_CODE_SUCCESS;
                $statusText = Enum::STATUS_TEXT_SUCCESS;
        }

        return [
            "requestSuccessful" => true,
            "sessionId" => $sessionId,
            "responseMessage" => $statusText,
            "responseCode" => $statusCode,
        ];
    }

    /**
     * @description this static function is usful for testing the webhook
     * @return array
     * @throws ApiException
     */
    public static function sendFakeWebhookResponse(): array
    {
        $client = new Request(
            'dGVzdF9Qcm92aWR1cw==',
            '29A492021F4B709A8D1152C3EF4D32DC5A7092723ECAC4C511781003584B48873CCBFEBDEAE89CF22ED1CB1A836213549BC6638A3B563CA7FC009BEB3BC30CF8',
            'https://providus.greenlite.com.ng/',
        );

        $requestData = [
            "sessionId" => "0000042103011805345648005069266636442357859508",
            "accountNumber" => "9977581536",
            "tranRemarks" => "FROM UBA/ CASAFINA CREDIT-EASY LOAN-NIP/SEYI OLUFEMI/CASAFINA CAP/0000042103015656180548005069266636",
            "transactionAmount" => "1",
            "settledAmount" => "1",
            "feeAmount" => "0",
            "vatAmount" => "0",
            "currency" => "NGN",
            "initiationTranRef" => "",
            "settlementId" => "202210301006807600001432",
            "sourceAccountNumber" => "2093566866",
            "sourceAccountName" => "CASAFINA CREDIT-EASY LOAN",
            "sourceBankName" => "UNITED BANK FOR AFRICA",
            "channelId" => "1",
            "tranDateTime" => "2021-03-01 18:06:20.000"
        ];

        $response = $client->fakeClient()->send(
            Enum::METHOD_POST,
            'index.php',
            $requestData
        );

        if ($response->isSuccess() === false) {
            throw new ApiException();
        }

        return $response->json();
    }
}


<?php

declare(strict_types=1);

namespace Providus\Providus\Resources;

class TransactionResource extends BaseResource
{
    public string $sessionId;

    public string $transactionReference;

    public string $accountNumber;

    public float $remarks;

    public float $transactionAmount;

    public float $settledAmount;

    public float $feeAmount;

    public float $vatAmount;

    public string $currency;

    public string $settlementId;

    public string $sourceAccountNumber;

    public string $sourceAccountName;

    public string $sourceBankName;

    public string $channelId;

    public string $transactionDate;
}

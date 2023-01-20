<?php

declare(strict_types=1);

namespace Providus\Providus\Resources;

class TransactionResource extends BaseResource
{
    public string $sessionId;

    public string $transactionReference;

    public string $accountNumber;

    public string $remarks;

    public string $transactionAmount;

    public string $settledAmount;

    public string $feeAmount;

    public string $vatAmount;

    public string $currency;

    public string $settlementId;

    public string $sourceAccountNumber;

    public string $sourceAccountName;

    public string $sourceBankName;

    public string $channelId;

    public string $transactionDate;
}

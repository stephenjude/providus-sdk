<?php

declare(strict_types=1);

namespace Providus\Providus\Enums;

enum ResponseField: string
{
    case SESSION_ID = 'sessionId';
    case ACCOUNT_NUMBER = "accountNumber";
    case REMARK = "tranRemarks";
    case AMOUNT = "transactionAmount";
    case SETTLED_AMOUNT = "settledAmount";
    case FEE_AMOUNT = "feeAmount";
    case VAT_AMOUNT = "vatAmount";
    case CURRENCY = "currency";
    case TRANSACTION_REFERENCE = "initiationTranRef";
    case SETTLEMENT_ID = "settlementId";
    case SOURCE_ACCOUNT_NUMBER = "sourceAccountNumber";
    case SOURCE_ACCOUNT_NAME = "sourceAccountName";
    case SOURCE_BANK_NAME = "sourceBankName";
    case CHANNEL_ID = "channelId";
    case TRANSACTION_DATE = "tranDateTime";
}

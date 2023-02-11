<?php

use Providus\Providus\Providus;
use Providus\Providus\Resources\AccountResource;
use Providus\Providus\Resources\TransactionResource;

it('can create dynamic account number', function () {
    $this->instance(
        abstract: Providus::class,
        instance: Mockery::mock(Providus::class)->allows([
            'createDynamicAccountNumber' => new AccountResource([]),
        ])
    );

    $accountDetails = app(Providus::class)->createDynamicAccountNumber("Test Account Name");

    expect($accountDetails)->toBeInstanceOf(AccountResource::class);
});

it('can verify transaction by session id', function () {
    $this->instance(
        abstract: Providus::class,
        instance: Mockery::mock(Providus::class)->allows([
            'verifyTransactionBySessionId' => new TransactionResource([]),
        ])
    );


    $transactionBySessionId = app(Providus::class)->verifyTransactionBySessionId("123456789012345");

    expect($transactionBySessionId)->toBeInstanceOf(TransactionResource::class);
});

it('can verify transaction by settlement id', function () {
    $this->instance(
        abstract: Providus::class,
        instance: Mockery::mock(Providus::class)->allows([
            'verifyTransactionBySettlementId' => new TransactionResource([]),
        ])
    );

    $transactionBySettlementId = app(Providus::class)->verifyTransactionBySettlementId("123456789012345");

    expect($transactionBySettlementId)->toBeInstanceOf(TransactionResource::class);
});

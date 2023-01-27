<?php

declare(strict_types=1);

namespace Providus\Providus\Actions;

use Providus\Providus\Resources\AccountResource;

trait ManagesAccount
{
    public function createReservedAccountNumber(string $name, string $bvn): AccountResource
    {
        $account = $this->post(
            uri: 'PiPCreateReservedAccountNumber',
            payload: [
                'account_name' => $name,
                'bvn' => $bvn,
            ]
        );

        $this->checkAndHandleProvidusError($account, 'account_number');

        return new AccountResource($account);
    }

    public function createDynamicAccountNumber(string $name): AccountResource
    {
        $account = $this->post(
            uri: 'PiPCreateDynamicAccountNumber',
            payload: ['account_name' => $name,]
        );

        $this->checkAndHandleProvidusError($account, 'account_number');

        return new AccountResource($account);
    }

    public function updateAccountName(string $name, string $accountNumber): array
    {
        $response = $this->post(
            uri: 'PiPUpdateAccountName',
            payload: [
                'account_number' => $accountNumber,
                'account_name' => $name,
            ]
        );

        $this->checkAndHandleProvidusError(
            data: $response,
            key: 'account_number'
        );

        // TODO
        // Need to map this response to a resource

        return $response;
    }

    public function blacklistAccountNumber(string $accountNumber): array
    {
        $response = $this->post(
            uri: 'PiPBlacklistAccount',
            payload: [
                'account_number' => $accountNumber,
                'blacklist_flg' => 1,
            ]
        );

        $this->checkAndHandleProvidusError(
            data: $response,
            key: 'account_number'
        );

        // TODO
        // Need to map this response to a resource

        return $response;
    }
}

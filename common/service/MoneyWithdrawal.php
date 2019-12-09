<?php

namespace common\service;

use common\domain\prize\money\Money;
use yii\httpclient\Client;

class MoneyWithdrawal
{
    /** @var Client; */
    private $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param Money $money
     * @throws \yii\base\InvalidConfigException
     */
    public function withdrawal(Money $money): void
    {
        $response = $this->client->createRequest()
            ->setMethod('GET')
            ->setUrl('http://google.com')
            ->setData(['q' => 'this+is+strange'])
            ->send();

        if ($response->isOk) {
            $money->markAsWithdrawn();
        } else {
            $money->markAsUnpaid();
        }
    }
}
<?php

namespace common\modules\exchange\clients;

use common\modules\exchange\clients\dto\Rate;
use yii\httpclient\Client;
use yii\httpclient\Exception;

final class CoincapClient
{

    public function __construct(
        private string $host = 'https://api.coincap.io/v2',
        private Client $client = new Client(),
    ) {
    }

    /**
     * @return array<array-key,Rate>
     */
    public function getRates(): array
    {
        $response = $this->client->createRequest()
            ->setMethod('GET')
            ->setUrl($this->host . '/rates')
            ->send();

        if (!$response->isOk) {
            throw new Exception("Error Processing Request", 1);
        }

        $data = $response->data['data'];

        /** @var array<array-key,Rate> */
        $rates = [];
        foreach ($data as $item) {
            $rates[] = new Rate(
                ...$item,
            );
        }

        return $rates;
    }
}
<?php

namespace common\modules\exchange\clients;

use common\modules\exchange\clients\dto\RateDTO;
use yii\httpclient\Client;
use yii\httpclient\Exception;

final class CoincapClient
{
    public function __construct(
        private string $host = 'https://api.coincap.io/v2',
        private Client $client = new Client(),
    ) {}

    /**
     * @return array<array-key,RateDTO>
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
            $rates[] = new RateDTO(
                ...$item,
            );
        }

        return $rates;
    }
}

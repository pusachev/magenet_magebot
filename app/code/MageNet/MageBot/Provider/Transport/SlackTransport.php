<?php
/**
 * @author Pavel Usachev <webcodekeeper@hotmail.com>
 * @copyright Copyright (c) 2017, Pavel Usachev
 */

namespace MageNet\MageBot\Provider\Transport;

use MageNet\MageBot\Factory\RestClientFactoryInterface;
use MageNet\MageBot\Provider\SlackConfigProviderInterface;

class SlackTransport implements SlackTransportInterface
{
    protected $token;

    protected $headers = [];

    protected $client;

    protected $configProvider;

    public function __construct(
        RestClientFactoryInterface $restClientFactory,
        SlackConfigProviderInterface $slackConfigProvider
    ) {
        $this->client = $restClientFactory->createRestClient([
            'base_uri' => self::BASE_URL,
            'headers' => [
                'Content-type' => self::CONTENT_TYPE
            ]
        ]);
        $this->configProvider = $slackConfigProvider;
    }

    public function init()
    {
        $this->client->post('auth.test', [
            'headers' => [
                'token' => $this->configProvider->getToken()
            ]
        ]);

        $response = $this->client->getJSON();

        return $response;
    }
}

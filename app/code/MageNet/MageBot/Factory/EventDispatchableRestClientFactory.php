<?php
/**
 * @author Pavel Usachev <webcodekeeper@hotmail.com>
 * @copyright Copyright (c) 2017, Pavel Usachev
 */

namespace MageNet\MageBot\Factory;

use Magento\Framework\Event\Manager as EventManager;

use MageNet\MageBot\Provider\Rest\Client\Guzzle;
use MageNet\MageBot\Provider\Rest\Client\RestClientInterface;

class EventDispatchableRestClientFactory implements RestClientFactoryInterface
{
    const EVENT_NAME = 'rest_client_create_after';

    /** @var EventManager */
    protected $eventManager;

    /** @var RestClientInterface */
    protected $client;

    public function __construct(EventManager $manager)
    {
        $this->eventManager = $manager;
    }

    /** {@inheritdoc} */
    public function createRestClient(array $defaultOptions)
    {
        $this->client = new Guzzle($defaultOptions);

        $this->eventManager->dispatch(self::EVENT_NAME, ['client' => $this->client]);

        return $this->client;
    }
}

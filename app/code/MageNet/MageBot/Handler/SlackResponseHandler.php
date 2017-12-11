<?php
/**
 * @author Pavel Usachev <webcodekeeper@hotmail.com>
 * @copyright Copyright (c) 2017, Pavel Usachev
 */

namespace MageNet\MageBot\Handler;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;

use MageNet\MageBot\Exception\SlackException;
use MageNet\MageBot\Provider\Rest\Client\RestClientInterface;

class SlackResponseHandler implements SlackHandlerInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->setLogger($logger);
    }

    /** {@inheritdoc} */
    public function handle(RestClientInterface $client)
    {
        $response = $client->getJSON();

        if (false === $response[self::STATUS_KEY]) {
            if (!empty($response[self::ERROR_KEY])) {
                 $this->logger->error($response[self::ERROR_KEY]);
                 throw new SlackException($response[self::ERROR_KEY]);
            }
        }

        return $response;
    }
}

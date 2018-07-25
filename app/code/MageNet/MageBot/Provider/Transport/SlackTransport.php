<?php
/**
 * @author Pavel Usachev <webcodekeeper@hotmail.com>
 * @copyright Copyright (c) 2017, Pavel Usachev
 */

namespace MageNet\MageBot\Provider\Transport;

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

use MageNet\MageBot\Exception\SlackException;
use MageNet\MageBot\Factory\RestClientFactoryInterface;
use MageNet\MageBot\Provider\SlackConfigProviderInterface;
use MageNet\MageBot\Handler\SlackHandlerInterface;
use MageNet\MageBot\Provider\Rest\Client\RestClientInterface;

class SlackTransport implements SlackTransportInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    /** @var string  */
    protected $token;

    /** @var string[]  */
    protected $headers = [];

    /** @var RestClientInterface  */
    protected $client;

    /** @var SlackConfigProviderInterface  */
    protected $configProvider;

    /** @var SlackHandlerInterface  */
    protected $handler;

    /**
     * @param RestClientFactoryInterface    $restClientFactory
     * @param SlackConfigProviderInterface  $slackConfigProvider
     * @param SlackHandlerInterface         $slackHandler
     * @param LoggerInterface               $logger
     */
    public function __construct(
        RestClientFactoryInterface $restClientFactory,
        SlackConfigProviderInterface $slackConfigProvider,
        SlackHandlerInterface $slackHandler,
        LoggerInterface $logger
    ) {
        $this->configProvider   = $slackConfigProvider;
        $this->token            = $this->configProvider->getToken();
        $this->handler          = $slackHandler;

        $this->client = $restClientFactory->createRestClient([
            'base_uri' => self::BASE_URL,
            'headers' => [
                'Content-type' => self::CONTENT_TYPE,
                self::AUTHORIZATION_KEY => sprintf(self::AUTHORIZATION, $this->token)
            ]
        ]);

        $this->setLogger($logger);
    }

    /** {@inheritdoc} */
    public function init()
    {
        if (!$this->isAuthenticated()) {
            throw new SlackException('Not authenticated!');
        }
    }

    public function isAuthenticated()
    {
        $this->logger->debug(sprintf('start request for %s', self::AUTH_TEST_METHOD_URI));

        $this->client->get(
            self::AUTH_TEST_METHOD_URI,
            $this->createQueryRequest([
                'token' => $this->token
            ])
        );

        $result = true;

        try {
            $this->handler->handle($this->client);
        } catch (SlackException $e) {
            $result = false;
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            throw $e;
        }

        $this->logger->info(
            sprintf('Slack method %s is %s', self::AUTH_TEST_METHOD_URI, (string)$result)
        );
        $this->logger->debug(sprintf('end request for %s', self::AUTH_TEST_METHOD_URI));
        return $result;
    }

    /** {@inheritdoc} */
    public function sendMessage($channel, $text, $asUser = true)
    {
        $this->client->get(
            self::CHAT_POST_MESSAGE_METHOD_URI,
            $this->createQueryRequest([
                'channel' => $channel,
                'text'    => $text,
                'token'   => $this->token,
                'as_user' => $asUser
            ])
        );

        return $this->handler->handle($this->client);
    }

    /**
     * @param mixed[] $query
     * @return mixed[]
     */
    protected function createQueryRequest(array $query)
    {
        return [
            'query' => $query
        ];
    }
}

<?php
/**
 * @author Pavel Usachev <webcodekeeper@hotmail.com>
 * @copyright Copyright (c) 2017, Pavel Usachev
 */

namespace MageNet\MageBot\Bot;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Slack\SlackDriver;
use BotMan\BotMan\BotManFactory;
use MageNet\MageBot\Exception\SlackException;
use MageNet\MageBot\Processor\SlackResponseProcessorInterface;
use MageNet\MageBot\Provider\SlackConfigProviderInterface;

class SlackBot implements SlackBotInterface, BotInterface
{
    /** @var BotMan */
    protected $slackBot;

    /** @var SlackResponseProcessorInterface */
    protected $processor;

    /** @var SlackConfigProviderInterface */
    protected $configProvider;

    public function __construct(
        SlackConfigProviderInterface $slackConfigProvider,
        SlackResponseProcessorInterface $slackResponseProcessor
    ) {
        $this->configProvider = $slackConfigProvider;
        $this->processor      = $slackResponseProcessor;

        $this->initialize();
    }

    /**
     * @return SlackBotInterface
     */
    public function initialize()
    {
        if (null === $this->slackBot) {
            DriverManager::loadDriver(SlackDriver::class);
            $this->slackBot = BotManFactory::create($this->getDriverConfig());
        }

        return $this;
    }

    /** {@inheritdoc} */
    public function sendMessage($message, $channel = null)
    {
        $channel = (null === $channel) ? 'general' : $channel;

        $response = $this->slackBot->say($message, $channel, SlackDriver::class);

        if (!$this->processor->process($response)) {
            throw new SlackException($this->processor->getLastError());
        }

        return $response;
    }

    /**
     * @return string[]
     */
    private function getDriverConfig()
    {
        return [
            'slack' => [
                'token' => $this->configProvider->getToken()
            ]
        ];
    }
}

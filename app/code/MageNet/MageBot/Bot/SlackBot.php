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
use MageNet\MageBot\Provider\SlackConfigProviderInterface;

class SlackBot implements SlackBotInterface, BotInterface
{
    /** @var BotMan */
    protected $slackBot;

    /** @var SlackConfigProviderInterface */
    protected $slackConfigProvider;

    public function __construct(SlackConfigProviderInterface $slackConfigProvider)
    {
        DriverManager::loadDriver(SlackDriver::class);
        $this->slackConfigProvider = $slackConfigProvider;

        $this->initialize();
    }

    /**
     * @return SlackBotInterface
     */
    public function initialize()
    {
        if (null === $this->slackBot) {
            $this->slackBot = BotManFactory::create($this->getDriverConfig());
        }

        return $this;
    }

    /** {@inheritdoc} */
    public function sendMessage($message, $channel = null)
    {
        $channel = (null === $channel) ? 'general' : $channel;

        return $this->slackBot->say($message, $channel, SlackDriver::class);
    }

    /**
     * @return string[]
     */
    private function getDriverConfig()
    {
        return [
            'slack' => [
                'token' => $this->slackConfigProvider->getToken()
            ]
        ];
    }
}

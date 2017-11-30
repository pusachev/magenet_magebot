<?php
/**
 * @author Pavel Usachev <webcodekeeper@hotmail.com>
 * @copyright Copyright (c) 2017, Pavel Usachev
 */

namespace MageNet\MageBot\Console\Command;

use BotMan\BotMan\Exceptions\Base\BotManException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use MageNet\MageBot\Bot\SlackBotInterface;

class SlackBotTestCommand extends Command
{
    /** @var  */
    protected $bot;

    /**
     * SlackBotTestCommand constructor.
     * @param SlackBotInterface $slackBot
     * @param null|string       $name
     */
    public function __construct(SlackBotInterface $slackBot, $name = null)
    {
        $this->bot = $slackBot;
        parent::__construct($name);
    }

    /** {@inheritdoc} */
    public function configure()
    {
        $this->setName('magenet:magebot:slack-test')
             ->setDescription('Test slack bot')
             ->addArgument('message', InputArgument::REQUIRED, 'send test message');
    }

    /** {@inheritdoc} */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $message = $input->getArgument('message');

        try {
            $result = $this->bot->sendMessage($message);
            $output->writeln('Message has been sent');
        } catch (\Exception $e) {
            $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
        }
    }
}

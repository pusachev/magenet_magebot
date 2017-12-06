<?php
/**
 * @author Pavel Usachev <webcodekeeper@hotmail.com>
 * @copyright Copyright (c) 2017, Pavel Usachev
 */

namespace MageNet\MageBot\Bot;

interface SlackBotInterface
{
    public function sendMessage($message, $channel=null);
}

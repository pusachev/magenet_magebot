<?php
/**
 * @author Pavel Usachev <webcodekeeper@hotmail.com>
 * @copyright Copyright (c) 2017, Pavel Usachev
 */

namespace MageNet\MageBot\Provider;

interface SlackConfigProviderInterface
{
    const TOKEN_CONFIG_NODE_XML         = 'magenet_magebot/slack/bot_token';
    const IS_ENABLED_CONFIG_NODE_XML    = 'magenet_magebot/slack/is_enabled';

    /**
     * @return string
     */
    public function getToken();

    /**
     * @return boolean
     */
    public function isEnabled();
}

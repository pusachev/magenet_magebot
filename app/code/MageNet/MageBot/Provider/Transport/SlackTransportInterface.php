<?php
/**
 * @author Pavel Usachev <webcodekeeper@hotmail.com>
 * @copyright Copyright (c) 2017, Pavel Usachev
 */

namespace MageNet\MageBot\Provider\Transport;

interface SlackTransportInterface extends TransportInterface
{
    const CONTENT_TYPE = 'application/json';
    const AUTHORIZATION = 'Bearer %s';
    const AUTHORIZATION_KEY = 'Authorization';
    const BASE_URL = 'https://slack.com/api/';
    const OK_KEY = 'ok';
    const ERROR_KEY = 'error';

    const AUTH_TEST_METHOD_URI = 'auth.test';
    const CHAT_POST_MESSAGE_METHOD_URI = 'chat.postMessage';

    /**
     * @return bool
     */
    public function isAuthenticated();

    /**
     * @param string    $chatId
     * @param string    $message
     * @param bool      $asUser
     * @throws \Exception
     * @return string[]
     */
    public function sendMessage($chatId, $message, $asUser = true);
}

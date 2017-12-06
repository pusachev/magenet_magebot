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
    const BASE_URL = 'https://slack.com/api/';
    const OK_KEY = 'ok';
    const ERROR_KEY = 'error';
}

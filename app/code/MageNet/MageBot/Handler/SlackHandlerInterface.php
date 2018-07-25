<?php
/**
 * @author Pavel Usachev <webcodekeeper@hotmail.com>
 * @copyright Copyright (c) 2017, Pavel Usachev
 */

namespace MageNet\MageBot\Handler;

use MageNet\MageBot\Exception\SlackException;
use MageNet\MageBot\Provider\Rest\Client\RestClientInterface;

interface SlackHandlerInterface extends RestHandlerInterface
{
    const STATUS_KEY = 'ok';
    const ERROR_KEY  = 'error';

    /**
     * @param RestClientInterface $client
     * @throws SlackException
     * @return string[]
     */
    public function handle(RestClientInterface $client);
}

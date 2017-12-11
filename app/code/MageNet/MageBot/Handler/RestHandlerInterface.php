<?php
/**
 * @author Pavel Usachev <webcodekeeper@hotmail.com>
 * @copyright Copyright (c) 2017, Pavel Usachev
 */

namespace MageNet\MageBot\Handler;

use MageNet\MageBot\Provider\Rest\Client\RestClientInterface;

interface RestHandlerInterface
{
    /**
     * @param RestClientInterface $client
     */
    public function handle(RestClientInterface $client);
}

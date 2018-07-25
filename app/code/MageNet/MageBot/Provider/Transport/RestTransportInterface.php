<?php
/**
 * @author Pavel Usachev <webcodekeeper@hotmail.com>
 * @copyright Copyright (c) 2017, Pavel Usachev
 */

namespace MageNet\MageBot\Provider\Transport;

use MageNet\MageBot\Provider\Rest\Client\RestClientInterface;

interface RestTransportInterface
{
    /**
     * @throws \Exception
     * @return void|bool
     */
    public function init();

    /**
     * @param RestClientInterface $restClient
     * @return RestTransportInterface
     */
    public function setClient(RestClientInterface $restClient);

    /**
     * @return RestClientInterface
     */
    public function getClient();
}

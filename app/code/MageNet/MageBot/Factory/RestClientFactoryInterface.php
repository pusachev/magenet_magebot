<?php
/**
 * @author Pavel Usachev <webcodekeeper@hotmail.com>
 * @copyright Copyright (c) 2017, Pavel Usachev
 */

namespace MageNet\MageBot\Factory;

use MageNet\MageBot\Provider\Rest\Client\RestClientInterface;

interface RestClientFactoryInterface
{
    /**
     * $defaultOptions = [
     *    'base_uri'        => 'http://example.com/api/',
     *    'timeout'         => 0,
     *    'allow_redirects' => false,
     *    'proxy'           => '192.168.16.1:10'
     * ]
     *
     * @param mixed[] $defaultOptions
     *
     * @return RestClientInterface
     */
    public function createRestClient(array $defaultOptions);
}

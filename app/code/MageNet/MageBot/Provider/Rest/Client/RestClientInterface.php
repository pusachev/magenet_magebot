<?php
/**
 * @author Pavel Usachev <webcodekeeper@hotmail.com>
 * @copyright Copyright (c) 2017, Pavel Usachev
 */

namespace MageNet\MageBot\Provider\Rest\Client;

use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;

interface RestClientInterface
{
    /**
     * @return string[]
     */
    public function getHeaders();

    /**
     * @param string $name
     * @param string $value
     * @return ClientInterface
     */
    public function addHeader($name, $value);

    /**
     * @param string    $uri
     * @param mixed[]   $options
     * @return ResponseInterface
     */
    public function get($uri, array $options = []);

    /**
     * @param string    $uri
     * @param mixed[]   $options
     * @return ResponseInterface
     */
    public function post($uri, array $options = []);

    /**
     * @param string    $uri
     * @param mixed[]   $options
     * @return ResponseInterface
     */
    public function put($uri, array $options = []);

    /**
     * @param string    $uri
     * @param mixed[]   $options
     * @return ResponseInterface
     */
    public function delete($uri, array $options = []);

    /**
     * @param string    $uri
     * @param mixed[]   $options
     * @return ResponseInterface
     */
    public function patch($uri, array $options = []);

    /**
     * @return mixed[]
     */
    public function getJSON();

    /**
     * @return ResponseInterface
     */
    public function getLastResponse();
}

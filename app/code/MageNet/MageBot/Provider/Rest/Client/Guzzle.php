<?php
/**
 * @author Pavel Usachev <webcodekeeper@hotmail.com>
 * @copyright Copyright (c) 2017, Pavel Usachev
 */

namespace MageNet\MageBot\Provider\Rest\Client;

use Psr\Http\Message\ResponseInterface;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface;

class Guzzle implements RestClientInterface
{
    /** @var GuzzleClient */
    protected $client;

    /** @var mixed[] */
    protected $options;

    /** @var ResponseInterface */
    protected $lastResponse;

    /**
     * Guzzle constructor.
     * @param mixed $options
     */
    public function __construct(array $options)
    {
        $this->options = $options;
    }

    public function get($uri, array $options = [])
    {
        $this->createRequest('GET', $uri, $options);

        return $this;
    }

    public function post($uri, array $options = [])
    {
        $this->createRequest('POST', $uri, $options);

        return $this;
    }

    public function put($uri, array $options = [])
    {
        $this->createRequest('PUT', $uri, $options);

        return $this;
    }

    public function patch($uri, array $options = [])
    {
        $this->createRequest('PATCH', $uri, $options);

        return $this;
    }

    public function delete($uri, array $options = [])
    {
        $this->createRequest('DELETE', $uri, $options);

        return $this;
    }

    public function getJSON()
    {
        return \GuzzleHttp\json_decode($this->lastResponse->getBody(), true);
    }

    public function getLastResponse()
    {
        return $this->lastResponse;
    }

    /**
     * @return ClientInterface
     */
    protected function getClient()
    {
        if (null === $this->client) {
            $this->client = new GuzzleClient($this->options);
        }

        return $this->client;
    }

    /**
     * @param string   $method
     * @param string   $uri
     * @param string[] $options
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function createRequest(
        $method,
        $uri,
        array $options
    ) {
        $this->lastResponse = $this->getClient()->request($method, $uri, $options);
    }

    /**
     * @return string[]
     */
    public function getHeaders()
    {
        // TODO: Implement getHeaders() method.
    }

    /**
     * @param string $name
     * @param string $value
     * @return ClientInterface
     */
    public function addHeader($name, $value)
    {
        // TODO: Implement addHeader() method.
    }
}

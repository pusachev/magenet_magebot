<?php
/**
 * @author Pavel Usachev <webcodekeeper@hotmail.com>
 * @copyright Copyright (c) 2017, Pavel Usachev
 */

namespace MageNet\MageBot\Processor;

use Symfony\Component\HttpFoundation\Response;

use Magento\Framework\Serialize\Serializer\Json as JsonHelper;

class SlackResponseProcessor implements SlackResponseProcessorInterface
{
    const STATUS_KEY = 'ok';

    const ERROR_KEY = 'error';

    /** @var string[] */
    protected $errors = [];

    /** @var JsonHelper */
    protected $jsonHelper;

    public function __construct(JsonHelper $jsonHelper)
    {
        $this->jsonHelper = $jsonHelper;
    }

    /** {@inheritdoc} */
    public function process(Response $response)
    {
        $data = $this->jsonHelper->unserialize($response->getContent());

        if (false === $data[self::STATUS_KEY]) {
            array_push($this->errors, $data[self::ERROR_KEY]);
            return false;
        }

        return true;
    }

    /** {@inheritdoc} */
    public function getErrors()
    {
        return $this->errors;
    }

    /** {@inheritdoc} */
    public function getLastError()
    {
        return array_pop($this->errors);
    }
}

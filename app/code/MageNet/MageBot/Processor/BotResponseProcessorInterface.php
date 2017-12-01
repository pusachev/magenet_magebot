<?php
/**
 * @author Pavel Usachev <webcodekeeper@hotmail.com>
 * @copyright Copyright (c) 2017, Pavel Usachev
 */

namespace MageNet\MageBot\Processor;

use Symfony\Component\HttpFoundation\Response;

interface BotResponseProcessorInterface
{
    /**
     * @param Response $response
     *
     * @return bool
     */
    public function process(Response $response);

    /**
     * @return string[]
     */
    public function getErrors();

    /**
     * @return string
     */
    public function getLastError();
}

<?php
/**
 * @author Pavel Usachev <webcodekeeper@hotmail.com>
 * @copyright Copyright (c) 2017, Pavel Usachev
 */

namespace MageNet\MageBot\Handler;

use Symfony\Component\HttpFoundation\Response;

interface BotErrorHandlerInterface
{
    const STATUS_KEY = 'ok';
    const ERROR_KEY = 'error';

    public function handle(Response $response);

    /**
     * @return string
     */
    public function getLastError();

    /**
     * @return string[]
     */
    public function getErrors();

    /**
     * @return boolean
     */
    public function hasErrors();
}

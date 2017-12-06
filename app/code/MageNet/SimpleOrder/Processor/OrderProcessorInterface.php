<?php
/**
 * @author Pavel Usachev <webcodekeeper@hotmail.com>
 * @copyright Copyright (c) 2017, Pavel Usachev
 */

namespace MageNet\SimpleOrder\Processor;

use Magento\Framework\App\RequestInterface;

interface OrderProcessorInterface
{
    public function process(RequestInterface $request);
}

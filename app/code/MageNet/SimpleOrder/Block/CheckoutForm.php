<?php
/**
 * @author Pavel Usachev <webcodekeeper@hotmail.com>
 * @copyright Copyright (c) 2017, Pavel Usachev
 */

namespace MageNet\SimpleOrder\Block;

use Magento\Framework\View\Element\Template;

class CheckoutForm extends Template
{
    public function getFormAction()
    {
        return $this->getUrl('simpleorder/index/post', ['_secure' => true]);
    }
}

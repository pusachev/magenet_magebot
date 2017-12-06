<?php
/**
 * @author Pavel Usachev <webcodekeeper@hotmail.com>
 * @copyright Copyright (c) 2017, Pavel Usachev
 */

namespace MageNet\SimpleOrder\Controller\Index;

use MageNet\SimpleOrder\Processor\OrderProcessorInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;

class Post extends Action
{
    protected $processor;

    public function __construct(Context $context, OrderProcessorInterface $orderProcessor)
    {
        $this->processor = $orderProcessor;
        parent::__construct($context);
    }

    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        if ($this->isPostRequest()) {
            $this->processor->process($this->getRequest());
        } else {
            return $this->_redirect('*/*/index');
        }

        return $this->_redirect('cms/index/index');
    }

    /**
     * @return bool
     */
    private function isPostRequest()
    {
        /** @var Request $request */
        $request = $this->getRequest();
        return !empty($request->getPostValue());
    }
}

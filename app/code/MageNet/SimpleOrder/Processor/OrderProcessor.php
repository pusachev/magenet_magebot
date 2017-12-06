<?php
/**
 * @author Pavel Usachev <webcodekeeper@hotmail.com>
 * @copyright Copyright (c) 2017, Pavel Usachev
 */

namespace MageNet\SimpleOrder\Processor;

use Magento\Framework\App\RequestInterface;
use Magento\Checkout\Model\Cart\CartInterface;
use Magento\Quote\Model\Quote as QuoteEntity;
use Magento\Quote\Model\Quote;
use Magento\Quote\Model\QuoteRepository;
use Magento\Sales\Api\Data\OrderInterfaceFactory as OrderFactory;
use Magento\Quote\Model\CustomerManagement;
use Magento\Sales\Api\OrderManagementInterface;

class OrderProcessor implements OrderProcessorInterface
{
    /** @var CartInterface */
    protected $cart;

    /** @var OrderFactory */
    protected $orderFactory;

    /** @var CustomerManagement */
    protected $customerManagement;

    /** @var QuoteRepository */
    protected $quoteRepository;

    /** @var OrderManagementInterface */
    protected $orderManagement;

    public function __construct(
        CartInterface $cart,
        OrderFactory $orderFactory,
        CustomerManagement $customerManagement,
        QuoteRepository $quoteRepository,
        OrderManagementInterface $orderManagement
    ) {
        $this->cart = $cart;
        $this->orderFactory = $orderFactory;
        $this->customerManagement = $customerManagement;
        $this->quoteRepository = $quoteRepository;
        $this->orderManagement = $orderManagement;
    }

    public function process(RequestInterface $request)
    {
        $phone = $request->getParam('phone');

        $quote = $this->cart->getQuote();

        $this->submitQuote($quote);
    }

    /**
     * Submit quote
     *
     * @param Quote $quote
     * @return \Magento\Framework\Model\AbstractExtensibleModel|\Magento\Sales\Api\Data\OrderInterface|object
     * @throws \Exception
     */
    protected function submitQuote(QuoteEntity $quote)
    {
        $order = $this->orderFactory->create();
        if (!$quote->getCustomerIsGuest()) {
            $this->customerManagement->populateCustomerInfo($quote);
        }
        $quote->reserveOrderId();

        $order->setItems($this->resolveItems($quote));
        if ($quote->getCustomer()) {
            $order->setCustomerId($quote->getCustomer()->getId());
        }
        $order->setQuoteId($quote->getId());
        $order->setCustomerEmail($quote->getCustomerEmail());
        $order->setCustomerFirstname($quote->getCustomerFirstname());
        $order->setCustomerMiddlename($quote->getCustomerMiddlename());
        $order->setCustomerLastname($quote->getCustomerLastname());

        try {
            $order = $this->orderManagement->place($order);
            $quote->setIsActive(false);
            $this->quoteRepository->save($quote);
        } catch (\Exception $e) {
            throw $e;
        }

        return $order;
    }

    /**
     * @param Quote $quote
     * @return array
     */
    protected function resolveItems(QuoteEntity $quote)
    {
        $quoteItems = [];
        foreach ($quote->getAllItems() as $quoteItem) {
            /** @var \Magento\Quote\Model\ResourceModel\Quote\Item $quoteItem */
            $quoteItems[$quoteItem->getId()] = $quoteItem;
        }
        $orderItems = [];
        foreach ($quoteItems as $quoteItem) {
            $parentItem = (isset($orderItems[$quoteItem->getParentItemId()])) ?
                $orderItems[$quoteItem->getParentItemId()] : null;
            $orderItems[$quoteItem->getId()] =
                $this->quoteItemToOrderItem->convert($quoteItem, ['parent_item' => $parentItem]);
        }
        return array_values($orderItems);
    }
}

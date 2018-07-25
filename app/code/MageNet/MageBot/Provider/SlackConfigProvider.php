<?php
/**
 * @author Pavel Usachev <webcodekeeper@hotmail.com>
 * @copyright Copyright (c) 2017, Pavel Usachev
 */

namespace MageNet\MageBot\Provider;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class SlackConfigProvider implements SlackConfigProviderInterface
{
    /** @var ScopeConfigInterface */
    protected $scopeConfig;

    /**
     * SlackConfigProvider constructor.
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    public function isEnabled()
    {
        return (bool) $this->scopeConfig->getValue(self::IS_ENABLED_CONFIG_NODE_XML, ScopeInterface::SCOPE_STORES);
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->scopeConfig->getValue(self::TOKEN_CONFIG_NODE_XML, ScopeInterface::SCOPE_STORE);
    }
}

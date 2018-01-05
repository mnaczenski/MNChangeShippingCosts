<?php
namespace MNChangeShippingCosts;
use Shopware\Components\Plugin\Context\ActivateContext;
use Shopware\Components\Plugin\Context\DeactivateContext;

class MNChangeShippingCosts extends \Shopware\Components\Plugin
{
    public function activate(ActivateContext $context)
    {
        $context->scheduleClearCache(ActivateContext::CACHE_LIST_DEFAULT);
    }
    public function deactivate(DeactivateContext $context)
    {
        $context->scheduleClearCache(DeactivateContext::CACHE_LIST_DEFAULT);
    }

    public static function getSubscribedEvents()
    {
        return [
            'sAdmin::sGetPremiumShippingcosts::after' => 'changeShippingCosts'
        ];
    }

    public function changeShippingCosts(\Enlight_Hook_HookArgs $arguments)
    {
        $return = $arguments->getReturn();

        if($return['netto'] != $return['brutto'])
        {
            $return['netto'] = $return['brutto']/($return['tax']/100+1);
        }

        return $return;
    }
}
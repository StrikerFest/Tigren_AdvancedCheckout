<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright  Copyright (c)  2023.  Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\AdvancedCheckout\Model\Config;

use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Class GetOffDate
 * @package Tigren\AdvancedCheckout\Model\Config
 * Tigren Solutions <info@tigren.com>
 */
class GetOffDate implements ConfigProviderInterface
{
    private ScopeConfigInterface $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
    ) {
        $this->scopeConfig = $scopeConfig;

    }

    /**
     * @return array
     */
    public function getConfig(): array
    {
        $daysOff = $this->scopeConfig->getValue('delivery_configuration/general/delivery_day_off',
            ScopeInterface::SCOPE_STORE);
        $daysOffArray = explode(",", $daysOff);

        $daysOffArrayCode = [];
        foreach ($daysOffArray as $dayOff){
            switch ($dayOff){
                case 'sunday':
                    $daysOffArrayCode[] = 0;
                    break;
                case 'monday':
                    $daysOffArrayCode[] = 1;
                    break;
                case 'tuesday':
                    $daysOffArrayCode[] = 2;
                    break;
                case 'wednesday':
                    $daysOffArrayCode[] = 3;
                    break;
                case 'thursday':
                    $daysOffArrayCode[] = 4;
                    break;
                case 'friday':
                    $daysOffArrayCode[] = 5;
                    break;
                case 'saturday':
                    $daysOffArrayCode[] = 6;
                    break;
                default:
                    break;
            }
        }

        $datesOff = $this->scopeConfig->getValue('delivery_configuration/general/delivery_date_off',
            ScopeInterface::SCOPE_STORE);

        $config = [];
        $config['daysOffArrayCode'] = $daysOffArrayCode;
        $config['datesOff'] = json_decode($datesOff);
        return $config;
    }
}

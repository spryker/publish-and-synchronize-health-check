<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantSalesOrderGui\Communication\Form\DataProvider;

use Spryker\Zed\MerchantSalesOrderGui\Communication\Form\EventItemTriggerForm;
use Spryker\Zed\MerchantSalesOrderGui\Communication\Form\EventTriggerForm;

class EventItemTriggerFormDataProvider
{
    protected const SUBMIT_BUTTON_CLASS = 'btn btn-primary btn-sm trigger-order-single-event';

    protected const URL_PARAM_ID_MERCHANT_SALES_ORDER_ITEM = 'id-merchant-sales-order-item';
    protected const URL_PARAM_REDIRECT = 'redirect';
    protected const URL_PARAM_EVENT_NAME = 'event';

    /**
     * @phpstan-return array<string, mixed>
     *
     * @param int $idMerchantSalesOrderItem
     * @param string $eventName
     * @param string $redirect
     *
     * @return array
     */
    public function getOptions(
        int $idMerchantSalesOrderItem,
        string $eventName,
        string $redirect
    ): array {
        return [
            EventItemTriggerForm::OPTION_EVENT => $eventName,
            EventItemTriggerForm::OPTION_ACTION_QUERY_PARAMETERS => [
                static::URL_PARAM_ID_MERCHANT_SALES_ORDER_ITEM => $idMerchantSalesOrderItem,
                static::URL_PARAM_EVENT_NAME => $eventName,
                static::URL_PARAM_REDIRECT => $redirect,
            ],
            EventTriggerForm::OPTION_SUBMIT_BUTTON_CLASS => static::SUBMIT_BUTTON_CLASS,
        ];
    }
}

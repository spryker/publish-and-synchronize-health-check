/**
 * Copyright (c) 2017-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

'use strict';

var DependentSelectBox = require('ZedGuiModules/libs/dependent-select-box');

$(document).ready(function() {
    var $activeFrom = $('#price_product_schedule_activeFrom_date');
    var $activeTo = $('#price_product_schedule_activeTo_date');
    var $store = $('#price_product_schedule_priceProduct_moneyValue_store_idStore');
    var $currency = $('#price_product_schedule_priceProduct_moneyValue_currency_idCurrency');

    $activeFrom.datepicker({
        altFormat: "yy-mm-dd",
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        defaultData: 0,
    });

    $activeTo.datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        defaultData: 0,
    });

    $($store, $currency).find('option').eq(0).attr('disabled', true);

    new DependentSelectBox(
        $store,
        $currency,
        '/currency/currencies-for-store',
        'idStore'
    );
});

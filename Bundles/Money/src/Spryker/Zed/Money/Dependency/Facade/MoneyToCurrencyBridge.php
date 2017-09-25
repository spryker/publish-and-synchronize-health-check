<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Money\Dependency\Facade;

class MoneyToCurrencyBridge implements MoneyToCurrencyInterface
{

    /**
     * @var \Spryker\Zed\Currency\Business\CurrencyFacadeInterface
     */
    protected $currencyFacade;

    /**
     * @param \Spryker\Zed\Currency\Business\CurrencyFacadeInterface $currencyFacade
     */
    public function __construct($currencyFacade)
    {
        $this->currencyFacade = $currencyFacade;
    }

    /**
     * @param string $isoCode
     *
     * @return \Generated\Shared\Transfer\CurrencyTransfer
     */
    public function fromIsoCode($isoCode)
    {
        return $this->currencyFacade->fromIsoCode($isoCode);
    }

    /**
     * @return \Generated\Shared\Transfer\CurrencyTransfer[]
     */
    public function getStoreCurrencies()
    {
        return $this->currencyFacade->getCurrentStoreCurrencies();
    }

    /**
     * @return \Generated\Shared\Transfer\StoreCurrencyTransfer[]
     */
    public function getAvailableStoreCurrencies()
    {
        return $this->currencyFacade->getAvailableStoreCurrencies();
    }

}

<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PriceProductOffer\Business;

use Generated\Shared\Transfer\MoneyValueTransfer;
use Generated\Shared\Transfer\PriceProductTransfer;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\PriceProductOffer\Business\Constraint\GreaterThanOrEmptyConstraint;
use Spryker\Zed\PriceProductOffer\Business\Constraint\TransferConstraint;
use Spryker\Zed\PriceProductOffer\Business\Constraint\ValidUniqueStoreCurrencyGrossNetPriceDataConstraint;
use Spryker\Zed\PriceProductOffer\Business\Expander\ProductOfferExpander;
use Spryker\Zed\PriceProductOffer\Business\Expander\ProductOfferExpanderInterface;
use Spryker\Zed\PriceProductOffer\Business\Validator\PriceProductOfferValidator;
use Spryker\Zed\PriceProductOffer\Business\Validator\PriceProductOfferValidatorInterface;
use Spryker\Zed\PriceProductOffer\Business\Writer\PriceProductOfferWriter;
use Spryker\Zed\PriceProductOffer\Business\Writer\PriceProductOfferWriterInterface;
use Spryker\Zed\PriceProductOffer\Dependency\External\PriceProductOfferToValidationAdapterInterface;
use Spryker\Zed\PriceProductOffer\Dependency\Facade\PriceProductOfferToPriceProductFacadeInterface;
use Spryker\Zed\PriceProductOffer\PriceProductOfferDependencyProvider;
use Symfony\Component\Validator\Constraint as SymfonyConstraint;

/**
 * @method \Spryker\Zed\PriceProductOffer\Persistence\PriceProductOfferEntityManagerInterface getEntityManager()
 * @method \Spryker\Zed\PriceProductOffer\Persistence\PriceProductOfferRepositoryInterface getRepository()
 * @method \Spryker\Zed\PriceProductOffer\PriceProductOfferConfig getConfig()
 */
class PriceProductOfferBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \Spryker\Zed\PriceProductOffer\Business\Writer\PriceProductOfferWriterInterface
     */
    public function createPriceProductOfferWriter(): PriceProductOfferWriterInterface
    {
        return new PriceProductOfferWriter(
            $this->getPriceProductFacade(),
            $this->getEntityManager(),
            $this->getRepository()
        );
    }

    /**
     * @return \Spryker\Zed\PriceProductOffer\Business\Expander\ProductOfferExpanderInterface
     */
    public function createProductOfferExpander(): ProductOfferExpanderInterface
    {
        return new ProductOfferExpander($this->getRepository());
    }

    /**
     * @return \Spryker\Zed\PriceProductOffer\Business\Validator\PriceProductOfferValidatorInterface
     */
    public function createPriceProductOfferValidator(): PriceProductOfferValidatorInterface
    {
        return new PriceProductOfferValidator(
            $this->getPriceProductOfferValidatorConstraints(),
            $this->getValidationAdapter()
        );
    }

    /**
     * @return \Symfony\Component\Validator\Constraint[]
     */
    public function getPriceProductOfferValidatorConstraints(): array
    {
        return [
            $this->getPriceProductFacade()->getValidCurrencyAssignedToStoreConstraint(),
            $this->createValidUniqueStoreCurrencyGrossNetPriceDataConstraint(),
            $this->createMoneyValueConstraint(),
        ];
    }

    /**
     * @return \Spryker\Zed\PriceProductOffer\Dependency\Facade\PriceProductOfferToPriceProductFacadeInterface
     */
    public function getPriceProductFacade(): PriceProductOfferToPriceProductFacadeInterface
    {
        return $this->getProvidedDependency(PriceProductOfferDependencyProvider::FACADE_PRICE_PRODUCT);
    }

    /**
     * @return \Symfony\Component\Validator\Constraint
     */
    public function createValidUniqueStoreCurrencyGrossNetPriceDataConstraint(): SymfonyConstraint
    {
        return new ValidUniqueStoreCurrencyGrossNetPriceDataConstraint($this->getRepository());
    }

    /**
     * @return \Symfony\Component\Validator\Constraint
     */
    public function createMoneyValueConstraint(): SymfonyConstraint
    {
        return new TransferConstraint([
            PriceProductTransfer::MONEY_VALUE => new TransferConstraint([
                    MoneyValueTransfer::NET_AMOUNT => new GreaterThanOrEmptyConstraint(['value' => 0]),
                    MoneyValueTransfer::GROSS_AMOUNT => new GreaterThanOrEmptyConstraint(['value' => 0]),
                ]),
            ]);
    }

    /**
     * @return \Spryker\Zed\PriceProductOffer\Dependency\External\PriceProductOfferToValidationAdapterInterface
     */
    public function getValidationAdapter(): PriceProductOfferToValidationAdapterInterface
    {
        return $this->getProvidedDependency(PriceProductOfferDependencyProvider::EXTERNAL_ADAPTER_VALIDATION);
    }
}

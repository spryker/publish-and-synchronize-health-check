<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Customer\Business;

use Spryker\Zed\Customer\Business\Anonymizer\CustomerAnonymizer;
use Spryker\Zed\Customer\Business\Checkout\CustomerOrderSaver;
use Spryker\Zed\Customer\Business\Checkout\CustomerOrderSaverInterface;
use Spryker\Zed\Customer\Business\Checkout\CustomerOrderSaverWithMultiShippingAddress;
use Spryker\Zed\Customer\Business\Customer\Address;
use Spryker\Zed\Customer\Business\Customer\Customer;
use Spryker\Zed\Customer\Business\Customer\CustomerReader;
use Spryker\Zed\Customer\Business\Customer\CustomerReaderInterface;
use Spryker\Zed\Customer\Business\Customer\EmailValidator;
use Spryker\Zed\Customer\Business\CustomerExpander\CustomerExpander;
use Spryker\Zed\Customer\Business\Model\CustomerOrderSaver as ObsoleteCustomerOrderSaver;
use Spryker\Zed\Customer\Business\Model\PreConditionChecker;
use Spryker\Zed\Customer\Business\ReferenceGenerator\CustomerReferenceGenerator;
use Spryker\Zed\Customer\Business\Sales\CustomerOrderHydrator;
use Spryker\Zed\Customer\Business\StrategyResolver\OrderSaverStrategyResolver;
use Spryker\Zed\Customer\Business\StrategyResolver\OrderSaverStrategyResolverInterface;
use Spryker\Zed\Customer\CustomerDependencyProvider;
use Spryker\Zed\Customer\Dependency\Service\CustomerToCustomerServiceInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \Spryker\Zed\Customer\CustomerConfig getConfig()
 * @method \Spryker\Zed\Customer\Persistence\CustomerQueryContainerInterface getQueryContainer()
 * @method \Spryker\Zed\Customer\Persistence\CustomerEntityManagerInterface getEntityManager()
 * @method \Spryker\Zed\Customer\Persistence\CustomerRepositoryInterface getRepository()
 */
class CustomerBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \Spryker\Zed\Customer\Business\Customer\CustomerInterface
     */
    public function createCustomer()
    {
        $config = $this->getConfig();

        $customer = new Customer(
            $this->getQueryContainer(),
            $this->createCustomerReferenceGenerator(),
            $config,
            $this->createEmailValidator(),
            $this->getMailFacade(),
            $this->getLocaleQueryContainer(),
            $this->getStore(),
            $this->createCustomerExpander(),
            $this->getPostCustomerRegistrationPlugins()
        );

        return $customer;
    }

    /**
     * @return \Spryker\Zed\Customer\Business\Customer\CustomerReaderInterface
     */
    public function createCustomerReader(): CustomerReaderInterface
    {
        return new CustomerReader(
            $this->getEntityManager(),
            $this->getRepository(),
            $this->createAddress()
        );
    }

    /**
     * @return \Spryker\Zed\Customer\Business\Customer\AddressInterface
     */
    public function createAddress()
    {
        return new Address(
            $this->getQueryContainer(),
            $this->getCountryFacade(),
            $this->getLocaleFacade(),
            $this->createCustomerExpander(),
            $this->getRepository()
        );
    }

    /**
     * @return \Spryker\Zed\Customer\Dependency\Facade\CustomerToCountryInterface
     */
    protected function getCountryFacade()
    {
        return $this->getProvidedDependency(CustomerDependencyProvider::FACADE_COUNTRY);
    }

    /**
     * @return \Spryker\Zed\Customer\Dependency\Facade\CustomerToMailInterface
     */
    protected function getMailFacade()
    {
        return $this->getProvidedDependency(CustomerDependencyProvider::FACADE_MAIL);
    }

    /**
     * @return \Spryker\Zed\Customer\Dependency\Facade\CustomerToLocaleInterface
     */
    protected function getLocaleFacade()
    {
        return $this->getProvidedDependency(CustomerDependencyProvider::FACADE_LOCALE);
    }

    /**
     * @return \Spryker\Zed\Customer\Business\ReferenceGenerator\CustomerReferenceGeneratorInterface
     */
    protected function createCustomerReferenceGenerator()
    {
        return new CustomerReferenceGenerator(
            $this->getSequenceNumberFacade(),
            $this->getConfig()->getCustomerReferenceDefaults()
        );
    }

    /**
     * @return \Spryker\Zed\Customer\Dependency\Facade\CustomerToSequenceNumberInterface
     */
    protected function getSequenceNumberFacade()
    {
        return $this->getProvidedDependency(CustomerDependencyProvider::FACADE_SEQUENCE_NUMBER);
    }

    /**
     * @return \Spryker\Zed\Customer\Business\Model\CustomerOrderSaverInterface
     */
    public function createCustomerOrderSaver()
    {
        return new ObsoleteCustomerOrderSaver($this->createCustomer(), $this->createAddress());
    }

    /**
     * @deprecated  Use createCheckoutCustomerOrderSaverWithMultiShippingAddress() instead.
     *
     * @return \Spryker\Zed\Customer\Business\Checkout\CustomerOrderSaverInterface
     */
    public function createCheckoutCustomerOrderSaver()
    {
        return new CustomerOrderSaver($this->createCustomer(), $this->createAddress());
    }

    /**
     * @return \Spryker\Zed\Customer\Business\Checkout\CustomerOrderSaverInterface
     */
    public function createCheckoutCustomerOrderSaverWithMultiShippingAddress(): CustomerOrderSaverInterface
    {
        return new CustomerOrderSaverWithMultiShippingAddress(
            $this->createCustomer(),
            $this->createAddress(),
            $this->getRepository()
        );
    }

    /**
     * @return \Spryker\Zed\Customer\Business\Model\PreConditionCheckerInterface
     */
    public function createPreConditionChecker()
    {
        return new PreConditionChecker($this->createCustomer(), $this->getUtilValidateService());
    }

    /**
     * @return \Spryker\Zed\Customer\Business\Anonymizer\CustomerAnonymizer
     */
    public function createCustomerAnonymizer()
    {
        return new CustomerAnonymizer(
            $this->getQueryContainer(),
            $this->createCustomer(),
            $this->createAddress(),
            $this->getCustomerAnonymizerPlugins()
        );
    }

    /**
     * @return \Spryker\Zed\Customer\Dependency\Plugin\CustomerAnonymizerPluginInterface[]
     */
    public function getCustomerAnonymizerPlugins()
    {
        return $this->getProvidedDependency(CustomerDependencyProvider::PLUGINS_CUSTOMER_ANONYMIZER);
    }

    /**
     * @return \Spryker\Zed\Locale\Persistence\LocaleQueryContainerInterface
     */
    protected function getLocaleQueryContainer()
    {
        return $this->getProvidedDependency(CustomerDependencyProvider::QUERY_CONTAINER_LOCALE);
    }

    /**
     * @return \Spryker\Shared\Kernel\Store
     */
    protected function getStore()
    {
        return $this->getProvidedDependency(CustomerDependencyProvider::STORE);
    }

    /**
     * @return \Spryker\Zed\Customer\Business\Sales\CustomerOrderHydratorInterface
     */
    public function createCustomerOrderHydrator()
    {
        return new CustomerOrderHydrator(
            $this->createCustomer()
        );
    }

    /**
     * @return \Spryker\Zed\Customer\Business\Customer\EmailValidatorInterface
     */
    protected function createEmailValidator()
    {
        return new EmailValidator(
            $this->getQueryContainer(),
            $this->getUtilValidateService()
        );
    }

    /**
     * @return \Spryker\Zed\Customer\Dependency\Service\CustomerToUtilValidateServiceInterface
     */
    protected function getUtilValidateService()
    {
        return $this->getProvidedDependency(CustomerDependencyProvider::SERVICE_UTIL_VALIDATE);
    }

    /**
     * @return \Spryker\Zed\Customer\Dependency\Service\CustomerToCustomerServiceInterface
     */
    public function getCustomerService(): CustomerToCustomerServiceInterface
    {
        return $this->getProvidedDependency(CustomerDependencyProvider::SERVICE_CUSTOMER);
    }

    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     *
     * @return \Spryker\Zed\Customer\Business\StrategyResolver\OrderSaverStrategyResolverInterface
     */
    public function createCustomerOrderSaverStrategyResolver(): OrderSaverStrategyResolverInterface
    {
        $strategyContainer = [];

        $strategyContainer = $this->addStrategyCustomerOrderSaverWithoutMultipleShippingAddress($strategyContainer);
        $strategyContainer = $this->addStrategyCustomerOrderSaverWithMultipleShippingAddress($strategyContainer);

        return new OrderSaverStrategyResolver($this->getCustomerService(), $strategyContainer);
    }

    /**
     * @param array $strategyContainer
     *
     * @return array
     */
    protected function addStrategyCustomerOrderSaverWithoutMultipleShippingAddress(array $strategyContainer): array
    {
        $strategyContainer[OrderSaverStrategyResolverInterface::STRATEGY_KEY_WITHOUT_MULTI_SHIPMENT] = function () {
            return $this->createCustomerOrderSaver();
        };

        return $strategyContainer;
    }

    /**
     * @param array $strategyContainer
     *
     * @return array
     */
    protected function addStrategyCustomerOrderSaverWithMultipleShippingAddress(array $strategyContainer): array
    {
        $strategyContainer[OrderSaverStrategyResolverInterface::STRATEGY_KEY_WITH_MULTI_SHIPMENT] = function () {
            return $this->createCheckoutCustomerOrderSaverWithMultiShippingAddress();
        };

        return $strategyContainer;
    }

    /**
     * @return \Spryker\Zed\Customer\Dependency\Plugin\CustomerTransferExpanderPluginInterface[]
     */
    protected function getCustomerTransferExpanderPlugins()
    {
        return $this->getProvidedDependency(CustomerDependencyProvider::PLUGINS_CUSTOMER_TRANSFER_EXPANDER);
    }

    /**
     * @return \Spryker\Zed\CustomerExtension\Dependency\Plugin\PostCustomerRegistrationPluginInterface[]
     */
    public function getPostCustomerRegistrationPlugins()
    {
        return $this->getProvidedDependency(CustomerDependencyProvider::PLUGINS_POST_CUSTOMER_REGISTRATION);
    }

    /**
     * @return \Spryker\Zed\Customer\Business\CustomerExpander\CustomerExpanderInterface
     */
    public function createCustomerExpander()
    {
        return new CustomerExpander(
            $this->getCustomerTransferExpanderPlugins()
        );
    }
}

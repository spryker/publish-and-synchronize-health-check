<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PriceProductOffer\Business;

use ArrayObject;
use Generated\Shared\Transfer\PriceProductOfferCollectionValidationResponseTransfer;
use Generated\Shared\Transfer\PriceProductOfferCriteriaTransfer;
use Generated\Shared\Transfer\PriceProductTransfer;
use Generated\Shared\Transfer\ProductOfferTransfer;

interface PriceProductOfferFacadeInterface
{
    /**
     * Specification:
     * - Persists Product prices using the PriceProduct facade.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ProductOfferTransfer $productOfferTransfer
     *
     * @return \Generated\Shared\Transfer\ProductOfferTransfer
     */
    public function saveProductOfferPrices(ProductOfferTransfer $productOfferTransfer): ProductOfferTransfer;

    /**
     * Specification:
     * - Persists Price Product Offer entities.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PriceProductTransfer $priceProductTransfer
     *
     * @return \Generated\Shared\Transfer\PriceProductTransfer
     */
    public function savePriceProductOfferRelation(PriceProductTransfer $priceProductTransfer): PriceProductTransfer;

    /**
     * Specification:
     * - Expands provided ProductOfferTransfer with PriceProduct transfers.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ProductOfferTransfer $productOfferTransfer
     *
     * @return \Generated\Shared\Transfer\ProductOfferTransfer
     */
    public function expandProductOfferWithPrices(ProductOfferTransfer $productOfferTransfer): ProductOfferTransfer;

    /**
     * Specification:
     * - Validates PriceProductTransfer stack.
     * - Сhecks if there are duplicated prices for store-currency-gross-net-price_data combinations (per price dimension).
     * - Checks that currency assigned to a store per prices.
     * - Returns PriceProductValidationResponse transfer object.
     *
     * @api
     *
     * @param \ArrayObject|\Generated\Shared\Transfer\PriceProductTransfer[] $priceProductTransfers
     *
     * @return \Generated\Shared\Transfer\PriceProductOfferCollectionValidationResponseTransfer
     */
    public function validateProductOfferPrices(ArrayObject $priceProductTransfers): PriceProductOfferCollectionValidationResponseTransfer;

    /**
     * Specification:
     * - Deletes entities from `spy_price_product_offer` using priceProductOfferIds from PriceProductOfferTransfer.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PriceProductOfferCriteriaTransfer $priceProductOfferCriteriaTransfer
     *
     * @return void
     */
    public function delete(PriceProductOfferCriteriaTransfer $priceProductOfferCriteriaTransfer): void;

    /**
     * Specification:
     * - Retrives and returns count of entities from `spy_price_product_offer` over PriceProductOfferTransfer.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PriceProductOfferCriteriaTransfer $priceProductOfferCriteriaTransfer
     *
     * @return int
     */
    public function count(PriceProductOfferCriteriaTransfer $priceProductOfferCriteriaTransfer): int;

    /**
     * Specification:
     * - Retrives collection of PriceProductTransfer over PriceProductOfferCriteriaTransfer.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PriceProductOfferCriteriaTransfer $priceProductOfferCriteriaTransfer
     *
     * @return \ArrayObject|\Generated\Shared\Transfer\PriceProductTransfer[]
     */
    public function getProductOfferPrices(PriceProductOfferCriteriaTransfer $priceProductOfferCriteriaTransfer): ArrayObject;
}

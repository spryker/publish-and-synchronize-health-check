<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\PriceProductStorageExtension\Dependency\Plugin;

interface PriceProductStoragePricesExtractorPluginInterface
{
    /**
     * Specification:
     * - Extracts additional product prices from price product data
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PriceProductTransfer[] $priceProductTransfers
     *
     * @return \Generated\Shared\Transfer\PriceProductTransfer[]
     */
    public function extractProductPricesForProductAbstract(
        array $priceProductTransfers
    ): array;

    /**
     * Specification:
     * - Extracts additional product prices from price product data for product conrete
     * - Uses id to fetch price from abstract product if needed
     *
     * @api
     *
     * @param int $idProductAbstract
     * @param \Generated\Shared\Transfer\PriceProductTransfer[] $priceProductTransfers
     *
     * @return \Generated\Shared\Transfer\PriceProductTransfer[]
     */
    public function extractProductPricesForProductConcrete(
        int $idProductAbstract,
        array $priceProductTransfers
    ): array;
}

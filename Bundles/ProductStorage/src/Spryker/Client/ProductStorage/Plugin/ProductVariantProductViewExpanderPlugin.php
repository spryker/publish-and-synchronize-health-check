<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\ProductStorage\Plugin;

use Generated\Shared\Transfer\ProductViewTransfer;
use Spryker\Client\Kernel\AbstractPlugin;
use Spryker\Client\ProductStorageExtension\Dependency\Plugin\ProductConcreteViewExpanderExcluderPluginInterface;
use Spryker\Client\ProductStorageExtension\Dependency\Plugin\ProductViewExpanderPluginInterface;

/**
 * @method \Spryker\Client\ProductStorage\ProductStorageFactory getFactory()
 */
class ProductVariantProductViewExpanderPlugin extends AbstractPlugin implements ProductViewExpanderPluginInterface, ProductConcreteViewExpanderExcluderPluginInterface
{
    /**
     * {@inheritDoc}
     * - Expands the transfer object with an attribute map and a product variant map.
     * - Marks the product variants with an only one possible value as the selected ones.
     * - Expands the transfer object with product concrete ID using the values of `selectedAttributes`.
     *
     * @param \Generated\Shared\Transfer\ProductViewTransfer $productViewTransfer
     * @param array $productData
     * @param string $localeName
     *
     * @return \Generated\Shared\Transfer\ProductViewTransfer
     */
    public function expandProductViewTransfer(ProductViewTransfer $productViewTransfer, array $productData, $localeName)
    {
        return $this->getFactory()
            ->createVariantExpander()
            ->expandProductViewWithProductVariant($productViewTransfer, $localeName);
    }
}

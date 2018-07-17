<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PriceProductVolume\Business\PriceProductReader;

use Generated\Shared\Transfer\PriceProductTransfer;
use Spryker\Zed\PriceProductVolume\Dependency\Facade\PriceProductVolumeToPriceProductFacadeInterface;
use Spryker\Zed\PriceProductVolume\Persistence\PriceProductVolumeRepositoryInterface;

class PriceProductReader implements PriceProductReaderInterface
{
    /**
     * @var \Spryker\Zed\PriceProductVolume\Persistence\PriceProductVolumeRepositoryInterface
     */
    protected $priceProductRepository;

    /**
     * @var \Spryker\Zed\PriceProductVolume\Dependency\Facade\PriceProductVolumeToPriceProductFacadeInterface
     */
    protected $priceProductFacade;

    /**
     * @param \Spryker\Zed\PriceProductVolume\Persistence\PriceProductVolumeRepositoryInterface $priceProductRepository
     * @param \Spryker\Zed\PriceProductVolume\Dependency\Facade\PriceProductVolumeToPriceProductFacadeInterface $priceProductFacade
     */
    public function __construct(
        PriceProductVolumeRepositoryInterface $priceProductRepository,
        PriceProductVolumeToPriceProductFacadeInterface $priceProductFacade
    ) {
        $this->priceProductRepository = $priceProductRepository;
        $this->priceProductFacade = $priceProductFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\PriceProductTransfer $priceProductTransfer
     *
     * @return array
     */
    public function getPriceProductAbstractFromPriceProduct(PriceProductTransfer $priceProductTransfer): array
    {
        $idProductAbstract = $this->priceProductRepository->findIdProductAbstractForPriceProduct($priceProductTransfer);

        if (!$idProductAbstract) {
            return [];
        }

        return $this->priceProductFacade->findProductAbstractPricesWithoutPriceExtraction($idProductAbstract);
    }
}

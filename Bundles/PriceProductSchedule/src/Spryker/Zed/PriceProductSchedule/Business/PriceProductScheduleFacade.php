<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PriceProductSchedule\Business;

use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Spryker\Zed\PriceProductSchedule\Business\PriceProductScheduleBusinessFactory getFactory()
 * @method \Spryker\Zed\PriceProductSchedule\Persistence\PriceProductScheduleEntityManagerInterface getEntityManager()
 * @method \Spryker\Zed\PriceProductSchedule\Persistence\PriceProductScheduleRepositoryInterface getRepository()
 */
class PriceProductScheduleFacade extends AbstractFacade implements PriceProductScheduleFacadeInterface
{
    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @return void
     */
    public function applyScheduledPrices(): void
    {
        $this->getFactory()
            ->createPriceProductScheduleApplier()
            ->applyScheduledPrices();
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @return void
     */
    public function cleanAppliedScheduledPrices(int $daysRetained): void
    {
        $this->getFactory()
            ->createPriceProductScheduleCleaner()
            ->cleanAppliedScheduledPrices($daysRetained);
    }
}
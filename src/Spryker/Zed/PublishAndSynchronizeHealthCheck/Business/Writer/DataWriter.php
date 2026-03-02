<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PublishAndSynchronizeHealthCheck\Business\Writer;

use Generated\Shared\Transfer\PublishAndSynchronizeHealthCheckTransfer;
use Spryker\Zed\PublishAndSynchronizeHealthCheck\Persistence\PublishAndSynchronizeHealthCheckEntityManagerInterface;

class DataWriter implements DataWriterInterface
{
    /**
     * @var \Spryker\Zed\PublishAndSynchronizeHealthCheck\Persistence\PublishAndSynchronizeHealthCheckEntityManagerInterface
     */
    protected $publishAndSynchronizeHealthCheckEntityManager;

    public function __construct(PublishAndSynchronizeHealthCheckEntityManagerInterface $publishAndSynchronizeHealthCheckEntityManager)
    {
        $this->publishAndSynchronizeHealthCheckEntityManager = $publishAndSynchronizeHealthCheckEntityManager;
    }

    public function savePublishAndSynchronizeHealthCheckEntity(): PublishAndSynchronizeHealthCheckTransfer
    {
        return $this->publishAndSynchronizeHealthCheckEntityManager->upsertPublishAndSynchronizeHealthCheckEntity();
    }
}

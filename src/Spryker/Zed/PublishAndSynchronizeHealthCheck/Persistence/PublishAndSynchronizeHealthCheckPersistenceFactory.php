<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PublishAndSynchronizeHealthCheck\Persistence;

use Orm\Zed\PublishAndSynchronizeHealthCheck\Persistence\SpyPublishAndSynchronizeHealthCheckQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;
use Spryker\Zed\PublishAndSynchronizeHealthCheck\Persistence\Propel\Mapper\PublishAndSynchronizeHealthCheckMapper;

/**
 * @method \Spryker\Zed\PublishAndSynchronizeHealthCheck\Persistence\PublishAndSynchronizeHealthCheckEntityManagerInterface getEntityManager()
 * @method \Spryker\Zed\PublishAndSynchronizeHealthCheck\PublishAndSynchronizeHealthCheckConfig getConfig()
 * @method \Spryker\Zed\PublishAndSynchronizeHealthCheck\Persistence\PublishAndSynchronizeHealthCheckRepositoryInterface getRepository()
 */
class PublishAndSynchronizeHealthCheckPersistenceFactory extends AbstractPersistenceFactory
{
    public function createPublishAndSynchronizeHealthCheckQuery(): SpyPublishAndSynchronizeHealthCheckQuery
    {
        return SpyPublishAndSynchronizeHealthCheckQuery::create();
    }

    public function createPublishAndSynchronizeHealthCheckMapper(): PublishAndSynchronizeHealthCheckMapper
    {
        return new PublishAndSynchronizeHealthCheckMapper();
    }
}

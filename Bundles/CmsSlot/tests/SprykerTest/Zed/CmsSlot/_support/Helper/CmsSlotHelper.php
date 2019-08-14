<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\CmsSlot\Helper;

use Codeception\Module;
use Generated\Shared\DataBuilder\CmsSlotBuilder;
use Generated\Shared\DataBuilder\CmsSlotTemplateBuilder;
use Generated\Shared\Transfer\CmsSlotTemplateTransfer;
use Generated\Shared\Transfer\CmsSlotTransfer;
use SprykerTest\Shared\Testify\Helper\LocatorHelperTrait;

class CmsSlotHelper extends Module
{
    use LocatorHelperTrait;

    /**
     * @param array $override
     *
     * @return \Generated\Shared\Transfer\CmsSlotTransfer
     */
    public function haveCmsSlot(array $override = []): CmsSlotTransfer
    {
        $data = [
            CmsSlotTransfer::KEY => 'test-center',
            CmsSlotTransfer::CONTENT_PROVIDER_TYPE => 'SprykerTestBlock',
            CmsSlotTransfer::NAME => 'Test Name',
            CmsSlotTransfer::DESCRIPTION => 'Test description.',
            CmsSlotTransfer::IS_ACTIVE => true,
        ];

        $cmsSlotTransfer = (new CmsSlotBuilder(array_merge($data, $override)))->build();

        return $cmsSlotTransfer;
    }

    /**
     * @param array $override
     *
     * @return \Generated\Shared\Transfer\CmsSlotTemplateTransfer
     */
    public function haveCmsSlotTemplate(array $override = []): CmsSlotTemplateTransfer
    {
        $data = [
            CmsSlotTemplateTransfer::PATH => '@TestModule/views/test/test.twig',
            CmsSlotTemplateTransfer::NAME => 'Test Name',
            CmsSlotTemplateTransfer::DESCRIPTION => 'Test description.',
        ];

        $cmsSlotTemplateTransfer = (new CmsSlotTemplateBuilder(array_merge($data, $override)))->build();

        return $cmsSlotTemplateTransfer;
    }
}
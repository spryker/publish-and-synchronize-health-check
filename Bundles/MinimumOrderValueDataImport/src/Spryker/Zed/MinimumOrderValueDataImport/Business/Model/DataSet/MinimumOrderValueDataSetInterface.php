<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Spryker\Zed\MinimumOrderValueDataImport\Business\Model\DataSet;

interface MinimumOrderValueDataSetInterface
{
    public const COLUMN_STORE = 'store';
    public const COLUMN_CURRENCY = 'currency';
    public const COLUMN_STRATEGY = 'strategy';
    public const COLUMN_THRESHOLD = 'threshold';
    public const COLUMN_FEE = 'fee';
}

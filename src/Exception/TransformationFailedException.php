<?php

/*
 * This file is part of the ModelTransformer package
 *
 * (c) FiveLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FiveLab\Component\ModelTransformer\Exception;

use FiveLab\Component\Exception\UnexpectedTrait;

/**
 * Fail transform
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class TransformationFailedException extends \Exception
{
    use UnexpectedTrait;
}

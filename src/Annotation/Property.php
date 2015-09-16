<?php

/*
 * This file is part of the ModelTransformer package
 *
 * (c) FiveLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FiveLab\Component\ModelTransformer\Annotation;

/**
 * Indicate property for available in transformation
 *
 * @Annotation
 * @Target("PROPERTY")
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class Property
{
    /** @var string */
    public $propertyName;
    /** @var array */
    public $groups = [];
    /** @var bool */
    public $shouldTransform = false;
    /** @var string */
    public $expressionValue = '';
}

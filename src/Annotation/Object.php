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
 * Indicate object for available transform
 *
 * @Annotation
 * @Target("CLASS")
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class Object
{
    /** @var string @Required */
    public $transformedClass;

    /** @var string*/
    public $evaluateConstructor = false;
}

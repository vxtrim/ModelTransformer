<?php

/*
 * This file is part of the ModelTransformer package
 *
 * (c) FiveLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FiveLab\Component\ModelTransformer\Transformer;

use FiveLab\Component\ModelTransformer\ContextInterface;
use FiveLab\Component\ModelTransformer\Exception\UnsupportedClassException;
use FiveLab\Component\ModelTransformer\ModelTransformerManagerAwareInterface;
use FiveLab\Component\ModelTransformer\ModelTransformerInterface;
use FiveLab\Component\ModelTransformer\ModelTransformerManagerInterface;

/**
 * Transform \Traversable instances
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class TraversableModelTransformer extends AbstractTraversableModelTransformer
{
    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        return is_a($class, 'Traversable', true);
    }

    /**
     * {@inheritDoc}
     */
    protected function createCollection($collection)
    {
        $class = get_class($collection);
        $transformed = new $class();

        return $transformed;
    }
}

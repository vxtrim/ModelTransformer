<?php

/*
 * This file is part of the ModelTransformer package
 *
 * (c) FiveLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FiveLab\Component\ModelTransformer;

/**
 * ModelTransformerManagerAwareInterface should be implemented by classes that depends on a ModelTransformerInterface.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
interface ModelTransformerManagerAwareInterface
{
    /**
     * It should receive transformer to work with underlying objects.
     *
     * @param ModelTransformerManagerInterface $manager
     *
     * @return mixed
     */
    public function setModelTransformerManager(ModelTransformerManagerInterface $manager);
}

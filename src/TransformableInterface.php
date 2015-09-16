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
 * Allows to use transformation directly in application entity, document or domain object.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
interface TransformableInterface
{
    /**
     * It receives model transformer for possibility to transform children.
     *
     * @param ModelTransformerManagerInterface $transformerManager
     * @param ContextInterface                 $context
     *
     * @return object
     */
    public function transformToModel(ModelTransformerManagerInterface $transformerManager, ContextInterface $context);
}

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
 * Transform instances, if instance implement "TransformableInterface"
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class TransformableModelTransformer implements ModelTransformerInterface, ModelTransformerManagerAwareInterface
{
    /**
     * @var ModelTransformerInterface
     */
    private $manager;

    /**
     * {@inheritdoc}
     */
    public function setModelTransformerManager(ModelTransformerManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($object, ContextInterface $context = null)
    {
        if (!$this->supportsClass(get_class($object))) {
            throw UnsupportedClassException::create($object);
        }

        return $object->transformToModel($this->manager, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        return is_a($class, 'FiveLab\Component\ModelTransformer\TransformableInterface', true);
    }
}

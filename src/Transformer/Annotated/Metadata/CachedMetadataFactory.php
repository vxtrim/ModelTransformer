<?php

/*
 * This file is part of the ModelTransformer package
 *
 * (c) FiveLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FiveLab\Component\ModelTransformer\Transformer\Annotated\Metadata;

use FiveLab\Component\Cache\CacheInterface;

/**
 * Cached metadata factory
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class CachedMetadataFactory implements MetadataFactoryInterface
{
    /**
     * @var MetadataFactoryInterface
     */
    private $delegate;

    /**
     * @var CacheInterface
     */
    private $cache;

    /**
     * Construct
     *
     * @param MetadataFactoryInterface $delegate
     * @param CacheInterface           $cache
     */
    public function __construct(MetadataFactoryInterface $delegate, CacheInterface $cache)
    {
        $this->delegate = $delegate;
        $this->cache = $cache;
    }

    /**
     * {@inheritDoc}
     */
    public function supportsClass($class)
    {
        if (is_object($class)) {
            $class = get_class($class);
        }

        $key = 'model_transformer.annotated.classes';

        $classes = $this->cache->get($key);

        if (null === $classes) {
            $classes = [];
        }

        $mustUpdateCache = false;

        if (!isset($classes[$class])) {
            $supports = $this->delegate->supportsClass($class);
            $classes[$class] = $supports;
            $mustUpdateCache = true;
        } else {
            $supports = $classes[$class];
        }

        if ($mustUpdateCache) {
            $this->cache->set($key, $classes);
        }

        return $supports;
    }

    /**
     * {@inheritDoc}
     */
    public function loadMetadata($class)
    {
        if (is_object($class)) {
            $class = get_class($class);
        }

        $key = 'model_transformer.annotated:' . $class;

        $metadata = $this->cache->get($key);

        if (null === $metadata) {
            $metadata = $this->delegate->loadMetadata($class);
            $this->cache->set($key, $metadata);
        }

        return $metadata;
    }
}

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

/**
 * Object transformation metadata
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class ObjectMetadata
{
    /**
     * @var string
     */
    private $transformedClass;

    /**
     * @var array|PropertyMetadata[]
     */
    private $properties;

    /** @var  bool */
    private $evaluateConstructor;

    /**
     * Construct
     *
     * @param string                   $transformedClass
     * @param bool                     $evaluateConstructor
     * @param array|PropertyMetadata[] $properties
     */
    public function __construct($transformedClass, $evaluateConstructor, array $properties)
    {
        $this->transformedClass = $transformedClass;
        $this->evaluateConstructor = $evaluateConstructor;
        $this->properties = $properties;
    }

    /**
     * Get transformed class
     *
     * @return string
     */
    public function getTransformedClass()
    {
        return $this->transformedClass;
    }

    /**
     * Return true if need evaluate constructor
     *
     * @return boolean
     */
    public function isEvaluateConstructor()
    {
        return $this->evaluateConstructor;
    }

    /**
     * Get properties
     *
     * @return array|PropertyMetadata[]
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * Get properties for groups
     *
     * @param array $groups
     *
     * @return array|PropertyMetadata[]
     */
    public function getPropertiesForGroups(array $groups)
    {
        $properties = [];

        foreach ($groups as $group) {
            foreach ($this->properties as $key => $property) {
                if (in_array($group, $property->getGroups())) {
                    $properties[$key] = $property;
                }
            }
        }

        return $properties;
    }
}

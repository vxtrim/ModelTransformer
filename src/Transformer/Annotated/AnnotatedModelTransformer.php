<?php

/*
 * This file is part of the ModelTransformer package
 *
 * (c) FiveLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FiveLab\Component\ModelTransformer\Transformer\Annotated;

use FiveLab\Component\Reflection\Reflection;
use FiveLab\Component\ModelTransformer\ContextInterface;
use FiveLab\Component\ModelTransformer\Exception\TransformationFailedException;
use FiveLab\Component\ModelTransformer\ModelTransformerInterface;
use FiveLab\Component\ModelTransformer\ModelTransformerManagerAwareInterface;
use FiveLab\Component\ModelTransformer\ModelTransformerManagerInterface;
use FiveLab\Component\ModelTransformer\Transformer\Annotated\Metadata\MetadataFactoryInterface;
use FiveLab\Component\ModelTransformer\Transformer\Annotated\Metadata\PropertyMetadata;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

/**
 * Annotated model transformer
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class AnnotatedModelTransformer implements ModelTransformerInterface, ModelTransformerManagerAwareInterface
{
    /**
     * @var ModelTransformerManagerInterface
     */
    private $transformerManager;

    /**
     * @var MetadataFactoryInterface
     */
    private $metadataFactory;

    /**
     * @var ExpressionLanguage
     */
    private $expressionLanguage;

    /**
     * Construct
     *
     * @param MetadataFactoryInterface $metadataFactory
     * @param ExpressionLanguage       $expressionLanguage
     */
    public function __construct(
        MetadataFactoryInterface $metadataFactory,
        ExpressionLanguage $expressionLanguage = null
    ) {
        $this->metadataFactory = $metadataFactory;
        $this->expressionLanguage = $expressionLanguage;
    }

    /**
     * {@inheritDoc}
     */
    public function setModelTransformerManager(ModelTransformerManagerInterface $manager)
    {
        $this->transformerManager = $manager;
    }

    /**
     * {@inheritDoc}
     */
    public function transform($object, ContextInterface $context)
    {
        $metadata = $this->metadataFactory->loadMetadata(get_class($object));

        // Get properties for transformation
        if (!$context->getGroups()) {
            $transformProperties = $metadata->getProperties();
        } else {
            $transformProperties = $metadata->getPropertiesForGroups($context->getGroups());
        }

        // Try create transformed
        $transformedClass = $metadata->getTransformedClass();
        $transformedReflection = Reflection::loadClassReflection($transformedClass);
        $transformed = ($metadata->isEvaluateConstructor())
            ? $transformedReflection->newInstance()
            : $transformedReflection->newInstanceWithoutConstructor();

        foreach ($transformProperties as $transformPropertyName => $propertyMetadata) {
            try {
                $objectPropertyReflection = Reflection::loadPropertyReflection($object, $transformPropertyName);
            } catch (\ReflectionException $e) {
                throw new \RuntimeException(sprintf(
                    'Error transform property: Not found property "%s" in class "%s".',
                    $transformPropertyName,
                    get_class($object)
                ), 0, $e);
            }

            try {
                $transformedPropertyReflection = $transformedReflection->getProperty(
                    $propertyMetadata->getPropertyName()
                );
            } catch (\ReflectionException $e) {
                throw new \RuntimeException(sprintf(
                    'Error transform property: Not found property "%s" in class "%s".',
                    $propertyMetadata->getPropertyName(),
                    $transformedReflection->getName()
                ));
            }

            if (!$transformedPropertyReflection->isPublic()) {
                $transformedPropertyReflection->setAccessible(true);
            }

            if (!$objectPropertyReflection->isPublic()) {
                $objectPropertyReflection->setAccessible(true);
            }

            $objectPropertyValue = $objectPropertyReflection->getValue($object);

            $transformedValue = $this->transformValue(
                $object,
                $objectPropertyValue,
                $propertyMetadata,
                $transformedPropertyReflection
            );

            $transformedPropertyReflection->setValue($transformed, $transformedValue);
        }

        return $transformed;
    }

    /**
     * {@inheritDoc}
     */
    public function supportsClass($class)
    {
        return $this->metadataFactory->supportsClass($class);
    }

    /**
     * Transform value
     *
     * @param object              $object
     * @param mixed               $value
     * @param PropertyMetadata    $metadata
     * @param \ReflectionProperty $property
     *
     * @return mixed
     *
     * @throws TransformationFailedException
     */
    protected function transformValue($object, $value, PropertyMetadata $metadata, \ReflectionProperty $property)
    {
        // Check, if should use expression language for get value
        if ($metadata->getExpressionValue()) {
            if (!$this->expressionLanguage) {
                throw new \LogicException(
                    'Can not evaluate expression language. Please inject ExpressionLanguage to transformer.'
                );
            }

            $attributes = [
                'object' => $object,
                'value' => $value
            ];

            $value = $this->expressionLanguage->evaluate($metadata->getExpressionValue(), $attributes);
        }

        // Check, if should use transformer for this value (recursive) and value is not null
        if ($metadata->isShouldTransform() && $value !== null) {
            if (!is_object($value)) {
                throw new TransformationFailedException(sprintf(
                    'Can not transform property "%s" in class "%s". The value must be a object, but "%s" given.',
                    $property->getName(),
                    $property->getDeclaringClass()->getName(),
                    gettype($value)
                ));
            }

            return $this->transformerManager->transform($value);
        }

        return $value;
    }
}

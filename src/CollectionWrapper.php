<?php
/**
 * This file is part of Vegas package
 *
 * @author Slawomir Zytko <slawek@amsterdam-standard.pl>
 * @copyright Amsterdam Standard Sp. Z o.o.
 * @homepage http://vegas-cmf.github.io
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vegas\ApiDoc;

use Vegas\ApiDoc\Exception\CollectionDefinitionNotFoundException;

/**
 * Class CollectionWrapper
 * @package Vegas\ApiDoc
 */
class CollectionWrapper
{
    /**
     * @var \Phalcon\Annotations\Annotation
     */
    private $annotation;

    /**
     * @var CollectionAbstract
     */
    private $collection;

    /**
     * Creates wrapper for specific collection
     *
     * @param $collectionName
     * @param \Phalcon\Annotations\Annotation $annotation
     * @throws CollectionDefinitionNotFoundException
     */
    public function __construct($collectionName, \Phalcon\Annotations\Annotation $annotation)
    {
        try {
            $this->collection = call_user_func(function() use ($collectionName) {
                $reflectionClass = new \ReflectionClass(__NAMESPACE__ . '\\Collection\\' . ucfirst($collectionName) . 'Collection');
                return $reflectionClass->newInstance();
            });

            $this->annotation = $annotation;

            $this->mapCollectionWrapper();
        } catch (\ReflectionException $e) {
            throw new CollectionDefinitionNotFoundException($collectionName);
        }
    }

    /**
     * Maps annotations to collection object
     *
     * @throws Exception\CollectionArgumentNotFoundException
     */
    public function mapCollectionWrapper()
    {
        foreach ($this->annotation->getArguments() as $argument => $value) {
            $this->collection->setArgument($argument, $value);
        }
    }

    /**
     * Returns mapped collection
     *
     * @return CollectionAbstract
     */
    public function getCollection()
    {
        return $this->collection;
    }
} 
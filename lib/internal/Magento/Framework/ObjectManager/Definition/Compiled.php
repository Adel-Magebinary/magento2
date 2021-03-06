<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Framework\ObjectManager\Definition;

/**
 * Compiled class definitions. Should be used for maximum performance in production.
 */
abstract class Compiled implements \Magento\Framework\ObjectManager\DefinitionInterface
{
    /**
     * Class definitions
     *
     * @var array
     */
    protected $_definitions;

    /**
     * @param array $definitions
     */
    public function __construct(array $definitions)
    {
        list($this->_signatures, $this->_definitions) = $definitions;
    }

    /**
     * Unpack signature
     *
     * @param string $signature
     * @return mixed
     */
    abstract protected function _unpack($signature);

    /**
     * Get list of method parameters
     *
     * Retrieve an ordered list of constructor parameters.
     * Each value is an array with following entries:
     *
     * array(
     *     0, // string: Parameter name
     *     1, // string|null: Parameter type
     *     2, // bool: whether this param is required
     *     3, // mixed: default value
     * );
     *
     * @param string $className
     * @return array|null
     */
    public function getParameters($className)
    {
        $definition = $this->_definitions[$className];
        if ($definition !== null) {
            if (is_string($this->_signatures[$definition])) {
                $this->_signatures[$definition] = $this->_unpack($this->_signatures[$definition]);
            }
            return $this->_signatures[$definition];
        }
        return null;
    }

    /**
     * Retrieve list of all classes covered with definitions
     *
     * @return array
     */
    public function getClasses()
    {
        return array_keys($this->_definitions);
    }
}

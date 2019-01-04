<?php

namespace cms\tests\Traits;

trait PrivateActions
{
    /**
     * Получение приватного свойства
     *
     * @param  mixed $className
     * @param  mixed $propertyName
     *
     * @return mixed
     */
    public function getPrivatePropertyValue($model, $propertyName)
    {
        $reflector = new \ReflectionClass($model::className());
        $property = $reflector->getProperty($propertyName);
        $property->setAccessible(true);
        return $property->getValue($model);
    }

    /**
     * setPrivatePropertyValue
     *
     * @param  object $model
     * @param  string $propertyName
     * @param  array $value
     *
     * @return void
     */
    public function setPrivatePropertyValue($model, $propertyName, $value = [])
    {
        $reflector = new \ReflectionClass($model::className());
        $property = $reflector->getProperty($propertyName);
        $property->setAccessible(true);
        $property->setValue($model, $value);
        return $property;
    }

    /**
     * Получение приватной функции
     *
     * @param  object $object
     * @param  string $methodName
     * @param  array $parameters
     *
     * @return object|null
     */
    public function invokePrivateMethod($classObject, $methodName, array $parameters = [])
    {
        $reflector = new \ReflectionClass($classObject::className());
        $method = $reflector->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($classObject, $parameters);
    }
}

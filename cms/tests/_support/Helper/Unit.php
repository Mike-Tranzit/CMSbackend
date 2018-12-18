<?php
namespace cms\tests\Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Unit extends \Codeception\Module
{
    /**
     * todo 'Перенести в treid вместе с методом из ProfileTest'
     */

    /**
     * Получение приватного свойства
     *
     * @param  mixed $className
     * @param  mixed $propertyName
     *
     * @return void
     */
    public function getPrivateProperty($className, $propertyName)
    {
        $reflector = new \ReflectionClass($className);
        $property = $reflector->getProperty($propertyName);
        $property->setAccessible(true);
        return $property;
    }

    /**
     * Получение приватной функции
     *
     * @param  mixed $className
     * @param  mixed $methodName
     *
     * @return object
     */
    public function getPrivateMethod($object, $methodName, $parameters = [])
    {
      $reflector = new \ReflectionClass($object::className());
      $method = $reflector->getMethod($methodName);
      $method->setAccessible(true);
      return $method->invokeArgs($object, $parameters);
    }
}

<?php
namespace cms\tests\Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use yii\web\HttpException;

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
     * @param  object $object
     * @param  string $methodName
     * @param  array $parameters
     *
     * @return object|null
     */
    public function getPrivateMethod(object $classObject, string $methodName, array $parameters = [])
    {
        $reflector = new \ReflectionClass($classObject::className());
        $method = $reflector->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($classObject, $parameters);
    }


    /**
     * Проверка
     *
     * @param  mixed $e
     * @param  mixed $code
     * @param  mixed $message
     *
     * @return void
     */
    public function checkExceptionData(HttpException $e, $code, $message)
    {
        expect('Check Exception code', $e->statusCode)->equals($code);
        expect("Check Exception message", $e->getMessage())->equals($message);
    }

    /**
     * Создаем рандомный класс
     *
     * @param  array $properties
     *
     * @return object
     */
    public function createCustomClass($properties)
    {
        $class = new \stdClass();
        foreach($properties as $key => $value) {
            $class->$key = $value;
        }
        return $class;
    }

    /**
     * Формирование списка полей для mock schema
     *
     * @param  string $modelName
     *
     * @return void
     */
    public function createColumnsListToMockModels($modelName)
    {
        $model = new $modelName();
        $columns = array_keys($model->attributeLabels());

        $columnsToSchema = [];
        foreach($columns as $item) {
            $columnsToSchema[$item] =  $this->createCustomClass(['defaultValue' => true, 'name' => $item]);
        }
        return $columnsToSchema;
    }
}

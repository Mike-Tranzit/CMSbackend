<?php

namespace admin\tests\v1\Traits;

use AspectMock\Test as Test;
use admin\tests\v1\Traits\PrivateActions;

trait AspectMockModels
{
    use PrivateActions;

    /**
     * Mock for AR
     *
     * @param  array|object $params
     *
     * @return object
     */
    public function mockActiveRecord($params, $modelName = 'yii\db\ActiveQuery')
    {
        return Test::double($modelName, $params);
    }


    /**
     * Возврат AR save
     *
     * @param  boolean $resultAction
     *
     * @return object
     */
    public function mockDefaultSaveAction(bool $resultAction)
    {
        return $this->mockActiveRecord(
            ['save' => $resultAction],
            'yii\db\BaseActiveRecord'
        );
    }


    /**
     * Метод используется при необходимости эмитировать метод save при создании новой записи
     *
     * @param  string $className
     * @param  boolean $resultAction
     *
     * @return object
     */
    public function mockNewSaveAction(string $className, bool $resultAction = true)
    {
        // Берем и формируем список полей в нужном нам формате [$key => object]
        $columns = $this->createColumnsListToMockModels($className);

        // При создании новой записи AR запрашивает список полей модели, для того чтобы AR не запрашивал БД переопределим этот метод
        $model = $this->mockActiveRecord(
            [
            'getTableSchema' => $this->createCustomClass(
                ['columns' => $columns]
            )],
            'yii\db\ActiveRecord'
        );

        return $this->mockDefaultSaveAction($resultAction);
    }


    /**
     * Формирование списка полей для mock schema
     *
     * @param  string $modelName
     *
     * @return void
     */
    public function createColumnsListToMockModels($className)
    {
        $model = new $className();
        $columns = array_keys($model->attributeLabels());

        $columnsToSchema = [];
        foreach ($columns as $item) {
            $columnsToSchema[$item] =  $this->createCustomClass(['defaultValue' => true, 'name' => $item]);
        }
        return $columnsToSchema;
    }
}

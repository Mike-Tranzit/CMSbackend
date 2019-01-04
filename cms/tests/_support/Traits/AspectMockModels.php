<?php

namespace cms\tests\Traits;

use AspectMock\Test as Test;

trait AspectMockModels
{
    
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
        return $this->mockActiveRecord(['save' => $resultAction], 'yii\db\BaseActiveRecord');
    }
}
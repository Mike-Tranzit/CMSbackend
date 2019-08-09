<?php

namespace admin\tests\v1\Traits;

trait CustomClassActions
{
    /**
     * Создаем рандомный класс
     *
     * @param  array $properties
     *
     * @return object
     */
    public function createCustomClass($properties, $class = null)
    {
        if(!$class) $class = new \stdClass();
        foreach($properties as $key => $value) {
            $class->$key = $value;
        }
        return $class;
    }
}

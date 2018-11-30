<?php
namespace cms\tests\Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Unit extends \Codeception\Module
{
    /**
     * todo 'Перенести в treid вместе с методом из ProfileTest'
     */
    public function getPrivateProperty( $className, $propertyName ) {
		$reflector = new \ReflectionClass( $className );
		$property = $reflector->getProperty( $propertyName );
		$property->setAccessible( true );
		return $property;
    }
}
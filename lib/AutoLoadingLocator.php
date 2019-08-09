<?php

namespace lib;

class AutoLoadingLocator implements \Go\ParserReflection\LocatorInterface
{
    public function locateClass($className)
    {
        return (new ReflectionClass($className))->getFileName();
    }
}
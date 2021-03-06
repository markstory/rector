<?php

namespace Rector\TypeDeclaration\Tests\Rector\Property\CompleteVarDocTypePropertyRector\Fixture;

use Rector\TypeDeclaration\Tests\Rector\Property\CompleteVarDocTypePropertyRector\Source\SomeService;

class SkipMoreSpecific
{
    /**
     * @var SomeService[]
     */
    private static $registry = [];
    /**
     * register an SomeService for using.
     *
     * @param SomeService $service
     */
    public static function register(SomeService $service)
    {
        self::$registry[$service->getLabel()] = $service;
    }
    /**
     * find registered SomeService.
     *
     * @return SomeService[]
     */
    public static function getRegisteredSomeServices()
    {
        return self::$registry;
    }
}

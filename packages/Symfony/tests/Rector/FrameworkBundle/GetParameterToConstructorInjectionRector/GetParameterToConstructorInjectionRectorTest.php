<?php

declare(strict_types=1);

namespace Rector\Symfony\Tests\Rector\FrameworkBundle\GetParameterToConstructorInjectionRector;

use Iterator;
use Rector\Symfony\Rector\FrameworkBundle\GetParameterToConstructorInjectionRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;

final class GetParameterToConstructorInjectionRectorTest extends AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(string $file): void
    {
        $this->doTestFile($file);
    }

    public function provideData(): Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }

    protected function getRectorClass(): string
    {
        return GetParameterToConstructorInjectionRector::class;
    }
}

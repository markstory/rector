<?php

declare(strict_types=1);

namespace Rector\RemovingStatic\Tests\Rector\Class_\PHPUnitStaticToKernelTestCaseGetRector;

use Iterator;
use Rector\Core\Testing\PHPUnit\AbstractRectorTestCase;
use Rector\RemovingStatic\Rector\Class_\PHPUnitStaticToKernelTestCaseGetRector;
use Rector\RemovingStatic\Tests\Rector\Class_\PHPUnitStaticToKernelTestCaseGetRector\Source\ClassWithStaticMethods;
use Symplify\SmartFileSystem\SmartFileInfo;

final class PHPUnitStaticToKernelTestCaseGetRectorTest extends AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(SmartFileInfo $fileInfo): void
    {
        $this->doTestFileInfo($fileInfo);
    }

    public function provideData(): Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }

    /**
     * @return mixed[]
     */
    protected function getRectorsWithConfiguration(): array
    {
        return [
            PHPUnitStaticToKernelTestCaseGetRector::class => [
                PHPUnitStaticToKernelTestCaseGetRector::STATIC_CLASS_TYPES => [ClassWithStaticMethods::class],
            ],
        ];
    }
}

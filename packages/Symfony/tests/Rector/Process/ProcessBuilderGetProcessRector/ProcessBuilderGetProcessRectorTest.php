<?php

declare(strict_types=1);

namespace Rector\Symfony\Tests\Rector\Process\ProcessBuilderGetProcessRector;

use Iterator;
use Rector\Symfony\Rector\Process\ProcessBuilderGetProcessRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;

final class ProcessBuilderGetProcessRectorTest extends AbstractRectorTestCase
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
        return ProcessBuilderGetProcessRector::class;
    }
}

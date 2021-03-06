<?php

declare(strict_types=1);

use PhpParser\Node\Expr\ShellExec;
use PhpParser\Node\Scalar\EncapsedStringPart;

$parts = [new EncapsedStringPart('first part'), new EncapsedStringPart('second part')];

return new ShellExec($parts);

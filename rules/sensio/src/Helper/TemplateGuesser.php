<?php

declare(strict_types=1);

namespace Rector\Sensio\Helper;

use Nette\Utils\Strings;
use PhpParser\Node\Stmt\ClassMethod;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\Sensio\BundleClassResolver;

/**
 * @see \Rector\Sensio\Tests\Rector\ClassMethod\TemplateAnnotationToThisRenderRector\TemplateAnnotationToThisRenderRectorTest
 */
final class TemplateGuesser
{
    /**
     * @var string
     */
    private const BUNDLE_SUFFIX_REGEX = '#Bundle$#';

    /**
     * @var string
     */
    private const BUNDLE_NAME_MATCHING_REGEX = '#(?<bundle>[\w]*Bundle)#';

    /**
     * @var string
     */
    private const SMALL_LETTER_BIG_LETTER_REGEX = '#([a-z\d])([A-Z])#';

    /**
     * @var string
     */
    private const CONTROLLER_NAME_MATCH_REGEX = '#Controller\\\(.+)Controller$#';

    /**
     * @var string
     */
    private const ACTION_MATCH_REGEX = '#Action$#';

    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;

    /**
     * @var BundleClassResolver
     */
    private $bundleClassResolver;

    public function __construct(BundleClassResolver $bundleClassResolver, NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->bundleClassResolver = $bundleClassResolver;
    }

    public function resolveFromClassMethodNode(ClassMethod $classMethod): string
    {
        $namespace = $classMethod->getAttribute(AttributeKey::NAMESPACE_NAME);
        if (! is_string($namespace)) {
            throw new ShouldNotHappenException();
        }

        $class = $classMethod->getAttribute(AttributeKey::CLASS_NAME);
        if (! is_string($class)) {
            throw new ShouldNotHappenException();
        }

        $method = $this->nodeNameResolver->getName($classMethod);
        if ($method === null) {
            throw new ShouldNotHappenException();
        }

        return $this->resolve($namespace, $class, $method);
    }

    /**
     * Mimics https://github.com/sensiolabs/SensioFrameworkExtraBundle/blob/v5.0.0/Templating/TemplateGuesser.php
     */
    private function resolve(string $namespace, string $class, string $method): string
    {
        $bundle = $this->resolveBundle($class, $namespace);
        $controller = $this->resolveController($class);

        $action = Strings::replace($method, self::ACTION_MATCH_REGEX);

        $fullPath = '';
        if ($bundle !== '') {
            $fullPath .= $bundle . '/';
        }

        if ($controller !== '') {
            $fullPath .= $controller . '/';
        }

        return $fullPath . $action . '.html.twig';
    }

    private function resolveBundle(string $class, string $namespace): string
    {
        $shortBundleClass = $this->bundleClassResolver->resolveShortBundleClassFromControllerClass($class);
        if ($shortBundleClass !== null) {
            return '@' . $shortBundleClass;
        }

        $bundle = Strings::match($namespace, self::BUNDLE_NAME_MATCHING_REGEX)['bundle'] ?? '';
        $bundle = Strings::replace($bundle, self::BUNDLE_SUFFIX_REGEX);
        return $bundle !== '' ? '@' . $bundle : '';
    }

    private function resolveController(string $class): string
    {
        $match = Strings::match($class, self::CONTROLLER_NAME_MATCH_REGEX);
        if (! $match) {
            return '';
        }

        $controller = Strings::replace($match[1], self::SMALL_LETTER_BIG_LETTER_REGEX, '\\1_\\2');
        return str_replace('\\', '/', $controller);
    }
}

<?php

declare(strict_types=1);

use Rector\Caching\ValueObject\Storage\FileCacheStorage;
use Rector\CodeQuality\Rector\Class_\InlineConstructorDefaultToPropertyRector;
use Rector\Config\RectorConfig;
use Rector\Php82\Rector\Class_\ReadOnlyClassRector;
use Rector\PHPUnit\CodeQuality\Rector\Class_\PreferPHPUnitSelfCallRector;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\Symfony\CodeQuality\Rector\Class_\EventListenerToEventSubscriberRector;
use Rector\Symfony\Set\SymfonySetList;
use Rector\Symfony\Symfony61\Rector\Class_\CommandPropertyToAttributeRector;
use Rector\ValueObject\PhpVersion;

$symfonyContainer = __DIR__.'/var/cache/test/Infrastructure_Symfony_KernelTestDebugContainer.xml';
if (file_exists(__DIR__.'/var/cache/dev/Infrastructure_Symfony_KernelDevDebugContainer.xml')) {
    $symfonyContainer = __DIR__.'/var/cache/dev/Infrastructure_Symfony_KernelDevDebugContainer.xml';
}

return RectorConfig::configure()
    ->withPaths([
        __DIR__.'/config',
        __DIR__.'/src',
        // __DIR__.'/tests',
    ])
    ->withPhpVersion(PhpVersion::PHP_82)
    ->withSkip([
        '**/config/bundles.php',
        EventListenerToEventSubscriberRector::class,
    ])
    ->withCache(
        cacheClass: FileCacheStorage::class,
        cacheDirectory: 'var/cache/ci/rector',
    )
    ->withSymfonyContainerXml($symfonyContainer)
    ->withImportNames(importShortClasses: false)
    ->withPreparedSets(
        codeQuality: true,
        deadCode: true,
        earlyReturn: true,
        instanceOf: true,
        privatization: true,
        strictBooleans: true,
        typeDeclarations: true,
    )
    ->withAttributesSets(symfony: true, phpunit: true)
    ->withSets([
        SymfonySetList::SYMFONY_71,
        SymfonySetList::SYMFONY_CODE_QUALITY,
        PHPUnitSetList::PHPUNIT_100,
        PHPUnitSetList::PHPUNIT_CODE_QUALITY,
    ])
    ->withRules([
        InlineConstructorDefaultToPropertyRector::class,
        ReadOnlyClassRector::class,
        CommandPropertyToAttributeRector::class,
        PreferPHPUnitSelfCallRector::class,
    ])
;

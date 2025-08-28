<?php

namespace WPPluginSkeleton_Vendor;

use WPPluginSkeleton_Vendor\VAF\WP\Framework\Facade\Facade;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\Facade\Attribute\AsFacade;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\Kernel\WordpressKernel;
use WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection\Container;
/** @internal */
class TestService
{
    public function doSomething() : string
    {
        return 'something done';
    }
    public function doSomethingWithArgs(string $arg1, int $arg2) : string
    {
        return "args: {$arg1}, {$arg2}";
    }
}
/** @internal */
\class_alias('WPPluginSkeleton_Vendor\\TestService', 'TestService', \false);
/** @internal */
#[AsFacade(TestService::class)]
class TestServiceFacade extends Facade
{
}
/** @internal */
\class_alias('WPPluginSkeleton_Vendor\\TestServiceFacade', 'TestServiceFacade', \false);
beforeEach(function () {
    Facade::clearResolvedInstances();
});
test('facade can call methods on underlying service', function () {
    $container = new Container();
    $testService = new TestService();
    $container->set(TestService::class, $testService);
    $kernel = $this->createMock(WordpressKernel::class);
    $kernel->method('getContainer')->willReturn($container);
    Facade::setKernel($kernel);
    expect(TestServiceFacade::doSomething())->toBe('something done');
});
test('facade can call methods with arguments', function () {
    $container = new Container();
    $testService = new TestService();
    $container->set(TestService::class, $testService);
    $kernel = $this->createMock(WordpressKernel::class);
    $kernel->method('getContainer')->willReturn($container);
    Facade::setKernel($kernel);
    expect(TestServiceFacade::doSomethingWithArgs('hello', 42))->toBe('args: hello, 42');
});
test('facade caches resolved instances', function () {
    $container = new Container();
    $testService = new TestService();
    $container->set(TestService::class, $testService);
    $kernel = $this->createMock(WordpressKernel::class);
    $kernel->method('getContainer')->willReturn($container);
    Facade::setKernel($kernel);
    // First call
    TestServiceFacade::doSomething();
    // Second call should use cached instance
    expect(TestServiceFacade::doSomething())->toBe('something done');
});
test('facade throws exception when kernel not set', function () {
    Facade::setKernel(null);
    TestServiceFacade::doSomething();
})->throws(\LogicException::class, 'Facade kernel has not been set.');
test('clear resolved instances removes all cached instances', function () {
    $container = new Container();
    $testService = new TestService();
    $container->set(TestService::class, $testService);
    $kernel = $this->createMock(WordpressKernel::class);
    $kernel->method('getContainer')->willReturn($container);
    Facade::setKernel($kernel);
    // Cache instance
    TestServiceFacade::doSomething();
    // Clear cache
    Facade::clearResolvedInstances();
    // This should resolve again
    expect(TestServiceFacade::doSomething())->toBe('something done');
});
test('clear resolved instance removes specific cached instance', function () {
    $container = new Container();
    $testService = new TestService();
    $container->set(TestService::class, $testService);
    $kernel = $this->createMock(WordpressKernel::class);
    $kernel->method('getContainer')->willReturn($container);
    Facade::setKernel($kernel);
    // Cache instance
    TestServiceFacade::doSomething();
    // Clear specific cache
    Facade::clearResolvedInstance(TestService::class);
    // This should resolve again
    expect(TestServiceFacade::doSomething())->toBe('something done');
});

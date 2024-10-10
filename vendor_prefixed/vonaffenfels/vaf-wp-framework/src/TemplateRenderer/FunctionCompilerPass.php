<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\TemplateRenderer;

use Exception;
use ReflectionClass;
use ReflectionIntersectionType;
use ReflectionMethod;
use ReflectionUnionType;
use WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection\ContainerBuilder;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\TemplateRenderer\Attribute\IsFunction;
/** @internal */
class FunctionCompilerPass implements CompilerPassInterface
{
    private array $functionList = [];
    /**
     * @throws Exception
     */
    public function process(ContainerBuilder $container) : void
    {
        if (!$container->has(FunctionHandler::class)) {
            return;
        }
        $functionHandlerDefinition = $container->findDefinition(FunctionHandler::class);
        $functionContainer = $container->findTaggedServiceIds('template.functions');
        foreach ($functionContainer as $id => $tags) {
            $definition = $container->findDefinition($id);
            $definition->setPublic(\true);
            $this->getFunctionContainerData($definition->getClass(), $container);
        }
        $functionHandlerDefinition->setArgument('$functionList', $this->functionList);
    }
    /**
     * @throws Exception
     */
    private function getFunctionContainerData(string $class, ContainerBuilder $container) : void
    {
        $reflection = new ReflectionClass($class);
        foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            $methodName = $method->getName();
            // Check if the Hook attribute is present
            $attributes = $method->getAttributes(IsFunction::class);
            if (empty($attributes)) {
                continue;
            }
            /** @var IsFunction $instance */
            $instance = $attributes[0]->newInstance();
            # Check if we have to inject service containers into parameters
            $serviceParams = [];
            foreach ($method->getParameters() as $paramIdx => $parameter) {
                $type = $parameter->getType();
                if ($parameter->isVariadic() || $type instanceof ReflectionIntersectionType || $type instanceof ReflectionUnionType) {
                    continue;
                }
                if ($container->has($type->getName())) {
                    $serviceParams[$paramIdx] = $type->getName();
                    $container->findDefinition($type->getName())->setPublic(\true);
                }
            }
            $functionName = $instance->name;
            if (isset($this->functionList[$functionName])) {
                throw new Exception(\sprintf('Function %s is already defined!', $functionName));
            }
            $this->functionList[$functionName] = ['container' => $class, 'method' => $methodName, 'isSafeHTML' => $instance->safeHTML, 'serviceParams' => $serviceParams];
        }
    }
}

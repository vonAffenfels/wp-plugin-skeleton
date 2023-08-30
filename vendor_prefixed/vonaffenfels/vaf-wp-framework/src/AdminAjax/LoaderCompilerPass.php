<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\AdminAjax;

use Exception;
use ReflectionClass;
use ReflectionIntersectionType;
use ReflectionMethod;
use ReflectionUnionType;
use WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection\ContainerBuilder;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\AdminAjax\Attributes\AsAdminAjaxContainer;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\AdminAjax\Attributes\IsAdminAjaxAction;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\System\Parameters\Parameter;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\System\Parameters\ParameterBag;
final class LoaderCompilerPass implements CompilerPassInterface
{
    private array $allowedTypes = ['int', 'string', 'bool', 'array'];
    /**
     * @throws Exception
     */
    public function process(ContainerBuilder $container) : void
    {
        if (!$container->has('adminajax.loader')) {
            return;
        }
        $loaderDefinition = $container->findDefinition('adminajax.loader');
        $adminAjaxContainerServices = $container->findTaggedServiceIds('adminajax.container');
        $containerData = [];
        foreach ($adminAjaxContainerServices as $id => $tags) {
            $definition = $container->findDefinition($id);
            $definition->setPublic(\true);
            $containerData[$id] = $this->getContainerData($definition->getClass(), $container);
        }
        $loaderDefinition->setArgument('$adminAjaxContainer', $containerData);
    }
    /**
     * @throws Exception
     */
    private function getContainerData(string $class, ContainerBuilder $container) : array
    {
        $data = [];
        $reflection = new ReflectionClass($class);
        $attribute = $reflection->getAttributes(AsAdminAjaxContainer::class);
        if (empty($attribute)) {
            return $data;
        }
        foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            // Check if the Hook attribute is present
            $attribute = $method->getAttributes(IsAdminAjaxAction::class);
            if (empty($attribute)) {
                continue;
            }
            /** @var IsAdminAjaxAction $instance */
            $instance = $attribute[0]->newInstance();
            $methodName = $method->getName();
            $returnType = $method->getReturnType();
            if (\is_null($returnType) || $returnType->getName() !== Response::class) {
                throw new Exception(\sprintf('AdminAjaxAction "%s" must return object of type %s!', $instance->action, Response::class));
            }
            $parameterBag = new ParameterBag();
            foreach ($method->getParameters() as $parameter) {
                $type = $parameter->getType();
                if ($type instanceof ReflectionIntersectionType || $type instanceof ReflectionUnionType) {
                    throw new Exception(\sprintf('Parameter type for AdminAjaxAction "%s" can\'t be a union or intersection type!', $instance->action));
                }
                if (!\in_array($type->getName(), $this->allowedTypes) && !$container->has($type->getName())) {
                    throw new Exception(\sprintf('Parameter type "%s" for AdminAjaxAction "%s" is not allowed. ' . 'Only %s or registered service classes are allowed', $type->getName(), $instance->action, '"' . \implode('", "', $this->allowedTypes) . '"'));
                }
                $isServiceParam = \false;
                if ($container->has($type->getName())) {
                    $container->findDefinition($type->getName())->setPublic(\true);
                    $isServiceParam = \true;
                }
                $parameterBag->addParam(new Parameter(name: $parameter->getName(), type: $type->getName(), isOptional: $parameter->isOptional(), default: $parameter->isOptional() ? $parameter->getDefaultValue() : null, isServiceParam: $isServiceParam));
            }
            $data[] = ['callback' => $methodName, 'action' => $instance->action, 'params' => $parameterBag->toArray(), 'capability' => $instance->capability];
        }
        return $data;
    }
}

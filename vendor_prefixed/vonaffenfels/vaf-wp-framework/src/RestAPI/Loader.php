<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\RestAPI;

use Exception;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\BaseWordpress;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\Kernel\WordpressKernel;
use WPPluginSkeleton_Vendor\WP_REST_Request;
final class Loader
{
    public function __construct(private readonly WordpressKernel $kernel, private readonly BaseWordpress $base, private readonly array $restContainer)
    {
    }
    public function registerRestRoutes() : void
    {
        $name = $this->base->getName();
        foreach ($this->restContainer as $serviceId => $restContainer) {
            foreach ($restContainer as $restRoute) {
                $namespace = $name;
                if (!empty($restRoute['namespace'])) {
                    $namespace .= '/' . $restRoute['namespace'];
                }
                $params = [];
                foreach ($restRoute['serviceParams'] as $param => $service) {
                    $params[$param] = $this->kernel->getContainer()->get($service);
                }
                $methodName = $restRoute['callback'];
                $options = ['methods' => $restRoute['method']->value, 'callback' => function (WP_REST_Request $request) use($serviceId, $methodName, $params, $restRoute) : array {
                    $return = ['success' => \false];
                    foreach ($restRoute['params'] as $name) {
                        if (!isset($restRoute['paramsDefault'][$name]) && !$request->has_param($name)) {
                            throw new Exception(\sprintf('Parameter "%s" for RestRoute "%s"%s not provided and without default value.', $restRoute['paramsLower'][$name], $restRoute['uri'], !empty($restRoute['namespace'] ?? '') ? \sprintf(' of namespace "%s"', $restRoute['namespace']) : ''));
                        }
                        if ($request->has_param($name)) {
                            $value = $request->get_param($name);
                        } else {
                            $value = $restRoute['paramsDefault'][$name];
                        }
                        # Handle type
                        switch ($restRoute['paramTypes'][$name]) {
                            case 'int':
                                $value = (int) $value;
                                break;
                            case 'bool':
                                $value = \in_array(\strtolower($value), ['1', 'on', 'true']);
                                break;
                            case 'string':
                            default:
                                # Nothing to do as $value is already a string
                                break;
                        }
                        $params[$restRoute['paramsLower'][$name]] = $value;
                    }
                    try {
                        $container = $this->kernel->getContainer()->get($serviceId);
                        $retVal = $container->{$methodName}(...$params);
                        if ($retVal !== \false) {
                            $return['success'] = \true;
                            if (!\is_null($retVal)) {
                                $return['data'] = $retVal;
                            }
                        }
                    } catch (Exception $e) {
                        $return['success'] = \false;
                        $return['message'] = $e->getMessage();
                    }
                    return $return;
                }];
                register_rest_route($namespace, '/' . $restRoute['uri'], $options);
            }
        }
    }
}

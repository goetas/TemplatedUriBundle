<?php

namespace Hautelook\TemplatedUriBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class TemplatedRouterPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $router = $container->findDefinition('router.default');
        $argument = $router->getArgument(2);

        $templatedRouter = $container->findDefinition('hautelook.router.template');
        $templatedArgument = $templatedRouter->getArgument(2);
        if (isset($argument['resource_type'])) {
            $templatedArgument['resource_type'] = $argument['resource_type'];
        }
        if (isset($argument['strict_requirements'])) {
            $templatedArgument['strict_requirements'] = $argument['strict_requirements'];
        }
        $templatedRouter->replaceArgument(2, $templatedArgument);
    }
}


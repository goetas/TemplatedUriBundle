<?php

namespace Hautelook\TemplatedUriBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class TemplatedRouterPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $router = $container->findDefinition('router.default');
        $resourceOptions = $router->getArgument(2);

        $templatedRouter = $container->findDefinition('hautelook.router.template');
        $templatedResourceOptions = $templatedRouter->getArgument(2);
        if (isset($resourceOptions['resource_type'])) {
            $templatedResourceOptions['resource_type'] = $resourceOptions['resource_type'];
        }
        if (isset($resourceOptions['strict_requirements'])) {
            $templatedResourceOptions['strict_requirements'] = $resourceOptions['strict_requirements'];
        }
        $templatedRouter->replaceArgument(2, $templatedResourceOptions);

        $ref = new \ReflectionClass($templatedRouter->getClass());
        $cargs = $ref->getConstructor()->getParameters();
        if ($cargs[4]->getName() !== 'parameters') { // Symfony < 4
            $args = $templatedRouter->getArguments();
            unset($args[4]);
            $templatedRouter->setArguments(array_values($args));
        }
    }
}

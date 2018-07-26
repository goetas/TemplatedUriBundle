<?php
/**
 * Created by PhpStorm.
 * User: goetas
 * Date: 26.07.18
 * Time: 13:11
 */

namespace Hautelook\TemplatedUriBundle\Tests\DependencyInjection;

use Hautelook\TemplatedUriBundle\HautelookTemplatedUriBundle;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ContainerTest extends TestCase
{
    private function getContainer(array $configs = array())
    {
        $container = new ContainerBuilder();

        $container->setParameter('kernel.name', 'app');
        $container->setParameter('kernel.environment', 'test');
        $container->setParameter('kernel.debug', true);
        $container->setParameter('kernel.cache_dir', sys_get_temp_dir() . '/HautelookTemplatedUriBundle');
        $container->setParameter('kernel.bundles', array('HautelookTemplatedUriBundle' => 'Hautelook\TemplatedUriBundle\HautelookTemplatedUriBundle'));
        $container->setParameter('router.resource', array(
            'resource_type' => 'foo'
        ));


        $bundle = new HautelookTemplatedUriBundle();

        $extension = $bundle->getContainerExtension();
        $extension->load($configs, $container);

        return $container;
    }

    public function testConfig()
    {
        $container = $this->getContainer();
        $container->compile();
    }
}

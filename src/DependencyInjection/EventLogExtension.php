<?php

declare(strict_types=1);

namespace Otcstores\EventLog\DependencyInjection;

use Otcstores\EventLog\Doctrine\Helper\UserId;
use Otcstores\EventLog\User\TokenStorageUsernameCallable;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class EventLogExtension extends Extension implements PrependExtensionInterface
{

    public function load(array $configs, ContainerBuilder $container)
    {
    }

    public function prepend(ContainerBuilder $container)
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Config')
        );
        $container->setParameter('otcstores.dir', __DIR__.'/../');
        $loader->load('services.yaml');
    }

}
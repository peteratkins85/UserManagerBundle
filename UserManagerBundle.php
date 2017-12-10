<?php

namespace Oni\UserManagerBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Oni\UserManagerBundle\Security\UserSecurityFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class UserManagerBundle extends Bundle
{

    public function build(ContainerBuilder $container)
    {
//        parent::build($container);
//
//        $extension = $container->getExtension('security');
//        $extension->addSecurityListenerFactory(new UserSecurityFactory());

        //$container->setDefinition(new Definition())

    }

}

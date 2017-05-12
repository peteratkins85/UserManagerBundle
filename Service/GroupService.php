<?php
/**
 * Created by PhpStorm.
 * User: peteratkins
 * Date: 28/04/2016
 * Time: 08:25
 */

namespace Oni\UserManagerBundle\Service;


class GroupService {

    public function __construct(
        EncoderFactoryInterface $encoderFactory,
        ObjectManager $objectManager,
        $class
    ) {

        $this->encoderFactory = $encoderFactory;
        $this->userRepository = $objectManager->getRepository($class);

        $metadata = $objectManager->getClassMetadata($class);
        $this->class = $metadata->getName();


    }

}
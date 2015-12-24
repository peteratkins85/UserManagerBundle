<?php

namespace Cms\UserManagerBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;


use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * UsersRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository
{

    public function getUserByUsername($username , $returnType = 'OBJECT'){

        if (!$username){ return false; }

        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('u')
            ->from($this->usersTable, 'u')
            ->where('u.username = :username')
            ->setParameter('username', $username)
            ->setMaxResults(1);

        if ($returnType == 'ARRAY') {
            $results = $qb->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_SCALAR);
        }else{

            $results = $qb->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_OBJECT);
            //expecting only one result so set the result to the first array element
            $results = isset($results[0]) ? $results[0] : false;

        }

        return $results;

    }

}

<?php
/**
 * Created by PhpStorm.
 * User: peteratkins
 * Date: 07/05/2016
 * Time: 12:08
 */

namespace Oni\UserManagerBundle\Doctrine\Spec;


use Oni\CoreBundle\Doctrine\Spec\Specification;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

class FilterUsername implements Specification{

	private $username;

	public function __construct($username)
	{
		$this->username = $username;
	}

	public function match(QueryBuilder $qb, $dqlAlias)
	{
		$qb->setParameter('username', $this->username);

		return $qb->expr()->eq($dqlAlias . '.username', ':username');
	}

	public function modifyQuery(Query $query) { /* empty ***/ }
	
}
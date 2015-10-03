<?php

namespace Cms\UserManagerBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * Users
 */
class WebUsers extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var date
     */
    protected $created;

    /**
     * @var date
     */
    protected $modified;

    /**
     * @var date
     */
    protected $lastlogin;

    /**
     * @var date
     */
    protected $loggedIn;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}

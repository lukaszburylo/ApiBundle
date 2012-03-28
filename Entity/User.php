<?php
namespace nBurylo\ApiBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	public function __construct()
	{
		parent::__construct();
		// your own logic
	}
	/**
	 * @ORM\Column(name="firstname", type="string")
	 */
	protected $firstname;
	
	/**
	 * @ORM\Column(name="lastname", type="string")
	 */
	protected $lastname;
	
	/**
	 * @ORM\Column(name="facebookID", type="string")
	 */
	protected $facebookID;
	
	
	/**
	 * @ORM\Column(name="thumb", type="text")
	 */
	protected $picture;
	
	public function serialize()
	{
		return serialize(array($this->facebookID, parent::serialize()));
	}
	
	public function unserialize($data)
	{
		list($this->facebookID, $parentData) = unserialize($data);
		parent::unserialize($parentData);
	}
	
	public function getPicture() {
		return $this->picture;
	}
	
	public function setPicture($picture) {
		$this->picture = $picture;
	}
	
	public function getFirstname()
	{
		return $this->firstname;
	}
	
	/**
	 * @param string $firstname
	 */
	public function setFirstname($firstname)
	{
		$this->firstname = $firstname;
	}
	
	/**
	 * @return string
	 */
	public function getLastname()
	{
		return $this->lastname;
	}
	
	/**
	 * @param string $lastname
	 */
	public function setLastname($lastname)
	{
		$this->lastname = $lastname;
	}
	
	/**
	 * @param string $facebookID
	 * @return void
	 */
	public function setFacebookID($facebookID)
	{
		$this->facebookID = $facebookID;
		$this->setUsername($facebookID);
		$this->salt = '';
	}
	
	/**
	 * @return string
	 */
	public function getFacebookID()
	{
		return $this->facebookID;
	}
	
	/**
	 * @param Array
	 */
	public function setFBData($fbdata)
	{
		if (isset($fbdata['id'])) {
			$this->setFacebookID($fbdata['id']);
			$this->addRole('ROLE_FACEBOOK');
		}
		if (isset($fbdata['first_name'])) {
			$this->setFirstname($fbdata['first_name']);
		}
		if (isset($fbdata['last_name'])) {
			$this->setLastname($fbdata['last_name']);
		}
		if (isset($fbdata['email'])) {
			$this->setEmail($fbdata['email']);
		}
	}
	
	public function getFullName() {
		if($this->firstname != '' & $this->lastname != ''){
			return $this->firstname.' '.$this->lastname;
		} else {
			return $this->username;
		}
			
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
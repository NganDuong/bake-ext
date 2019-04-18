<?php
namespace BakeLike\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;

class User extends Entity {
	
	protected $_accessible = [
        '*' => true,
        'id' => false,
    ];

    protected function _setPassword($password) {
		
        return $this->hashPassword($password);
	}

    /**
     * Hash password before save
     * @param string $password password
     * @return string
     */
    public function hashPassword($password) {
        
        if (strlen($password)) {
            $hash = new DefaultPasswordHasher();

            return $hash->hash($password);
        }
    }
}
<?php
namespace BakeLike\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * 
 */
class UsersTable extends Table {

	public function initialize(array $config) {
		parent::initialize($config);
		$this->table('users');
        $this->displayField('username');
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');
	}
	
	public function validationDefault(Validator $validator) {

        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->email('email')
            ->requirePresence('email', 'create', 'Please input your email')
            ->notEmpty('email', 'Please input your email')
            ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->requirePresence('password', 'create')
            ->notEmpty('password', 'Please input your password');
            
        return $validator;
    }
}
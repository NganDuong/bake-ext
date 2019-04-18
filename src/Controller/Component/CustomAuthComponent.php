<?php
namespace BakeLike\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Http\ServerRequest;
use Cake\Log\Log;

class CustomAuthComponent extends Component {
	protected $_model = null;

	public function initialize(array $config) {
        parent::initialize($config);

        $this->_model = TableRegistry::get('Users');
    }

    public function prepareUserInfo($userId) {
        $user = $this->_model->get($userId);
        $result = [
        	'name' => $user->name,
            'role' => $user->role_id,
            'email' => $user->email,
            'avatar' => $user->avatar
        ];

        return $result;
    }
}

<?php
namespace BakeLike\Controller;

use Cake\Controller\Component\AuthComponent;
use \Cake\Filesystem\Folder;
use \Cake\Filesystem\File;
use Cake\Core\Configure;
use Cake\Log\Log;

class UsersController extends AppController {

	public function initialize() {
		parent::initialize();
		$this->Auth->allow(['hello', 'register', 'passwordRecover']);
	}

    public function login() {

        if ($this->request->is('post')) {
        	// Log::info($this->request->data);
	        $user = $this->Auth->identify();
	        // Log::info($user);

	        if ($user) {
	            $this->Auth->setUser($user);
	            $this->Flash->success('Logged');

	            return $this->redirect(['action' => 'hello']);
	        }
	        $this->Flash->error('Your username or password is incorrect.');
	    }
    }

    public function register() {

        if ($this->request->is('post')) {
        	$user = $this->Users->newEntity($this->request->data);

        	if (!$this->Users->save($user)) {

        		$this->Flash->error('An error accur, please try again');
        	} else {
        		$this->Flash->success('Registered');

	            return $this->redirect(['action' => 'login']);
        	}
	    }
    }

    public function logout() {

	    $this->Flash->success('You are now logged out.');

	    return $this->redirect($this->Auth->logout());
	}

	public function passwordRecover() {

        if ($this->request->is('post')) {

	    }
    }

	public function hello() {
		// Log::info($this->getControllers());
		// $this->set('all_controllers', $this->getControllers());
	}
}

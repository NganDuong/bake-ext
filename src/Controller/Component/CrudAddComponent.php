<?php
namespace BakeLike\Controller\Component;

use Cake\Controller\Component;
use Cake\Log\Log;

class CrudAddComponent extends CrudComponent {
	public $components = ['RequestHandler'];
    private $model = null;
	public function initialize(array $config) {
        parent::initialize($config);
    }
    public function execute($inputs) {
        $this->model = $this->getModel();
    	$newEntity = $this->model->newEntity($inputs);
        
    	if (!$this->model->save($newEntity)) {
    		
            $this->RequestHandler->set(false, [], __('Unable to save'));

            return $this->RequestHandler->prepareRespone($newEntity->errors(), $this->RequestHandler->get());
    	} else {
            $this->RequestHandler->set(true, [], __('Saved'));
            
            return $this->RequestHandler->prepareRespone($newEntity, $this->RequestHandler->get());
    	}
    }
}

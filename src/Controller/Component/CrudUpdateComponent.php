<?php
namespace BakeLike\Controller\Component;

use Cake\Controller\Component;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Log\Log;

class CrudUpdateComponent extends CrudComponent {
	public $components = ['RequestHandler'];
    private $model = null;

	public function initialize(array $config) {
        parent::initialize($config);
    }
    
    public function execute($id, $inputs) {
        $this->model = $this->getModel();
        try {
            $entity = $this->model->get($id);
            $entity = $this->model->PatchEntity($entity, $inputs);
            if (!$this->model->save($entity)) {

                $this->RequestHandler->set(false, [], __('Unable to save'));

                return $this->RequestHandler->prepareRespone($entity->errors(), $this->RequestHandler->get());
            } else {
                $this->RequestHandler->set(true, [], __('Saved'));

                return $this->RequestHandler->prepareRespone($entity, $this->RequestHandler->get());
            }
        } catch (RecordNotFoundException $e) {

            $this->RequestHandler->set(false, [], __('Resource(s) not found'));

            return $this->RequestHandler->prepareRespone($e, $this->RequestHandler->get());
        }
    }
}
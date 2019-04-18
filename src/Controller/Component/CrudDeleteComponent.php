<?php
namespace BakeLike\Controller\Component;

use Cake\Controller\Component;
use Cake\Log\Log;
use Cake\Datasource\Exception\RecordNotFoundException;

class CrudDeleteComponent extends CrudComponent {
    public $components = ['RequestHandler'];
    private $model = null;

    public function initialize(array $config) {
        parent::initialize($config);
    }
    
    public function execute($id) {
        $this->model = $this->getModel();
        try {
            $entity = $this->model->get($id);
            if (!$this->model->delete($entity)) {

                $this->RequestHandler->set(false, [], __('Resource(s) cannot delete'));

                return $this->RequestHandler->prepareRespone($entity->errors(), $this->RequestHandler->get());
            } else {

                $this->RequestHandler->set(true, [], __('Deleted the resource'));

                return $this->RequestHandler->prepareRespone(null, $this->RequestHandler->get());
            }
        } catch (RecordNotFoundException $e) {

            $this->RequestHandler->set(false, [], __('Resource(s) not found'));

            return $this->RequestHandler->prepareRespone($e, $this->RequestHandler->get());
        }
    }
}
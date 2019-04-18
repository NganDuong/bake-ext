<?php
namespace BakeLike\Controller\Component;

use Cake\Controller\Component;
use Cake\Log\Log;

class CrudViewComponent extends CrudComponent {
	public $components = ['RequestHandler', 'RequestQueryHandler'];
    private $model = null;

	public function initialize(array $config) {
        parent::initialize($config);
    }

    public function execute($inputs, $request) {
        $this->model = $this->getModel();
    	$entities = $this->model->find('all', $inputs)->toArray();
        
    	if (empty($entities)) {

            $this->RequestHandler->set(false, [], __('Resource(s) not found'));

            return $this->RequestHandler->prepareRespone($entities, $this->RequestHandler->get());
    	} else {
            $paging = $this->RequestQueryHandler->preparePaginateLink($this->model, $request, $inputs['conditions']);
            $this->RequestHandler->set(true, $paging, __('Found resource(s)'));

            return $this->RequestHandler->prepareRespone($entities, $this->RequestHandler->get());
    	}
    }
}
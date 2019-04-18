<?php
namespace BakeLike\Controller;
use Cake\Controller\Controller;
use Cake\Log\Log;
/**
 * CRUD base controller.
 */
abstract class CrudController extends AppController {
	protected $_model = null;
	protected $_modelName = '';
    // protected $_components = ['JsonResponses', 'CrudAdd', 'RequestHandler', 'RequestQueryHandler'];
	
	public function initialize() {
        parent::initialize();
        $this->loadComponent('JsonResponses');        
        $this->loadComponent('RequestHandler');
        $this->loadComponent('RequestQueryHandler');
        $this->loadComponent('CrudAdd');
        $this->loadComponent('CrudView');
        $this->loadComponent('CrudDelete');
        $this->loadComponent('CrudUpdate');
    }

    abstract public function prepareCreateInputs($inputs);

    public function create() {
        $this->CrudAdd->setModel($this->_modelName);
        $inputs = $this->RequestHandler->getRequestDatas($this->request);
        $validatedData = $this->prepareCreateInputs($inputs);
        if (!$validatedData['success']) {
            
            return $this->JsonResponses->prepareResponse(404, $validatedData);
        } else {
            $validatedData = $validatedData['data'];
        }
        $crudResult = $this->CrudAdd->execute($validatedData);
        if (!$crudResult['success']) {
            
            return $this->JsonResponses->prepareResponse(404, $crudResult);
        } else {
            
            return $this->JsonResponses->prepareResponse(200, $crudResult);
        }
    }

    abstract public function prepareUpdateInputs($inputs);

    public function update() {
        $this->CrudUpdate->setModel($this->_modelName);
        $inputs = $this->RequestHandler->getRequestDatas($this->request);
        $validatedData = $this->prepareUpdateInputs($inputs);
        if (!$validatedData['success']) {
            
            return $this->JsonResponses->prepareResponse(404, $validatedData);
        } else {
            $validatedData = $validatedData['data'];
        }
        $crudResult = $this->CrudUpdate->execute($this->request->getParam('id'), $validatedData);
        if (!$crudResult['success']) {
            
            return $this->JsonResponses->prepareResponse(404, $crudResult);
        } else {
            
            return $this->JsonResponses->prepareResponse(200, $crudResult);
        }
    }

    abstract public function prepareQueries($inputs);

    public function view() {
        $this->CrudView->setModel($this->_modelName);
        $query = $this->RequestQueryHandler->prepareQuery($this->_model, $this->_modelName, $this->request);
        $validatedQuery = $this->prepareQueries($query);
        if (!$validatedQuery['success']) {
            
            return $this->JsonResponses->prepareResponse(404, $validatedQuery);
        } else {
            $validatedQuery = $validatedQuery['data'];
        }
        $crudResult = $this->CrudView->execute($validatedQuery, $this->request);
        if (!$crudResult['success']) {
            
            return $this->JsonResponses->prepareResponse(404, $crudResult);
        } else {
            
            return $this->JsonResponses->prepareResponse(200, $crudResult);
        }
    }

    abstract public function prepareDeleteQueries($inputs);
    
    public function delete() {
        $this->CrudDelete->setModel($this->_modelName);
        $validatedQuery = $this->prepareDeleteQueries($this->request);
        if (!$validatedQuery['success']) {
            
            return $this->JsonResponses->prepareResponse(404, $validatedQuery);
        } else {
            $validatedQuery = $validatedQuery['data'];
        }
        $crudResult = $this->CrudDelete->execute($this->request->getParam('id'));
        if (!$crudResult['success']) {
            
            return $this->JsonResponses->prepareResponse(404, $crudResult);
        } else {
            
            return $this->JsonResponses->prepareResponse(204, $crudResult);
        }
    }
}
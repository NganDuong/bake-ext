<?php
namespace BakeLike\Controller;
use Cake\Controller\Controller;
use Cake\Log\Log;
/**
 * CRUD base controller.
 */
abstract class BakeController extends AppController {
	protected $_model = null;
	protected $_modelName = '';
	
	public function initialize() {
        parent::initialize();     
        $this->loadComponent('RequestHandler');
        $this->loadComponent('RequestQueryHandler');
        $this->loadComponent('Crud');
        $this->loadComponent('CrudAdd');
        $this->loadComponent('CrudView');
        $this->loadComponent('CrudDelete');
        $this->loadComponent('CrudUpdate');
    }

    abstract public function prepareCreateInputs($inputs);

    public function create() {

        if ($this->request->is('post')) {
            $this->CrudAdd->setModel($this->_modelName);
            $inputs = $this->RequestHandler->getRequestDatas($this->request);
            $validatedData = $this->prepareCreateInputs($inputs);

            if (!$validatedData['success']) {
                
                // return $this->RequestHandler->prepareRespone(404, $validatedData);
                $this->Flash->error($validatedData['message']);
            } else {
                $validatedData = $validatedData['data'];
            }
            $crudResult = $this->CrudAdd->execute($validatedData);

            if (!$crudResult['success']) {
                
                // return $this->RequestHandler->prepareRespone(404, $crudResult);
                $this->Flash->error($crudResult['message']);
            } else {
                $this->Crud->setModel($this->_modelName);
                $prepareFields = $this->Crud->prepareModelFields($crudResult['data']);
                $this->set('fields', $prepareFields);

                return $this->redirect(
                    ['controller' => $this->_modelName, 'action' => 'view', $crudResult['data']->id]
                );
            }
        } else {
            $this->Crud->setModel($this->_modelName);
            $prepareFields = $this->Crud->prepareModelFields();
            $this->set('fields', $prepareFields);
        }            
    }

    abstract public function prepareUpdateInputs($inputs);

    public function update() {
        $this->CrudUpdate->setModel($this->_modelName);
        $inputs = $this->RequestHandler->getRequestDatas($this->request);
        $validatedData = $this->prepareUpdateInputs($inputs);

        if (!$validatedData['success']) {
            
            // return $this->RequestHandler->prepareRespone(404, $validatedData);
            $this->Flash->error($validatedData['message']);
        } else {
            $validatedData = $validatedData['data'];
        }
        $crudResult = $this->CrudUpdate->execute($this->request->getParam('id'), $validatedData);

        if (!$crudResult['success']) {
            
            // return $this->RequestHandler->prepareRespone(404, $crudResult);
            $this->Flash->error($crudResult['message']);
        } else {
            $this->Crud->setModel($this->_modelName);
        	$prepareFields = $this->Crud->prepareModelFields($crudResult['data']);
        	$this->set('fields', $prepareFields);
        }
    }

    abstract public function prepareQueries($inputs);

    public function view($id = null) {
        $this->CrudView->setModel($this->_modelName);
        $query = $this->RequestQueryHandler->prepareQuery($this->_model, $this->_modelName, $this->request);
        $validatedQuery = $this->prepareQueries($query);

        if (!$validatedQuery['success']) {
            
            // return $this->RequestHandler->prepareRespone(404, $validatedQuery);
            $this->Flash->error($validatedQuery['message']);
        } else {
            $validatedQuery = $validatedQuery['data'];
        }
        $crudResult = $this->CrudView->execute($validatedQuery, $this->request);

        if (!$crudResult['success']) {
            
            // return $this->RequestHandler->prepareRespone(404, $crudResult);
            $this->Flash->error($crudResult['message']);
        } else {
            $this->Crud->setModel($this->_modelName);
        	$prepareFields = $this->Crud->prepareModelFields($crudResult['data']);
        	$this->set('fields', $prepareFields);
        }
    }

    public function list() {
        $this->CrudView->setModel($this->_modelName);
        $query = $this->RequestQueryHandler->prepareQuery($this->_model, $this->_modelName, $this->request);
        $validatedQuery = $this->prepareQueries($query);

        if (!$validatedQuery['success']) {
            
            // return $this->RequestHandler->prepareRespone(404, $validatedQuery);
            $this->Flash->error($validatedQuery['message']);
        } else {
            $validatedQuery = $validatedQuery['data'];
        }
        $crudResult = $this->CrudView->execute($validatedQuery, $this->request);

        if (!$crudResult['success']) {
            
            // return $this->RequestHandler->prepareRespone(404, $crudResult);
            $this->Flash->error($crudResult['message']);
        } else {
            $this->Crud->setModel($this->_modelName);
            $prepareFields = $this->Crud->preparelistModelFields($crudResult['data']);
        	$this->set('fields', $prepareFields);
            $this->set('paging', $crudResult['paging']);
        }
    }

    abstract public function prepareDeleteQueries($inputs);
    
    public function delete() {
        $this->CrudDelete->setModel($this->_modelName);
        $validatedQuery = $this->prepareDeleteQueries($this->request);

        if (!$validatedQuery['success']) {
            
            // return $this->RequestHandler->prepareRespone(404, $validatedQuery);
            $this->Flash->error($validatedQuery['message']);
        } else {
            $validatedQuery = $validatedQuery['data'];
        }
        $crudResult = $this->CrudDelete->execute($this->request->getParam('id'));

        if (!$crudResult['success']) {
            
            // return $this->RequestHandler->prepareRespone(404, $crudResult);
            $this->Flash->error($crudResult['message']);
        } else {
            $this->Crud->setModel($this->_modelName);
            $prepareFields = $this->Crud->prepareModelFields($crudResult['data']);
        	$this->set('fields', $prepareFields);
        }
    }
}
<?php
namespace BakeLike\Controller;

use Cake\Log\Log;

class BaseController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadComponent('Crud');

        $this->Crud->setModel('Users');
    }

    public function createUpdate($id = null) {
        $prepareFields = $this->Crud->prepareModelFields();

        $this->set('fields', $prepareFields);
    }

    
}

namespace <?= $namespace;?>\Controller;

use Cake\Controller\Controller;

class <?= $name;?> extends BakeController {

    public function initialize() {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->_model =<?= '$' . 'this';?>-><?= $modelName;?>;
        $this->_modelName = '<?= $modelName;?>';
    }

    public function prepareCreateInputs($input) {
    	$this->RequestHandler->set(true, array(), __('Input validated'));

    	return $this->RequestHandler->prepareRespone($input, $this->RequestHandler->get());
    }

    public function prepareUpdateInputs($input) {
    	$this->RequestHandler->set(true, array(), __('Input validated'));

    	return $this->RequestHandler->prepareRespone($input, $this->RequestHandler->get());
    }

    public function prepareQueries($input) {
    	$this->RequestHandler->set(true, array(), __('Input validated'));

    	return $this->RequestHandler->prepareRespone($input, $this->RequestHandler->get());
    }

    public function prepareDeleteQueries($input) {
    	$this->RequestHandler->set(true, array(), __('Input validated'));

    	return $this->RequestHandler->prepareRespone($input, $this->RequestHandler->get());
    }
}
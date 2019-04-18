<?php
namespace BakeLike\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Http\ServerRequest;
use Cake\Log\Log;

class CrudComponent extends Component {
	protected $_model = null;

	public function initialize(array $config) {
        parent::initialize($config);
    }

    public function setModel($modelName) {
        $this->_model = TableRegistry::get($modelName);

        return $this;
    }

    public function getModel() {

        return $this->_model;
    }
    
    public function prepareModelFields($datas = null) {
        $result = [];
        $columns = $this->_model->schema()->columns();

        if (gettype($datas) != 'array') {
            $datas = [$datas];
        }

        foreach ($datas as $data) {
            foreach ($columns as $column) {

                if ($column != 'created' && $column != 'modified') {
                    $columnType = $this->_model->schema()->getColumnType($column);
                    switch ($columnType) {
                        case 'integer':
                            $result[] = [
                                'lable' => $column,
                                'type' => 'number',
                                'value' => !empty($data[$column]) ? $data[$column] : 0,
                                'help' => ''
                            ];
                            break;

                        case 'timestamp':
                            $result[] = [
                                'lable' => $column,
                                'type' => 'date',
                                'value' => !empty($data[$column]) ? $data[$column] : null,
                                'help' => ''
                            ];
                            break;

                        case 'tinyinteger':
                            $result[] = [
                                'lable' => $column,
                                'type' => 'checkbox',
                                'value' => !empty($data[$column]) ? $data[$column] : 0,
                                'help' => ''
                            ];
                            break;
                        
                        default:
                            $result[] = [
                                'lable' => $column,
                                'type' => 'text',
                                'value' => !empty($data[$column]) ? $data[$column] : '',
                                'help' => ''
                            ];
                            break;
                    }
                }                
            }
        }

        return $result;
    }

    public function preparelistModelFields($datas = null) {
        $result = [];
        $columns = $this->_model->schema()->columns();

        if (gettype($datas) != 'array') {
            $datas = [$datas];
        }

        foreach ($datas as $data) {
            $_result = [];
            foreach ($columns as $column) {
                
                if ($column != 'created' && $column != 'modified') {
                    $columnType = $this->_model->schema()->getColumnType($column);
                    switch ($columnType) {
                        case 'integer':
                            $_result[] = [
                                'lable' => $column,
                                'type' => 'number',
                                'value' => !empty($data[$column]) ? $data[$column] : 0,
                                'help' => ''
                            ];
                            break;

                        case 'timestamp':
                            $_result[] = [
                                'lable' => $column,
                                'type' => 'date',
                                'value' => !empty($data[$column]) ? $data[$column] : null,
                                'help' => ''
                            ];
                            break;

                        case 'tinyinteger':
                            $_result[] = [
                                'lable' => $column,
                                'type' => 'checkbox',
                                'value' => !empty($data[$column]) ? $data[$column] : 0,
                                'help' => ''
                            ];
                            break;
                        
                        default:
                            $_result[] = [
                                'lable' => $column,
                                'type' => 'text',
                                'value' => !empty($data[$column]) ? $data[$column] : '',
                                'help' => ''
                            ];
                            break;
                    }
                }               
            }
            $result[] = $_result;
        }

        return $result;
    }
}

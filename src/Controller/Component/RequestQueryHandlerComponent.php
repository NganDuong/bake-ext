<?php
namespace BakeLike\Controller\Component;
use Cake\Controller\Component;
use Cake\Http\ServerRequest;
use Cake\Utility\Inflector;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
/**
 * 
 */
class RequestQueryHandlerComponent extends Component {
    protected $conditions = [];
    protected $contain = [];
    protected $sort = [];
    protected $fields = [];
    protected $page = 1;
    protected $limit = 5;
	
	public function initialize(array $config) {
        parent::initialize($config);
    }
    /**
     * Set page of pagination. 
    */
    public function setPage($page) {
        return $this->page = $page;
    }
    /**
     * Set limit of pagination. 
    */
    public function setLimit($limit) {
        return $this->limit = $limit;
    }
    /**
     * Prepare conditions to query.
     * @param object $request.
     * query = ?price[gt]=10&price[lt]=100
     * @param string $modelName.
     *
     * @return array $conditions.
     */
    private function _prepareQueryConditions($request, $model, $modelName) {
        $existedFields = $model->schema()->columns();
        $query = $request->query;
        // Log::info($query);
        $conditionPostfixes = [
            '' => '',
            'ge' => ' >=',
            'le' => ' <=',
            'gt' => ' >',
            'lt' => ' <',
            'llike' => ' LIKE',
            'rlike' => ' LIKE',
            'like' => ' LIKE',
            'ne' => ' !=',
            'in' => ' IN'
        ];
        
        foreach ($query as $field => $value) {
            if ($field != 'filter' &&
                $field != 'order_by' &&
                $field != 'page' &&
                $field != 'limit' &&
                array_search($field, $existedFields) !== false
            ){
                if ($model->schema()->getColumnType($field) == 'timestamp') {
                    if (gettype($value) == 'array') {
                        foreach ($value as $_key => $_value) {
                            $value[$_key] = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_value)));
                        }
                        // $value[key($value)] = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $value[key($value)])));
                    } else {
                        $value = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $value)));
                    }
                }
                if (gettype($value) == 'array') {
                    foreach ($value as $_key => $_value) {
                        
                        if (array_key_exists($_key, $conditionPostfixes)) {
                            switch ($_key) {
                                case 'llike':
                                    $value[$_key] = '%' . $value[$_key];
                                    break;
                                case 'rlike':
                                    $value[$_key] = $value[$_key] . '%';
                                    break;
                                case 'like':
                                    $value[$_key] = '%' . $value[$_key] . '%';
                                    break;
                                case 'in':
                                    $value[$_key] = explode(',', $value[$_key]);
                                    break;
                            }
                            $_field = $field . $conditionPostfixes[$_key];
                        }
                        $this->conditions = array_merge($this->conditions, array($modelName . '.' . $_field => $value[$_key]));
                    }       
                } else {
                    $this->conditions = array_merge($this->conditions, array($modelName . '.' . $field => $value));
                }               
            }           
        }
        if (!empty($request['id'])) {
            $this->conditions = array_merge($this->conditions, array($modelName . '.id' => $request['id']));
        }
        return $this->conditions;
    }
    /**
     * Prepare filter fields to query.
     * @param object $query.
     * @param string $modelName.
     *
     * @return array $fields.
     */
    private function _prepareQueryFields($query, $model, $modelName) {
        $existedFields = $model->schema()->columns();
        foreach ($query as $field => $value) {
            
            if ($field == 'filter') {
                $value = explode(',', $value);
                foreach ($value as $field) {
                    
                    if (array_search($field, $existedFields) !== false) {
                        $this->fields[] = $field;
                    }
                }               
            }
        }
        return $this->fields;
    }
    /**
     * Prepare object's order.
     * @param object $query ?order_by=asc(email),desc(username,phone)
     * @param string $modelName.
     * 
     * @return array $sort.
     */
    private function _prepareQueryOrder($query, $model, $modelName) {
        $existedFields = $model->schema()->columns();
        foreach ($query as $field => $value) {
            
            if ($field == 'order_by') {
                $_sort = explode(',', $value);
                foreach ($_sort as $type) {
                    preg_match('/asc\((.*?)\)/', $type, $_sortAsc);
                    if (!empty($_sortAsc)) {
                        $_sortAsc = explode(',', $_sortAsc[1]);
                        foreach ($_sortAsc as $field) {
                            if (array_search($field, $existedFields) !== false) {
                                $this->sort = array_merge($this->sort, array($modelName . '.' . $field => 'ASC'));
                            }                           
                        }
                    }
                    preg_match('/desc\((.*?)\)/', $type, $_sortDesc);
                    if (!empty($_sortDesc)) {
                        $_sortDesc = explode(',', $_sortDesc[1]);
                        foreach ($_sortDesc as $field) {
                            if (array_search($field, $existedFields) !== false) {
                                $this->sort = array_merge($this->sort, array($modelName . '.' . $field => 'DESC'));
                            }                           
                        }
                    }
                }                       
            }
        }
        return $this->sort;
    }
    /**
     * Prepare pagination.
     * @param object $query.
     *
     * @return int $page.
     */
    private function _preparePaginate($query) {
        foreach ($query as $field => $value) {
            
            if ($field == 'page') {
                $this->page = (int)$value;
            }
            if ($field == 'limit') {
                $this->limit = (int)$value;
            }
        }
        return [
            'page' => $this->page,
            'limit' => $this->limit,
        ];
    }
    /**
     * Prepare object's belongs.
     * @param object $query.
     * @param object $model.
     *
     * @return array $contain.
     */
    public function _prepareQueryContain($query, $model) {
        $fields = [];
        $contain = [];
        $associations = $model->associations()->keys();
        foreach ($associations as $key => $value) {
            $contain[] = $model->associations()->get($model->associations()->keys()[$key])->getName();
        }
        foreach ($query as $field => $value) {
            if ($field == 'filter') {
                $values = explode(',', $value);
                foreach ($values as $_value) {
                    $_value = Inflector::pluralize($_value);
                    $_value = Inflector::camelize($_value);
                    $fields[] = $_value;
                }
            }
        }
        if (empty($fields)) {
            $contains = $contain;
        } else {
            $contains = array_intersect($contain, $fields);
        }
        foreach ($contains as $value) {
            $value = Inflector::camelize($value);
        }
        return $contains;
    }
    /**
     * Filter query params.
     * @param object $model.
     *
     * @return object $query.
     */
    public function prepareQuery($model, $modelName, $request) {
        $queries = $request->query;
        $this->conditions = $this->_prepareQueryConditions($request, $model, $modelName);
        $this->fields = $this->_prepareQueryFields($queries, $model, $modelName);
        $this->order = $this->_prepareQueryOrder($queries, $model, $modelName);
        $this->contain = $this->_prepareQueryContain($queries, $model);
        $paginate = $this->_preparePaginate($queries);
        return [
            'conditions' => $this->conditions,
            'contain' => $this->contain,
            'fields' => $this->fields,
            'order' => $this->order,
            'limit' => $paginate['limit'],
            'page' => $paginate['page'],
        ];
    }
    /**
     * Prepare paginate link.
     * @param object $model.
     * @param object $request.
     * @param array $conditions.
     *
     * @return array $hasMoreResult | null.
     */
    public function preparePaginateLink($model, $request, $conditions, $groupConditions = []) {
        $paging = [];
        $totalRecords = $model->find('all', [
            'conditions' => $conditions,
            'group' => $groupConditions,
        ])->count();
        if ($this->page * $this->limit < $totalRecords) {
            $pos = strpos(urldecode($request->here()), 'page=');
            if ($pos == false) {                
                if (empty($request->query)) {
                    $paging['next'] = urldecode($request->here()) . '?page=' . (string)($this->page + 1);
                } else {
                    $paging['next'] = urldecode($request->here()) . '&page=' . (string)($this->page + 1);
                }
                                        
            } else {
                $subStr = explode('page=', urldecode($request->here()))[1];
                $subStr = explode('&', $subStr)[0];
                $subStr = 'page=' . $subStr;
                $replace = 'page=' . (string)($this->page + 1);
                $paging['next'] = substr_replace(urldecode($request->here()), $replace, $pos, strlen($subStr));
            }                       
        }
        if ($this->page - 1 > 0) {
            $pos = strpos(urldecode($request->here()), 'page=');
            if ($pos == false) {
                if (empty($request->query)) {
                    $paging['previous'] = urldecode($request->here()) . '?page=' . (string)($this->page - 1);
                } else {
                    $paging['previous'] = urldecode($request->here()) . '&page=' . (string)($this->page - 1);
                }
                                            
            } else {
                $subStr = explode('page=', urldecode($request->here()))[1];
                $subStr = explode('&', $subStr)[0];
                $subStr = 'page=' . $subStr;
                $replace = 'page=' . (string)($this->page - 1);
                $paging['previous'] = substr_replace(urldecode($request->here()), $replace, $pos, strlen($subStr));            
            }
        }
        $paging['total'] = $totalRecords;
        $paging['total_page'] = ($totalRecords / $this->limit) > 0 ? ceil($totalRecords / $this->limit) : 0;
        return $paging;
    }
    /**
     * Hide associations.
     *
     * @param array $associations.
     * @param array $associationNames.
     *
     * @return array $inputs.
     */
    public function hideAssociations($associations, $associationNames) {
        foreach ($associationNames as $field) {
            $key = array_search($field, $associations);
            if ($key !== false) {
                unset($associations[$key]);
            }
        }
            
        return $associations;
    }
}
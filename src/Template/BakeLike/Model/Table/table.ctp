namespace <?= $namespace;?>\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class <?= $name;?> extends Table {
	
    public function initialize(array $config) {

		parent::initialize($config);
		$this->table('<?= $tableName;?>');
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');
	}

	public function validationDefault(Validator $validator) {

        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');
        
        return $validator;
    }
}
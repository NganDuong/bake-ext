namespace <?= $namespace;?>\Model\Entity;

use Cake\ORM\Entity;

class <?= $name;?> extends Entity {

    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
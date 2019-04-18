<?php
namespace BakeLike\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\Utility\Inflector;
use Cake\Core\Configure;
use Cake\Routing\Router;
use Cake\Log\Log;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

class BakeLikeCommand extends Command {
	protected $entityRootPath = 'src/Model/Entity/';
	protected $tableRootPath = 'src/Model/Table/';
	protected $controllerRootPath = 'src/Controller/';
    protected $viewRootPath = 'src/Template/';

	protected function buildOptionParser(ConsoleOptionParser $parser) {

        $parser
	        ->addArgument('name', [
	            'help' => 'Name of your model'
	        ]);

        return $parser;
    }

    public function execute(Arguments $args, ConsoleIo $io) {
        $name = $args->getArgument('name');

        $tableName = Inflector::tableize($name);
        $modelTableName = Inflector::camelize($tableName);
        $modelEntityName = Inflector::camelize(Inflector::singularize($tableName));

	    $io->out("Generation code....");
	    $this->createModelEntity($io, $modelEntityName);
	    $this->createModelTable($io, $modelTableName, $tableName);
	    $this->createController($io, $modelTableName);
        $this->createViews($io, $modelTableName);
	    $options = [
	    	'scope' => $name,
	    	'controller' => $modelTableName,
	    	'actions' => [
	    		'create' => [
                    'nav_show' => true,
	    			'path' => 'add',
	    			'pass' => '[]'
	    		],
	    		'update' => [
                    'nav_show' => false,
	    			'path' => 'update/:id',
	    			'pass' => '[\'id\']'
	    		],
	    		'list' => [
                    'nav_show' => true,
	    			'path' => 'view',
	    			'pass' => '[]'
	    		],
	    		'view' => [
                    'nav_show' => false,
	    			'path' => 'view/:id',
	    			'pass' => '[\'id\']'
	    		],
	    		'delete' => [
                    'nav_show' => false,
	    			'path' => 'delete/:id',
	    			'pass' => '[\'id\']'
	    		]
	    	],
	    ];
	    $this->createRoute($io, $options);
        $this->createNavigationMenu($io, $options);

        $menuList = Configure::read('menuList');
    }

    public function createModelEntity(ConsoleIo $io, $name) {
        $fileName = $name . '.php';
    	$name .= 'Entity';

    	$io->out("Create an entity name: {$name}");

    	$view = new \Cake\View\View();
    	$view->setLayout(false);
    	$view->set('namespace', Configure::read('App.namespace'));
    	$view->set('name', $name);
    	$content = $view->render('/BakeLike/Model/Entity/entity');
    	$content = '<?php ' . $content;
        $this->createFile($io, $this->entityRootPath . $fileName, $content);
    	$io->out($content);
    }

    public function createModelTable(ConsoleIo $io, $name, $tableName) {
    	$name .= 'Table';
        $fileName = $name . '.php';

    	$io->out("Create an table name: {$name}");
    	$io->out("Using table name: {$tableName}");

    	$view = new \Cake\View\View();
    	$view->setLayout(false);
    	$view->set('namespace', Configure::read('App.namespace'));
    	$view->set('name', $name);
    	$view->set('tableName', $tableName);
    	$content = $view->render('/BakeLike/Model/Table/table');
    	$content = '<?php ' . $content;
        $this->createFile($io, $this->tableRootPath . $fileName, $content);
    	$io->out($content);
    }

    public function createController(ConsoleIo $io, $name) {
        $modelName = $name;     
    	$name .= 'Controller';
        $fileName = $name . '.php';

    	$io->out("Create a controller name: {$name}");

    	$view = new \Cake\View\View();
    	$view->setLayout(false);
    	$view->set('namespace', Configure::read('App.namespace'));
    	$view->set('name', $name);
        $view->set('modelName', $modelName);
    	$content = $view->render('/BakeLike/Controller/controller');
    	$content = '<?php ' . $content;
        $this->createFile($io, $this->controllerRootPath . $fileName, $content);
    	$io->out($content);
    }

    public function createFile(ConsoleIo $io, $path, $content) {
    	$io->createFile($path, $content);
    }

    public function createRoute(ConsoleIo $io, $options = []) {
    	$io->out("Create routes:");

    	foreach ($options['actions'] as $action => $actionOptions) {
    		$io->out($action);
    		$view = new \Cake\View\View();
	    	$view->setLayout(false);
	    	$view->set('scope', $options['scope']);
	    	$view->set('controller', $options['controller']);
    		$view->set('action', $action);
    		$view->set('path', $actionOptions['path']);
    		$view->set('pass', $actionOptions['pass']);
    		$content = $view->render('/BakeLike/Route/route');

    		$cmd = 'echo '. "\"" . $content . "\"" . ' >> config/routes.php';
    		// $io->out(exec($cmd));
    		exec($cmd);

    		$io->out($cmd);
    		// $route = Router::url(['controller' => $options['controller'], 'action' => $action]);
    		// $io->out(Router::createRouteBuilder('/users/home'));
    	}    	
    }

    public function createNavigationMenu(ConsoleIo $io, $options = []) {
        $actions = [];

        foreach ($options['actions'] as $action => $actionOptions) {

            if ($actionOptions['nav_show']) {
                $actions[] = [
                    'name' => $action,
                    'url' => '/' . $options['scope'] . '/' . $actionOptions['path'],
                ];
            }                
        }

        $_menuList = [
            $options['controller'] => [
                'active' => false,
                'actions' => $actions,
            ],
        ];
        $menuList = Configure::read('menuList', []);
        $menuList = array_merge($menuList, $_menuList);
        Configure::write('menuList', $menuList);

        return $menuList;
    }

    public function createViews(ConsoleIo $io, $name) {
        // create folder
        $dir = new Folder($this->viewRootPath . $name, true, 0755);
        // create create.
        $fileName = 'create.ctp';
        $view = new \Cake\View\View();
        $view->setLayout(false);
        $content = $view->render('/BakeLike/View/create');
        $this->createFile($io, $this->viewRootPath . $name . '/' . $fileName, $content);
        // create list.
        $fileName = 'list.ctp';
        $view = new \Cake\View\View();
        $view->setLayout(false);
        $content = $view->render('/BakeLike/View/list');
        $this->createFile($io, $this->viewRootPath . $name . '/' . $fileName, $content);
        // create view.
        $fileName = 'view.ctp';
        $view = new \Cake\View\View();
        $view->setLayout(false);
        $content = $view->render('/BakeLike/View/view');
        $this->createFile($io, $this->viewRootPath . $name . '/' . $fileName, $content);
        // create update.
        $fileName = 'update.ctp';
        $view = new \Cake\View\View();
        $view->setLayout(false);
        $content = $view->render('/BakeLike/View/update');
        $this->createFile($io, $this->viewRootPath . $name . '/' . $fileName, $content);
        // create delete.
        $fileName = 'delete.ctp';
        $view = new \Cake\View\View();
        $view->setLayout(false);
        $content = $view->render('/BakeLike/View/delete');
        $this->createFile($io, $this->viewRootPath . $name . '/' . $fileName, $content);
    }
}
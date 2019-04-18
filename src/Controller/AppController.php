<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace BakeLike\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Log\Log;
use Cake\Routing\Router;
use Cake\Core\Configure;
use \Cake\Filesystem\Folder;
use \Cake\Filesystem\File;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        $this->loadComponent('Flash');
        $this->loadComponent('CustomAuth');

        /*
         * Enable the following component for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');

        $this->loadComponent('Auth', [
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'email',
                        'password' => 'password'
                    ]
                ]
            ],
            'loginAction' => [
                'controller' => 'Users',
                'action' => 'login'
            ],
             // If unauthorized, return them to login page
            'unauthorizedRedirect' => false
        ]);

        $this->Auth->allow(['logout', 'hello']);
    }

    public function getControllers() {
        $folder = new Folder(ROOT);
        $controllerFiles = $folder->cd('src' . DS . 'Controller');
        $controllerFiles = $folder->find('.*.php', true);

        $skipControllers = ['AppController.php', 'ErrorController.php', 'BaseController.php'];
        $cleanControllers = [];
        foreach ($controllerFiles as $key => $controller) {
            
            if (!in_array($controller, $skipControllers)) {
                $cleanControllers[] = str_replace('Controller.php','',$controller);
                //Could build a menu based on the controller here now, but do not
                //have time to do this now.
            }
        }
        
        return $cleanControllers;
    }

    public function setDefaultMenuList($controllerList) {
        $result = [];
        $existedRoutes = Router::routes();
        foreach ($controllerList as $controller) {
            $controllerDetails = [
                'active' => false,
                'actions' => [],
            ];
            foreach ($existedRoutes as $route) {
                
                if ($route->defaults['controller'] == $controller) {

                    if ($route->defaults['action'] == 'create' || $route->defaults['action'] == 'list') {
                        $_actions = [                        
                            'name' => !empty($route->defaults['action']) ? $route->defaults['action'] : '',
                            'url' => !empty($route->template) ? $route->template : '',
                        ];
                        $controllerDetails['actions'][] = $_actions;
                    }                                            
                }
            }            

            $result = array_merge($result, [$controller => $controllerDetails]);
        }

        return $result;
    }

    public function beforeFilter(Event $event) {

        if (!empty($this->Auth->user())) {
            $prepareUserInfo = $this->CustomAuth->prepareUserInfo($this->Auth->user('id'));
            $this->set('user', $prepareUserInfo);
        }

        $_menuList = $this->setDefaultMenuList($this->getControllers());
        $menuList = Configure::read('menuList', $_menuList);
        $this->set('menuList', $menuList);
    }
}

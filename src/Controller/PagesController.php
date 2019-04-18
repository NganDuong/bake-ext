<?php
namespace BakeLike\Controller;

use Cake\Log\Log;

class PagesController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->Auth->allow(['createUpdate']);
    }

    public function createUpdate($id = null) {

        if (!empty($id)) {
            # Update request
            
        } else {
            # Create request
        }
        $fields = [
        	[
        		'lable' => 'username',
	        	'type' => 'text',
	        	'value' => 'Ngan Duong',
	        	'help' => 'Limit 50 characters'
        	],
        	[
        		'lable' => 'options',
	        	'type' => 'dropdown',
	        	'options' => [
	        		'option 1',
	        		'option 2',
	        		'option 3'
	        	],
        	],
        	[
        		'lable' => 'status',
	        	'type' => 'checkbox',
	        	'value' => true
        	],
        	[
        		'lable' => 'Message',
	        	'type' => 'textarea',
        	],
        	[
        		'lable' => 'Upload',
	        	'type' => 'file',
        	],
        	[
        		'lable' => 'Date',
	        	'type' => 'date',
        	],
        ];

        $menuList = [
        	'Pages' => [
        		'active' => true,
        		'actions' => [
        			[
        				'name' => 'create',
        				'url' => '/admin/pages/add'
        			],
        			[
        				'name' => 'view',
        				'url' => '/admin/pages/view'
        			],
        		],
        	],
        ];

        $this->set('fields', $fields);
        $this->set('menuList', $menuList);

        $user = [
            'name' => 'Ngan Duong',
            'role' => 'Admin',
            'email' => 'ngan.duong@findsoft.xyz',
            'avatar' => '/img/!sample-user.jpg'
        ];

        $this->set('user', $user);


        if ($this->request->is('post')) {
            Log::info($this->request->data);
        }
    }

    public function view() {
        $fields = [
        	[
        		'lable' => 'username',
	        	'type' => 'text',
	        	'value' => 'Ngan Duong',
	        	'help' => 'Limit 50 characters'
        	],
        	[
        		'lable' => 'options',
	        	'type' => 'dropdown',
	        	'options' => [
	        		'option 1',
	        		'option 2',
	        		'option 3'
	        	],
        	],
        	[
        		'lable' => 'status',
	        	'type' => 'checkbox',
	        	'value' => true
        	],
        	[
        		'lable' => 'Message',
	        	'type' => 'textarea',
        	],
        	[
        		'lable' => 'Upload',
	        	'type' => 'file',
        	],
        	[
        		'lable' => 'Date',
	        	'type' => 'date',
        	],
        ];

        $this->set('fields', $fields);

        $menuList = [
        	'Pages' => [
        		'active' => true,
        		'actions' => [
        			[
        				'name' => 'create',
        				'url' => '/admin/pages/add'
        			],
        			[
        				'name' => 'view',
        				'url' => '/admin/pages/view'
        			],
        		],
        	],
        ];
        
        $this->set('menuList', $menuList);

        $user = [
        	'name' => 'Ngan Duong',
        	'role' => 'Admin',
        	'email' => 'ngan.duong@findsoft.xyz',
            'avatar' => '/img/!sample-user.jpg'
        ];

        $this->set('user', $user);
    }
}

<?php
namespace BakeLike\Controller\Component;

use Cake\Controller\Component;
use Cake\Http\ServerRequest;
use Cake\Log\Log;
/**
 * 
 */
class RequestHandlerComponent extends Component {
	
	public function initialize(array $config) {
        parent::initialize($config);
    }

    public function getRequestDatas(ServerRequest $request) {

    	if ($request->is('bakeLikeJson')) {
    		
    		return $this->_jsonRequests($request);
    	} elseif ($request->is('bakeLikeXml')) {
            
            return $this->_xmlRequests($request);
        } elseif ($request->is('bakeLikeUrlEncoded')) {

            return $request->data;
        } else {

            return $request->data;
        }
    }

    private function _jsonRequests(ServerRequest $request) {

        return (array)$request->input('json_decode');
    }

    private function _xmlRequests(ServerRequest $request) {

    	return $request->input('Cake\Utility\Xml::build', ['return' => 'domdocument']);
    }

    public function getRequestParams(ServerRequest $request) {
        
        return $request->query();
    }

    /**
     * Set response template.
     *
     * @param array $data.
     * @param array $options.
     *
     * @return object $response.
     */
    public function set($success = false, $paging = [], $message = 'Error') {
        $this->defaultOptions = [
            'success' => $success,
            'paging' => $paging,
            'message' => $message,
        ];

        return $this;
    }

    /**
     * Get response template.
     *
     * @param array $data.
     * @param array $options.
     *
     * @return object $response.
     */
    public function get() {
        
        return $this->defaultOptions;
    }

    /**
     * Prepare response template.
     *
     * @param array $data.
     * @param array $options.
     *
     * @return object $response.
     */
    public function prepareRespone($data, $options = []) {

        if (!isset($options['success'])) {
            $options['success'] = false;
        }

        if (!isset($options['paging'])) {
            $options['paging'] = [];
        }

        if (!isset($options['message'])) {
            $options['message'] = 'Default message';
        }

        return [
            'success' => $options['success'],
            'data' => $data,
            'paging' => $options['paging'],
            'message' => $options['message'],
        ];
    }

    /**
     * Prepare response template.
     *
     * @param array $data.
     * @param array $options.
     *
     * @return object $response.
     */
    public function renderDataRespone($modelName, $data) {
        $model = 
        $fields = [];
        foreach ($data['data'] as $field => $value) {
            $fields[] = [
                'lable' => $field,
                'type' => 'text',
                'value' => $value,
            ];
        }

        return $fields;
    }

    // $fields = [
    //     [
    //         'lable' => 'username',
    //         'type' => 'text',
    //         'value' => 'Ngan Duong',
    //         'help' => 'Limit 50 characters'
    //     ],
    //     [
    //         'lable' => 'options',
    //         'type' => 'dropdown',
    //         'options' => [
    //             'option 1',
    //             'option 2',
    //             'option 3'
    //         ],
    //     ],
    //     [
    //         'lable' => 'status',
    //         'type' => 'checkbox',
    //         'value' => true
    //     ],
    //     [
    //         'lable' => 'Message',
    //         'type' => 'textarea',
    //     ],
    //     [
    //         'lable' => 'Upload',
    //         'type' => 'file',
    //     ],
    //     [
    //         'lable' => 'Date',
    //         'type' => 'date',
    //     ],
    // ];
}

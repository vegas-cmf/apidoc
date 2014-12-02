<?php
/**
 * TestController.php
 */

namespace ApiTest\Controllers;

use ApiTest\Services\Exception\ApiException;
use Vegas\Mvc\Controller\ControllerAbstract;
use Phalcon\Mvc\Dispatcher;

/**
 * @api(
 *  name='Test',
 *  description='Test API',
 *  version='1.0.0'
 * )
 */
class TestController extends ControllerAbstract
{
    /**
     * @api(
     *  method='GET',
     *  description='Test',
     *  name='Get test object',
     *  url='/api/test/{id}',
     *  params=[
     *      {name: 'id', type: 'string', description: 'Test ID'}
     *  ],
     *  headers=[
     *      {name: 'HTTP_X_AUTH', description: 'Authentication token'}
     *  ],
     *  errors=[
     *      {type: 'Error 404', description: 'Test was not found'},
     *      {type: 'Error 500', description: 'Application error'}
     *  ],
     *  responseFormat='JSON',
     *  responseContentType='application/json',
     *  response=[
     *      {name: 'id', type: 'MongoId', description: 'Test ID'},
     *      {name: 'name', type: 'string', description: 'Foo name'}
     *  ],
     *  responseExample='{
     *      "id": "123",
     *      "name": "Test"
     *  }'
     * )
     */
    public function getAction()
    {
        try {
            if (!$this->request->get('id')) {
                throw new ApiException();
            }
            return $this->jsonResponse(
                [
                    'id' => '123',
                    'name' => 'Test 1'
                ]
            );
        } catch (ApiException $e) {
            $response = $this->jsonResponse('');
            $response->setStatusCode(404, 'Record not found');
            return $response;
        } catch (\Exception $e) {
            $response = $this->jsonResponse('');
            $response->setStatusCode(500, 'Application error');
            return $response;
        }
    }

    /**
     * @api(
     *  method='GET',
     *  description='Tests list',
     *  name='Get list of tests',
     *  url='/api/test',
     *  headers=[
     *      {name: 'HTTP_X_AUTH', description: 'Authentication token'}
     *  ],
     *  errors=[
     *      {type: 'Error 500', description: 'Unknown error'}
     *  ],
     *  responseFormat='JSON',
     *  responseContentType='application/json',
     *  response=[
     *      [
     *          {name: 'id', type: 'MongoId', description: 'Test ID'},
     *          {name: 'name', type: 'string', description: 'Test name'}
     *      ],
     *      [
     *          {name: 'id', type: 'MongoId', description: 'Test ID'},
     *          {name: 'name', type: 'string', description: 'Test name'}
     *      ]
     *  ],
     *  responseExample='[
     *      {
     *          "id": "123",
     *          "name": "Test"
     *      },
     *      {
     *          "id": "124",
     *          "name": "Test"
     *      }
     *  ]'
     * )
     * @return null|\Phalcon\Http\ResponseInterface
     */
    public function listAction()
    {
        try {
            return $this->jsonResponse(
                [
                    'id' => '123',
                    'name' => 'Test 1'
                ],
                [
                    'id' => '124',
                    'name' => 'Test 2'
                ]
            );
        } catch (\Exception $e) {
            $response = $this->jsonResponse('');
            $response->setStatusCode(500, 'Application  error');
            return $response;
        }
    }
}
<?php
/**
 * FooController.php
 */

namespace ApiTest\Controllers;

use ApiTest\Services\Exception\ApiException;
use Vegas\Mvc\Controller\ControllerAbstract;
use Phalcon\Mvc\Dispatcher;

/**
 * @api(
 *  name='Foo',
 *  description='Foo API',
 *  version='1.0.0'
 * )
 */
class FooController extends ControllerAbstract
{
    /**
     * @api(
     *  method='GET',
     *  description='Foo',
     *  name='Get foo object',
     *  url='/api/foo/{id}',
     *  params=[
     *      {name: 'id', type: 'string', description: 'Foo ID'}
     *  ],
     *  headers=[
     *      {name: 'HTTP_X_AUTH', description: 'Authentication token'}
     *  ],
     *  responseCodes=[
     *      {code: 404, type: 'Error', description: 'Record not found'},
     *      {code: 500, type: 'Error', description: 'Application error'}
     *  ],
     *  responseFormat='JSON',
     *  responseContentType='application/json',
     *  response=[
     *      {name: 'id', type: 'MongoId', description: 'Foo ID'},
     *      {name: 'name', type: 'string', description: 'Foo name'}
     *  ],
     *  responseExample='{
     *      "id": "123",
     *      "name": "Foo"
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
                    'name' => 'Foo 1'
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
     *  description='Foo list',
     *  name='Get list of foo',
     *  url='/api/foo',
     *  headers=[
     *      {name: 'HTTP_X_AUTH', description: 'Authentication token'}
     *  ],
     *  responseCodes=[
     *      {code: 500, type: 'Error', description: 'Application error'}
     *  ],
     *  responseFormat='JSON',
     *  responseContentType='application/json',
     *  response=[
     *      {
     *          {name: 'id', type: 'MongoId', description: 'Foo ID'},
     *          {name: 'name', type: 'string', description: 'Foo name'}
     *      },
     *      {
     *          {name: 'id', type: 'MongoId', description: 'Foo ID'},
     *          {name: 'name', type: 'string', description: 'Foo name'}
     *      }
     *  ],
     *  responseExample='[
     *      {
     *          "id": "123",
     *          "name": "Foo 1"
     *      },
     *      {
     *          "id": "124",
     *          "name": "Foo 2"
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
                    'name' => 'Foo 1'
                ],
                [
                    'id' => '124',
                    'name' => 'Foo 2'
                ]
            );
        } catch (\Exception $e) {
            $response = $this->jsonResponse('');
            $response->setStatusCode(500, 'Application  error');
            return $response;
        }
    }
}
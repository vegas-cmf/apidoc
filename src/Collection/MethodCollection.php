<?php
/**
 * This file is part of Vegas package
 *
 * @author Slawomir Zytko <slawek@amsterdam-standard.pl>
 * @copyright Amsterdam Standard Sp. Z o.o.
 * @homepage http://vegas-cmf.github.io
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vegas\ApiDoc\Collection;

use Vegas\ApiDoc\CollectionAbstract;

/**
 * Class MethodCollection
 *
 * @api(
 *  method='GET',
 *  description='Some longer description about method',
 *  name='Short name/description about method',
 *  url='/api/endpoint/{id}',
 *  version='1.0.0',
 *  params=[
 *      {name: 'id', type: 'string', description: 'ID of something'}
 *  ],
 *  headers=[
 *      {name: 'HTTP_X_AUTH', description: 'Authentication token'}
 *  ],
 *  errors=[
 *      {type: 'Error 404', description: 'Object was not found'},
 *      {type: 'Error 500', description: 'Application error'}
 *  ],
 *  requestFormat='JSON',
 *  requestContentType='application/json',
 *  request=[
 *      {name: 'id', type: 'MongoId', description: 'ID of something'}
 *  ],
 *  requestExample='{
 *      "id": "123"
 *  }',
 *  responseFormat='JSON',
 *  responseContentType='application/json',
 *  response=[
 *      {name: 'id', type: 'MongoId', description: 'ID of something'},
 *      {name: 'name', type: 'string', description: 'Name of something'}
 *  ],
 *  responseExample='{
 *      "id": "123",
 *      "name": "Test"
 *  }'
 * )
 *
 * @package Vegas\ApiDoc\Collection
 */
class MethodCollection extends CollectionAbstract
{
    const NAME = 'method';

    public $method;

    public $url;

    public $params;

    public $headers;

    public $errors;

    public $request;

    public $requestContentType;

    public $requestFormat;

    public $requestExample;

    public $response;

    public $responseContentType;

    public $responseFormat;

    public $responseExample;

    public $description;

    public $name;
} 
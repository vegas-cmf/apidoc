Vegas CMF API Documentor
========================

[![Build Status](https://travis-ci.org/vegas-cmf/apidoc.png?branch=master)](https://travis-ci.org/vegas-cmf/apidoc)
[![Coverage Status](https://coveralls.io/repos/vegas-cmf/apidoc/badge.png?branch=master)](https://coveralls.io/r/vegas-cmf/apidoc?branch=master)
[![Latest Stable Version](https://poser.pugx.org/vegas-cmf/apidoc/v/stable.png)](https://packagist.org/packages/vegas-cmf/apidoc)
[![Total Downloads](https://poser.pugx.org/vegas-cmf/apidoc/downloads.png)](https://packagist.org/packages/vegas-cmf/apidoc)

Usage
-----

#### Add vegas-cmf/apidoc to composer.json dependencies

```
"vegas-cmf/apidoc" : "1.0.0"
```

and run composer update

```
php composer.phar update
```


#### Create CLI task which extends \Vegas\ApiDoc\Task\GeneratorTaskAbstract.php

```
mkdir app/tasks

touch app/tasks/ApidocTask.php
```

```php
//app/tasks/ApidocTask.php
use Vegas\Cli\Task\Option;
use Vegas\Mvc\View;

class ApidocTask extends \Vegas\ApiDoc\Task\GeneratorTaskAbstract
{
    protected function getView()
    {
        $view = new View($this->di->get('config')->application->view->toArray());
        $view->setDI($this->di);

        return $view;
    }

    protected function getOutputPath()
    {
        return APP_ROOT . '/public/apiDoc/';
    }

    protected function getLayoutFilePath()
    {
        return APP_ROOT . '/app/layouts/partials/apiDoc/layout';
    }

    protected function getInputPath()
    {
        return APP_ROOT . '/app/modules';
    }
}
```

#### Add annotations to controllers classes

```php
<?php
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
     *  description='Returns Test object',
     *  name='Get test',
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
     *  requestFormat='JSON',
     *  requestContentType='application/json',
     *  request={
     *      {name: 'id', type: 'MongoId', description: 'ID of something'}
     *  },
     *  requestExample='{
     *      "id": "123"
     *  }',
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
     *  description='Returns list of tests objects',
     *  name='Get tests',
     *  url='/api/test',
     *  headers=[
     *      {name: 'HTTP_X_AUTH', description: 'Authentication token'}
     *  ],
     *  errors=[
     *      {type: 'Error 500', description: 'Unknown error'}
     *  ],
     *  requestFormat='JSON',
     *  requestContentType='application/json',
     *  request=''
     *  requestExample='',
     *  responseFormat='JSON',
     *  responseContentType='application/json',
     *  response=[
     *      {
     *          {name: 'id', type: 'MongoId', description: 'Test ID'},
     *          {name: 'name', type: 'string', description: 'Test name'}
     *      },
     *      {
     *          {name: 'id', type: 'MongoId', description: 'Test ID'},
     *          {name: 'name', type: 'string', description: 'Test name'}
     *      }
     *  ],
     *  responseExample='[
     *      {
     *          "id": "123",
     *          "name": "Test 1"
     *      },
     *      {
     *          "id": "124",
     *          "name": "Test 2"
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
```

##### Available parameters:

###### Class

`name`                  Name of endpoint

`description`           Detailed description of the API endpoint

`version`               API version


###### Method

`name`                  Name of API method

`description`           Detailed description of the API method

`method`                Determines HTTP method (POST, GET, ...)

`url`                   Request path

`params`                Describes parameters passed to API method

`headers`               Describes headers passed in request e.g. for Authorization

`errors`                Describes errors

`request`               Describes request

`requestContentType`    Determines request Content-Type

`requestFormat`         Determines request format

`requestExample`        Example of request body

`response`              Describes response

`responseContentType`   Determines response Content-Type

`responseFormat`        Determines response format

`responseExample`       Example of response body


#### Create documentation layout ( you can use sample layout from tests/fixtures/app/layouts/partials/apiDoc directory ) and prepare output directory 

```
mkdir app/layouts/partials -p

touch cp -R vendor/vegas-cmf/apidoc/tests/fixtures/app/layouts/partials/apiDoc app/layouts/partials/.

mkdir public/apiDoc
```

#### Run CLI Task to generate documentation

```
php cli/cli.php app:apidoc generate
```

Check example documentation [http://jsbin.com/sigebogegu/1](http://jsbin.com/sigebogegu/1)
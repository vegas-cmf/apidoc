Vegas CMF API Documentation generator
======================

Usage
-----

* Add vegas-cmf/apidoc to composer.json dependencies

```
"vegas-cmf/apidoc" : "1.0.0"
```

and run composer update

```
php composer.phar update
```


* Create CLI task which extends \Vegas\ApiDoc\Task\GeneratorTaskAbstract.php

```
mkdir app/tasks

touch app/tasks/ApidocTask.php
```

```
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
}
```

* Create documentation layout ( you can use sample layout from tests/fixtures/app/layouts/partials/apiDoc directory ) and prepare output directory 

```
mkdir app/layouts/partials -p

touch cp -R vendor/vegas-cmf/apidoc/tests/fixtures/app/layouts/partials/apiDoc app/layouts/partials/.

mkdir public/apiDoc
```

* Run CLI Task to generate documentation

```
php cli/cli.php app:apidoc generate
```
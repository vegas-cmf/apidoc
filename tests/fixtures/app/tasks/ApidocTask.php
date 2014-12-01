<?php
/**
 * This file is part of Vegas package
 *
 * @author Slawomir Zytko <slawomir.zytko@gmail.com>
 * @copyright Amsterdam Standard Sp. Z o.o.
 * @homepage https://bitbucket.org/amsdard/vegas-phalcon
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
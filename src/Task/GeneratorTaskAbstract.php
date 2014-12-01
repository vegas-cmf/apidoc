<?php
/**
 * This file is part of Vegas package
 *
 * @author Slawomir Zytko <slawek@amsterdam-standard.pl>
 * @copyright Amsterdam Standard Sp. Z o.o.
 * @homepage https://bitbucket.org/amsdard/vegas-phalcon
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vegas\ApiDoc\Task;

use Vegas\Cli\Task\Option;
use Vegas\Mvc\View;

/**
 * Class GeneratorTaskAbstract
 *
 * Abstract class that must be extended by the application task
 *
 * @package Vegas\ApiDoc\Task
 */
abstract class GeneratorTaskAbstract extends \Vegas\Cli\Task
{

    /**
     * Task must implement this method to set available options
     *
     * @return mixed
     */
    public function setOptions()
    {
        $action = new \Vegas\Cli\Task\Action('generate', 'Generate api doc');
        $this->addTaskAction($action);
    }

    /**
     * Returns instance of View
     *
     * @return \Phalcon\Mvc\ViewInterface
     */
    abstract protected function getView();

    /**
     * Returns path where main file will be generated
     *
     * @return string
     */
    abstract protected function getOutputPath();

    /**
     * Generates documentation
     *
     * Usage
     * <code>
     * php cli/cli.php app:apidoc generate
     * </code>
     */
    public function generateAction()
    {
        //instantiates generator by passing the input directory and regular expression for matching file names
        //set verbose on true to get information about parsed classes
        $generator = new \Vegas\ApiDoc\Generator(APP_ROOT . '/app/modules', [
            'match' => '/(.*)Controller(.*)\.php/i',
            'verbose' => true
        ]);
        //builds information
        $collections = $generator->build();
        //get the view object that will be rendering output html
        $view = $this->getView();

        //instantiate default renderer
        $renderer = new \Vegas\ApiDoc\Renderer(
            $collections,
            $view->getPartialsDir() . 'apiDoc/layout'
        );
        $renderer->setView($view);

        //sets renderer to generator
        $generator->setRenderer($renderer);

        //creates output file
        file_put_contents($this->getOutputPath() . 'index.html', $generator->render());
    }
}
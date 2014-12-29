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

use Vegas\ApiDoc\Benchmark;
use Vegas\ApiDoc\Generator;
use Vegas\ApiDoc\Renderer;
use Vegas\Cli\Task;
use Vegas\Cli\Task\Action;

/**
 * Class GeneratorTaskAbstract
 *
 * Abstract class that must be extended by the application task
 *
 * @package Vegas\ApiDoc\Task
 */
abstract class GeneratorTaskAbstract extends Task
{

    /**
     * Task must implement this method to set available options
     *
     * @return mixed
     */
    public function setOptions()
    {
        $action = new Action('generate', 'Generate api doc');
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
     * Returns path where files are located
     *
     * @return string
     */
    abstract protected function getInputPath();

    /**
     * Returns path to layout file
     * Note. Remember to skip extension
     *
     * @return string
     */
    abstract protected function getLayoutFilePath();

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
        /**
         * @var \Phalcon\Events\Manager $eventsManager
         */
        $eventsManager = $this->di->get('eventsManager');

        /**
         * Benchmarks building annotations collections
         */
        $buildBenchmark = new Benchmark();
        $eventsManager->attach('generator:beforeBuild', function() use ($buildBenchmark) {
            $buildBenchmark->start();
        });
        $eventsManager->attach('generator:afterBuild', function() use ($buildBenchmark) {
            $buildBenchmark->finish();
        });

        /**
         * Benchmarks rendering html
         */
        $renderBenchmark = new Benchmark();
        $eventsManager->attach('generator:beforeRender', function() use ($renderBenchmark) {
            $renderBenchmark->start();
        });
        $eventsManager->attach('generator:beforeRender', function() use ($renderBenchmark) {
            $renderBenchmark->finish();
        });

        //instantiates generator by passing the input directory and regular expression for matching file names
        //set verbose on true to get information about parsed classes
        $generator = new Generator($this->getInputPath(), [
            'match' => '/(.*)Controller(.*)\.php/i',
            'verbose' => true
        ]);
        $generator->setEventsManager($eventsManager);
        //builds information
        $collections = $generator->build();
        //get the view object that will be rendering output html
        $view = $this->getView();

        //instantiate default renderer
        $renderer = new Renderer(
            $collections,
            $this->getLayoutFilePath()
        );
        $renderer->setView($view);
        /**
         * Injects benchmarks into view
         */
        $renderer->setViewVar('buildBenchmark', $buildBenchmark);
        $renderer->setViewVar('renderBenchmark', $renderBenchmark);

        //sets renderer to generator
        $generator->setRenderer($renderer);

        //creates output file
        file_put_contents($this->getOutputPath() . 'index.html', $generator->render());
    }
}

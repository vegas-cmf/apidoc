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

namespace Vegas\ApiDoc;

use Phalcon\Annotations\Adapter\Memory;
use Phalcon\Annotations\AdapterInterface;
use Phalcon\Annotations\Collection;
use Phalcon\Annotations\Reader;
use Phalcon\Events\EventsAwareInterface;
use Phalcon\Events\ManagerInterface;
use Phalcon\Loader;
use Vegas\ApiDoc\Exception\InvalidRendererException;

/**
 * Class Generator
 *
 * Generates REST API documentation
 * Available annotation:
 *
 * Class annotations:
 *
 * @api(
 *  name='Api endpoint',
 *  description='Some description about endpoint',
 *  version='1.0.0'
 * )
 *
 *
 * Method annotations:
 *
 * @api(
 *  method='GET',
 *  description='Some longer description about method',
 *  name='Short name/description about method',
 *  url='/api/endpoint/{id}',
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
 * Usage:
 * <code>
 *
 * //instantiates generator by passing the input directory and regular expression for matching file names
 * //set verbose on true to get information about parsed classes
 * $generator = new \Vegas\ApiDoc\Generator(APP_ROOT . '/app/modules', [
 *      'match' => '/(.*)Controller(.*)\.php/i',
 *      'verbose' => true
 * ]);
 * //builds information
 * $collections = $generator->build();
 *
 * //get the view object that will be rendering output html
 * $view = $this->getView();
 * //instantiate default renderer
 * $renderer = new \Vegas\ApiDoc\Renderer($collections, $view->getPartialsDir() . 'apiDoc/layout');
 * $renderer->setView($view);
 *
 * //sets renderer to generator
 * $generator->setRenderer($renderer);
 *
 * //creates output file
 * file_put_contents($this->getOutputPath() . 'index.html', $generator->render());
 * </code>
 * @package Vegas\ApiDoc
 */
class Generator implements EventsAwareInterface
{
    /**
     * @var AdapterInterface
     */
    protected $annotationReader;

    /**
     * Directory containing codebase
     *
     * @var array
     */
    private $directory;

    /**
     * @var array
     */
    private $options;

    /**
     * @var Loader
     */
    private $loader;

    /**
     * @var RendererInterface
     */
    private $renderer;

    /**
     * @var \Phalcon\Events\Manager
     */
    protected $eventsManager;

    /**
     * Instantiates annotations reader
     * Instantiates file autoloader
     *
     * @param array $directory
     * @param array $options
     */
    public function __construct($directory, array $options = [])
    {
        $this->directory = $directory;
        $this->options = $options;
        $this->annotationParser = new Reader();
        $this->loader = new Loader();
    }

    /**
     * Sets default events manager
     * @param ManagerInterface $eventsManager
     */
    public function setEventsManager($eventsManager)
    {
        $this->eventsManager = $eventsManager;
    }

    /**
     * @return \Phalcon\Events\Manager|ManagerInterface
     */
    public function getEventsManager()
    {
        return $this->eventsManager;
    }

    /**
     * Sets template renderer
     *
     * @param RendererInterface $renderer
     */
    public function setRenderer(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * Sets default annotations adapter
     * As default reader we use Memory
     *
     * @param AdapterInterface $adapter
     */
    public function setupAnnotationsReader(AdapterInterface $adapter = null)
    {
        if (null === $adapter) {
            $this->annotationReader = new Memory();
        } else {
            $this->annotationReader = $adapter;
        }
    }

    /**
     * Returns the annotations reader
     *
     * @return \Phalcon\Annotations\AdapterInterface
     */
    public function getAnnotationsReader()
    {
        if (!$this->annotationReader) {
            $this->setupAnnotationsReader();
        }
        return $this->annotationReader;
    }

    /**
     * Collects information from input directory
     * Returns collection of all information grabbed from input directory
     *
     * @return array
     */
    public function build()
    {
        if ($this->eventsManager instanceof ManagerInterface) {
            $this->eventsManager->fire('generator:beforeBuild', $this);
        }

        $collections = array();
        $files = $this->setupClassesAutoloader();
        foreach ($files as $className => $file) {
            if (isset($this->options['verbose']) && $this->options['verbose']) {
                echo '# Processing file : ' . $file . PHP_EOL;
            }
            $this->loader->autoLoad($className);

            $collection = $this->getClassCollection($className);
            if (empty($collection)) {
                continue;
            }

            $collections[$className] = $this->getClassCollection($className);
        }

        if ($this->eventsManager instanceof ManagerInterface) {
            $this->eventsManager->fire('generator:afterBuild', $this, $collections);
        }

        return $collections;
    }

    /**
     * Returns all information from given class name
     * It will contain information about class and all methods inside class
     *
     * @param $className
     * @return array
     */
    protected function getClassCollection($className)
    {
        $annotations = $this->extractAnnotations($className);
        return $this->parseAnnotations($annotations);
    }

    /**
     * Setups class autoloader
     *
     * @return array
     */
    protected function setupClassesAutoloader()
    {
        $files = array();
        $classes = array();

        //browse directories recursively
        $directoryIterator = new \RecursiveDirectoryIterator($this->directory);
        $regex = isset($this->options['match']) ? $this->options['match'] : '/(.*)\.php/i';
        $iterator = new \RecursiveIteratorIterator($directoryIterator);
        foreach ($iterator as $file) {
            if ($file->getFileName() == '.' || $file->getFileName() == '..') {
                continue;
            }
            if ($regex && !preg_match($regex, $file->getFileName())) {
                continue;
            }

            //resolves name of class
            $className = $this->resolveFileClassName($file);

            //collects files and classes
            $files[$className] = $file;
            $classes[ltrim($className, '\\')] = $file->getPathname();
        }

        //classes autoloader
        $this->loader->registerClasses($classes, true);
        $this->loader->register();

        return $files;
    }

    /**
     * Resolves name of class inside given file
     *
     * @param \SplFileInfo $fileInfo
     * @return string
     */
    protected function resolveFileClassName(\SplFileInfo $fileInfo)
    {
        $relativeFilePath = str_replace(
                $this->directory,
                '',
                $fileInfo->getPath()) . DIRECTORY_SEPARATOR .
            $fileInfo->getBasename('.' . $fileInfo->getExtension()
            );

        //converts file path to namespace
        //DIRECTORY_SEPARATOR will be converted to namespace separator => \
        //each directory name will be converted to first upper case
        $splitPath = explode(DIRECTORY_SEPARATOR, $relativeFilePath);
        $namespace = implode('\\', array_map(function ($item) {
            return ucfirst($item);
        }, $splitPath));

        return $namespace;
    }

    /**
     * Extract all class annotations
     * The result contains annotations of class itself, class methods
     *
     * @param $className
     * @return array
     */
    protected function extractAnnotations($className)
    {
        $reader = $this->getAnnotationsReader();
        $reflector = $reader->get($className);

        $classAnnotations = $reflector->getClassAnnotations();
        $methodsAnnotations = $reflector->getMethodsAnnotations();
        return array(
            'class' => $classAnnotations,
            'methods' => $methodsAnnotations
        );
    }

    /**
     * Parses annotations for extract class and methods information
     *
     * @param $annotations
     * @return array
     */
    protected function parseAnnotations($annotations)
    {
        if (!$annotations['class'] instanceof Collection) {
            return array();
        }
        //get api from class annotation
        if (!$annotations['class']->has('api')) {
            return array();
        }

        //maps class annotations
        $classCollection = (new CollectionWrapper(
            'class',
            $annotations['class']->get('api'))
        )->getCollection();

        $collection = array(
            'class' => $classCollection
        );
        //maps methods annotations
        foreach ($annotations['methods'] as $name => $method) {
            if (!$method->has('api')) {
                continue;
            }

            $methodCollection = (new CollectionWrapper(
                'method', $method->get('api'))
            )->getCollection();
            $collection['methods'][str_replace('Action', '', $name)] = $methodCollection;
        }

        return $collection;
    }

    /**
     * Renders output file using renderer object
     *
     * @throws InvalidRendererException
     * @return string
     */
    public function render()
    {
        if ($this->eventsManager instanceof ManagerInterface) {
            $this->eventsManager->fire('generator:beforeRender', $this);
        }

        if (!$this->renderer instanceof RendererInterface) {
            throw new InvalidRendererException();
        }
        $output = $this->renderer->render();

        if ($this->eventsManager instanceof ManagerInterface) {
            $this->eventsManager->fire('generator:afterRender', $this);
        }

        return $output;
    }
}

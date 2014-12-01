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

use Vegas\ApiDoc\Exception\InvalidViewComponentException;

/**
 * Class Renderer
 *
 * Output renderer
 *
 * @package Vegas\ApiDoc
 */
class Renderer implements RendererInterface
{
    /**
     * Collection of information from Generator class
     *
     * @var array
     */
    private $collections;

    /**
     * Path to template
     *
     * @var string
     */
    private $templatePath;

    /**
     * @var \Phalcon\Mvc\ViewInterface
     */
    private $view;

    /**
     * @param array $collections
     * @param string $templatePath
     */
    public function __construct(array $collections, $templatePath)
    {
        $this->collections = $collections;
        $this->templatePath = $templatePath;
    }

    /**
     * @param \Phalcon\Mvc\ViewInterface $view
     */
    public function setView(\Phalcon\Mvc\ViewInterface $view)
    {
        $this->view = $view;
    }

    /**
     * Renders output content
     *
     * @return string
     * @throws Exception\InvalidViewComponentException
     */
    public function render()
    {
        if (!$this->view && $this->view instanceof \Phalcon\Mvc\ViewInterface) {
            throw new InvalidViewComponentException();
        }

        ob_start();
        $this->view->partial($this->templatePath, [
            'collections' => $this->collections
        ]);
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }
}
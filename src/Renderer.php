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

use Phalcon\Mvc\ViewInterface;
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
     * @var ViewInterface
     */
    private $view;

    /**
     * @var array
     */
    private $viewParams = [];

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
     * @param ViewInterface $view
     */
    public function setView(ViewInterface $view)
    {
        $this->view = $view;
    }

    /**
     * Sets view var
     *
     * @param $varName
     * @param $varValue
     * @throws InvalidViewComponentException
     */
    public function setViewVar($varName, $varValue)
    {
        $this->viewParams[$varName] = $varValue;
    }

    /**
     * Renders output content
     *
     * @return string
     * @throws Exception\InvalidViewComponentException
     */
    public function render()
    {
        if (!$this->view || !$this->view instanceof ViewInterface) {
            throw new InvalidViewComponentException();
        }

        foreach ($this->viewParams as $param => $value) {
            $this->view->setVar($param, $value);
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

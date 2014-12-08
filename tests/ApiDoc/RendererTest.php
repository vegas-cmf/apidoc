<?php
/**
 * This file is part of Vegas package
 *
 * @author Slawomir Zytko <slawomir.zytko@gmail.com>
 * @copyright Amsterdam Standard Sp. Z o.o.
 * @homepage http://vegas-cmf.github.io
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vegas\Tests\ApiDoc;

use Vegas\ApiDoc\Renderer;

class RendererTest extends \Vegas\Tests\TestCase
{
    private function getViewInstance()
    {
        $viewConfig = \Phalcon\DI::getDefault()->get('config')->application->view->toArray();
        $viewConfig['compileAlways'] = true;
        unset($viewConfig['cacheDir']);
        $view = new \Vegas\Mvc\View($viewConfig);
        $view->setDI(\Phalcon\DI::getDefault());

        return $view;
    }

    public function testShouldRenderHtml()
    {
        $generator = new \Vegas\ApiDoc\Generator(APP_ROOT . '/app/modules', [
                'match' => '/(.*)Controller(.*)\.php/i',
                'verbose' => false
            ]
        );
        //builds information
        $collections = $generator->build();

        $renderer = new Renderer($collections, APP_ROOT . '/app/layouts/partials/apiDoc/layout');
        $renderer->setView($this->getViewInstance());
        $output = $renderer->render();
file_put_contents('/tmp/vegas_apidoc_index.html', $output);
        $this->assertNotEmpty($output);
        $this->assertTag(['tag' => 'body'], $output);

        foreach ($collections as $collection) {
            $this->assertContains($collection['class']['name'], $output);
        }
    }

    public function testShouldSetViewVariable()
    {
        $view = $this->getViewInstance();

        $renderer = new Renderer([], APP_ROOT . '/app/layouts/partials/apiDoc/layout');
        $renderer->setView($view);

        $renderer->setViewVar('test', 1);
        $renderer->render();

        $this->assertNotNull('test', $view->getVar('test'));
        $this->assertEquals(1, $view->getVar('test'));
    }

    public function testShouldThrowExceptionForInvalidViewObject()
    {
        $exception = null;
        try {
            $renderer = new Renderer([], 'foo');
            $renderer->render();
        } catch (\Exception $e) {
            $exception = $e;
        }
        $this->assertInstanceOf('\Vegas\ApiDoc\Exception\InvalidViewComponentException', $exception);
    }
}
 
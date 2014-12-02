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

namespace Vegas\Tests\ApiDoc\Task;

class GeneratorTaskAbstractTest extends \Vegas\Tests\TestCase
{
    public function tearDown()
    {
        if (file_exists('/tmp/vegas_apidoc/index.html')) {
            unlink('/tmp/vegas_apidoc/index.html');
            rmdir('/tmp/vegas_apidoc');
        }
        if (file_exists('/tmp/vegas_apidoc_template.volt')) {
            unlink('/tmp/vegas_apidoc_template.volt');
        }
    }

    private function getViewInstance()
    {
        $viewConfig = \Phalcon\DI::getDefault()->get('config')->application->view->toArray();
        $viewConfig['compileAlways'] = true;
        unset($viewConfig['cacheDir']);
        $view = new \Vegas\Mvc\View($viewConfig);
        $view->setDI(\Phalcon\DI::getDefault());

        return $view;
    }

    public function test()
    {
        $stub = $this->getMockForAbstractClass('\Vegas\ApiDoc\Task\GeneratorTaskAbstract');
        $stub->expects($this->any())
            ->method('getView')
            ->will($this->returnValue($this->getViewInstance()));

        $stub->expects($this->any())
            ->method('getInputPath')
            ->will($this->returnValue(APP_ROOT . '/app/modules'));

        //create output directory in /tmp
        mkdir('/tmp/vegas_apidoc');
        $stub->expects($this->any())
            ->method('getOutputPath')
            ->will($this->returnValue('/tmp/vegas_apidoc/'));

        //create template in /tmp
        file_put_contents('/tmp/vegas_apidoc_template.volt', '');
        $stub->expects($this->any())
            ->method('getLayoutFilePath')
            ->will($this->returnValue('/tmp/vegas_apidoc_template'));

        ob_start();
        $stub->generateAction();
        $info = ob_get_contents();
        ob_end_clean();

        $this->assertNotEmpty($info);
        $this->assertContains('Processing', $info);
        $this->assertFileExists('/tmp/vegas_apidoc/index.html');
    }
}
 
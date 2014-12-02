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

use Phalcon\Events\Event;
use Vegas\ApiDoc\Generator;
use Vegas\ApiDoc\Renderer;
use Vegas\ApiDoc\RendererInterface;

class FakeRenderer implements RendererInterface
{

    /**
     * Renders output content
     *
     * @return string
     */
    public function render()
    {
        return '';
    }
}


class GeneratorTest extends \Vegas\Tests\TestCase
{
    public function testShouldFindThreeControllers()
    {
        $generator = new \Vegas\ApiDoc\Generator(APP_ROOT . '/app/modules', [
                'match' => '/(.*)Controller(.*)\.php/i',
                'verbose' => false
            ]
        );
        //builds information
        $collections = $generator->build();

        $this->assertInternalType('array', $collections);
        $this->assertCount(3, $collections);
        $this->assertArrayNotHasKey('\ApiTest\Controllers\ShouldBeSkipped', $collections);
    }

    public function testShouldThrowExceptionForNonExistingArgument()
    {
        $generator = new \Vegas\ApiDoc\Generator(APP_ROOT . '/app/invalid', [
            'match' => '/(.*)Controller(.*)\.php/i',
            'verbose' => false
        ]);

        $exception = null;
        try {
            $generator->build();
        } catch (\Exception $e) {
            $exception = $e;
        }
        $this->assertInstanceOf('\Vegas\ApiDoc\Exception\CollectionArgumentNotFoundException', $exception);
    }

    public function testShouldThrowExceptionAboutInvalidRenderer()
    {
        $generator = new \Vegas\ApiDoc\Generator(APP_ROOT . '/app/modules', [
            'match' => '/(.*)Controller(.*)\.php/i',
            'verbose' => false
        ]);
        $generator->build();

        $exception = null;
        try {
            $generator->render();
        } catch (\Exception $e) {
            $exception = $e;
        }
        $this->assertInstanceOf('\Vegas\ApiDoc\Exception\InvalidRendererException', $exception);
    }

    public function testShouldFireEvents()
    {
        $firedEventsCounter = 0;

        $eventsManager = new \Phalcon\Events\Manager();
        $eventsManager->attach('generator:beforeBuild', function(Event $event, Generator $generator) use (&$firedEventsCounter) {
            $firedEventsCounter++;
        });
        $eventsManager->attach('generator:afterBuild', function(Event $event, Generator $generator) use (&$firedEventsCounter) {
            $firedEventsCounter++;
        });
        $eventsManager->attach('generator:beforeRender', function(Event $event, Generator $generator) use (&$firedEventsCounter) {
            $firedEventsCounter++;
        });
        $eventsManager->attach('generator:afterRender', function(Event $event, Generator $generator) use (&$firedEventsCounter) {
            $firedEventsCounter++;
        });

        $generator = new \Vegas\ApiDoc\Generator(APP_ROOT . '/app/modules', [
            'match' => '/(.*)Controller(.*)\.php/i',
            'verbose' => false
        ]);

        $generator->setEventsManager($eventsManager);
        $generator->build();
        $generator->setRenderer(new FakeRenderer());
        $generator->render();

        $this->assertInstanceOf('\Phalcon\Events\Manager', $generator->getEventsManager());
        $this->assertSame(4, $firedEventsCounter);
    }

    public function testShouldShowInfoAboutProcessingFile()
    {
        $generator = new \Vegas\ApiDoc\Generator(APP_ROOT . '/app/modules', [
            'match' => '/(.*)Controller(.*)\.php/i',
            'verbose' => true
        ]);

        $info = '';
        ob_start();
        $generator->build();
        $info = ob_get_contents();
        ob_end_clean();

        $this->assertNotEmpty($info);
        $this->assertContains('Processing', $info);
    }

    public function testShouldSwitchAnnotationsReader()
    {
        $generator = new \Vegas\ApiDoc\Generator(APP_ROOT . '/app/modules', [
            'match' => '/(.*)Controller(.*)\.php/i',
            'verbose' => false
        ]);

        $generator->setupAnnotationsReader(new \Phalcon\Annotations\Adapter\Files());
        $this->assertInstanceOf('\Phalcon\Annotations\Adapter\Files', $generator->getAnnotationsReader());
    }
}
 
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
            'match' => '/(.*)C ontroller(.*)\.php/i',
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
}
 
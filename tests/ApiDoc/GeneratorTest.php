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
    public function testShouldFindTwoClasses()
    {
        $generator = new \Vegas\ApiDoc\Generator(APP_ROOT . '/app/modules', [
                'match' => '/(.*)Controller(.*)\.php/i',
                'verbose' => true
            ]);
        //builds information
        $collections = $generator->build();
    }
}
 
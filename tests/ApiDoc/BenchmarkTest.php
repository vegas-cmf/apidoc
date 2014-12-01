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


use Vegas\ApiDoc\Benchmark;
use Vegas\Tests\TestCase;

class BenchmarkTest extends TestCase
{
    public function testShouldReturnTheSameTimeDifferent()
    {
        $benchmark = new Benchmark();
        $reflectObject = new \ReflectionObject($benchmark);

        $benchmark->start();

        $startedAtProperty = $reflectObject->getProperty('startedAt');
        $startedAtProperty->setAccessible(true);
        $this->assertInternalType('float', $startedAtProperty->getValue($benchmark));

        $benchmark->finish();

        $finishedAtProperty = $reflectObject->getProperty('finishedAt');
        $finishedAtProperty->setAccessible(true);
        $this->assertInternalType('float', $finishedAtProperty->getValue($benchmark));

        $this->assertSame(
            $finishedAtProperty->getValue($benchmark) - $startedAtProperty->getValue($benchmark),
            $benchmark->getGenerationTime()
        );
    }
} 
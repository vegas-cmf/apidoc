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

namespace Vegas\Tests\ApiDoc\Collection;

use Vegas\ApiDoc\Collection\ClassCollection;

class ClassCollectionTest extends \Vegas\Tests\TestCase
{
    public function testShouldSetExistingProperty()
    {
        $collection = new ClassCollection();
        $collection->name = 'test';

        $this->assertEquals('test', $collection->name);
        $this->assertEquals('test', $collection['name']);

        $collection->setArgument('name', 'test2');
        $this->assertEquals('test2', $collection->name);
        $this->assertEquals('test2', $collection['name']);

        $collection['name'] = 'test3';
        $this->assertEquals('test3', $collection->name);
        $this->assertEquals('test3', $collection['name']);
    }

    public function testShouldNotSetNonExistingProperty()
    {
        $collection = new ClassCollection();

        $exception = null;
        try {
            $collection->foo = 'test';
        } catch (\Exception $e) {
            $exception = $e;
        }
        $this->assertInstanceOf('\Vegas\ApiDoc\Exception\CollectionArgumentNotFoundException', $exception);


        $exception = null;
        try {
            $collection->setArgument('foo', 'test2');
        } catch (\Exception $e) {
            $exception = $e;
        }
        $this->assertInstanceOf('\Vegas\ApiDoc\Exception\CollectionArgumentNotFoundException', $exception);

        $exception = null;
        try {
            $collection['foo'] = 'test2';
        } catch (\Exception $e) {
            $exception = $e;
        }
        $this->assertInstanceOf('\Vegas\ApiDoc\Exception\CollectionArgumentNotFoundException', $exception);
    }

    public function testShouldReturnBooleanForWhenCheckingProperty()
    {
        $collection = new ClassCollection();

        $this->assertTrue($collection->hasArgument('name'));
        $this->assertFalse($collection->hasArgument('name2'));
    }
} 
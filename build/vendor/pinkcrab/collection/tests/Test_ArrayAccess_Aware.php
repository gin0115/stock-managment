<?php

declare (strict_types=1);
/**
 * Tests for a collection with ArrayAccess
 *
 * @since 0.1.0
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @package PinkCrab\Collection
 */
namespace pc_stock_man_v1\PinkCrab\Core\Tests\Collection;

use PHPUnit\Framework\TestCase;
use pc_stock_man_v1\PinkCrab\Collection\Tests\Fixtures\Array_Collection;
class Test_Has_ArrayAccess extends \PHPUnit\Framework\TestCase
{
    /** @testdox It should be possible to set a value using array syntax when using the Has_ArrayAccess trait*/
    public function test_can_set() : void
    {
        $collection = new \pc_stock_man_v1\PinkCrab\Collection\Tests\Fixtures\Array_Collection();
        $collection[] = '0';
        $collection[1] = '1';
        $this->assertEquals('0', $collection->to_array()[0]);
        $this->assertEquals('1', $collection->to_array()[1]);
    }
    /** @testdox It should be possible to get a value from an index using array syntax when using the Has_ArrayAccess trait*/
    public function test_can_get() : void
    {
        $collection = new \pc_stock_man_v1\PinkCrab\Collection\Tests\Fixtures\Array_Collection(array('one', 'two'));
        $this->assertEquals('one', $collection[0]);
        $this->assertEquals('two', $collection[1]);
    }
    /** @testdox It should be possible to unset a value from an index using array syntax when using the Has_ArrayAccess trait*/
    public function test_can_unset() : void
    {
        $collection = new \pc_stock_man_v1\PinkCrab\Collection\Tests\Fixtures\Array_Collection(array('one', 'two'));
        unset($collection[0]);
        $this->assertCount(1, $collection);
    }
    /** @testdox It should be possible to check an index exists using array syntax when using the Has_ArrayAccess trait*/
    public function test_exists() : void
    {
        $collection = new \pc_stock_man_v1\PinkCrab\Collection\Tests\Fixtures\Array_Collection(array('test'));
        $this->assertTrue(isset($collection[0]));
        $this->assertFalse(isset($collection[1]));
    }
}

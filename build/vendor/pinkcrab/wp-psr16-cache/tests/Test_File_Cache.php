<?php

declare (strict_types=1);
namespace PC_Woo_Stock_Man;

/**
 * Tests the transient cache driver
 *
 * @since 1.0.0
 * @author GLynn Quelch <glynn.quelch@gmail.com>
 */
use PHPUnit\Framework\TestCase;
use PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects;
use PC_Woo_Stock_Man\Psr\SimpleCache\CacheInterface;
use PC_Woo_Stock_Man\PinkCrab\WP_PSR16_Cache\Cache_Item;
use PC_Woo_Stock_Man\PinkCrab\WP_PSR16_Cache\File_Cache;
use PC_Woo_Stock_Man\PinkCrab\WP_PSR16_Cache\Tests\Test_Case_Trait;
class Test_File_Cache extends \PHPUnit\Framework\TestCase
{
    use Test_Case_Trait;
    /**
     * The Transient Cache Implementation
     *
     * @var CacheInterface
     */
    protected $cache;
    public function setUp() : void
    {
        $this->cache = new \PC_Woo_Stock_Man\PinkCrab\WP_PSR16_Cache\File_Cache(__DIR__ . '/File_Cache_FS');
    }
    /**             RUNS ALL TESTS FROM TRAIT!             */
    public function test_validate_check_all_item_properties() : void
    {
        // Mock item
        $item = new \PC_Woo_Stock_Man\PinkCrab\WP_PSR16_Cache\Cache_Item('key', array('test' => 'foo'), \time());
        // Check returns false if keys do not match.
        $this->assertFalse(\PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::invoke_method($this->cache, 'validate_contents', array('not_the_correct_key', $item)));
        // Function test returns false if expiry is no numerical.
        $item->expiry = 'IM NOT A NUMBER!';
        $this->assertFalse(\PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::invoke_method($this->cache, 'validate_contents', array('key', $item)));
    }
}
\class_alias('PC_Woo_Stock_Man\\Test_File_Cache', 'Test_File_Cache', \false);

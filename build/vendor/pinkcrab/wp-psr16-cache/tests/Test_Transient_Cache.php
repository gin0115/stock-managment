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
use PC_Woo_Stock_Man\PinkCrab\WP_PSR16_Cache\Transient_Cache;
use PC_Woo_Stock_Man\PinkCrab\WP_PSR16_Cache\Tests\Test_Case_Trait;
class Transient_Cache_Tests extends \PHPUnit\Framework\TestCase
{
    use Test_Case_Trait;
    /**
     * The Tranient Cache Implementation
     *
     * @var CacheInterface
     */
    protected $cache;
    public function setUp() : void
    {
        $this->cache = new \PC_Woo_Stock_Man\PinkCrab\WP_PSR16_Cache\Transient_Cache('tests');
    }
    /**             RUNS ALL TESTS FROM TRAIT!             */
    /**
     * Tests that all transients set with no ttl or an invalid type
     * are set to 0 (do not expire)
     *
     * @return void
     */
    public function testTransientsWithNoTTLHaveNoExpiry() : void
    {
        $this->cache->set('as_array', 'Zulu', array('array', 'should never expire'));
        $this->assertEquals(0, (int) \get_option('_transient_timeout_tests_as_array', 0));
        $this->cache->set('as_zero', 'Zulu', 0);
        $this->assertEquals(0, (int) \get_option('_transient_timeout_tests_as_zero', 0));
    }
    /**
     * Test CacheInterface_Trait::all_true()
     *
     * @return void
     */
    public function test_all_true_returns_false_if_not_bool() : void
    {
        $none_bool = array('string');
        $this->assertFalse(\PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::invoke_method($this->cache, 'all_true', array($none_bool)));
    }
    /**
     * Test CacheInterface_Trait::all_true()
     *
     * @return void
     */
    public function test_all_true_returns_false_if_some_not_false() : void
    {
        $some_false = array(\true, \false);
        $this->assertFalse(\PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::invoke_method($this->cache, 'all_true', array($some_false)));
    }
}
\class_alias('PC_Woo_Stock_Man\\Transient_Cache_Tests', 'Transient_Cache_Tests', \false);

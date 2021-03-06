<?php

declare (strict_types=1);
/**
 * Mock Post Type with meta data with defined schema
 *
 * @since 0.7.1
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @package PinkCrab\Registerables
 */
namespace PC_Woo_Stock_Man\PinkCrab\Registerables\Tests\Fixtures\CPT;

use PC_Woo_Stock_Man\PinkCrab\Registerables\Meta_Data;
use PC_Woo_Stock_Man\PinkCrab\Registerables\Post_Type;
use PC_Woo_Stock_Man\PinkCrab\WP_Rest_Schema\Argument\Argument;
use PC_Woo_Stock_Man\PinkCrab\WP_Rest_Schema\Argument\Number_Type;
use PC_Woo_Stock_Man\PinkCrab\WP_Rest_Schema\Argument\String_Type;
use PC_Woo_Stock_Man\PinkCrab\WP_Rest_Schema\Argument\Integer_Type;
class Meta_Data_Rest_CPT extends \PC_Woo_Stock_Man\PinkCrab\Registerables\Post_Type
{
    public const META_1 = array('key' => 'meta_rest_key_1', 'type' => 'string', 'default' => 'default value 1', 'description' => 'test 1', 'single' => \true, 'sanitize_callback' => 'strtoupper', 'auth_callback' => '__return_true');
    public const META_2 = array('key' => 'meta_rest_key_2', 'type' => 'number', 'default' => 3.245, 'description' => 'test 2', 'single' => \true, 'sanitize_callback' => 'strtoupper', 'auth_callback' => '__return_true');
    // The schema for key 1 as array.
    public static function meta_rest_key_1_schema() : array
    {
        return array('type' => 'string', 'default' => 'default value 1', 'description' => 'test 1');
    }
    // The schema for key 2 as Argument type
    public static function meta_rest_key_2_schema() : \PC_Woo_Stock_Man\PinkCrab\WP_Rest_Schema\Argument\Argument
    {
        return \PC_Woo_Stock_Man\PinkCrab\WP_Rest_Schema\Argument\Number_Type::on(self::META_2['key'])->description('test 2')->default(3.245);
    }
    // Returns as an array for comparison.
    public static function meta_rest_key_2_schema_as_array() : array
    {
        return array('type' => 'number', 'description' => 'test 2', 'default' => 3.245);
    }
    public static $call_log = array();
    public $key = 'metadata_rest_cpt';
    public $singular = 'singular';
    public $plural = 'plural';
    /**
     * Define some fake meta.
     *
     * @param Meta_Data[] $collection
     * @return Meta_Data[]
     */
    public function meta_data(array $collection) : array
    {
        $update_rest = function ($meta_key) : callable {
            return function ($value, $model) use($meta_key) : void {
                self::$call_log[\get_class($model)][$meta_key] = $value;
            };
        };
        $view_rest = function ($meta_key) : callable {
            return function ($model) use($meta_key) {
                self::$call_log[$model['id']][] = $meta_key;
            };
        };
        $collection[] = (new \PC_Woo_Stock_Man\PinkCrab\Registerables\Meta_Data(self::META_1['key']))->type(self::META_1['type'])->default(self::META_1['default'])->description(self::META_1['description'])->single(self::META_1['single'])->sanitize(self::META_1['sanitize_callback'])->permissions(self::META_1['auth_callback'])->rest_schema(self::meta_rest_key_1_schema())->rest_update($update_rest(self::META_1['key']))->rest_view($view_rest(self::META_1['key']));
        $collection[] = (new \PC_Woo_Stock_Man\PinkCrab\Registerables\Meta_Data(self::META_2['key']))->type(self::META_2['type'])->default(self::META_2['default'])->description(self::META_2['description'])->single(self::META_2['single'])->sanitize(self::META_2['sanitize_callback'])->permissions(self::META_2['auth_callback'])->rest_schema(self::meta_rest_key_2_schema())->rest_update($update_rest(self::META_2['key']))->rest_view($view_rest(self::META_2['key']));
        return $collection;
    }
}

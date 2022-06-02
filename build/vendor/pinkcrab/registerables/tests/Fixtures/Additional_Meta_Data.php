<?php

declare (strict_types=1);
/**
 * Mock Additional_Meta_Data_Controller
 *
 * @since 0.8.0
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @package PinkCrab\Registerables
 */
namespace PC_Woo_Stock_Man\PinkCrab\Registerables\Tests\Fixtures;

use PC_Woo_Stock_Man\PinkCrab\Registerables\Meta_Data;
use PC_Woo_Stock_Man\PinkCrab\WP_Rest_Schema\Argument\String_Type;
use PC_Woo_Stock_Man\PinkCrab\Registerables\Additional_Meta_Data_Controller;
class Additional_Meta_Data extends \PC_Woo_Stock_Man\PinkCrab\Registerables\Additional_Meta_Data_Controller
{
    /**
     * Mock meta data for POST
     *
     * Has Schema (via ARRAY)
     *
     * @return \PinkCrab\Registerables\Meta_Data
     */
    public static function post_meta_data() : \PC_Woo_Stock_Man\PinkCrab\Registerables\Meta_Data
    {
        return (new \PC_Woo_Stock_Man\PinkCrab\Registerables\Meta_Data('mock_post_meta_data'))->post_type('page')->rest_schema(array('type' => 'string'));
    }
    /**
     * Mock meta data for TERM
     *
     * Without Schema
     *
     * @return \PinkCrab\Registerables\Meta_Data
     */
    public static function term_meta_data() : \PC_Woo_Stock_Man\PinkCrab\Registerables\Meta_Data
    {
        return (new \PC_Woo_Stock_Man\PinkCrab\Registerables\Meta_Data('mock_term_meta_data'))->taxonomy('categories');
    }
    /**
     * Mock meta data for COMMENT
     *
     * Has Schema (Via WP_Rest_Schema)
     *
     * @return \PinkCrab\Registerables\Meta_Data
     */
    public static function comment_meta_data() : \PC_Woo_Stock_Man\PinkCrab\Registerables\Meta_Data
    {
        return (new \PC_Woo_Stock_Man\PinkCrab\Registerables\Meta_Data('mock_comment_meta_data'))->meta_type('comment')->rest_schema(\PC_Woo_Stock_Man\PinkCrab\WP_Rest_Schema\Argument\String_Type::on('mock_comment_meta_data'));
    }
    /**
     * Mock meta data for USER
     *
     * Without Schema
     *
     * @return \PinkCrab\Registerables\Meta_Data
     */
    public static function user_meta_data() : \PC_Woo_Stock_Man\PinkCrab\Registerables\Meta_Data
    {
        return (new \PC_Woo_Stock_Man\PinkCrab\Registerables\Meta_Data('mock_user_meta_data'))->meta_type('user');
    }
    /**
     * Registers all the meta data.
     *
     * @param Meta_Data[] $array
     * @return Meta_Data[]
     */
    public function meta_data(array $array) : array
    {
        return array(self::post_meta_data(), self::term_meta_data(), self::comment_meta_data(), self::user_meta_data());
    }
}

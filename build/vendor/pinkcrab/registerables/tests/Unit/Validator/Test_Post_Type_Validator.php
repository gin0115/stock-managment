<?php

declare (strict_types=1);
/**
 * UNIT tests for the Post Type Validator
 *
 * @since 0.1.0
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @package PinkCrab\Registerables
 */
namespace PC_Woo_Stock_Man\PinkCrab\Registerables\Tests\Unit\Validator;

use PHPUnit\Framework\TestCase;
use PC_Woo_Stock_Man\PinkCrab\Registerables\Tests\Fixtures\CPT\Basic_CPT;
use PC_Woo_Stock_Man\PinkCrab\Registerables\Validator\Post_Type_Validator;
use PC_Woo_Stock_Man\PinkCrab\Registerables\Registration_Middleware\Registerable;
class Test_Post_Type_Validator extends \PHPUnit\Framework\TestCase
{
    /** @testdox When validating a post type, errors should be generated if attempting with none Post Type Registerable. */
    public function test_generates_errors_if_not_post_type() : void
    {
        $validator = new \PC_Woo_Stock_Man\PinkCrab\Registerables\Validator\Post_Type_Validator();
        $mock = $this->createMock(\PC_Woo_Stock_Man\PinkCrab\Registerables\Registration_Middleware\Registerable::class);
        $result = $validator->validate($mock);
        // Should return false for error.
        $this->assertFalse($result);
        // Check created errors in log
        $this->assertTrue($validator->has_errors());
        $this->assertContains(\get_class($mock) . ' is not a valid Post Type Model', $validator->get_errors());
    }
    /** @testdox When validating a post type, key, singular and plural must be string and not empty. If any are, then validation should fail with error messages. */
    public function test_fails_if_required_fields_are_missing() : void
    {
        $validator = new \PC_Woo_Stock_Man\PinkCrab\Registerables\Validator\Post_Type_Validator();
        $cpt = new \PC_Woo_Stock_Man\PinkCrab\Registerables\Tests\Fixtures\CPT\Basic_CPT();
        // Key empty string
        $cpt->key = '';
        $result = $validator->validate($cpt);
        $this->assertFalse($result);
        $this->assertContains('key is not set on PinkCrab\\Registerables\\Tests\\Fixtures\\CPT\\Basic_CPT Post Type Model', $validator->get_errors());
        $validator->reset_errors();
        $cpt = new \PC_Woo_Stock_Man\PinkCrab\Registerables\Tests\Fixtures\CPT\Basic_CPT();
        // Key none string.
        $cpt->key = null;
        $result = $validator->validate($cpt);
        $this->assertFalse($result);
        $this->assertContains('key is not set on PinkCrab\\Registerables\\Tests\\Fixtures\\CPT\\Basic_CPT Post Type Model', $validator->get_errors());
        $validator->reset_errors();
        $cpt = new \PC_Woo_Stock_Man\PinkCrab\Registerables\Tests\Fixtures\CPT\Basic_CPT();
        // singular empty string
        $cpt->singular = '';
        $result = $validator->validate($cpt);
        $this->assertFalse($result);
        $this->assertContains('singular is not set on PinkCrab\\Registerables\\Tests\\Fixtures\\CPT\\Basic_CPT Post Type Model', $validator->get_errors());
        $validator->reset_errors();
        $cpt = new \PC_Woo_Stock_Man\PinkCrab\Registerables\Tests\Fixtures\CPT\Basic_CPT();
        // singular none string.
        $cpt->singular = array(null);
        $result = $validator->validate($cpt);
        $this->assertFalse($result);
        $this->assertContains('singular is not set on PinkCrab\\Registerables\\Tests\\Fixtures\\CPT\\Basic_CPT Post Type Model', $validator->get_errors());
        $validator->reset_errors();
        $cpt = new \PC_Woo_Stock_Man\PinkCrab\Registerables\Tests\Fixtures\CPT\Basic_CPT();
        // plural empty string
        $cpt->plural = '';
        $result = $validator->validate($cpt);
        $this->assertFalse($result);
        $this->assertContains('plural is not set on PinkCrab\\Registerables\\Tests\\Fixtures\\CPT\\Basic_CPT Post Type Model', $validator->get_errors());
        $validator->reset_errors();
        $cpt = new \PC_Woo_Stock_Man\PinkCrab\Registerables\Tests\Fixtures\CPT\Basic_CPT();
        // plural none string.
        $cpt->plural = (object) array('r' => null);
        $result = $validator->validate($cpt);
        $this->assertFalse($result);
        $this->assertContains('plural is not set on PinkCrab\\Registerables\\Tests\\Fixtures\\CPT\\Basic_CPT Post Type Model', $validator->get_errors());
        $validator->reset_errors();
        $cpt = new \PC_Woo_Stock_Man\PinkCrab\Registerables\Tests\Fixtures\CPT\Basic_CPT();
    }
}

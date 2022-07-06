<?php

declare (strict_types=1);
/**
 * UNIT tests for the Abstract Validators shared functionality
 *
 * @since 0.1.0
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @package PinkCrab\Registerables
 */
namespace pc_stock_man_v1\PinkCrab\Registerables\Tests\Unit\Validator;

use PHPUnit\Framework\TestCase;
use pc_stock_man_v1\Gin0115\WPUnit_Helpers\Objects;
use pc_stock_man_v1\PinkCrab\Registerables\Validator\Abstract_Validator;
use pc_stock_man_v1\PinkCrab\Registerables\Registration_Middleware\Registerable;
class Test_Abstract_Validator extends \PHPUnit\Framework\TestCase
{
    /**
     * Creates a testable validator
     *
     * @return \PinkCrab\Registerables\Validator\Abstract_Validator
     */
    public function get_validator() : \pc_stock_man_v1\PinkCrab\Registerables\Validator\Abstract_Validator
    {
        return new class extends \pc_stock_man_v1\PinkCrab\Registerables\Validator\Abstract_Validator
        {
            public function validate(\pc_stock_man_v1\PinkCrab\Registerables\Registration_Middleware\Registerable $object) : bool
            {
                return \true;
            }
        };
    }
    /** @testdox It should be possible to add errors to the validators internal collection of errors. */
    public function test_can_add_errors() : void
    {
        $validator = $this->get_validator();
        $validator->add_error('ERROR');
        $this->assertCount(1, \pc_stock_man_v1\Gin0115\WPUnit_Helpers\Objects::get_property($validator, 'errors'));
        $this->assertContains('ERROR', \pc_stock_man_v1\Gin0115\WPUnit_Helpers\Objects::get_property($validator, 'errors'));
    }
    /** @testdox It should be possible to check if the validator has logged any errors */
    public function test_has_errors() : void
    {
        $validator = $this->get_validator();
        $this->assertFalse($validator->has_errors());
        $validator->add_error('ERROR');
        $this->assertTrue($validator->has_errors());
    }
    /** @testdox It should be possible to access any errors that have been logged. */
    public function test_get_errors() : void
    {
        $validator = $this->get_validator();
        $this->assertEmpty($validator->get_errors());
        $this->assertTrue(\is_array($validator->get_errors()));
        $validator->add_error('ERROR');
        $this->assertCount(1, $validator->get_errors());
        $this->assertContains('ERROR', $validator->get_errors());
    }
    /** @testdox It should be possible to reset any errors in the log. */
    public function test_reset_errors() : void
    {
        $validator = $this->get_validator();
        $validator->add_error('ERROR');
        $this->assertTrue($validator->has_errors());
        // Reset
        $validator->reset_errors();
        $this->assertEmpty($validator->get_errors());
        $this->assertTrue(\is_array($validator->get_errors()));
        $this->assertFalse($validator->has_errors());
    }
}

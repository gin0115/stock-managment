<?php

declare (strict_types=1);
/**
 * Blade Config Mock
 *
 * @since 1.1.2
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @package PinkCrab\BladeOne
 */
namespace PC_Woo_Stock_Man\PinkCrab\BladeOne\Tests\Fixtures;

use PC_Woo_Stock_Man\PinkCrab\BladeOne\BladeOne_Provider;
use PC_Woo_Stock_Man\PinkCrab\BladeOne\Abstract_BladeOne_Config;
use PC_Woo_Stock_Man\PinkCrab\BladeOne\Tests\Fixtures\Mock_Service;
class Mock_Blade_Config extends \PC_Woo_Stock_Man\PinkCrab\BladeOne\Abstract_BladeOne_Config
{
    protected $service;
    public function __construct(\PC_Woo_Stock_Man\PinkCrab\BladeOne\Tests\Fixtures\Mock_Service $service)
    {
        $this->service = $service;
    }
    public function config(\PC_Woo_Stock_Man\PinkCrab\BladeOne\BladeOne_Provider $bladeOne) : void
    {
        $bladeOne->set_compiled_extension($this->service->get_cache_file_extension());
        $bladeOne->directive('test', '__return_true');
        $bladeOne->allow_pipe(\false);
    }
}

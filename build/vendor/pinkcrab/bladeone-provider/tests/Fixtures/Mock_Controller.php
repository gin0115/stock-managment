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

use PC_Woo_Stock_Man\eftec\bladeone\BladeOne;
use PC_Woo_Stock_Man\PinkCrab\Perique\Services\View\View;
class Mock_Controller
{
    public $view;
    public function __construct(\PC_Woo_Stock_Man\PinkCrab\Perique\Services\View\View $view)
    {
        $this->view = $view;
    }
    public function get_blade() : \PC_Woo_Stock_Man\eftec\bladeone\BladeOne
    {
        return $this->view->engine()->get_blade();
    }
}

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
namespace pc_stock_man_v1\PinkCrab\BladeOne\Tests\Fixtures;

use pc_stock_man_v1\eftec\bladeone\BladeOne;
use pc_stock_man_v1\PinkCrab\Perique\Services\View\View;
class Mock_Controller
{
    public $view;
    public function __construct(\pc_stock_man_v1\PinkCrab\Perique\Services\View\View $view)
    {
        $this->view = $view;
    }
    public function get_blade() : \pc_stock_man_v1\eftec\bladeone\BladeOne
    {
        return $this->view->engine()->get_blade();
    }
}

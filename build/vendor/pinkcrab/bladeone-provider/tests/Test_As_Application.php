<?php

declare (strict_types=1);
/**
 * Application test
 *
 * @since 0.1.0
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @package PinkCrab\BladeOne
 */
namespace pc_stock_man_v1\PinkCrab\BladeOne\Tests;

use pc_stock_man_v1\WP_UnitTestCase;
use pc_stock_man_v1\eftec\bladeone\BladeOne;
use pc_stock_man_v1\Gin0115\WPUnit_Helpers\Objects;
use pc_stock_man_v1\PinkCrab\Perique\Application\Hooks;
use pc_stock_man_v1\PinkCrab\BladeOne\BladeOne_Provider;
use pc_stock_man_v1\PinkCrab\BladeOne\PinkCrab_BladeOne;
use pc_stock_man_v1\PinkCrab\Perique\Services\View\View;
use pc_stock_man_v1\PinkCrab\BladeOne\BladeOne_Bootstrap;
use pc_stock_man_v1\PinkCrab\Perique\Interfaces\Renderable;
use pc_stock_man_v1\PinkCrab\Perique\Application\App_Factory;
use pc_stock_man_v1\PinkCrab\Perique\Services\View\PHP_Engine;
use pc_stock_man_v1\PinkCrab\BladeOne\Abstract_BladeOne_Config;
use pc_stock_man_v1\PinkCrab\BladeOne\Tests\Fixtures\Mock_Controller;
use pc_stock_man_v1\PinkCrab\BladeOne\Tests\Fixtures\Mock_Blade_Config;
use pc_stock_man_v1\PinkCrab\BladeOne\Tests\Fixtures\Mock_Custom_Blade_One_Instance;
class Test_As_Application extends \WP_UnitTestCase
{
    /** @testdox It should be possible to use bladeone and configure its use as part of the Perique Boot process. */
    public function test_run() : void
    {
        // Include the mocks.
        require_once __DIR__ . '/Fixtures/Mock_Blade_Config.php';
        require_once __DIR__ . '/Fixtures/Mock_Service.php';
        require_once __DIR__ . '/Fixtures/Mock_Controller.php';
        $cache = \dirname(__FILE__) . '/files/cache';
        $views = \dirname(__FILE__) . '/files/views';
        // Setup BladeOne.
        \pc_stock_man_v1\PinkCrab\BladeOne\BladeOne_Bootstrap::use($views, $cache, \pc_stock_man_v1\eftec\bladeone\BladeOne::MODE_DEBUG);
        // Check the DI rules filter has been added.
        $this->assertTrue(\has_filter('PinkCrab/App/Boot/set_di_rules'));
        // Boot the app as normal, with the PHP_Engine configured for Renderable.
        $app = (new \pc_stock_man_v1\PinkCrab\Perique\Application\App_Factory())->with_wp_dice(\true)->di_rules(array('*' => array('substitutions' => array(\pc_stock_man_v1\PinkCrab\Perique\Interfaces\Renderable::class => new \pc_stock_man_v1\PinkCrab\Perique\Services\View\PHP_Engine('/')))))->registration_classes(array(\pc_stock_man_v1\PinkCrab\BladeOne\Tests\Fixtures\Mock_Blade_Config::class))->boot();
        // Check Blade One has been setup in container, but not yet populated using any configs.
        $container = $app->get_container();
        $container = \pc_stock_man_v1\Gin0115\WPUnit_Helpers\Objects::get_property($container, 'dice');
        // Check renderable is no longer php_engine and using default PinkCrab BladeOne
        $renderable = $container->getRule(\pc_stock_man_v1\PinkCrab\Perique\Interfaces\Renderable::class);
        $this->assertEquals(\pc_stock_man_v1\PinkCrab\BladeOne\BladeOne_Provider::class, $renderable['instanceOf']);
        $this->assertTrue($renderable['shared']);
        // Check BladeOne is passed as a substitute to Renderable
        $blade_one_pre_config = $renderable['substitutions'][\pc_stock_man_v1\PinkCrab\BladeOne\PinkCrab_BladeOne::class];
        $this->assertInstanceOf(\pc_stock_man_v1\PinkCrab\BladeOne\PinkCrab_BladeOne::class, $blade_one_pre_config);
        $this->assertEquals($views, \pc_stock_man_v1\Gin0115\WPUnit_Helpers\Objects::get_property($blade_one_pre_config, 'templatePath')[0]);
        $this->assertEquals($cache, \pc_stock_man_v1\Gin0115\WPUnit_Helpers\Objects::get_property($blade_one_pre_config, 'compiledPath'));
        $this->assertEquals(5, $blade_one_pre_config->getMode());
        // Enable pipe by default.
        $this->assertEquals('allow_pipe', $renderable['call'][0][0]);
        $this->assertEquals(array(), $renderable['call'][0][1]);
        // Check that the BladeOne Config is populated
        $config_class = $container->getRule(\pc_stock_man_v1\PinkCrab\BladeOne\Abstract_BladeOne_Config::class);
        $this->assertNotEmpty($config_class);
        $this->assertArrayHasKey('call', $config_class);
        $this->assertEquals('set_renderable', $config_class['call'][0][0]);
        $this->assertContains(array('Dice::INSTANCE' => \pc_stock_man_v1\PinkCrab\Perique\Interfaces\Renderable::class), $config_class['call'][0][1]);
        // Bootup the app and ensure config is run.
        $data_via_reference = array();
        add_action('init', function () use($container, &$data_via_reference) {
            $data_via_reference['mock_controller'] = $container->create(\pc_stock_man_v1\PinkCrab\BladeOne\Tests\Fixtures\Mock_Controller::class);
        });
        do_action('init');
        // Boots Perique
        do_action('wp_loaded');
        // Triggers the blade one config once all is loaded (see issue 13)
        // Ensure the mock controller added to registration is populated with BladeOne for view.
        $this->assertInstanceOf(\pc_stock_man_v1\PinkCrab\BladeOne\Tests\Fixtures\Mock_Controller::class, $data_via_reference['mock_controller']);
        $view = $data_via_reference['mock_controller']->view;
        $this->assertInstanceOf(\pc_stock_man_v1\PinkCrab\Perique\Services\View\View::class, $view);
        $this->assertInstanceOf(\pc_stock_man_v1\PinkCrab\BladeOne\BladeOne_Provider::class, $view->engine());
        $blade_one_post_config = $view->engine()->get_blade();
        $this->assertInstanceOf(\pc_stock_man_v1\PinkCrab\BladeOne\PinkCrab_BladeOne::class, $blade_one_post_config);
        // Ensure that config class has been called to setup blade one
        // This runs on init priority 2.
        $this->assertFalse($blade_one_post_config->pipeEnable);
        $this->assertArrayHasKey('test', \pc_stock_man_v1\Gin0115\WPUnit_Helpers\Objects::get_property($blade_one_post_config, 'customDirectives'));
        $this->assertEquals('__return_true', \pc_stock_man_v1\Gin0115\WPUnit_Helpers\Objects::get_property($blade_one_post_config, 'customDirectives')['test']);
        $this->assertEquals('.mock-cache', \pc_stock_man_v1\Gin0115\WPUnit_Helpers\Objects::get_property($blade_one_post_config, 'compileExtension'));
    }
    /** @testdox It should be possible to use a custom wrapper for PinkCrab BladeOne as a class name., this allows for setting of custom traits for Components etc. */
    public function test_can_use_custom_blade_one_wrapper_as_class_name() : void
    {
        // Clear existing filters from previous tests.
        \remove_all_filters(\pc_stock_man_v1\PinkCrab\Perique\Application\Hooks::APP_INIT_SET_DI_RULES);
        // Configure with a custom Blade Implementation.
        \pc_stock_man_v1\PinkCrab\BladeOne\BladeOne_Bootstrap::use(__DIR__, __DIR__, \pc_stock_man_v1\eftec\bladeone\BladeOne::MODE_DEBUG, \pc_stock_man_v1\PinkCrab\BladeOne\Tests\Fixtures\Mock_Custom_Blade_One_Instance::class);
        $rules = \apply_filters(\pc_stock_man_v1\PinkCrab\Perique\Application\Hooks::APP_INIT_SET_DI_RULES, array());
        $this->assertInstanceOf(\pc_stock_man_v1\PinkCrab\BladeOne\Tests\Fixtures\Mock_Custom_Blade_One_Instance::class, $rules[\pc_stock_man_v1\PinkCrab\BladeOne\BladeOne_Provider::class]['substitutions'][\pc_stock_man_v1\PinkCrab\BladeOne\PinkCrab_BladeOne::class]);
    }
    /** @testdox It should be possible to use a custom wrapper for PinkCrab BladeOne as an instance, this allows for setting of custom traits for Components etc. */
    public function test_can_use_custom_blade_one_wrapper_as_instance() : void
    {
        // Clear existing filters from previous tests.
        \remove_all_filters(\pc_stock_man_v1\PinkCrab\Perique\Application\Hooks::APP_INIT_SET_DI_RULES);
        // Configure with a custom Blade Implementation as instance.
        \pc_stock_man_v1\PinkCrab\BladeOne\BladeOne_Bootstrap::use(__DIR__, __DIR__, \pc_stock_man_v1\eftec\bladeone\BladeOne::MODE_DEBUG, new \pc_stock_man_v1\PinkCrab\BladeOne\Tests\Fixtures\Mock_Custom_Blade_One_Instance());
        $rules = \apply_filters(\pc_stock_man_v1\PinkCrab\Perique\Application\Hooks::APP_INIT_SET_DI_RULES, array());
        $this->assertInstanceOf(\pc_stock_man_v1\PinkCrab\BladeOne\Tests\Fixtures\Mock_Custom_Blade_One_Instance::class, $rules[\pc_stock_man_v1\PinkCrab\BladeOne\BladeOne_Provider::class]['substitutions'][\pc_stock_man_v1\PinkCrab\BladeOne\PinkCrab_BladeOne::class]);
    }
}

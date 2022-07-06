<?php

declare (strict_types=1);
/**
 * Implementation of BladeOne for the PinkCrab Perique frameworks Renderable interface
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @package PinkCrab\BladeOne_Provider
 */
namespace pc_stock_man_v1\PinkCrab\BladeOne;

use pc_stock_man_v1\Dice\Dice;
use pc_stock_man_v1\eftec\bladeone\BladeOne;
use pc_stock_man_v1\PinkCrab\Perique\Application\Hooks;
use pc_stock_man_v1\PinkCrab\BladeOne\BladeOne_Provider;
use pc_stock_man_v1\PinkCrab\BladeOne\PinkCrab_BladeOne;
use pc_stock_man_v1\PinkCrab\Perique\Interfaces\Renderable;
use pc_stock_man_v1\PinkCrab\Perique\Services\View\PHP_Engine;
use pc_stock_man_v1\PinkCrab\BladeOne\Abstract_BladeOne_Config;
class BladeOne_Bootstrap
{
    /**
     * Sets the rules for bladeone and unsets the default PHP_Engine for rendering
     *
     * @param string $template_path
     * @param string|null $compiled_path
     * @param int $mode
     * @param class-string|BladeOne $blade
     * @return void
     */
    public static function use($template_path = null, ?string $compiled_path = null, int $mode = 0, $blade = null)
    {
        add_filter(\pc_stock_man_v1\PinkCrab\Perique\Application\Hooks::APP_INIT_SET_DI_RULES, function ($rules) use($template_path, $compiled_path, $mode, $blade) {
            // Unset the global PHP_Engine useage.
            if (\array_key_exists('*', $rules) && \array_key_exists('substitutions', $rules['*']) && \array_key_exists(\pc_stock_man_v1\PinkCrab\Perique\Interfaces\Renderable::class, $rules['*']['substitutions']) && \is_a($rules['*']['substitutions'][\pc_stock_man_v1\PinkCrab\Perique\Interfaces\Renderable::class], \pc_stock_man_v1\PinkCrab\Perique\Services\View\PHP_Engine::class)) {
                unset($rules['*']['substitutions'][\pc_stock_man_v1\PinkCrab\Perique\Interfaces\Renderable::class]);
            }
            // Get the version of Blade to start.
            $blade = self::get_blade_instance($blade);
            $rules[\pc_stock_man_v1\PinkCrab\BladeOne\BladeOne_Provider::class] = array('substitutions' => array(\pc_stock_man_v1\PinkCrab\BladeOne\PinkCrab_BladeOne::class => new $blade($template_path, $compiled_path, $mode)), 'call' => array(array('allow_pipe', array())));
            $rules[\pc_stock_man_v1\PinkCrab\Perique\Interfaces\Renderable::class] = array('instanceOf' => \pc_stock_man_v1\PinkCrab\BladeOne\BladeOne_Provider::class, 'shared' => \true);
            $rules[\pc_stock_man_v1\PinkCrab\BladeOne\Abstract_BladeOne_Config::class] = array('call' => array(array('set_renderable', array(array(\pc_stock_man_v1\Dice\Dice::INSTANCE => \pc_stock_man_v1\PinkCrab\Perique\Interfaces\Renderable::class)))));
            return $rules;
        });
    }
    /**
     * Gets the class used for bladeone instance
     *
     * @param mixed $blade
     * @return class-string
     */
    protected static function get_blade_instance($blade) : string
    {
        // If we have a populated instance of BladeOne, get the full class name.
        if (\is_object($blade) && \is_a($blade, \pc_stock_man_v1\PinkCrab\BladeOne\PinkCrab_BladeOne::class)) {
            $blade = \get_class($blade);
        }
        if (\is_string($blade) && \is_a($blade, \pc_stock_man_v1\PinkCrab\BladeOne\PinkCrab_BladeOne::class, \true)) {
            return $blade;
        }
        return \pc_stock_man_v1\PinkCrab\BladeOne\PinkCrab_BladeOne::class;
    }
}

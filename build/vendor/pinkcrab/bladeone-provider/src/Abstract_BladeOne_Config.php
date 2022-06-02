<?php

declare (strict_types=1);
/**
 * Abstract class for configuring BladeOne
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
namespace PC_Woo_Stock_Man\PinkCrab\BladeOne;

use PC_Woo_Stock_Man\PinkCrab\Perique\Interfaces\Hookable;
use PC_Woo_Stock_Man\eftec\bladeone\BladeOne;
use PC_Woo_Stock_Man\PinkCrab\BladeOne\BladeOne_Provider;
use PC_Woo_Stock_Man\PinkCrab\Perique\Interfaces\Renderable;
use PC_Woo_Stock_Man\PinkCrab\Loader\Hook_Loader;
abstract class Abstract_BladeOne_Config implements \PC_Woo_Stock_Man\PinkCrab\Perique\Interfaces\Hookable
{
    /**
     * The current view model.
     *
     * @var BladeOne_Provider|null
     */
    protected $renderable;
    public final function register(\PC_Woo_Stock_Man\PinkCrab\Loader\Hook_Loader $loader) : void
    {
        $loader->action('wp_loaded', array($this, 'configure_blade_handler'), 10, 2);
    }
    /**
     * Sets renderable from DI when constructing.
     *
     * @param BladeOne_Provider $renderable
     * @return void
     */
    public function set_renderable(\PC_Woo_Stock_Man\PinkCrab\BladeOne\BladeOne_Provider $renderable) : void
    {
        $this->renderable = $renderable;
    }
    /**
     * Will call the config class, if using BladeOne.
     *
     * @return void
     */
    public final function configure_blade_handler() : void
    {
        if (!\is_null($this->renderable) && \is_a($this->renderable, \PC_Woo_Stock_Man\PinkCrab\BladeOne\BladeOne_Provider::class)) {
            $this->config($this->renderable);
        }
    }
    /**
     * Method to extend from to configure bladeone
     *
     * @param BladeOne_Provider $bladeone
     * @return void
     */
    public abstract function config(\PC_Woo_Stock_Man\PinkCrab\BladeOne\BladeOne_Provider $bladeone) : void;
}

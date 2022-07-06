<?php

declare (strict_types=1);
/**
 * Factory for creating Dispatchers
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
 * @package PinkCrab\Registerables
 */
namespace pc_stock_man_v1\PinkCrab\Registerables\Registrar;

use Exception;
use pc_stock_man_v1\PinkCrab\Loader\Hook_Loader;
use pc_stock_man_v1\PinkCrab\Registerables\Taxonomy;
use pc_stock_man_v1\PinkCrab\Registerables\Post_Type;
use pc_stock_man_v1\PinkCrab\Perique\Interfaces\DI_Container;
use pc_stock_man_v1\PinkCrab\Registerables\Registrar\Taxonomy_Registrar;
use pc_stock_man_v1\PinkCrab\Registerables\Validator\Meta_Box_Validator;
use pc_stock_man_v1\PinkCrab\Registerables\Validator\Taxonomy_Validator;
use pc_stock_man_v1\PinkCrab\Registerables\Registrar\Post_Type_Registrar;
use pc_stock_man_v1\PinkCrab\Registerables\Validator\Post_Type_Validator;
use pc_stock_man_v1\PinkCrab\Registerables\Registration_Middleware\Registerable;
class Registrar_Factory
{
    /**
     * Returns an instance of the factory.
     *
     * @return self
     */
    public static function new() : self
    {
        return new self();
    }
    /**
     * Creates the dispatcher based on the registerable passed.
     *
     * @param \PinkCrab\Registerables\Registration_Middleware\Registerable $registerable
     * @return Registrar
     * @throws Exception If not valid registerable type passed.
     */
    public function create_from_registerable(\pc_stock_man_v1\PinkCrab\Registerables\Registration_Middleware\Registerable $registerable) : \pc_stock_man_v1\PinkCrab\Registerables\Registrar\Registrar
    {
        switch (\true) {
            case \is_a($registerable, \pc_stock_man_v1\PinkCrab\Registerables\Post_Type::class):
                return new \pc_stock_man_v1\PinkCrab\Registerables\Registrar\Post_Type_Registrar(new \pc_stock_man_v1\PinkCrab\Registerables\Validator\Post_Type_Validator(), new \pc_stock_man_v1\PinkCrab\Registerables\Registrar\Meta_Data_Registrar());
            case \is_a($registerable, \pc_stock_man_v1\PinkCrab\Registerables\Taxonomy::class):
                return new \pc_stock_man_v1\PinkCrab\Registerables\Registrar\Taxonomy_Registrar(new \pc_stock_man_v1\PinkCrab\Registerables\Validator\Taxonomy_Validator(), new \pc_stock_man_v1\PinkCrab\Registerables\Registrar\Meta_Data_Registrar());
            default:
                $type = \get_class($registerable);
                throw new \Exception('Invalid registerable (' . $type . ')type (no dispatcher exists)');
        }
    }
    /**
     * Returns an instance of the meta box registrar.
     *
     * @param \PinkCrab\Perique\Interfaces\DI_Container $container
     * @param \PinkCrab\Loader\Hook_Loader $loader
     * @return Meta_Box_Registrar
     */
    public function meta_box_registrar(\pc_stock_man_v1\PinkCrab\Perique\Interfaces\DI_Container $container, \pc_stock_man_v1\PinkCrab\Loader\Hook_Loader $loader) : \pc_stock_man_v1\PinkCrab\Registerables\Registrar\Meta_Box_Registrar
    {
        return new \pc_stock_man_v1\PinkCrab\Registerables\Registrar\Meta_Box_Registrar(new \pc_stock_man_v1\PinkCrab\Registerables\Validator\Meta_Box_Validator(), $container, $loader);
    }
    /**
     * Returns and instance of the Meta Data registrar.
     *
     * @return Meta_Data_Registrar
     */
    public function meta_data_registrar() : \pc_stock_man_v1\PinkCrab\Registerables\Registrar\Meta_Data_Registrar
    {
        return new \pc_stock_man_v1\PinkCrab\Registerables\Registrar\Meta_Data_Registrar();
    }
}

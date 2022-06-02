<?php

declare (strict_types=1);
/**
 * Helper class for working with Ajax models
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
 * @package PinkCrab\Ajax
 */
namespace PC_Woo_Stock_Man\PinkCrab\Ajax;

use PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax;
use PC_Woo_Stock_Man\Psr\Http\Message\ServerRequestInterface;
use PC_Woo_Stock_Man\PinkCrab\Nonce\Nonce;
use PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax_Exception;
use ReflectionClass;
class Ajax_Helper
{
    /**
     * Cache of all reflected ajax class, constructed.
     *
     * @var array<string,Ajax>
     */
    private static $class_cache = array();
    /**
     * Returns the admin ajax url.
     *
     * @return string
     */
    public static function admin_ajax_url() : string
    {
        return admin_url('admin-ajax.php');
    }
    /**
     * Returns the reflection of an Ajax instance.
     * Either from cache or created without constructor.
     *
     * @param string $class
     * @return Ajax
     * @throws Ajax_Exception (code 100) If non valid Ajax class passed.
     */
    private static function get_reflected(string $class) : \PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax
    {
        if (!\is_subclass_of($class, \PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax::class)) {
            throw \PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax_Exception::non_ajax_model('get reflection');
        }
        if (!\array_key_exists($class, self::$class_cache)) {
            $reflection = new \ReflectionClass($class);
            self::$class_cache[$class] = $reflection->newInstanceWithoutConstructor();
        }
        return self::$class_cache[$class];
    }
    /**
     * Gets the action from an Ajax class
     * uses reflection to create instance without using the constructor.
     *
     * @param string $class
     * @return string|null
     * @throws Ajax_Exception (code 100) If non valid Ajax class passed.
     * @throws Ajax_Exception (code 101) If no action defined
     */
    public static function get_action(string $class) : ?string
    {
        $instance = self::get_reflected($class);
        if (!$instance->has_valid_action()) {
            throw \PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax_Exception::undefined_action($class);
        }
        return $instance->get_action();
    }
    /**
     * Returns if the passed ajax class  has a nonce
     *
     * @param string $class
     * @return boolean
     * @throws Ajax_Exception (code 100) If non valid Ajax class passed.
     */
    public static function has_nonce(string $class) : bool
    {
        return self::get_reflected($class)->has_nonce();
    }
    /**
     * Returns a Nonce object if the passed class has a non handle defined.
     *
     * @param string $class
     * @return Nonce|null
     * @throws Ajax_Exception (code 100) If non valid Ajax class passed.
     */
    public static function get_nonce(string $class) : ?\PC_Woo_Stock_Man\PinkCrab\Nonce\Nonce
    {
        $instance = self::get_reflected($class);
        return $instance->has_nonce() ? new \PC_Woo_Stock_Man\PinkCrab\Nonce\Nonce($instance->get_nonce_handle() ?? '') : null;
    }
    /**
     * Return the defined nonce field from the Ajax class passed
     *
     * @param string $class
     * @return string
     * @throws Ajax_Exception (code 100) If non valid Ajax class passed.
     */
    public static function get_nonce_field(string $class) : string
    {
        return self::get_reflected($class)->get_nonce_field();
    }
    /**
     * Extracts the args from the server request.
     * Based on request type GET/POST
     *
     * @param ServerRequestInterface $request
     * @return array<string, string>
     */
    public static function extract_server_request_args(\PC_Woo_Stock_Man\Psr\Http\Message\ServerRequestInterface $request) : array
    {
        switch ($request->getMethod()) {
            case 'POST':
                // Return different post types.
                if (\str_contains($request->getHeaderLine('Content-Type'), 'application/x-www-form-urlencoded;')) {
                    $params = (array) $request->getParsedBody();
                } else {
                    $params = \json_decode((string) $request->getBody(), \true) ?? array();
                }
                break;
            case 'GET':
                $params = $request->getQueryParams();
                break;
            default:
                $params = array();
                break;
        }
        return $params;
    }
}

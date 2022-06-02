<?php

declare (strict_types=1);
/**
 * Custom exceptions for the Ajax module.
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

use Exception;
class Ajax_Exception extends \Exception
{
    /**
     * Class is not an Ajax::class
     * @code 100
     * @param string $operation The operation being carries out.
     * @return Ajax_Exception
     */
    public static function non_ajax_model(string $operation = 'unknown operation') : \PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax_Exception
    {
        $message = 'None Ajax Model passed to ' . $operation;
        return new \PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax_Exception($message, 100);
    }
    /**
     * Ajax::class has no defined action.
     * @code 101
     * @param string $class Ajax class
     * @return Ajax_Exception
     */
    public static function undefined_action(string $class) : \PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax_Exception
    {
        $message = "{$class} has no defined action property";
        return new \PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax_Exception($message, 101);
    }
}

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
namespace PC_Woo_Stock_Man\PinkCrab\BladeOne;

use ReflectionClass;
use BadMethodCallException;
use PC_Woo_Stock_Man\eftec\bladeone\BladeOne;
use PC_Woo_Stock_Man\eftec\bladeonehtml\BladeOneHtml;
use PC_Woo_Stock_Man\PinkCrab\BladeOne\PinkCrab_BladeOne;
use PC_Woo_Stock_Man\PinkCrab\Perique\Interfaces\Renderable;
class BladeOne_Provider implements \PC_Woo_Stock_Man\PinkCrab\Perique\Interfaces\Renderable
{
    /**
     * BladeOne Instance
     *
     * @var BladeOne
     */
    protected static $blade;
    /**
     * Creates an instance with blade one.
     *
     * @param PinkCrab_BladeOne $blade
     */
    public final function __construct(\PC_Woo_Stock_Man\PinkCrab\BladeOne\PinkCrab_BladeOne $blade)
    {
        static::$blade = $blade;
    }
    /**
     * Static constructor with BladeOne initalsation details
     *
     * @param string|array<mixed> $template_path If null then it uses (caller_folder)/views
     * @param string $compiled_path If null then it uses (caller_folder)/compiles
     * @param int $mode =[BladeOne::MODE_AUTO,BladeOne::MODE_DEBUG,BladeOne::MODE_FAST,BladeOne::MODE_SLOW][$i]
     * @return self
     */
    public static function init($template_path = null, ?string $compiled_path = null, int $mode = 0) : self
    {
        return new static(new \PC_Woo_Stock_Man\PinkCrab\BladeOne\PinkCrab_BladeOne($template_path, $compiled_path, $mode));
    }
    /**
     * Returns the current BladeOne instance.
     *
     * @return BladeOne
     */
    public function get_blade() : \PC_Woo_Stock_Man\eftec\bladeone\BladeOne
    {
        return static::$blade;
    }
    /**
     * Display a view and its context.
     *
     * @param string $view
     * @param iterable<string, mixed> $data
     * @param bool $print
     * @return void|string
     */
    public function render(string $view, iterable $data, bool $print = \true)
    {
        if ($print) {
            print static::$blade->run($view, (array) $data);
            // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        } else {
            return static::$blade->run($view, (array) $data);
        }
    }
    /**
     * magic instanced method caller.
     *
     * @param string $method
     * @param array<mixed> $args
     * @return mixed
     * @throws BadMethodCallException
     */
    public function __call(string $method, array $args = array())
    {
        if (!$this->is_method($method)) {
            throw new \BadMethodCallException("{$method} is not a valid method on the BladeOne instance.");
        }
        return static::$blade->{$method}(...$args);
    }
    /**
     * Magic static method caller.
     *
     * @param string $method
     * @param array<mixed> $args
     * @return mixed
     * @throws BadMethodCallException
     */
    public static function __callStatic(string $method, array $args = array())
    {
        if (!static::is_static_method($method)) {
            throw new \BadMethodCallException("{$method} is not a valid method on the BladeOne instance.");
        }
        return static::$blade::$method(...$args);
    }
    /**
     * Checks if the passed method exists, is public and isnt static.
     *
     * @param string $method
     * @return bool
     */
    protected function is_method(string $method) : bool
    {
        $class_reflection = new \ReflectionClass(static::$blade);
        // Check method exists.
        if (!$class_reflection->hasMethod($method)) {
            return \false;
        }
        $method_reflection = $class_reflection->getMethod($method);
        return $method_reflection->isPublic() && !$method_reflection->isStatic();
    }
    /**
     * Checks if the passed method exists, is public and IS static.
     *
     * @param string $method
     * @return bool
     */
    protected static function is_static_method(string $method) : bool
    {
        $class_reflection = new \ReflectionClass(static::$blade);
        // Check method exists.
        if (!$class_reflection->hasMethod($method)) {
            return \false;
        }
        $method_reflection = $class_reflection->getMethod($method);
        return $method_reflection->isPublic() && $method_reflection->isStatic();
    }
    /**
     * Sets if piping is enabled in templates.
     *
     * @param bool $bool
     * @return self
     */
    public function allow_pipe(bool $bool = \true) : self
    {
        static::$blade->pipeEnable = $bool;
        //phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
        return $this;
    }
    /**
     * Register a handler for custom directives.
     *
     * @param string   $name
     * @param callable $handler
     * @return self
     */
    public function directive(string $name, callable $handler) : self
    {
        static::$blade->directive($name, $handler);
        return $this;
    }
    /**
     * Register a handler for custom directives for run at runtime
     *
     * @param string   $name
     * @param callable $handler
     * @return self
     */
    public function directive_rt($name, callable $handler) : self
    {
        static::$blade->directiveRT($name, $handler);
        return $this;
    }
    /**
     * Define a template alias
     *
     * @param string      $view  example "folder.template"
     * @param string|null $alias example "mynewop". If null then it uses the name of the template.
     * @return self
     */
    public function add_include($view, $alias = null) : self
    {
        static::$blade->addInclude($view, $alias);
        return $this;
    }
    /**
     * Define a class with a namespace
     *
     * @param string $alias_name
     * @param string $class_with_namespace
     * @return self
     */
    public function add_alias_classes($alias_name, $class_with_namespace) : self
    {
        static::$blade->addAliasClasses($alias_name, $class_with_namespace);
        return $this;
    }
    /**
     * Set the compile mode
     *
     * @param int $mode BladeOne::MODE_AUTO, BladeOne::MODE_DEBUG, BladeOne::MODE_FAST, BladeOne::MODE_SLOW
     * @return self
     */
    public function set_mode(int $mode) : self
    {
        static::$blade->setMode($mode);
        return $this;
    }
    /**
     * Adds a global variable. If <b>$var_name</b> is an array then it merges all the values.
     * <b>Example:</b>
     * <pre>
     * $this->share('variable',10.5);
     * $this->share('variable2','hello');
     * // or we could add the two variables as:
     * $this->share(['variable'=>10.5,'variable2'=>'hello']);
     * </pre>
     *
     * @param string|array<string, mixed> $var_name It is the name of the variable or it is an associative array
     * @param mixed        $value
     * @return $this
     */
    public function share($var_name, $value = null) : self
    {
        static::$blade->share($var_name, $value);
        return $this;
    }
    /**
     * Sets the function used for resolving classes with inject.
     *
     * @param callable $function
     * @return $this
     */
    public function set_inject_resolver(callable $function) : self
    {
        static::$blade->setInjectResolver($function);
        return $this;
    }
    /**
     * Set the file extension for the template files.
     * It must includes the leading dot e.g. .blade.php
     *
     * @param string $file_extension Example: .prefix.ext
     * @return $this
     */
    public function set_file_extension(string $file_extension) : self
    {
        static::$blade->setFileExtension($file_extension);
        return $this;
    }
    /**
     * Set the file extension for the compiled files.
     * Including the leading dot for the extension is required, e.g. .bladec
     *
     * @param string $file_extension
     * @return $this
     */
    public function set_compiled_extension(string $file_extension) : self
    {
        static::$blade->setCompiledExtension($file_extension);
        return $this;
    }
}

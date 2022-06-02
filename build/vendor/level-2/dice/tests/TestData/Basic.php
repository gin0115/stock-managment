<?php

namespace PC_Woo_Stock_Man;

/* @description Dice - A minimal Dependency Injection Container for PHP *
 * @author Tom Butler tom@r.je *
 * @copyright 2012-2018 Tom Butler <tom@r.je> | https:// r.je/dice.html *
 * @license http:// www.opensource.org/licenses/bsd-license.php BSD License *
 * @version 3.0 */
class NoConstructor
{
    public $a = 'b';
}
/* @description Dice - A minimal Dependency Injection Container for PHP *
 * @author Tom Butler tom@r.je *
 * @copyright 2012-2018 Tom Butler <tom@r.je> | https:// r.je/dice.html *
 * @license http:// www.opensource.org/licenses/bsd-license.php BSD License *
 * @version 3.0 */
\class_alias('PC_Woo_Stock_Man\\NoConstructor', 'NoConstructor', \false);
class CyclicA
{
    public $b;
    public function __construct(\PC_Woo_Stock_Man\CyclicB $b)
    {
        $this->b = $b;
    }
}
\class_alias('PC_Woo_Stock_Man\\CyclicA', 'CyclicA', \false);
class CyclicB
{
    public $a;
    public function __construct(\PC_Woo_Stock_Man\CyclicA $a)
    {
        $this->a = $a;
    }
}
\class_alias('PC_Woo_Stock_Man\\CyclicB', 'CyclicB', \false);
class A
{
    public $b;
    public function __construct(\PC_Woo_Stock_Man\B $b)
    {
        $this->b = $b;
    }
}
\class_alias('PC_Woo_Stock_Man\\A', 'A', \false);
class B
{
    public $c;
    public function __construct(\PC_Woo_Stock_Man\C $c)
    {
        $this->c = $c;
    }
}
\class_alias('PC_Woo_Stock_Man\\B', 'B', \false);
class ExtendedB extends \PC_Woo_Stock_Man\B
{
}
\class_alias('PC_Woo_Stock_Man\\ExtendedB', 'ExtendedB', \false);
class C
{
    public $d;
    public $e;
    public function __construct(\PC_Woo_Stock_Man\D $d, \PC_Woo_Stock_Man\E $e)
    {
        $this->d = $d;
        $this->e = $e;
    }
}
\class_alias('PC_Woo_Stock_Man\\C', 'C', \false);
class D
{
}
\class_alias('PC_Woo_Stock_Man\\D', 'D', \false);
class E
{
    public $f;
    public function __construct(\PC_Woo_Stock_Man\F $f)
    {
        $this->f = $f;
    }
}
\class_alias('PC_Woo_Stock_Man\\E', 'E', \false);
class F
{
}
\class_alias('PC_Woo_Stock_Man\\F', 'F', \false);
class RequiresConstructorArgsA
{
    public $foo;
    public $bar;
    public function __construct($foo, $bar)
    {
        $this->foo = $foo;
        $this->bar = $bar;
    }
}
\class_alias('PC_Woo_Stock_Man\\RequiresConstructorArgsA', 'RequiresConstructorArgsA', \false);
class MyObj
{
    private $foo;
    public function setFoo($foo)
    {
        $this->foo = $foo;
    }
    public function getFoo()
    {
        return $this->foo;
    }
}
\class_alias('PC_Woo_Stock_Man\\MyObj', 'MyObj', \false);
class MethodWithDefaultValue
{
    public $a;
    public $foo;
    public function __construct(\PC_Woo_Stock_Man\A $a, $foo = 'bar')
    {
        $this->a = $a;
        $this->foo = $foo;
    }
}
\class_alias('PC_Woo_Stock_Man\\MethodWithDefaultValue', 'MethodWithDefaultValue', \false);
class MethodWithDefaultNull
{
    public $a;
    public $b;
    public function __construct(\PC_Woo_Stock_Man\A $a, \PC_Woo_Stock_Man\B $b = null)
    {
        $this->a = $a;
        $this->b = $b;
    }
}
\class_alias('PC_Woo_Stock_Man\\MethodWithDefaultNull', 'MethodWithDefaultNull', \false);
interface interfaceTest
{
}
\class_alias('PC_Woo_Stock_Man\\interfaceTest', 'interfaceTest', \false);
class InterfaceTestClass implements \PC_Woo_Stock_Man\interfaceTest
{
}
\class_alias('PC_Woo_Stock_Man\\InterfaceTestClass', 'InterfaceTestClass', \false);
class ParentClass
{
}
\class_alias('PC_Woo_Stock_Man\\ParentClass', 'ParentClass', \false);
class Child extends \PC_Woo_Stock_Man\ParentClass
{
}
\class_alias('PC_Woo_Stock_Man\\Child', 'Child', \false);
class OptionalInterface
{
    public $obj;
    public function __construct(\PC_Woo_Stock_Man\InterfaceTest $obj = null)
    {
        $this->obj = $obj;
    }
}
\class_alias('PC_Woo_Stock_Man\\OptionalInterface', 'OptionalInterface', \false);
class ScalarTypeHint
{
    public function __construct(string $a = null)
    {
    }
}
\class_alias('PC_Woo_Stock_Man\\ScalarTypeHint', 'ScalarTypeHint', \false);
class CheckConstructorArgs
{
    public $arg1;
    public function __construct($arg1)
    {
        $this->arg1 = $arg1;
    }
}
\class_alias('PC_Woo_Stock_Man\\CheckConstructorArgs', 'CheckConstructorArgs', \false);
class someclass
{
}
\class_alias('PC_Woo_Stock_Man\\someclass', 'someclass', \false);
class someotherclass
{
    public $obj;
    public function __construct(\PC_Woo_Stock_Man\someclass $obj)
    {
        $this->obj = $obj;
    }
}
\class_alias('PC_Woo_Stock_Man\\someotherclass', 'someotherclass', \false);

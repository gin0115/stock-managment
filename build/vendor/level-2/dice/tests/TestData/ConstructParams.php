<?php

namespace PC_Woo_Stock_Man;

/* @description Dice - A minimal Dependency Injection Container for PHP *
 * @author Tom Butler tom@r.je *
 * @copyright 2012-2018 Tom Butler <tom@r.je> | https:// r.je/dice.html *
 * @license http:// www.opensource.org/licenses/bsd-license.php BSD License *
 * @version 3.0 */
class MyDirectoryIterator extends \DirectoryIterator
{
}
/* @description Dice - A minimal Dependency Injection Container for PHP *
 * @author Tom Butler tom@r.je *
 * @copyright 2012-2018 Tom Butler <tom@r.je> | https:// r.je/dice.html *
 * @license http:// www.opensource.org/licenses/bsd-license.php BSD License *
 * @version 3.0 */
\class_alias('PC_Woo_Stock_Man\\MyDirectoryIterator', 'MyDirectoryIterator', \false);
class MyDirectoryIterator2 extends \DirectoryIterator
{
    public function __construct($f)
    {
        parent::__construct($f);
    }
}
\class_alias('PC_Woo_Stock_Man\\MyDirectoryIterator2', 'MyDirectoryIterator2', \false);
class ParamRequiresArgs
{
    public $a;
    public function __construct(\PC_Woo_Stock_Man\D $d, \PC_Woo_Stock_Man\RequiresConstructorArgsA $a)
    {
        $this->a = $a;
    }
}
\class_alias('PC_Woo_Stock_Man\\ParamRequiresArgs', 'ParamRequiresArgs', \false);
class RequiresConstructorArgsB
{
    public $a;
    public $foo;
    public $bar;
    public function __construct(\PC_Woo_Stock_Man\A $a, $foo, $bar)
    {
        $this->a = $a;
        $this->foo = $foo;
        $this->bar = $bar;
    }
}
\class_alias('PC_Woo_Stock_Man\\RequiresConstructorArgsB', 'RequiresConstructorArgsB', \false);
trait MyTrait
{
    public function foo()
    {
    }
}
class MyDirectoryIteratorWithTrait extends \DirectoryIterator
{
    use MyTrait;
}
\class_alias('PC_Woo_Stock_Man\\MyDirectoryIteratorWithTrait', 'MyDirectoryIteratorWithTrait', \false);
class NullScalar
{
    public $string;
    public function __construct($string = null)
    {
        $this->string = $string;
    }
}
\class_alias('PC_Woo_Stock_Man\\NullScalar', 'NullScalar', \false);
class NullScalarNested
{
    public $nullScalar;
    public function __construct(\PC_Woo_Stock_Man\NullScalar $nullScalar)
    {
        $this->nullScalar = $nullScalar;
    }
}
\class_alias('PC_Woo_Stock_Man\\NullScalarNested', 'NullScalarNested', \false);
class NB
{
}
\class_alias('PC_Woo_Stock_Man\\NB', 'NB', \false);
class NC
{
}
\class_alias('PC_Woo_Stock_Man\\NC', 'NC', \false);
class MethodWithTwoDefaultNullC
{
    public $a;
    public $b;
    public function __construct($a = null, \PC_Woo_Stock_Man\NB $b = null)
    {
        $this->a = $a;
        $this->b = $b;
    }
}
\class_alias('PC_Woo_Stock_Man\\MethodWithTwoDefaultNullC', 'MethodWithTwoDefaultNullC', \false);
class MethodWithTwoDefaultNullCC
{
    public $a;
    public $b;
    public $c;
    public function __construct($a = null, \PC_Woo_Stock_Man\NB $b = null, \PC_Woo_Stock_Man\NC $c = null)
    {
        $this->a = $a;
        $this->b = $b;
        $this->c = $c;
    }
}
\class_alias('PC_Woo_Stock_Man\\MethodWithTwoDefaultNullCC', 'MethodWithTwoDefaultNullCC', \false);
class NullableClassTypeHint
{
    public $obj;
    public function __construct(?\PC_Woo_Stock_Man\D $obj)
    {
        $this->obj = $obj;
    }
}
\class_alias('PC_Woo_Stock_Man\\NullableClassTypeHint', 'NullableClassTypeHint', \false);

<?php

/* @description Dice - A minimal Dependency Injection Container for PHP *
 * @author Tom Butler tom@r.je *
 * @copyright 2012-2018 Tom Butler <tom@r.je> | https:// r.je/dice.html *
 * @license http:// www.opensource.org/licenses/bsd-license.php BSD License *
 * @version 3.0 */
namespace PC_Woo_Stock_Man\Foo;

class A
{
}
class B
{
    public $a;
    public function __construct(\PC_Woo_Stock_Man\Foo\A $a)
    {
        $this->a = $a;
    }
}
class ExtendedA extends \PC_Woo_Stock_Man\Foo\A
{
}
class C
{
    public $a;
    public function __construct(\PC_Woo_Stock_Man\Bar\A $a)
    {
        $this->a = $a;
    }
}
namespace PC_Woo_Stock_Man\Bar;

class A
{
}
class B
{
}

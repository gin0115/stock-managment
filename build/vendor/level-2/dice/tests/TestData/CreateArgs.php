<?php

namespace PC_Woo_Stock_Man;

/* @description Dice - A minimal Dependency Injection Container for PHP *
 * @author Tom Butler tom@r.je *
 * @copyright 2012-2018 Tom Butler <tom@r.je> | https:// r.je/dice.html *
 * @license http:// www.opensource.org/licenses/bsd-license.php BSD License *
 * @version 3.0 */
class ConsumeArgsTop
{
    public $s;
    public $a;
    public function __construct(\PC_Woo_Stock_Man\ConsumeArgsSub $a, $s)
    {
        $this->a = $a;
        $this->s = $s;
    }
}
/* @description Dice - A minimal Dependency Injection Container for PHP *
 * @author Tom Butler tom@r.je *
 * @copyright 2012-2018 Tom Butler <tom@r.je> | https:// r.je/dice.html *
 * @license http:// www.opensource.org/licenses/bsd-license.php BSD License *
 * @version 3.0 */
\class_alias('PC_Woo_Stock_Man\\ConsumeArgsTop', 'ConsumeArgsTop', \false);
class ConsumeArgsSub
{
    public $s;
    public function __construct($s)
    {
        $this->s = $s;
    }
}
\class_alias('PC_Woo_Stock_Man\\ConsumeArgsSub', 'ConsumeArgsSub', \false);
class A2
{
    public $b;
    public $c;
    public $foo;
    public function __construct(\PC_Woo_Stock_Man\B $b, \PC_Woo_Stock_Man\C $c, $foo)
    {
        $this->b = $b;
        $this->foo = $foo;
        $this->c = $c;
    }
}
\class_alias('PC_Woo_Stock_Man\\A2', 'A2', \false);
class A3
{
    public $b;
    public $c;
    public $foo;
    public function __construct(\PC_Woo_Stock_Man\C $c, $foo, \PC_Woo_Stock_Man\B $b)
    {
        $this->b = $b;
        $this->foo = $foo;
        $this->c = $c;
    }
}
\class_alias('PC_Woo_Stock_Man\\A3', 'A3', \false);
class A4
{
    public $m1;
    public $m2;
    public function __construct(\PC_Woo_Stock_Man\M1 $m1, \PC_Woo_Stock_Man\M2 $m2)
    {
        $this->m1 = $m1;
        $this->m2 = $m2;
    }
}
\class_alias('PC_Woo_Stock_Man\\A4', 'A4', \false);
class BestMatch
{
    public $a;
    public $string;
    public $b;
    public function __construct($string, \PC_Woo_Stock_Man\A $a, \PC_Woo_Stock_Man\B $b)
    {
        $this->a = $a;
        $this->string = $string;
        $this->b = $b;
    }
}
\class_alias('PC_Woo_Stock_Man\\BestMatch', 'BestMatch', \false);
//From: https://github.com/TomBZombie/Dice/issues/62#issuecomment-112370319
class ScalarConstructors
{
    public $string;
    public $null;
    public function __construct($string, $null)
    {
        $this->string = $string;
        $this->null = $null;
    }
}
//From: https://github.com/TomBZombie/Dice/issues/62#issuecomment-112370319
\class_alias('PC_Woo_Stock_Man\\ScalarConstructors', 'ScalarConstructors', \false);

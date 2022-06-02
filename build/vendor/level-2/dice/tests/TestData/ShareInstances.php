<?php

namespace PC_Woo_Stock_Man;

/* @description Dice - A minimal Dependency Injection Container for PHP *
 * @author Tom Butler tom@r.je *
 * @copyright 2012-2018 Tom Butler <tom@r.je> | https:// r.je/dice.html *
 * @license http:// www.opensource.org/licenses/bsd-license.php BSD License *
 * @version 3.0 */
class TestSharedInstancesTop
{
    public $share1;
    public $share2;
    public function __construct(\PC_Woo_Stock_Man\SharedInstanceTest1 $share1, \PC_Woo_Stock_Man\SharedInstanceTest2 $share2)
    {
        $this->share1 = $share1;
        $this->share2 = $share2;
    }
}
/* @description Dice - A minimal Dependency Injection Container for PHP *
 * @author Tom Butler tom@r.je *
 * @copyright 2012-2018 Tom Butler <tom@r.je> | https:// r.je/dice.html *
 * @license http:// www.opensource.org/licenses/bsd-license.php BSD License *
 * @version 3.0 */
\class_alias('PC_Woo_Stock_Man\\TestSharedInstancesTop', 'TestSharedInstancesTop', \false);
class SharedInstanceTest1
{
    public $shared;
    public function __construct(\PC_Woo_Stock_Man\Shared $shared)
    {
        $this->shared = $shared;
    }
}
\class_alias('PC_Woo_Stock_Man\\SharedInstanceTest1', 'SharedInstanceTest1', \false);
class SharedInstanceTest2
{
    public $shared;
    public function __construct(\PC_Woo_Stock_Man\Shared $shared)
    {
        $this->shared = $shared;
    }
}
\class_alias('PC_Woo_Stock_Man\\SharedInstanceTest2', 'SharedInstanceTest2', \false);
class M1
{
    public $f;
    public function __construct(\PC_Woo_Stock_Man\F $f)
    {
        $this->f = $f;
    }
}
\class_alias('PC_Woo_Stock_Man\\M1', 'M1', \false);
class M2
{
    public $e;
    public function __construct(\PC_Woo_Stock_Man\E $e)
    {
        $this->e = $e;
    }
}
\class_alias('PC_Woo_Stock_Man\\M2', 'M2', \false);
class Foo77
{
    public $bar;
    public function __construct(\PC_Woo_Stock_Man\Bar77 $bar)
    {
        $this->bar = $bar;
    }
}
\class_alias('PC_Woo_Stock_Man\\Foo77', 'Foo77', \false);
class Bar77
{
    public $a;
    public function __construct($a)
    {
        $this->a = $a;
    }
}
\class_alias('PC_Woo_Stock_Man\\Bar77', 'Bar77', \false);
class Baz77
{
    public static function create()
    {
        return new \PC_Woo_Stock_Man\Bar77('Z');
    }
}
\class_alias('PC_Woo_Stock_Man\\Baz77', 'Baz77', \false);
class Shared
{
    public $uniq;
    public function __construct()
    {
        $this->uniq = \uniqid();
    }
}
\class_alias('PC_Woo_Stock_Man\\Shared', 'Shared', \false);

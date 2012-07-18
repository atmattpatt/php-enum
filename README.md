php-enum
========

php-enum is an attempt to replicate the Enum language structure found in many
other high-level languages such as C, Java, C#, and VisualBasic.  It is
somewhat inspired by [SplEnum](http://php.net/manual/en/class.splenum.php),
which is currently only available as part of the SPL\_Types PECL extension.

## Things to Consider
* An Enum is simply a PHP class with some constants defined.  That said, the
Enum class cannot limit the scope of its subclasses.  It is up to the developer
to make sure an Enum subtype only does things that a regular enumerated type
would do.
* The values of Enum constants must be manually assigned.  Again, it is up to
the developer to determine how values are assigned; this developer personally
recommends starting at 0 and counting up.
* Enum constants can only have scalar values.  After all, they are just PHP
constants.
* Enums can be instantiated.  This means that you can use Enums for typehinting
in your function definitions.
* The value of an Enum instance can be retrieved in one of three ways:

    $foo = new FooEnum(FooEnum::BAR);
    var_dump( $foo->getValue() ) // int(2)
    var_dump( $foo() )           // int(2)
    var_dump( (string)$foo )     // string(1) '2'

* Enums, being classes, can provide their own custom methods.  These methods
should be, in some way, related to the Enum itself.  (see first bullet)
* The methods in the Enum class are declared as final for a reason.  This class
is meant to simulate a language structure, and its children instances of that
structure.  If you really can't help yourself, feel free to fork this repo and
remove the final keyword.
* If you choose to implement some custom methods in your Enum child class, be
aware that you can only access the value of the Enum instance through the
getValue() method or by invoking the instance.

## A Working Example

    <?php
    
    class PlanetGravity extends Enum {
    
        /*
         * Planet gravity figures from
         * @link http://nssdc.gsfc.nasa.gov/planetary/factsheet/index.html
         */
        const MERCURY = 3.7;
        const VENUS   = 8.9;
        const EARTH   = 9.8;
        const MARS    = 3.7;
        const JUPITER = 23.1;
        const SATURN  = 9.0;
        const URANUS  = 8.7;
        const NEPTUNE = 11.0;
        const PLUTO   = 0.6; // still a planet to me
    
        /**
         * Get the weight of an object on another planet
         * @param float $earthWeight The object's weight on Earth
         * @return float
         */
        public function weightOnPlanet($earthWeight) {
            $mass = $earthWeight / PlanetGravity::EARTH;
            $accel = $this->getValue();
    
            return $mass * $accel;
        }
    }
    
    ?>

## See Also
* [PHP RFC on Enums](https://wiki.php.net/rfc/enum)

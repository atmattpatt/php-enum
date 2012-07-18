<?php
/**
 * Enum class
 * 
 * The Enum class is an attempt to create an Enum datatype in PHP similar to
 * many other high-level programming languages.  Of course, due to limitations
 * imposed by PHP, Enums in this sense are very primitive.
 * 
 * @version 1.0
 * @author Matthew Patterson <matthew.s.patterson@gmail.com>
 * @license http://www.gnu.org/copyleft/gpl.html GPL
 * @copyright 2012 Matthew Patterson
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

use \ReflectionClass;

/**
 * Enum class
 */
abstract class Enum {
    
    /**
     * The instance value
     * @var mixed
     */
    private $value = null;
    
    /**
     * Class constructor; checks that the given $const is valid for this Enum
     * @param mixed $const The constant value or, alternatively, the constant
     *      name to instantiate
     * @throws Exception if the constant is not defined
     */
    final public function __construct($const) {
        $this->value = static::valid($const);
    }
    
    /**
     * Shorthand alias for Enum::getValue()
     * @return mixed
     */
    final public function __invoke() {
        return $this->getValue();
    }
    
    /**
     * Alias for Enum::getValue(), guaranteed to return a string
     * @return string
     */
    final public function __toString() {
        return strval($this->getValue());
    }
    
    /**
     * Accessor for Enum::$value
     * @return mixed
     */
    final public function getValue() {
        return $this->value;
    }
    
    /**
     * Checks that $const is valid for this Enum
     * @param mixed $const The constant value or, alternatively, the constant
     *      name to validate
     * @return mixed The constant value
     * @throws Exception If the constant is not defined
     */
    final public static function valid($const) {
        $constants = static::getAll();
        
        // Check by value
        if (in_array($const, $constants)) {
            return $const;
        }
        
        // Check by name
        if (isset($constants[$const])) {
            return $constants[$const];
        }
        
        // Not valid
        throw new Exception('Invalid Enum constant ' . get_called_class() . '::' . $const);
    }
    
    /**
     * Gets all defined constants
     * @return array
     */
    final public static function getAll() {
        $rc = new ReflectionClass(get_called_class());
        return $rc->getConstants();
    }
    
}

?>

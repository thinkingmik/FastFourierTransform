<?php
/**
 * @author Michele Andreoli <michi.andreoli[at]gmail.com>
 * @name Complex.class.php
 * @version 0.3 updated 09-05-2010
 * @license http://opensource.org/licenses/gpl-license-php GNU Public License
 * @package FFT
 */

/**
 * Class that implements a complex data number
 */
class Complex {
	private $real;
	private $imag;
	
	/**
	 * Create a complex datatype
	 * @param double $real
	 * @param double $imag
	 */
	public function __construct($real, $imag) {
		$this->real = $real;
		$this->imag = $imag;
	}
	
	/**
	 * Return the multiplication of two complex number
	 * @param complex $a
	 * @param complex $b
	 * @return complex
	 */
	static public function Cmul($a, $b) {
		$c = new Complex(0, 0);
		
		$c->setReal($a->getReal() * $b->getReal() - $a->getImag() * $b->getImag());
		$c->setImag($a->getImag() * $b->getReal() + $a->getReal() * $b->getImag());
		
		return $c;
	}
	
	/**
	 * Return the sum of two complex number
	 * @param complex $a
	 * @param complex $b
	 * @return complex
	 */
	static public function Cadd($a, $b) {
		$c = new Complex(0, 0);
		
		$c->setReal($a->getReal() + $b->getReal());
		$c->setImag($a->getImag() + $b->getImag());
		
		return $c;
	}
	
	/**
	 * Return the difference of two complex number
	 * @param complex $a
	 * @param complex $b
	 * @return complex
	 */
	static public function Csub($a, $b) {
		$c = new Complex(0, 0);
        
		$c->setReal($a->getReal() - $b->getReal());
		$c->setImag($a->getImag() - $b->getImag());
        
        return $c;
	}
	
	/**
	 * Return the absolute value of a complex number
	 * @param complex $z
	 * @return double
	 */
	static public function Cabs($z) {
        $x = abs($z->getReal());
        $y = abs($z->getImag());
        
        if ($x == 0.0)
        	$ans = $y;
        else if ($y == 0.0)
        	$ans = $x;
        else if ($x > $y) {
        	$temp = $y / $x;
        	$ans = $x * sqrt(1.0 + $temp * $temp);
        } 
        else {
        	$temp = $x / $y;
            $ans = $y * sqrt(1.0 + $temp * $temp);
        }
        
        return $ans;
	}
	
	/**
	 * Return the radix of two complex number
	 * @param complex $z
	 * @return complex
	 */
	static public function Csqrt($z) {
		if (($z->getReal() == 0.0) && ($z->getImag() == 0.0)) {
			$c = new Complex(0, 0);        
			return $c;
		} 
        else {
        	$x = abs($z->getReal());
            $y = abs($z->getImag());
            
            if ($x >= $y) {
            	$r = $y / $x;
                $w = sqrt($x) * sqrt(0.5 * (1.0 + sqrt(1.0 + $r * $r)));
            }
            else {
            	$r = $x / $y;
                $w = sqrt($y) * sqrt(0.5 * ($r + sqrt(1.0 + $r * $r)));
            }
            
            $c = new Complex(0, 0);
            
            if ($z->getReal() >= 0.0) {
            	$c->setReal($w);
            	$c->setImag($z->getImag() / (2.0 * $w));
            } 
            else {
            	if ($z->getImag() >= 0)
            		$c->setImag($w);
            	else
            		$c->setImag(-$w);
            	$c->setReal($z->getReal() / (2.0 * $c->getImag()));
            }
            
            return $c;
        }
	}

	/**
	 * Return the inverse of a complex number
	 * @param complex $z
	 * @return complex
	 */
	static public function Cinv($z) {
		$c = new Complex(0, 0);
		
		$c->setReal($z->getReal());
		$c->setImag(-$z->getImag());
		
		return $c;
	}

	/**
	 * Return the multiplication of a complex number with a scalar value
	 * @param complex $n
	 * @param complex $z
	 * @return complex
	 */
	static public function RCmul($n, $z) {
		$c = new Complex(0, 0);
		
		$c->setReal($z->getReal() * $n);
		$c->setImag(-$z->getImag() * $n);
		
		return $c;
	}
	
	/**
	* Getters and setters
	*/
	public function setReal($real) {
		$this->real = $real;
	}
	
	public function setImag($imag) {
		$this->imag = $imag;
	}
	
	public function getReal() {
		return $this->real;
	}
	
	public function getImag() {
		return $this->imag;
	}
}
?>
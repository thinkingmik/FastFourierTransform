<?php
/**
 * @author Michele Andreoli <michi.andreoli[at]gmail.com>
 * @name FFT.class.php
 * @version 0.5 updated 06-07-2010
 * @license http://opensource.org/licenses/gpl-license-php GNU Public License
 * @package FFT
 */
require_once 'Complex.class.php';

/**
 * Class that calculate the FFT and the inverse FFT of a 1D signal
 */
class FFT {
	private $dim;
	private $p;
	private $ind;
	private $func;
	private $w1;
	private $w1i;
	private $w2;
	
	/**
	 * Constructor for FFT class
	 * @param int $dim dimension of the signal
	 */
	public function __construct($dim) {
		$this->dim = $dim;
		$this->p = log($this->dim, 2);
	}
	
	/**
	 * Calculate the FFT of a signal
	 * @param array<double> $func input signal
	 * @return array<complex> return the DFT for the signal in input
	 */
	public function fft($func) {
		$this->func = $func;
		
		for ($i = 0; $i < $this->dim; $i++)
			$this->w1[$i] = new Complex($func[$i], 0);
		
		$w[0] = new Complex(1, 0);
		$w[1] = new Complex(cos((-2 * M_PI) / $this->dim), sin((-2 * M_PI) / $this->dim));
			
		for ($i = 2; $i < $this->dim; $i++)
			$w[$i] = Complex::Cmul($w[$i-1], $w[1]);
		
		return $this->calculate($w);
	}
	
	/**
	 * Calculate the inverse FFT of a signal
	 * @param array<complex> $func input signal
	 * @return array<complex> result of inverse FFT for the signal in input
	 */
	public function ifft($func) {
		$this->func = $func;
		$norm = 1 / $this->dim;
		
		for ($i = 0; $i < $this->dim; $i++)
			$this->w1[$i] = new Complex($func[$i]->getReal(), $func[$i]->getImag());
		
		$w[0] = new Complex(1, 0);
		$w[1] = new Complex(cos((2 * M_PI) / $this->dim), sin((2 * M_PI) / $this->dim));
			
		for ($i = 2; $i < $this->dim; $i++)
			$w[$i] = Complex::Cmul($w[$i-1], $w[1]);	
			
		$this->w1i = $this->calculate($w);
		
		for ($i = 0; $i < $this->dim; $i++)
			$this->w1i[$i] = Complex::RCmul($norm, $this->w1i[$i]);
			
		return $this->w1i;
	}
	
	private function calculate($w) {
		$k = 1;
		$ind[0] = 0;
		
		for ($j = 0; $j < $this->p; $j++) {
			for ($i = 0; $i < $k; $i++) {
				$ind[$i] *= 2;
				$ind[$i+$k] = $ind[$i] + 1;
			}
			$k *= 2;
		}
		
		for ($i = 0; $i < $this->p; $i++) {
			$indw = 0;
			for ($j = 0; $j < pow(2, $i); $j++) {
				$inf = ($this->dim / pow(2, $i)) * $j;
				$sup = (($this->dim / pow(2, $i)) * ($j+1)) - 1;
				$comp = ($this->dim / pow(2, $i)) / 2;
				
				for ($k = $inf; $k <= floor($inf+(($sup-$inf)/2)); $k++)
					$this->w2[$k] = Complex::Cadd(Complex::Cmul($this->w1[$k], $w[0]), Complex::Cmul($this->w1[$k+$comp], $w[$ind[$indw]]));	
				
				$indw++;
				
				for ($k = floor($inf+(($sup-$inf)/2)+1); $k <= $sup; $k++)
					$this->w2[$k] = Complex::Cadd(Complex::Cmul($this->w1[$k], $w[$ind[$indw]]), Complex::Cmul($this->w1[$k-$comp], $w[0]));
				
				$indw++;
			}
			
			for($j = 0; $j < $this->dim; $j++)
	      		$this->w1[$j] = $this->w2[$j];
		}
		
		for ($i = 0; $i < $this->dim; $i++)
			$this->w1[$i] = $this->w2[$ind[$i]];
			
		return $this->w1;
	}
	
	/**
	 * Getter for the FFT
	 * @return array<complex> get the FFT of the signal
	 */
	public function getFFT() {
		return $this->w1;
	}
	
	/**
	 * Getter for the inverse FFT
	 * @return array<complex> get the inverse FFT of the signal
	 */
	public function getIFFT() {
		return $this->w1i;
	}
	
	/**
	 * Get the absolute value of the signal
	 * @param array<complex> $fft
	 * @return array<complex> get the absolute value of FFT
	 */
	public function getAbsFFT($w) {
		for ($i = 0; $i < $this->dim; $i++)
			$temp[$i] = Complex::Cabs($w[$i]);
			
		return $temp;
	}
	
	/**
	 * Getter for the dimension of the signal
	 * @return int return the dimension of the signal
	 */
	public function getDim() {
		return $this->dim;
	}
	
	/**
	 * Convert an array of double into an array of complex
	 * @param array<double> $func
	 * @return array<complex> return an array of complex
	 */
	public function doubleToComplex($func) {
		for ($i = 0; $i < count($func); $i++)
			$aux[$i] = new Complex($func[$i], 0);
			
		return $aux;
	}
	
	/**
	 * Convert an array of complex into an array of double
	 * @param array<complex> $func
	 * @return array<double> return an array of double
	 */
	public function complexToDouble($func) {
		for ($i = 0; $i < count($func); $i++)
			$aux[$i] = $func[$i]->getReal();
			
		return $aux;
	}
}
?>
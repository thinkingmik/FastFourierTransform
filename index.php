<?php
/**
 * @author Michele Andreoli <michi.andreoli[at]gmail.com>
 * @name index.php
 * @version 0.1 updated 07-05-2010
 * @license http://opensource.org/licenses/gpl-license-php GNU Public License
 * @package FFT
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Fast Fourier Transform, FFT</title>
    </head>
    <body>
    		<?php 
    			require_once 'FFT.class.php';
    			
    			// Define a generic function
    			$f = array();
    			for ($i = 0; $i < 256; $i++) {
					if (($i >= 0 && $i <= 8) || ($i >= 248 && $i <= 255))
				    	$f[$i] = 1;
					else
				    	$f[$i] = 0;
				}
    			
    			$fft = new FFT(256);
    			
    			// Calculate the FFT of the function $f
    			$w = $fft->fft($f);
    			
    			echo "<h1 style=\"font: bold 14px verdana;\">FFT: </h1>";
    			for ($i = 0; $i < $fft->getDim(); $i++)
    				echo "<p style=\"font: normal 10px verdana;\"><b>".$i."</b>  (".$w[$i]->getReal().", ".$w[$i]->getImag().")</p>";
    			
    			// Calculate the inverse FFT of the function $w
    			$w = $fft->ifft($w);
    			
    			echo "<br/><h1 style=\"font: bold 14px verdana;\">FFT inverse:</h1>";
    			for ($i = 0; $i < $fft->getDim(); $i++)
    				echo "<p style=\"font: normal 10px verdana;\"><b>".$i."</b>  (".$w[$i]->getReal().")</p>";		
    		?>
    </body>
</html>
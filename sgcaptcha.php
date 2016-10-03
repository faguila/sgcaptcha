<?php
// Simple geometric captcha for PHP
// Version 1. 2014-06-07.
// Author: Francisco del Aguila (http://www.alboran.net, faguila@alboran.net)
// Generate a captcha with geometric figures.
// Usage: <img src="path/captcha.php" alt="Captcha" />
// The captcha solution value is stored in $_SESSION['captcha']
// The key figure appears at right with no value.
// User must input digits inside the key figures. The result may be an empty string.
// License: MIT (see http://opensource.org/licenses/MIT)
// This information must remain in all copies of this software.
// Requires GD library enabled in PHP

class captcha {
    private $value = ''; // Stores the value that solves the captcha
    private $image = NULL; // The image container
    private $key = NULL; // The kind of the key element: 0->square, 1->circle, 2->triangle
    
    // Function getRamdomIntStr(digits). Returns a random integer as a string filled with ceros at left.
    private function getRandomIntStr($digits){
        list($usec, $sec) = explode(' ', microtime());
        mt_srand( (float)$sec + ((float)$usec * 100000) );
        $randomMin = str_pad('', $digits, '0');
        $randomMax = str_pad('', $digits, '9');
        $random = str_pad( (string)mt_rand($randomMin, $randomMax), $digits, '0', STR_PAD_LEFT );
        return $random;
    }
    
    private function drawSquare($position, $size, $color){
        imagefilledrectangle($this->image, $position+2, 0, $position+$size-2, $size, $color);
    }
    
    private function drawCircle($position, $size, $color){
        imagefilledellipse($this->image, $position+floor($size/2), floor($size/2), $size-2, $size-2, $color);
    }
    
    private function drawTriangle($position, $size, $color){
        $points = array($position+floor($size/2), 0, $position+$size-2, $size, $position+2, $size);
        imagefilledpolygon($this->image, $points, count($points)/2, $color);
    }
    
    private function drawBackground($position, $size, $color){
        imagerectangle($this->image, $position+2, 0, $position+$size-2, $size, $color);
        imageellipse($this->image, $position+floor($size/2), floor($size/2), $size-2, $size-2, $color);
        $points = array($position+floor($size/2), 0, $position+$size-2, $size, $position+2, $size);
        imagepolygon($this->image, $points, count($points)/2, $color);
    }
    
    // Shows the captcha image
    private function show(){
        header( "Content-type: image/png" );
        imagepng($this->image);
    }
    
    // Constructor. Creates a image of $number blocks of $size * $size pixels
    public function __construct($size, $number){
        $randomNumber = $this->getRandomIntStr($number);
        $this->image = imagecreate(($size * ($number + 1)) + 1, $size + 1);
        $background = imagecolorallocate($this->image, 255, 255, 255); // Set here the background rgb color
        $textcolor = imagecolorallocate($this->image, 0, 0, 0); // Set here the text rgb color
        $foreground = imagecolorallocate($this->image, 200, 200, 200); // Set here the elements rgb colour
        // Set the kind for the key
        $this->key = mt_rand(0, 2);
        // Generate elements
        $element = 0;
        while ($element < $number){
            $topLeftX = $element * $size; // top left X position of element
            // draw background 
            $this->drawBackground($topLeftX, $size, $foreground);
            // Set the kind for this element and draw it
            $kind = mt_rand(0, 2);
            switch($kind){
                case 0: $this->drawSquare($topLeftX, $size, $foreground); break;
                case 1: $this->drawCircle($topLeftX, $size, $foreground); break;        
                case 2: $this->drawTriangle($topLeftX, $size, $foreground); break;
            }
            // Write the value
            imagestring($this->image, 5, $topLeftX+floor($size/2)-4, floor($size/2)-7, $randomNumber[$element], $textcolor);
            if ($kind == $this->key) $this->value .= $randomNumber[$element]; // Add to captcha solution value
            $element++;
        }
        // Draw the key figure
        $topLeftX += $size;
        switch($this->key){
            case 0: $this->drawSquare($topLeftX, $size, $textcolor); break;
            case 1: $this->drawCircle($topLeftX, $size, $textcolor); break;        
            case 2: $this->drawTriangle($topLeftX, $size, $textcolor); break;
        }
        // Show captcha and set result in session
        @session_start();
        $_SESSION['captcha'] = $this->value; 
        $this->show();
    }
    
    public function __destruct(){
        imagedestroy($this->image);
    }
    
} // Class end

// Generate the captcha
$APP_captcha = new captcha(36, 12); // 12 characters in 36x36 pixels geometric figures
?>

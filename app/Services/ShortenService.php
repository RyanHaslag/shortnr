<?php

namespace App\Services;

class ShortenService
{
    private $baseCharacters;
    private $baseCount;

    public function __construct(){
        //Initialize the base set and base count variables to hold eligible characters and digits for determining the shortcode
        $this->baseCharacters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $this->baseCount = 62;
    }

    public function shorten($index): string {
        $shortCode = '';

        while($index > 0) {
            //Append the character corresponding to the result of the modulo, subtracting 1 to handle the first entry into the DB being at index "1" instead of "0"
            $shortCode = $this->baseCharacters[($index % $this->baseCount) - 1]  . $shortCode;

            //Determine if the index is less than 1 when interpreted as an integer to exit the loop with the full shortcode
            $index = (int)  ($index / $this->baseCount);
        }
        return $shortCode;
    }
}

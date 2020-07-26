<?php

class Price
{
    public static function priceAr($value)
    {
        return number_format( $value, 0, "","  ") . " Ar";
    }
}
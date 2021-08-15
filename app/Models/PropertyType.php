<?php

namespace App\Models;

use App\Traits\HasConstants;

abstract class PropertyType
{
    use HasConstants;

    const HOUSE = "HOUSE";
    const APARTMENT = "APARTMENT";
    const VILLA = "VILLA";
    const COMMERCIAL = "COMMERCIAL";
    const OFFICE = "OFFICE";
    const GARAGE = "GARAGE";
}//end abstract class PropertyType
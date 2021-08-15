<?php

namespace App\Models;

use App\Traits\HasConstants;

abstract class PropertyStatus
{
    use HasConstants;

    const RENT = "RENT";
    const SALE = "SALE";
}//end abstract class PropertySatus
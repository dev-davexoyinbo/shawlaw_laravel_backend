<?php

namespace App\Models;

use App\Traits\HasConstants;

abstract class PropertyFeature
{
    use HasConstants;
    const AIR_CONDITION = "Air Condition";
    const BEDDING = "Bedding";
    const HEATING = "Heating";
    const INTERNET = "Internet";
    const MICROWAVE = "Microwave";
    const SMOKING_ALLOWED = "Smoking Allowed";
    const TERRACE = "Terrace";
    const BALCONY = "Balcony";
    const ICON = "Icon";
    const WIFI = "Wi-Fi";
    const BEACH = "Beach";
    const PARKING = "Parking";
}//end class PropertyFeature
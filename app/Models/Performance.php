<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\FlareStrand;

class Performance extends Model
{

    protected $fillable = [
        'show_id',
        'start_datetime',
        'end_datetime',
        'venue',
        'screen',
        'availability_number',
        'availability',
        'sales_status',
        'pricing',
        'on_sale_date',
        'additional_info_url',
        'instance',
        'strand',
        'accessibility'
    ];

    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
        'strand' => FlareStrand::class
    ];

    public function isSoldOut()
    {
        if($this->availability === 'Sold out'){
            return true;
        }
        return false;
    }

}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use App\Models\Performance;

class Show extends Model
{
    protected $fillable = ['av_id', 'title', 'slug'];

    public function performances()
    {
        return $this->hasMany(Performance::Class)
            // ->where(function (Builder $query) {
            //     return $query->where('start_datetime', '>=', Carbon::now());
            // })
            ->orderBy('start_datetime', 'asc');
    }

    public function isSoldOut()
    {
        return $this->performances->every(function ($performance) {
            return $performance->isSoldOut();
        });
    }


}
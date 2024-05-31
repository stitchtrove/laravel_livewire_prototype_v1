<?php

use Illuminate\Support\Facades\Route;
use App\Services\AVDataService;
use App\Livewire\Performances;
use App\Models\Performance;
use App\Models\Work;
use App\Livewire\Shows;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/performances', Performances::class);
Route::get('/show/{id}', Shows::class);

Route::get('/api', function () {
    // Create an instance of AVDataService
    $avDataService = new App\Services\AVDataService();
    $performances = $avDataService->getFuturePerformances();
    dd($performances);
});

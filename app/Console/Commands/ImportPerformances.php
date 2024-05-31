<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use App\Services\AVDataService;
use App\Models\Show;
use App\Models\Performance;

class ImportPerformances extends Command
{

    protected $signature = 'import-performances';
    protected $description = 'Fetches content from Audience View and builds the basic programme structure.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(AVDataService $av)
    {
        $programme = $av->getFuturePerformances();

        foreach ($programme->groupBy('grouping_description') as $key => $value) {

            $show = Show::updateOrCreate(
                ['av_id' => $key],
                [
                    'av_id' => $key,
                    'title' => $key,
                    'slug' => Str::slug($key)
                ]
            );

            foreach ($value as $performance) {
                Performance::updateOrCreate(
                    ['id' => $performance['id']],
                    [
                        'show_id' => $show->id,
                        'start_datetime' => $performance['start_datetime'],
                        'end_datetime' => $performance['end_datetime'],
                        'venue' => $performance['venue'],
                        'screen' => $performance['screen'],
                        'availability_number' => $performance['availability_number'],
                        'availability' => $performance['availability'],
                        'pricing' => $performance['pricing'],
                        'sales_status' => $performance['sales_status'],
                        'on_sale_date' => $performance['on_sale_date'],
                        'additional_info_url' => $performance['additional_info'],
                        'instance' => 'flare',
                        'strand' => $performance['strand'],
                        'accessibility' => $performance['accessibility'],
                    ]
                );
            }
        }


    }
}
<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Carbon;
use GuzzleHttp\Cookie\CookieJar;

class AVDataService
{
    protected $client;

    public function __construct()
    {
        $this->cookieJar = new CookieJar();
        $this->client = new Client([
            'base_uri' => env('av_base_url'),
            'cookies' => $this->cookieJar,
            'headers' => ['Accept' => 'application/json']
        ]);
    }

    private function authenticate($instance)
    {
        $this->client->post(env('av_base_url').'WebAPI/session/authenticateUser', [
            'form_params' => [
                'userid' => env('av_user_flare'),
                'password' => env('av_password_flare')
            ]
        ]);
    }

    public function getFuturePerformances($instance = 'flare')
    {
        $this->authenticate($instance);
        $boHandle = $this->client->get(env('av_base_url').'WebAPI/session/boCreate?handle=performances&object=TScontentBO'); // this is required

        $today = '2024-01-01';
        $threeMonths = '2024-05-01';
        
        $response = $this->client->get(env('av_base_url').'WebAPI/object/performances/search?SET::SearchCriteria::search_from=' . $today . '&SET::SearchCriteria::search_to=' . $threeMonths . '&GET=SearchResults&GET=SearchResultsInfo');

        $data = json_decode($response->getBody());

        $total_pages = $data->response->data->SearchResultsInfo->total_pages->standard;
        $current_page = $data->response->data->SearchResultsInfo->current_page->standard;

        $results = $data->response->data->SearchResults; //  this gets all 100 results

        dd($results);

        unset($results->state);
        $output = [];
        foreach ($results as $result) {
            if ($result->availability_status->standard != 'U') {
                $output[] = $this->extractPerformanceData($result);
            }
        }
        return collect($output);
    }

    private function extractPerformanceData($result)
    {
        if (isset($result->on_sale_date->standard[0])) {
            $on_sale_date = (new Carbon($result->on_sale_date->standard[0]))->toDateTimeString();
        } else {
            $on_sale_date = Carbon::now()->toDateTimeString();
        }

        $performance = [];
        $performance['id'] = $result->id->standard;
        $performance['start_datetime'] = (new Carbon($result->start_date->standard[0]));
        $performance['end_datetime'] = isset($result->end_date->standard[0]) ? (new Carbon($result->end_date->standard[0])) : null;
        $performance['venue'] = $this->translateVenueName($result->venue_name->standard);
        $performance['screen'] = $result->venue_description->standard;
        $performance['description'] = $result->short_description->standard;
        $performance['grouping_description'] = explode(' + ', $result->short_description->standard)[0];
        $performance['availability_number'] = $result->availability_num->standard;
        $performance['availability'] = $this->getAvailabilityText($result);
        $performance['min_price'] = $result->min_price->standard;
        $performance['max_price'] = $result->max_price->standard;
        $performance['pricing'] = $this->getPricingText($result);
        $performance['sales_status'] = $result->sales_status->standard;
        $performance['on_sale_date'] = $on_sale_date;
        $performance['additional_info'] = $result->additional_info->standard;
        $performance['strand'] = $result->data3->standard;
        $performance['accessibility'] = $result->data10->standard;
        return $performance;
    }

    private function translateVenueName($name)
    {
        if ($name == 'Player') {
            return 'Online Player';
        }
        if ($name == 'X' || $name == 'Y' || $name == 'Z') {
            return 'In person venue';
        }
        return $name;
    }

    private function getAvailabilityText($result)
    {
        // Currently on sale with availability
        if ($result->sales_status->standard === 'S' && $result->availability_num->standard > 0) {
            return 'On sale now';
        }
        // Currently on sale but no availability
        if ($result->sales_status->standard === 'S' && $result->availability_num->standard < 1) {
            return 'Sold out';
        }
        // On calendar
        if ($result->sales_status->standard === 'C') {
            return 'Available soon';
        }
    }

    private function getPricingText($result)
    {
        if (isset($result->min_price->standard) && isset($result->max_price->standard)) {
            if ($result->min_price->standard === '0.00' && $result->min_price->standard === '0.00') {
                return 'Free';
            }
            if ($result->min_price->standard === $result->max_price->standard) {
                return $result->min_price->display;
            } else {
                return $result->min_price->display . ' - ' . $result->max_price->display;
            }
        }
    }

}
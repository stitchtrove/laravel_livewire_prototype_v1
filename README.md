## What this is

This is a prototype built during a single two week sprint with the intention of trying new tech and seeing how well it can work with a legacy API. 

The desired outcome was a html page with a listing of show performances.

All work related domains and data have been removed/switched out.

## Tech Stack

Laravel 10, Livewire 3, Alpine, Tailwind

## Overview: 

Run the custom command *php artisan import-performances*, this connects to the API, formats the data into something nice and stores it in the DB. 

The API simply returns a list of performances, from a user perspective I would rather search by film rather than by date so I added a *group-by* function within the custom command to create a relationship between Shows and Performances. 

The newly created data structure is Show (model) can have many Performances (model) 

Then we have the Performances livewire component which is a listing of shows in an accordian style, click the show to see a list of the related performances. It also has a nice search and filter functionality to make browsing shows easier. 

## Outcome

The prototype was well recieved and had excellent feedback. 

## Next Steps

This is a throwaway prototype so will likely not recieve any updates, future prototypes will be built from scratch. 

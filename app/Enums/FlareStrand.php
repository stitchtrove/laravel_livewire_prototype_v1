<?php

namespace App\Enums;

enum FlareStrand: string
{
    case BODIES = 'BODIES';
    case EVENT = 'EVENT';
    case EVENTS = 'EVENTS';
    case FILMACADEMY = 'FILMACADEMY';
    case GALA = 'GALA';
    case HEARTS = 'HEARTS';
    case MINDS = 'MINDS';
    case SCREENTALK = 'SCREENTALK';
    case SPECIALPRESENTATION = 'SPECIALPRESENTATION';

    public function title(): string
    {
        return match($this) 
        {
            self::BODIES => 'Bodies',
            self::EVENT => 'Event',
            self::EVENTS => 'Events',
            self::FILMACADEMY => 'Film Academy',
            self::GALA => 'Gala',
            self::HEARTS => 'Hearts',
            self::MINDS => 'Minds',
            self::SCREENTALK => 'Screen Talk',
            self::SPECIALPRESENTATION => 'Special Presentation',
        };
    }

    public function color(): string
    {
        return match($this) 
        {
            self::BODIES => '#9966cc',
            self::EVENT => 'transparent',
            self::EVENTS => 'transparent',
            self::FILMACADEMY => '#ffbf00',
            self::GALA => '#ffbf00',
            self::HEARTS => '#a1caf1',
            self::MINDS => '#ffe135',
            self::SCREENTALK => '#b5a642',
            self::SPECIALPRESENTATION => '#ff55a3',
        };
    }
}
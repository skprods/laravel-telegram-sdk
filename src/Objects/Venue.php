<?php

namespace SKprods\Telegram\Objects;

/**
 * @property Location $location         Venue location. Can't be a live location
 * @property string $title              Name of the venue
 * @property string $address            Address of the venue
 * @property string $foursquareId       Optional. Foursquare identifier of the venue
 * @property string $foursquareType     Optional. Foursquare type of the venue. (For example, “arts_entertainment/default”, “arts_entertainment/aquarium” or “food/icecream”.)
 * @property string $googlePlaceId      Optional. Google Places identifier of the venue
 * @property string $googlePlaceType    Optional. Google Places type of the venue
 *
 * @link https://core.telegram.org/bots/api#venue
 */
class Venue extends BaseObject
{
    protected function casts(): array
    {
        return [
            'location' => Location::class,
        ];
    }
}
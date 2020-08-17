<?php

namespace ParcelStars;

use ParcelStars\Exception\ParcelStarsException;
use ParcelStars\Person;

/**
 *
 */
class Sender extends Person
{
    public function __construct()
    {

    }

    public function generateSender()
    {
        if (!$this->company_name) throw new ParcelStarsException('All the fields must be filled. company_name is missing.');
        if (!$this->contact_name) throw new ParcelStarsException('All the fields must be filled. contact_name is missing.');
        if (!$this->street_name) throw new ParcelStarsException('All the fields must be filled. street_name is missing.');
        if (!$this->zipcode) throw new ParcelStarsException('All the fields must be filled. zipcode is missing.');
        if (!$this->city) throw new ParcelStarsException('All the fields must be filled. city is missing.');
        if (!$this->phone_number) throw new ParcelStarsException('All the fields must be filled. phone_number is missing.');
        if (!$this->country_id) throw new ParcelStarsException('All the fields must be filled. country_id is missing.');
        return array(
            'company_name' => $this->company_name,
            'contact_name' => $this->contact_name,
            'street_name' => $this->street_name,
            'zipcode' => $this->zipcode,
            'city' => $this->city,
            'phone_number' => $this->phone_number,
            'country_id' => $this->country_id
        );
    }

    public function returnJson()
    {
        return $this->json_encode(generateSender());
    }

    public function __toArray()
    {
        return $this->generateSender();
    }
}

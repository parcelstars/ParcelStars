<?php

namespace ParcelStars;

use ParcelStars\Exception\ParcelStarsException;

/**
 *
 */
class Person
{
    protected $company_name;
    protected $contact_name;
    protected $street_name;
    protected $zipcode;
    protected $city;
    protected $phone_number;
    protected $country_id;
    protected $email;

    public function __construct()
    {
    }

    public function setCompanyName($company_name)
    {
        $this->company_name = $company_name;

        return $this;
    }

    public function setContactName($contact_name)
    {
        $this->contact_name = $contact_name;

        return $this;
    }

    public function setStreetName($street_name)
    {
        $this->street_name = $street_name;

        return $this;
    }

    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    public function setPhoneNumber($phone_number)
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    public function setCountryId($country_id)
    {
        $this->country_id = $country_id;

        return $this;
    }

    public function setEmail($email) {
      if (filter_var($email, FILTER_VALIDATE_EMAIL) !== false) {
        $this->email = $email;

        return $this;
      }
      else {
        throw new ParcelStarsException('All the fields must be filled. company_name is missing.');
      }
    }
}

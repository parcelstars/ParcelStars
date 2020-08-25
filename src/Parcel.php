<?php

namespace ParcelStars;

use ParcelStars\Exception\ParcelStarsException;

/**
 *
 */
class Parcel
{
    private $amount;
    private $unit_weight;
    private $width;
    private $length;
    private $height;

    public function __construct()
    {

    }

    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    public function setUnitWeight($unit_weight)
    {
        $this->unit_weight = $unit_weight;

        return $this;
    }

    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    public function setLength($length)
    {
        $this->length = $length;

        return $this;
    }

    public function setHeight($heigth)
    {
        $this->heigth = $heigth;

        return $this;
    }

    public function generateParcel()
    {
        if (!$this->amount) throw new ParcelStarsException('All the fields must be filled. amount is missing.');
        if (!$this->unit_weight) throw new ParcelStarsException('All the fields must be filled. unit_weight is missing.');
        if (!$this->width) throw new ParcelStarsException('All the fields must be filled. width is missing.');
        if (!$this->length) throw new ParcelStarsException('All the fields must be filled. length is missing.');
        if (!$this->heigth) throw new ParcelStarsException('All the fields must be filled. heigth is missing.');
        $parcel = array(
            'amount' => $this->amount,
            'unit_weight' => $this->unit_weight,
            'width' => $this->width,
            'length' => $this->length,
            'heigth' => $this->heigth
        );

        return $parcel;
    }

    public function generateParcelOffers()
    {
        if (!$this->amount) throw new ParcelStarsException('All the fields must be filled. amount is missing.');
        if (!$this->unit_weight) throw new ParcelStarsException('All the fields must be filled. unit_weight is missing.');
        if (!$this->width) throw new ParcelStarsException('All the fields must be filled. width(x) is missing.');
        if (!$this->length) throw new ParcelStarsException('All the fields must be filled. length(y) is missing.');
        if (!$this->heigth) throw new ParcelStarsException('All the fields must be filled. heigth(z) is missing.');
        $parcel = array(
            'amount' => $this->amount,
            'weight' => $this->unit_weight,
            'x' => $this->width,
            'y' => $this->length,
            'z' => $this->heigth
        );

        return $parcel;
    }


    public function returnJson()
    {
        return json_encode($this->generateParcel());
    }

    public function __toArray()
    {
        return $this->generateParcel();
    }
}

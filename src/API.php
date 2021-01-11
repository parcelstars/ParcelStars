<?php

namespace ParcelStars;

use ParcelStars\Exception\ParcelStarsException;
use ParcelStars\Exception\ValidationException;

class API
{
    protected $url = "https://demo.parcelstars.com/api/";
    protected $token;
    private $debug_mode;

    public function __construct($token = false, $test_mode = false, $api_debug_mode = false)
    {
        if (!$token) {
            throw new ParcelStarsException("ParcelStars user Token is required");
        }

        $this->token = $token;

        if (!$test_mode) {
            $this->url = "https://www.parcelstars.com/api/";
        }

        if ($api_debug_mode) {
            $this->debug_mode = $api_debug_mode;
        }
    }

    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }


    private function callAPI($url, $data = [])
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer " . $this->token
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if ($data) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($this->debug_mode) {
            echo '<b>Token:</b><br><br>';
            echo $this->token;
            echo '<br><br>';
            echo '<b>Endpoint:</b><br><br>';
            echo $url;
            echo '<br><br>';
            echo '<b>Data passed:</b><br><br>';
            echo  json_encode($data, JSON_PRETTY_PRINT);
            echo '<br><br>';
            echo '<b>Data returned:</b><br><br>';
            echo json_encode($response, JSON_PRETTY_PRINT);
            echo '<br><br>';
            echo '<b>Default API lib response:</b><br><br>';
        }

        return $this->handleApiResponse($response, $httpCode);
    }

    private function handleApiResponse($response, $httpCode)
    {
        if ($httpCode == 200) {
            return json_decode($response)->result;
        }

        if ($httpCode == 401) {
            throw new ParcelStarsException(implode(" \n", json_decode($response)->errors));
        }

        $errors = json_decode($response, true);

        if (isset($errors['messages'])) {
            //echo 'messages:<br><br>';
            //echo $response;
            //echo '<br><br>';
            throw new ValidationException(debug_backtrace()[2]['function'] . '():<br><br>' . implode(", \n", $errors['messages'][0]));
        }

        if (isset($errors['error'])) {
            //echo 'errors:<br><br>';
            //echo $response;
            echo debug_backtrace()[2]['function'];
            throw new ValidationException(debug_backtrace()[2]['function'] . '():<br><br>' . $errors['error']);
        }

        throw new ParcelStarsException('API responded with error: ' . $response);
    }


    public function listAllCountries()
    {
        $response = $this->callAPI($this->url . 'services/countries');

        return $response->countries;
    }

    public function listAllStates()
    {
        $response = $this->callAPI($this->url . 'services/states');

        return $response->states;
    }

    public function getDepartments()
    {
        $response = $this->callAPI($this->url . 'departments');

        return $response->departments;
    }

    public function getImporters()
    {
        $response = $this->callAPI($this->url . 'importers');

        return $response->importers;
    }

    public function listAllServices()
    {
        $response = $this->callAPI($this->url . 'services');

        return $response->services;
    }

    public function getOffers(string $parcel_type, Sender $sender, Receiver $receiver, $parcels)
    {
        $post_data = array(
            'parcel_type' => $parcel_type,
            'sender' => $sender->generateSenderOffers(),
            'receiver' => $receiver->generateReceiverOffers(),
            'parcels' => $parcels
        );
        $response = $this->callAPI($this->url . 'services/', $post_data);

        return $response->offers;
    }

    public function getOffers_parcelTerminal(string $parcel_type, Sender $sender, Receiver $receiver, $parcels)
    {
        $post_data = array(
            'parcel_type' => $parcel_type,
            'sender' => $sender->generateSenderOffers(),
            'receiver' => $receiver->generateReceiverOffers(),
            'parcels' => $parcels
        );
        $response = $this->callAPI($this->url . 'services/', $post_data);

        return $response->offers;
    }

    public function getAllOrders()
    {
        $response = $this->callAPI($this->url . 'orders');

        return $response->orders;
    }

    public function getLabel($shipment_id)
    {
        $response = $this->callAPI($this->url . "orders/" . $shipment_id . "/label");

        return $response;
    }

    public function generateManifest($shipment_ids)
    {
        $post_data = array('shipments' => $shipment_ids);
        $response = $this->callAPI($this->url . 'manifests', $post_data);

        return $response;
    }

    public function getTerminals($country_code)
    {
        $response = $this->callAPI($this->url . 'terminals/' . $country_code);

        return $response->terminals;
    }

    public function generateOrder($order)
    {
        $post_data = $order->__toArray();
        $response = $this->callAPI($this->url . 'orders', $post_data);

        return $response;
    }

    public function generateOrder_parcelTerminal($order)
    {
        $post_data = $order->__toArray();
        $response = $this->callAPI($this->url . 'orders', $post_data);

        return $response;
    }

    public function cancelOrder($shipment_id)
    {
        $response = $this->callAPI($this->url . 'orders/' . $shipment_id . '/cancel');

        return $response;
    }

    public function makePickup($shipment_id)
    {
        $response = $this->callAPI($this->url . 'orders/' . $shipment_id . '/pickup');

        return $response;
    }

    public function trackOrder($shipment_id)
    {
        $response = $this->callAPI($this->url . 'orders/' . $shipment_id . '/track');

        return $response;
    }
}

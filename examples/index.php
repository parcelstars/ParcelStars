
<!DOCTYPE html>
<html>
<body>
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('error_reporting', E_ALL);

require("../vendor/autoload.php");

use ParcelStars\API;
use ParcelStars\Sender;
use ParcelStars\Receiver;
use ParcelStars\Item;
use ParcelStars\Parcel;
use ParcelStars\Order;
use ParcelStars\Exception\ParcelStarsException;

$token = "KW7z763Gd5ok8ArSHQ5Lqwtt";

try {
    $ps = new API($token, true);

    $sender1 = new Sender('TEST', 'TEST', 'TEST', '48311', 'TEST', '+37061234567', 122);
    $sender2 = new Sender('TEST', 'TEST', 'TEST', '48311', 'TEST', '+37061234567', 122);
    $sender3 = new Sender('UAB ZIPAS', 'Daiva Jagielaitė', 'Saltoniškių g. 10A', '08105', 'Vilnius', '+37061697227', 122);

    $receiver1 = new Receiver('courier', 'TEST', '+37061234567', 116, '12-345', 'TEST', 'TEST', 'TEST');
    $receiver2 = new Receiver('terminal', 'TEST', '+37061234567', 116, '12-345');
    $receiver3 = new Receiver('courier', 'JOHN JOHN', '+37065032153', 241, '22767', 'UNO MOMENTO', 'James road 54', 'Frankfurt');
    
    $parcel1 = new Parcel(2, 1, 20, 20, 20);
    $parcels1 = array( $parcel1->return_object() );

    $item1 = new Item('test package', 5, 1);
    $items1 = array( $item1->return_object() );

    $callback_urls = array(
      "http://webhook.site/1c05bdb9-6f15-4c61-8549-8f45c1cae1a0"
    );

    $order1 = new Order('ZIPAS', 'PS1', $sender1, $receiver1, 'parcel', $parcels1, 'test package', 0, $items1, $callback_urls);
    $order2 = new Order('ZIPAS', 'PS5 LT', $sender1, $receiver1, 'parcel', $parcels1, 'test package', 0, $items1, $callback_urls);

    //echo json_encode($ps->listAllCountries());
    //echo json_encode($ps->getDepartments());
    //echo json_encode($ps->getLabel('W2S081037758'));
    //echo json_encode($ps->getTerminals('LT'));
    //echo json_encode($ps->listAllServices());
    //echo json_encode($ps->generateManifest(array('W2S081137782', 'W2S081137783')) );
    //echo json_encode($ps->makePickup('W2S0627258'));
    //echo json_encode($ps->trackOrder('W2S030418190'));
    //echo json_encode($ps->generateOrder($order1));
    //echo json_encode($ps->generateOrder_parcelTerminal($order2));
} catch (ParcelStarsException $e) {
    echo $e->getMessage();
}

 ?>




</body>
</html>
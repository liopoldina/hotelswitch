<?php

namespace App\Repositories;

use GuzzleHttp\Client;

use Illuminate\Support\Facades\DB;

use App\Libraries\MyLibrary;

use App\Models\Static_Hotel;
use App\Models\FacilityGroups;
use App\Models\Facilities;
class ReservationsRepository{

    public static function CheckRate($rateKey) {
    
        $client = new Client([
            'base_uri' => 'https://api.test.hotelbeds.com/hotel-api/1.0/'
        ]);
        
        $api_key='09561817f75e14b5b941446bffbb10ff';
        $secret='a0a2a7b764';
        $timestamp= time();
        $x_signature= hash('sha256', $api_key . $secret . $timestamp);
        
        $headers=[
            'Api-key'         => $api_key,
            'X-Signature'     => $x_signature,
            'Accept'          => 'application/json',
            'Accept-Encoding' => 'gzip',
            'Content-Type'    => 'application/json'
        ];
    
        $body=[
            "rooms"=> [
                [
                "rateKey"  => $rateKey,
                ]
            ],
            "upselling" => 'false',
        ];

        $response = $client->request('POST', 'checkrates',  ['headers' => $headers,'json' => $body,]);

        $r = json_decode($response->getBody()->getContents());

        // set selling rate if not set
        if (!isset($r->hotel->rooms[0]->rates[0]->sellingRate)){  
            $r->hotel->rooms[0]->rates[0]->sellingRate =  round($r->hotel->rooms[0]->rates[0]->net * 1.06,2);
            }
    
        // set cancellaton policy
        $r->hotel->rooms[0]->rates[0]->rateClass = "NRF"; //default
 
        if (isset($r->hotel->rooms[0]->rates[0]->cancellationPolicies[0]->from)){   
            [$r->hotel->rooms[0]->rates[0]->rateClass, $r->hotel->rooms[0]->rates[0]->cancellationPolicies[0]->description]  = MyLibrary::cancellation_policy($r->hotel->rooms[0]->rates[0]);         
        }
    
        return $r;         
    }

    public static function Book($data) {
    
        $client = new Client([
            'base_uri' => 'https://api.test.hotelbeds.com/hotel-api/1.0/'
        ]);
        
        $api_key='09561817f75e14b5b941446bffbb10ff';
        $secret='a0a2a7b764';
        $timestamp= time();
        $x_signature= hash('sha256', $api_key . $secret . $timestamp);
        
        $headers=[
            'Api-key'         => $api_key,
            'X-Signature'     => $x_signature,
            'Accept'          => 'application/json',
            'Accept-Encoding' => 'gzip',
            'Content-Type'    => 'application/json'
        ];
    
        $body=[
            "holder"=> [
                "name"=> $data['first_name'],
                "surname"=> $data['last_name']
            ],
            "rooms"=> [
                [
                    "rateKey"=> $data['rateKey'],
                    // "paxes"=> [
                    //     [
                    //         "roomId"=> 1,
                    //         "type"=> "AD",
                    //         "name"=> "First Adult Name",
                    //         "surname"=> "Surname"
                    //     ],
                    //     [
                    //         "roomId"=> 1,
                    //         "type"=> "AD",
                    //         "name"=> "First Adult Name",
                    //         "surname"=> "Surname"
                    //     ]
                    // ]
                ]
            ],
            "clientReference"=> "IntegrationAgency",
            "remark"=>  $data['special_requests'],
            "tolerance"=> 2
        ];

        $response = $client->request('POST', 'bookings',  ['headers' => $headers,'json' => $body,]);

        $r = json_decode($response->getBody()->getContents());

        // set selling rate if not set
        if(!isset($r->booking->hotel->rooms[0]->rates[0]->sellingRate)){
            $r->booking->hotel->rooms[0]->rates[0]->sellingRate = round($r->booking->hotel->rooms[0]->rates[0]->net * 1.06,2);
        }

        // set cancellaton policy
        $r->booking->hotel->rooms[0]->rates[0]->rateClass = "NRF"; //default

        if (isset($r->booking->hotel->rooms[0]->rates[0]->cancellationPolicies[0]->from)){   
            [$r->booking->hotel->rooms[0]->rates[0]->rateClass, $r->booking->hotel->rooms[0]->rates[0]->cancellationPolicies[0]->description]  = MyLibrary::cancellation_policy($r->booking->hotel->rooms[0]->rates[0]);         
        }
            
        return $r;            
    }

    public static function get_hotel($hotel_id, $r){
    
        $Static_Hotel = Static_Hotel::find($hotel_id);

        $h = new Hotel($Static_Hotel, $r);
        
        return $h;
    }
}

class Hotel {
    var $check_in;
    var $check_out;
    var $nights;
    var $nights_text;
    var $rooms;
    var $rooms_text;
    var $adults;
    var $adults_text;
    var $children;
    var $children_text;

    var $name;
    var $stars;
    var $stars_symbol;

    var $city;
    var $country;
    var $address;

    var $email;
    var $phone;

    var $coords;

    var $images;

    var $facilities;

    var $policies;

    var $icons;

    function __construct($static, $r)
    {          
        if(isset($r->hotel)){
            // book page
            $this->check_in = $r->hotel->checkIn;
            $this->check_out = $r->hotel->checkOut;
            $this->rooms = $r->hotel->rooms[0]->rates[0]->rooms;
            $this->adults = $r->hotel->rooms[0]->rates[0]->adults;
            $this->children = $r->hotel->rooms[0]->rates[0]->children;

            if(isset($r->hotel->rooms[0]->rates[0]->taxes->allIncluded)){
                if($r->hotel->rooms[0]->rates[0]->taxes->allIncluded == false){
                    $this->tax = $r->hotel->rooms[0]->rates[0]->taxes->taxes[0]->amount . " " . $r->hotel->rooms[0]->rates[0]->taxes->taxes[0]->currency;
                }
            }
        }else
            {// confimation page
            $this->check_in = $r["reservation"]["booking"]["hotel"]["checkIn"];
            $this->check_out = $r["reservation"]["booking"]["hotel"]["checkOut"];
            $this->rooms = $r["reservation"]["booking"]["hotel"]["rooms"][0]["rates"][0]["rooms"];

            foreach ($r["reservation"]["booking"]["hotel"]["rooms"][0]["paxes"] as $pax){
                if($pax["type"] == "AD"){ $this->adults = $this->adults + 1;}
                if($pax["type"] == "CH"){ $this->children = $this->children + 1;}
            }

            if(isset($r["reservation"]["booking"]["hotel"]["rooms"][0]["rates"][0]["taxes"]["allIncluded"])){
                if($r["reservation"]["booking"]["hotel"]["rooms"][0]["rates"][0]["taxes"]["allIncluded"] == false){
                    $this->tax = $r["reservation"]["booking"]["hotel"]["rooms"][0]["rates"][0]["taxes"]["taxes"][0]["amount"] . " " . $r["reservation"]["booking"]["hotel"]["rooms"][0]["rates"][0]["taxes"]["taxes"][0]["currency"];
                }
            }
        }

        $this->nights = (strtotime($this->check_out) - strtotime($this->check_in))/86400;
        $this->nights_text = $this->nights .  ($this->nights == 1 ? " night" :" nights");
        $this->rooms_text = $this->rooms .  ($this->adults == 1 ? " room" :" rooms");
        $this->adults_text = $this->adults .  ($this->adults == 1 ? " adult" :" adults");
        $this->children_text = $this->children .  ($this->adults == 1 ? " child" :" children");

        $this->name = $static["name"]["content"];
        $this->stars = (int)$static["categoryCode"];
        $this->stars_symbol = MyLibrary::set_stars_symbol($this->stars );

        $this->city=$static["city"]["content"];
        $this->country =  $static["country"]['description']['content']; 

        $this->address = MyLibrary::titleCase($static["address"]["content"]).", ".MyLibrary::titleCase($this->city). ", " . $static["postalCode"] . ", " . $this->country;

        $this->email = $static["email"];
        $this->phone = $static["phones"][0]["phoneNumber"];

        $this->coords = ['lat'=>$static["coordinates"]["latitude"],'lon'=>$static["coordinates"]["longitude"]];

        $this->images = $static["images"];

        $facilities_aux=$this->get_facilities($static["facilities"]); // instead of feeding $static["facilities"] to function get_policies, we feed $facilities_aux that is equal but already contains the description of the facility
        $this->get_policies($facilities_aux);

        $this->get_icons();

    }
    

    function get_facilities($facilities){
        
        $cursor_decode =  FacilityGroups::all();
    
        $this->facilities = array();
        $this->icons = new \stdClass();
        $this->icons->facility_groups = [];
    
        foreach ($cursor_decode as $facility_group){
        $this->facilities[$facility_group["FacilityGroup"]]=array();
        $this->icons->facility_groups [] = $facility_group["Icon"];
        }
    
        for ($i=0; $i<count($facilities); $i++){
        
                $filter=[
                    'facilityGroupCode'=>$facilities[$i]["facilityGroupCode"],
                    'code'=>$facilities[$i]["facilityCode"]
                    ];  
                
                $options = [ 'projection' => ['_id' => 0, 'code' => 1, 'description' => 1]];
        
                $cursor_decode = Facilities::where($filter)->get();

                $facilities[$i]['description']=$cursor_decode[0]["description"]["content"];
        
                if(isset($cursor_decode[0]["description"]["FacilityGroup"])){
        
                    if(!in_array($cursor_decode[0]["description"]["content"],$this->facilities[$cursor_decode[0]["description"]["FacilityGroup"]])){
            
                        $this->facilities[$cursor_decode[0]["description"]["FacilityGroup"]][]=$cursor_decode[0]["description"]["content"];
        
                    }
                }
            }
    
        return($facilities);
    }

    function get_policies($facilities){
        $this->policies['Check-in and check-out']=array();
        $this->policies['Cancellation/Prepayment']=array();
        $this->policies['Children and beds']=array();
        $this->policies['Meals']=array();
        $this->policies['Pets']=array();
        $this->policies['Cards accepted']=array();
    
        $this->policies['Cancellation/Prepayment'][]="You can find more information on the terms of cancellation or prepayment in the booking terms of the rate you've chosen.";
    
        // $this->policies['Children and beds'][]="Children of any age are welcome.";
        // $this->policies['Children and beds'][]="Children aged 12 years and above are considered adults at this property.";
        $this->policies['Children and beds'][]="To see correct prices and occupancy information, please add the number of children in your group and their ages to your search.";
    
        // $this->policies['Meals'][]="Price of an additional breakfast: 8.00 EUR per person.";
        $this->policies['Meals'][]="Information about the type of meals included in the price is indicated in the rate details.";

        for ($i=0; $i<count($facilities); $i++){
    
            switch ($facilities[$i]["description"]) {
                case "Check-in hour":
                    $this->policies['Check-in and check-out'][]='Check-in from '. substr($facilities[$i]['timeFrom'], 0, -3);
                break;
    
                case "Check-out hour":
                    if(isset($facilities[$i]['timeTo'])){
                    $this->policies['Check-in and check-out'][]='Check-out time: before '. substr($facilities[$i]['timeTo'], 0, -3);
                    } else{
                    $this->policies['Check-in and check-out'][]='Check-out time: before '. substr($facilities[$i]['timeFrom'], 0, -3);
                    }
                break;
    
                case "Small pets allowed (under 5 kg)":
                    if($facilities[$i]['indYesOrNo'] == true){
                    $this->policies['Pets'][]=$facilities[$i]["description"];
                    }else{
                    $this->policies['Pets'][]="Pets are not allowed.";
                    }
                break;
            }

            $missing_icons = ['Maestro','Visa Electrón','EuroCard', 'EC', 'Euro 6000'];
    
            if ($facilities[$i]["facilityGroupCode"]==30) {

                if(!in_array($facilities[$i]["description"],$missing_icons)){
                    $this->policies['Cards accepted'][]=$facilities[$i]["description"];
                }
            }
        }
    }

    function get_icons(){
        // policies group icons
        $this->icons->policies [] = 'far fa-clock fa-lg';
        $this->icons->policies [] = 'fas fa-info-circle fa-lg';
        $this->icons->policies [] = 'fas fa-child fa-lg';
        $this->icons->policies [] = 'fas fa-utensils fa-lg';
        $this->icons->policies [] = 'fas fa-paw fa-lg';
        $this->icons->policies [] = 'far fa-credit-card fa-lg';

        // credit card icons
        $this->icons->cards = [
            "Visa"=>"fab fa-cc-visa fa-2x",
            "MasterCard"=>"fab fa-cc-mastercard fa-2x",
            "American Express"=>"fab fa-cc-amex fa-2x",
            "JCB"=>"fab fa-cc-jcb fa-2x",
            "Diners Club"=>"fab fa-cc-diners-club fa-2x"
        ];
    }
}




?>
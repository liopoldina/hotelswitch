<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

use App\Models\Static_Hotel;
use App\Models\FacilityGroups;
use App\Models\Facilities;
use App\Libraries\MyLibrary;

class HotelRepository{

    public static function get_hotel($m){
    
        $Static_Hotel = Static_Hotel::find($m->hotel_id);
        $info   = DB::connection('hotelbeds')->table($m->collection_name)->where('info', 'exists', true)->first();
        $offer  = DB::connection('hotelbeds')->table($m->collection_name)->where('code', $m->hotel_id)->get();

        $h = new Hotel($Static_Hotel,$offer,$info);
        
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

    var $name;
    var $stars;
    var $stars_symbol;

    var $city;
    var $country;
    var $address;

    var $coords;
    var $city_coords;
    var $distance_center;

    var $score;
    var $quality;
    var $nr_reviews;

    var $images;

    var $description;

    var $facilities;

    var $policies;

    var $offer;

    var $tourist_tax;

    var $icons;

    function __construct($static, $offer, $info)
    {           
                // dynamic content
                if($info["info"]["total"] > 0){ 
                    $this->rooms = $offer[0]["rooms"][0]["rates"][0]["rooms"];
                    $this->rooms_text = MyLibrary::number_text($this->rooms,"rooms");

                    $this->score = $offer[0]["reviews"][0]["rate"] * 2;
                    $this->quality = MyLibrary::set_quality($this->score );
                    $this->nr_reviews= $offer[0]["reviews"][0]["reviewCount"];
                    
                    $this->get_offer($offer[0]['rooms'],$static);
    
                    if(isset($offer[0]["rooms"][0]["rates"][0]["taxes"]["allIncluded"])){
                        if($offer[0]["rooms"][0]["rates"][0]["taxes"]["allIncluded"] == false){
                            $this->tourist_tax = intval($offer[0]["rooms"][0]["rates"][0]["taxes"]["taxes"][0]["amount"])/$offer[0]["rooms"][0]["rates"][0]["adults"];
                        }
                    }
                }
                
                // static content
                $this->check_in=$info["info"]["checkIn"];
                $this->check_out=$info["info"]["checkOut"];
                $this->nights= (strtotime($this->check_out) - strtotime($this->check_in))/86400;
                $this->nights_text = MyLibrary::number_text($this->nights,"nights");
                

                $this->name = $static["name"]["content"];
                $this->stars = (int)$static["categoryCode"];
                $this->stars_symbol = MyLibrary::set_stars_symbol($this->stars );

                $this->city=$static["city"]["content"];
                $this->country =  $static["country"]['description']['content']; 

                $this->address = MyLibrary::titleCase($static["address"]["content"]).", ".MyLibrary::titleCase($this->city). ", " . $static["postalCode"] . ", " . $this->country;

                $this->coords = ['lat'=>$static["coordinates"]["latitude"],'lon'=>$static["coordinates"]["longitude"]];
                $this->city_coords = ['lat'=>38.71667,'lon'=>-9.13333];

                $this->distance_center = round(MyLibrary::distance($this->coords["lat"],  $this->coords["lon"], $this->city_coords["lat"], $this->city_coords["lon"]),1). " km from center";

                $this->get_images($static["images"]);
            
                $this->description=$static["description"]["content"];
                $this->get_paragraphs();

                $facilities_aux=$this->get_facilities($static["facilities"]); // instead of feeding $static["facilities"] to function get_policies, we feed $facilities_aux that is equal but already contains the description of the facility
                $this->get_policies($facilities_aux);

                $this->get_icons();

    }
    
    function get_images($images){
        foreach ($images as $image) {
            $this->images[]= "http://photos.hotelbeds.com/giata/bigger/" . $image["path"];
            $this->images_min[]= "http://photos.hotelbeds.com/giata/small/" . $image["path"];
        }   
    }

    function get_paragraphs(){
        $description = explode('.', $this->description);
        for ($i=0; $i<count($description)-1; $i++){
            $description[$i]=$description[$i].".";
        }

        for ($i=0; $i<count($description)/2-1; $i++){
            $this->paragraphs[]= htmlspecialchars($description[$i*2].$description[$i*2+1]);
        }
    }

    function get_facilities($facilities){
        
        $cursor_decode =  FacilityGroups::all();
    
        $this->facilities = array();
    
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

    function get_offer($rooms,$static){

        for ($i=0; $i < count($rooms); $i++){

            // get room images
            foreach($static["images"] as $image){
                if (isset($image["roomCode"]))
                    if($rooms[$i]["code"] == $image["roomCode"]){
                        $rooms[$i]["images"][] = $image;
                    } 
            }
    
    
            for ($n=0; $n < count($rooms[$i]["rates"]); $n++){

                // set cancellaton policy
                $rooms[$i]["rates"][$n]["cancellationPolicies"][0]["description"] = "Non-refundable rate"; //default
    
                if (isset($rooms[$i]["rates"][$n]["cancellationPolicies"][0]["from"])){   
                    $rooms[$i]["rates"][$n]["cancellationPolicies"][0] = array_merge($rooms[$i]["rates"][$n]["cancellationPolicies"][0], MyLibrary::cancellation_policy($rooms[$i]["rates"][$n]));         
                }
            }
        }
        $this->offer=$rooms;
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
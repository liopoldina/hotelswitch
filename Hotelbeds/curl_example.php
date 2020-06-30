<?php

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, 'https://www.rossiogardenhotel.com');

        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, false);


        curl_exec($curl);


?>
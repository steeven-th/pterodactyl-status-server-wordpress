<?php

defined('ABSPATH') or die('Get out.');

global $table_name_table_pteroq, $wpdb, $urlApiPteroqServer, $apiKeyClient, $apiKeyServer;

$return = null;
$err = null;

/*----------------------*/
// CURL REQUEST
/*----------------------*/

/* Search server attributes */
function serverAttributes($urlApi, $apiKey, $id, $typeOfAttribute) {

    global $err;

    $curlRequest = curlRequest('attributes', $urlApi, $apiKey, $id);

    $response = curl_exec($curlRequest);
    $err = curl_error($curlRequest);

    curl_close($curlRequest);

    $array = json_decode($response, true);

    $return = '';

    /*----------------------*/
    // SELECTION OF THE DESIRED ELEMENTS
    /*----------------------*/

    if ($array == null) {
        return $return;
    }

    if ($typeOfAttribute == 'name') {
        $return = $array["attributes"]["name"];
    } else if ($typeOfAttribute == 'connectionport') {
        $return = $array["attributes"]["relationships"]["allocations"]["data"][0]["attributes"]["port"];
    } else if ($typeOfAttribute == 'otherports') {
        $datatab = $array["attributes"]["relationships"]["allocations"]["data"];
        if (is_array($datatab) || is_object($datatab)) {
            foreach ($datatab as $key => $value) {
                if ($key != 0) {
                    $return .= $array["attributes"]["relationships"]["allocations"]["data"][$key]["attributes"]["notes"] . " : " . $array["attributes"]["relationships"]["allocations"]["data"][$key]["attributes"]["port"] . "<br>";
                }
            }
        }
    }

    return $return;
}

/* Search server state */
function serverState($urlApi, $apiKey, $id) {

    global $err;

    $curlRequest = curlRequest('resources', $urlApi, $apiKey, $id);

    $response = curl_exec($curlRequest);
    $err = curl_error($curlRequest);
    $code_pteroq_server = curl_getinfo($curlRequest, CURLINFO_HTTP_CODE);

    curl_close($curlRequest);

    $array = json_decode($response, true);

    /*----------------------*/
    // SELECTION OF THE DESIRED ELEMENTS
    /*----------------------*/

    if ($code_pteroq_server == '404') {
        return $code_pteroq_server;
    } else {
        return $array["attributes"]["current_state"];
    }
}

/* Search server type */
function eggName($urlApi, $apiKey, $id, $id2, $resources) {

    global $return, $err;

    $curlRequest = curlRequest($resources, $urlApi, $apiKey, $id, $id2);

    $response = curl_exec($curlRequest);
    $err = curl_error($curlRequest);

    curl_close($curlRequest);

    $array = json_decode($response, true);

    /*----------------------*/
    // SELECTION OF THE DESIRED ELEMENTS
    /*----------------------*/

    if ($resources == 'id_egg') {

        $datatab = $array["data"];

        if (is_array($datatab) || is_object($datatab)) {

            foreach ($datatab as $key => $value) {

                if ($array["data"][$key]["attributes"]["identifier"] == $id) {

                    $nest = $array["data"][$key]["attributes"]["nest"];
                    $egg = $array["data"][$key]["attributes"]["egg"];

                    eggName($urlApi, $apiKey, $nest, $egg, 'name_egg');
                }
            }
        }
    } else if ($resources == 'name_egg') {

        $return = $array["attributes"]["name"];
    }

    return $return;
}

/* Curl request */
function curlRequest($typeOfRequest, $urlApi, $apiKey, $id, $id2 = '') {

    $urlRequest = '';

    if ($typeOfRequest == 'attributes') {
        $urlRequest = "$urlApi/client/servers/$id";
    } else if ($typeOfRequest == 'resources') {
        $urlRequest = "$urlApi/client/servers/$id/resources";
    } else if ($typeOfRequest == 'id_egg') {
        $urlRequest = "$urlApi/application/servers";
    } else if ($typeOfRequest == 'name_egg') {
        $urlRequest = "$urlApi/application/nests/$id/eggs/$id2";
    }

    $curlRequest = curl_init();

    curl_setopt_array($curlRequest, array(
        CURLOPT_URL => $urlRequest,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_COOKIE => 'pterodactyl_session=eyJpdiI6InhIVXp5ZE43WlMxUU1NQ1pyNWRFa1E9PSIsInZhbHVlIjoiQTNpcE9JV3FlcmZ6Ym9vS0dBTmxXMGtST2xyTFJvVEM5NWVWbVFJSnV6S1dwcTVGWHBhZzdjMHpkN0RNdDVkQiIsIm1hYyI6IjAxYTI5NDY1OWMzNDJlZWU2OTc3ZDYxYzIyMzlhZTFiYWY1ZjgwMjAwZjY3MDU4ZDYwMzhjOTRmYjMzNDliN2YifQ%253D%253D',
        CURLOPT_HTTPHEADER => array(
            'Accept: application / json',
            'Content-Type: application/json',
            'Authorization: Bearer ' . $apiKey,
        )
    ));

    return $curlRequest;
}
<?php

function set_array_key( $array, $key ) {
    $temp = [];

    foreach ($array as $index => $value) {
        $temp[$value[$key]] = $value;
    }

    return $temp;
}

?>
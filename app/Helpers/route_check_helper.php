<?php


//this helper is for showing documents with their flags on sidebar


if(!function_exists('route_check_helper')){
    function route_check_helper($object){
     return   url()->full() == url($object) ?  'active' :  '';

    }


}

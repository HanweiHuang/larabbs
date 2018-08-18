<?php

/*
* transfer current routename to css class name.
*/
function route_class(){
    return str_replace('.', '-', Route::currentRouteName());
}



?>
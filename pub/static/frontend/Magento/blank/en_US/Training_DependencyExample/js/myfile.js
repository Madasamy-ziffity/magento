define(['jquery'], function($){
    "use strict";
    return function myscript()
    {
        alert("Yes, got it");
    }
    return function(config){
        console.log("Requires Js AMD module function",config)
    }
});
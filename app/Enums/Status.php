<?php

namespace App\Enums ;

enum Status : string {
    case InPreparation  = 'InPreparation' ;
    case OrderSent = 'OrderSent' ;
    case ReceivedIt = 'ReceivedIt' ;

}

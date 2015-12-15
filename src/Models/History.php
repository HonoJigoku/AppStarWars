<?php
/**
 * Created by PhpStorm.
 * User: Corentin
 * Date: 27/11/2015
 * Time: 15:31
 */

namespace Models;


class History extends Model
{
    protected $fillable = ['quantity', 'product_id', 'customer_id', 'price', 'total', 'commanded_at'];

   /* $token = $_POST['_token'];

    $valid = false;

    foreach (range(0.3) as $t)
    {
        if($token == md5(date('Y-m-d h:i', time() - 60*$t).SALT )){
        $valid = true;
        break;
        }
    }

    if($valid == true) {

    }*/

}
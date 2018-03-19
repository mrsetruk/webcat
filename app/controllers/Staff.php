<?php
/**
 * Created by PhpStorm.
 * User: Galbanie
 * Date: 2018-03-18
 * Time: 12:23
 */

namespace App\Controllers;


use Core\Controller;
use Core\View;

class Staff extends Controller
{
    function access($action = null){
//       var_dump($action);
       View::renderTemplate('staff/index.html',array(
           'scope' => $this->scope,
           'css' => [
               'class' => [
                   'body' => 'fixed-nav sticky-footer bg-dark'
               ],
               'id' => [
                   'body' => 'page-top'
               ]
           ]
       ));
    }
}
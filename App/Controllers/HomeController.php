<?php
/**
 * Created by PhpStorm.
 * User: Swar
 * Date: 12/5/2018
 * Time: 11:20 AM
 */

namespace App\Controllers;

use System\Controller;

class HomeController extends Controller
{
  public function index()
  {
    $data['name'] = 'SWAR';
    return $this->view->render('home', $data);
  }
}
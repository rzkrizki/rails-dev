<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('secure')) {
  /**
   *
   * Trim data agar tidak ada spasi
   * Gunakan html_entities
   * Mysql real escape string
   *
   */
  function secure($input)
  {

    $input = trim($input);
    $input = htmlentities($input);
    return $input;
  }
}

if (!function_exists('multisecure')) {
  /**
   *
   * Untuk keamanan data, trim inputan agar tidak ada spasi, Htmlentities
   *
   */
  function multisecure($array)
  {
    foreach ($array as $key => $value) {
      $array[$key] = secure($value);
    }
    return $array;
  }
}

if (!function_exists('dd')) {
  function dd($var)
  {

    if (is_object($var) || is_array($var)) {
      echo '<pre>';
      print_r($var);
      echo '</pre>';
    } else {
      echo $var;
    }
    exit();
  }
}

if (!function_exists('display_404')) {
  function display_404()
  {
    $CI = &get_instance();
    $CI->load->view('404');
  }
}

if (!function_exists('optimus_curl')) {
  function optimus_curl($method, $url, $postdata)
  {
    $ch = curl_init();

    $postData = json_encode($postdata);
    $username = '123123123';
    $password = '123123123';

    // var_dump($method);
    // die;

    curl_setopt_array($ch, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 3600,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_POSTFIELDS => $postData,
        CURLOPT_HTTPAUTH => CURLAUTH_ANY,
        CURLOPT_USERPWD => "$username:$password",
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
            "content-type: application/json"
        ),
    ));

    $result = curl_exec($ch);
    $err = curl_error($ch);

    if($err){
      $response = $err;
    }

    $response = json_decode($result);

    return $response;


  }
}

if (!function_exists('api_url')){
  function api_url($params = ''){
    $api_url = 'http://localhost:3000/api/' . $params;
    return $api_url;
  }
}

if (!function_exists('init_view')) {
  function init_view($view, $data = array()){
    $CI = &get_instance();
    $CI->load->view('layout/header.php');
    $CI->load->view('layout/navbar.php');
    $CI->load->view('layout/sidebar.php',$data);
    $CI->load->view($view, $data);
    $CI->load->view('layout/footer.php');
  }
}
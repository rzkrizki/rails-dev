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
  function optimus_curl($method, $url, $postdata, $token)
  {

    $curl = curl_init();

    if ($token <> NULL) {
      if ($method <> "GET") {
        curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => $method,
          CURLOPT_POSTFIELDS => http_build_query($postdata),
          CURLOPT_HTTPHEADER => array(
            "authorization: Bearer $token",
            "cache-control: no-cache"
          ),
        ));
      } else {
        curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => $method,
          CURLOPT_HTTPHEADER => array(
            "authorization: Bearer $token",
            "cache-control: no-cache"
          ),
        ));
      }
    } else {

      curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_POSTFIELDS => http_build_query($postdata),
        CURLOPT_HTTPHEADER => array(
          "cache-control: no-cache",
          "content-type: application/x-www-form-urlencoded"
        ),
      ));
    }

    $response = json_decode(curl_exec($curl), true);
    $err = curl_error($curl);
    curl_close($curl);

    return $response;
  }
}

if (!function_exists('api_url')){
  function drive_url($id = ''){
    $drive_url = '' . $id;
    return $drive_url;
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
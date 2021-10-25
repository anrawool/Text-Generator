<?php


class TextGenerator {

  function __construct($payload)
  {
    $this->query($payload);
  }
  /*
  
  Functions :
  1. http_get($req_set, $http_req)
  2. query($payload)
  3. parser_string($string_parse)
  4. compiler($output, $newoutput = NULL)
  
  */
  
  private function http_get($req_set, $http_req, $last_fullstop = NULL)
  {
    session_start();
    $url = 'https://api-inference.huggingface.co/models/gpt2';
    
    
    // Initializes a new cURL session
    $curl = curl_init($url);
    
    // Set the CURLOPT_RETURNTRANSFER option to true
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
    // Set the CURLOPT_POST option to true for POST request
    curl_setopt($curl, CURLOPT_POST, true);
    
    // Set the request data as JSON using json_encode function
    curl_setopt($curl, CURLOPT_POSTFIELDS,  $http_req);
    
    // Set custom headers for RapidAPI Auth and Content-Type header
    curl_setopt($curl, CURLOPT_HTTPHEADER, $req_set);
    
    // Execute cURL request with all previous settings
    $response = curl_exec($curl);
    curl_close($curl);
    $this->parser($response, $last_fullstop);
  }
  
  public function query($payload)
  {
    session_start();
    $headers = [
      'Authorization: Please write your api key here (delete this text leaving the authorization and colon [:])',
    ];
    
    if($last_fullstop = strrpos($_SESSION['output'], '.', -1)) {
      $newinput = substr($_SESSION['output'], $last_fullstop + 1, -1);
      $randintnew = random_int(10, 99);
      $jsonpayload = json_encode($randintnew . $newinput);
    } else {
      $randint = random_int(10, 99);
      $jsonpayload = json_encode($randint . $payload['inputs']);
    }
    
    $this->http_get($headers, $jsonpayload, $newinput);
  }
  
  private function parser($parseinput, $last_fullstop)
  {
    session_start();
    $final = json_decode($parseinput, true);
    $unpure_string = $final[0]['generated_text'];
    $unpure_string = str_replace($last_fullstop, " ", $unpure_string);
    // var_dump($last_fullstop);
    $output = "" . substr($unpure_string, 2);
    
    $this->compiler($output);
  }
  
  
  public function compiler($output)
  {
    session_start();
    $_SESSION['output'] .= $output;
    $this->give();
  }
  
  private function __clear() {
    $_SESSION['output'] = "";
  }

  public function give(){
    session_start();
    $end = $_SESSION['output'];
    return $end;
  }
  
}

$_SESSION['inputs'] = $_POST['text-input'];

$exinput = new TextGenerator(['inputs' => $_SESSION['inputs']]);
$_SESSION['final'] = $exinput->give();


header("location: index.php");


?>
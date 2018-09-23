<?php
include('includes/database.php');
//include('includes/curl.php')
include('includes/header.php');
include('includes/footer.php');


$urlInputError = ""; 
$results = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (empty($_POST["url_input"])) {
            $url = "";
            echo 'Enter URL to explore!!';
      } else {
            $url = test_input($_POST["url_input"]);
            
            // check if URL address syntax is valid
            if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$url)) {
                
                $urlInputError = "Invalid URL";
                $statusCode = "";
                $contentLength = "";
                $date  = "";
                
            } else {

                $url = filter_var($url, FILTER_SANITIZE_URL);
                // initiate the curl process
                $curl = curl_init();
                
                curl_setopt_array($curl, array(
                        CURLOPT_HEADER => 1,
                        CURLOPT_VERBOSE => 1,
                     //   CURLOPT_NOBODY => 1,
                        CURLOPT_FOLLOWLOCATION => 0, 
                        CURLOPT_RETURNTRANSFER => 1,
                        CURLOPT_CONNECTTIMEOUT => 20,
                        CURLOPT_URL => $url
                   )); 
                
                
                $response = curl_exec($curl);
                
                if($errno = curl_errno($curl)) {
                    $error_message = curl_strerror($errno);
                    echo "cURL error ({$errno}):\n {$error_message}";
                }
                
                curl_close($curl); 
                
                foreach(explode("\r\n", $response) as $line) {
                    if(preg_match("/^[\w\d\.\/ ]{1,10}[ ]([\d]{3})/", $line, $matches)){
                        $results['Status-code'] = $matches[1];
                    }else{
                        list($key, $value) = explode(':', $line, 2);
                        $results[$key] = $value; 
                    }
                }   

                $statusCode = $results['Status-code'];
                $contentLength = $results['Content-Length'];
                $date  = $results['Date'];
                $urlInputError = ""; 
        } 
         
        $db = new pdoDB;
        if($db) {
            $resuts = $db->insertData($url,$statusCode,$contentLength,$date,$urlInputError); 
        }       
    }
}


function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>
  
  <form class="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <div class="form-group input_url col-md-8">
        Enter URL : <input type="text" class="form-control" name="url_input">
    </div>
    <br>
    <button type="submit" class="btn btn-primary">Browse </button> 
    <button type="clear" class="btn btn-primary">Clear</button>  
    
    <button type="submit" class="btn btn-primary" name="url_history">Show History</button> 
</form>
 
    
 

   
<?php

$showAllTrans = $db->showHistory();

if(!empty($showAllTrans)){
    header('Content-Type: application/json');
    print json_encode($showAllTrans);
}

?>













 
    



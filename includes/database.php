<?php
/* 
   Establish Db connection 
   Inserting Data
   Querying Transcation history
*/


class pdoDB{

    private $connection;
    private $host = "localhost";
    private $db = "curlpractice_db";
    private $username = "root";
    private $password = "root";

    public function __construct(){

        try{
           $this->connection = new PDO("mysql:host=".$this->host.";dbname=".$this->db,$this->username,$this->password); 
        }catch(PDOException $e){
            die('Cannot Load The Page');
        }      
        
    }
    
    
    // Insert Url response details
    public function insertData($url,$statusCode,$contentLength,$date,$error){
 
        $sql = "INSERT INTO transcations (url, status_code, content_length, date, error) VALUES (:url, :code, :length, :date, :error)";

        $query = $this->connection->prepare($sql);    

        $results = $query->execute(array('url'=>$url,
                                        'code'=>$statusCode,
                                        'length'=>$contentLength,
                                        'date'=>$date,
                                        'error'=>$error));
        return $results;
    }

 
     // Display all Url inputs
     public function showHistory(){
         $data = array();
         $sql= "SELECT * FROM transcations";

         $trans = $this->connection->query($sql);

         while($results = $trans->fetchAll(PDO::FETCH_ASSOC)){
            $data[]= $results;
         }

        return $data;
     }
 

     // Delete all url history
     public function deleteHistory(){
         
        $sql= "SELECT * FROM transcations";

        $query = $this->connection->prepare($sql);

        $query->execute();

        return true;
     }
}

?>


<?php

namespace Shortener\Elena;

use PDO;
use PDOException;

class Url
{

    private DbConnection $connection;
    private PDO $pdo;

    public int $id;
    public string $shortUrl;
    public string $numericId;
    public string $date;
    public string $longUrl;


    public function __construct()
    {
        try {
            $this->connection = new DbConnection();
            $this->pdo = $this->connection->connect();
        } catch (ConnectionFailedException $e) {
            echo '<div class ="alert">{$->getMessage()}</div>';
        }
    }
       
    public function create(string $longURL, string $encodedPath, string $numericId): bool
    {
        //date_default_timezone_set('Europe/Moscow');
        $this->date=date("d.m.Y");
        $this->longUrl = $longURL;
        $url = parse_url($this->longUrl);
        $this->shortUrl = $url["scheme"]. '://'. $url["host"].'/'.$encodedPath;  
        $this->numericId= $numericId;              
        try {
            $query = "INSERT INTO urls (long_url, short_url, generation_date) 
            VALUES (:long_url, :short_url, :generation_date)";

            $stmt = $this->pdo->prepare($query);

            $stmt->bindParam(":long_url", $this->longUrl);
            $stmt->bindParam(":short_url", $this->shortUrl);
            $stmt->bindParam(":generation_date", $this->date);

            $stmt->execute();
            return true;
        } catch (PDOException $e) {

            $message = PHP_EOL . $e->getMessage() . ' with code ' . $e->getCode();
            error_log($message, 3, 'error-log.php');
            return false;
        }
    }

    public function all(): array| false
    {
        $urls = [];
        try {
            $query = "SELECT * FROM  urls";
            foreach ($this->pdo->query($query)->fetchAll(PDO::FETCH_ASSOC) as $url) {
                $url[] = $url;
            }
            return $urls;
        } catch (PDOException $e) {
            $message = PHP_EOL . $e->getMessage() . 'with code ' . $e->getCode();
            error_log($message, 3, 'error-log.php');
            return false;
        }
    }

    public function update(Url $url): bool
    {
        $longUrl = $url->longUrl;
        $shortUrl = $url->shortUrl;
        $id = $url->id;
        $date= date("d.m.Y H:i:s");
        try {

            $query = "UPDATE urls SET long_url= :long_url," .
                "short_url = :short_url, generation_date=:generation_date WHERE id=:id";
            $stmt = $this->pdo->prepare($query);

            $stmt->bindParam(":long_url", $longUrl);
            $stmt->bindParam(":short_url", $shortUrl);
            $stmt->bindParam(":generation_date", $date);
            $stmt->bindParam(":id", $id);

            $stmt->execute();
            return true;
        } catch (PDOException $e) {
       
            $message = PHP_EOL . $e->getMessage() . ' with code ' . $e->getCode();
            error_log($message, 3, 'error-log.php');
            return false;
        }
    }

    public function updateShortUrl(string $longUrl, $encodedPath, int $id){
        $url = parse_url($longUrl);
        $shortUrl = $url["scheme"]. '://'. $url["host"].'/'.$encodedPath;  
        $date = date("d.m.Y");
        try {

            $query = "UPDATE urls SET short_url = :short_url,". 
            "generation_date = :generation_date WHERE id=:id";
            $stmt = $this->pdo->prepare($query);

            $stmt->bindParam(":short_url", $shortUrl);
            $stmt->bindParam(":generation_date", $date);
            $stmt->bindParam(":id", $id);

            $stmt->execute();
            return true;
        } catch (PDOException $e) {  
            $message = PHP_EOL . $e->getMessage() . ' with code ' . $e->getCode();
            error_log($message, 3, 'error-log.php');
            return false;
        }
        
      
    } 

    public function delete($id): bool
    {
        try {
            $query = "DELETE FROM urls WHERE id=:id";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(":id", $id);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
    
            $message = PHP_EOL . $e->getMessage() . ' with code ' . $e->getCode();
            error_log($message, 3, 'error-log.php');
            return false;
        }
    } 
   
    public function getById(int $id) : Url|false {
        $url = null;
        try {
            $query = "SELECT * FROM urls WHERE id=:id";

            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $url = new Url ();
            $url->id = $result['id'];
            $url->longUrl = $result['long_url'];
            $url->shortUrl = $result['short_url'];
            $url->date= $result['generation_date'];

            return $url;
        } catch (PDOException $e) {
            $message = PHP_EOL . $e->getMessage() . 'with code ' . $e->getCode();
            error_log($message, 3, 'error-log.php');
            return false;
        }
    }

    public function getByShortUrl(string $shortUrl) : Url|false {

        try {
            $query = "SELECT * FROM urls WHERE short_url=:short_url";

            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(":short_url", $shortUrl);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
           
            $longUrl = $result['long_url'];  
            return $longUrl;
            
        } catch (PDOException $e) {
            $message = PHP_EOL . $e->getMessage() . 'with code ' . $e->getCode();
            error_log($message, 3, 'error-log.php');
            return false;
        }
    }
}

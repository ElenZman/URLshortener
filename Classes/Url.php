<?php 

class Url {
    
    private DbConnection $connection;
    private PDO $pdo;
    public int $id;
    public string $shortUrl;
    public string $numericId;

    
    public function __construct(public string $longUrl) {        
        try {
            $this->connection = new DbConnection();
            $pdo = $this->connection->connect();
        } catch(ConnectionFailedException $e) {
            echo '<div class ="alert">{$->getMessage()}</div>';
        }
    }
    public function create(string $longUrl, string $shortUrl, string $numericId) {
        try {
            $query = "INSERT INTO urls (numeric_id, long_url, short_url) 
            VALUES (:numeric_id, :short_url, :long_url)";

            $stmt = $this->pdo->prepare($query);

            $stmt->bindParam(":numeric_id", $numericId);
            $stmt->bindParam(":long_url", $longUrl);
            $stmt->bindParam(":short_url", $shortUrl);
            
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            $message = PHP_EOL . $e->getMessage() . ' with code ' . $e->getCode();
            error_log($message, 3, 'error-log.php');
            return false;
        }
    }
    
    public function isUnique(string $numericalId){

    }
    
    public function all():array| false{
        $urls = [];
        try {
            $pdo = $this->connection->connect();
            $query = "SELECT * FROM  urls";
            foreach ($pdo->query($query)->fetchAll(PDO::FETCH_ASSOC) as $url) {
                $url[] = $url;
            }
            return $urls;
        } catch (PDOException $e) {
            $message = PHP_EOL . $e->getMessage() . 'with code ' . $e->getCode();
            error_log($message, 3, 'error-log.php');
            return false;
        }
    }

    public function update() {

    }

    public function getByNumericId() {
        
    }
    
    public function delete() {

    }

}
<?php

/**
 * Этот класс реализует пагинацию. Конструктор получает в качестве параметра 
 * количество строк, которые будут отражатся на странице. Основной метод getData()
 * возвращает ассоциативный массив с данными из базы 
 * 
 * @method array|false getData(int itenmsPerPage)
 * @method int getTotalPages()
 * @method int getItamsPerPage()
 * 
 * @author Zmanovskaya Elena
 */

class Paginator
{
    private DbConnection $connection;

   
    private int $totalItems;
    private int $totalPages;
  

    public function __construct(private int $itemsPerPage, private string $tableName)
    {
        $this->connection = new DbConnection();
        try {
            $pdo = $this->connection->connect();
            $result = $pdo->query("SELECT COUNT(*) FROM {$this->tableName}")->fetch();
            $this->totalItems = (int)$result[0];
        } catch (ConnectionFailedException $e) {      
            $message = PHP_EOL . $e->getMessage() . ' with code ' . $e->getCode();
            error_log($message, 3, APP_DIR.'error-log.php');   
        }   catch (PDOException $e) {
            $message = PHP_EOL . $e->getMessage() . ' with code ' . $e->getCode();
            error_log($message, 3, APP_DIR.'error-log.php');
            return false;
        }
       
        $pdo = null;
    }

    /**
     * Метод рассчитывает количесво страниц для пагинации
     */
    public function getTotalPages() : int
    {
        $this->totalPages = ceil($this->totalItems / $this->itemsPerPage);
        return $this->totalPages;
    }

    /**
     * Метод возвращает количество элементов на странице
     */    
    public function getItemsPerPage() : int
    {
        return $this->itemsPerPage;
    }

   /**
    * Метод формирует содержимое страницы 

    */
    /**
     * Метод формирует содержимое страницы 
     * 
     * @throws PDOException
     * @throws ConnectionFailedException
     */
    public function getData(int $currentPage): array| false
    {
        try {
            $offset = ($currentPage - 1) * $this->itemsPerPage;
            $pdo = $this->connection->connect();
            $stmt = $pdo->prepare("SELECT * FROM {$this->tableName} LIMIT " . $offset . "," . $this->itemsPerPage);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            $message = PHP_EOL . $e->getMessage() . ' with code ' . $e->getCode();
            error_log($message, 3, APP_DIR.'error-log.php');
            return false;
        }  catch (ConnectionFailedException $e) {
            $pdo = null;
            $_SESSION['connection_error_message'] = $e->getMessage();
            header("Location: error-page.php");
      
        }
    }
}

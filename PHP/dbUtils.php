<?php
class DBUtils
{
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'labphp456';
    private $charset = 'utf8';
    private $pdo = null;
    private $error;

    public function __construct($databaseName)
    {
        $this->database = $databaseName;
        $dsn = "mysql:host={$this->host};dbname={$this->database};charset={$this->charset}";

        try {
            $this->pdo = new PDO($dsn, $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            die("Connection failed: " . $this->error);
        }
    }

    public function getPDO()
    {
        return $this->pdo;
    }

    public function closeConnection()
    {
        $this->pdo = null;
    }

    public function getError()
    {
        return $this->error;
    }

    public function select($table, $fields, $where)
    {
        $sql = "SELECT $fields FROM $table WHERE $where";
        echo "<script>console.log('".$sql."')</script>";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert($table, $fields, $values)
    {
        $sql = "INSERT INTO $table ($fields) VALUES ($values)";
        if ($this->pdo->query($sql)) {
            return "New record created successfully";
        } else {
            return "Error: " . $sql . "<br>" . $this->pdo->errorInfo()[2];
        }
    }
}
?>



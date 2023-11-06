#Votation System

## By Camarg0vs

### Connecction with database:

```php
<?php
    ini_set("display_errors", 1);
    error_reporting(E_ALL);

    $hostname = 'localhost';
    $user = 'root';
    $password = ''; // Senha local :)
    $database = 'eleicao';

    $conn = mysqli_connect($hostname, $user, $password, $database);

    if (!$conn) {
        die("Conexão falhou: " . mysqli_connect_error());
    }
?>
```
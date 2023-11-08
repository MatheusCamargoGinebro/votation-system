# Votation System <sub> By Camarg0vs</sub>

### Connecction with database:
> [!IMPORTANT]
> Para o sistema funcionar, deve-se criar o arquivo ``./php/connection.php``.
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

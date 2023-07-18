<?php

$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
}

$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'], '/'));
$input = json_decode(file_get_contents('php://input'), true);

// GET
if ($method == 'GET' && $request[0] == 'api' && $request[1] == 'products') {
    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $rows = array();
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        echo json_encode($rows);
    } else {
        echo "Список товаров пуст.";
    }
}

// GET/ID
if ($method == 'GET' && $request[0] == 'api' && $request[1] == 'products' && isset($request[2])) {
    $product_id = $request[2];
    $sql = "SELECT * FROM products WHERE id = $product_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row);
    } else {
        echo "Товар не найден.";
    }
}

// POST
if ($method == 'POST' && $request[0] == 'api' && $request[1] == 'products') {
    $name = $input['name'];
    $price = $input['price'];

    $sql = "INSERT INTO products (name, price) VALUES ('$name', $price)";

    if ($conn->query($sql) === TRUE) {
        echo "Новый товар успешно добавлен.";
    } else {
        echo "Ошибка при добавлении товара: " . $conn->error;
    }
}

// PUT
if ($method == 'PUT' && $request[0] == 'api' && $request[1] == 'products' && isset($request[2])) {
    $product_id = $request[2];
    $name = $input['name'];
    $price = $input['price'];

    $sql = "UPDATE products SET name='$name', price=$price WHERE id = $product_id";

    if ($conn->query($sql) === TRUE) {
        echo "Товар успешно обновлен.";
    } else {
        echo "Ошибка при обновлении товара: " . $conn->error;
    }
}

// DELETE
if ($method == 'DELETE' && $request[0] == 'api' && $request[1] == 'products' && isset($request[2])) {
    $product_id = $request[2];

    $sql = "DELETE FROM products WHERE id = $product_id";

    if ($conn->query($sql) === TRUE) {
        echo "Товар успешно удален.";
    } else {
        echo "Ошибка при удалении товара: " . $conn->error;
    }
}

$conn->close();


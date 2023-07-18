<?php
$dbFile = 'guestbook.db';

$db = new SQLite3($dbFile);

$query = "CREATE TABLE IF NOT EXISTS messages (
id INTEGER PRIMARY KEY AUTOINCREMENT,
name TEXT,
message TEXT,
timestamp DATETIME DEFAULT CURRENT_TIMESTAMP
)";
$db->exec($query);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $message = $_POST['message'] ?? '';

    if (!empty($message)) {
        $query = "INSERT INTO messages (name, message) VALUES (:name, :message)";
        $statement = $db->prepare($query);
        $statement->bindValue(':name', $name);
        $statement->bindValue(':message', $message);

        $statement->execute();
    }
}

$query = "SELECT * FROM messages ORDER BY timestamp DESC";
$result = $db->query($query);

while ($row = $result->fetchArray()) {
    $id = $row['id'];
    $name = $row['name'] ?: 'Аноним';
    $message = $row['message'];
    $timestamp = $row['timestamp'];

    echo "<div>
<p>Имя: $name</p>
<p>Сообщение: $message</p>
<p>Дата: $timestamp</p>
</div>";
}

$db->close();
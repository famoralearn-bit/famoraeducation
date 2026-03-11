<?php
require_once '../config/config.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

header('Content-Type: application/json');

$user_id = $_SESSION['user_id'];
update_last_seen($user_id);

$result = $conn->query("SELECT id, last_seen FROM users WHERE id != $user_id");
$users  = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $users[] = [
            'id'        => $row['id'],
            'is_online' => is_user_online($row['last_seen'])
        ];
    }
}

echo json_encode([
    'users'        => $users,
    'discord_link' => get_discord_link()
]);

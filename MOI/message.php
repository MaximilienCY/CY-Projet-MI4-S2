<?php
session_start();
$user_id_session = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

if (!$user_id_session) {
    header("Location: connexion.php");
    exit;
}

include 'messagerie.php';

$users = getUsers();
$messages = receiveMessages($user_id_session);

$selected_conversation = [];
$conversation_with = null; // Initialisation de la variable
if (isset($_GET['conversation_with'])) {
    $conversation_with = $_GET['conversation_with'];
    $selected_conversation = getConversation($user_id_session, $conversation_with);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['send'])) {
        $to = $_POST['to'];
        $message = $_POST['message'];

        $isValidRecipient = false;
        foreach ($users as $user) {
            if ($user['id'] === $to) {
                $isValidRecipient = true;
                break;
            }
        }

        if ($isValidRecipient) {
            sendMessage($user_id_session, $to, $message);
            // Actualiser les messages après l'envoi
            $messages = receiveMessages($user_id_session);
        } else {
            echo "Invalid recipient.";
        }
    } elseif (isset($_POST['report'])) {
        reportMessage($_POST['index'], $_POST['reason']);
    } elseif (isset($_POST['block'])) {
        blockUser($user_id_session, $_POST['blocked_user']);
    } elseif (isset($_POST['delete'])) {
        deleteMessage($_POST['index']);
    }
}

function getConversation($user1, $user2) {
    $messages = file('messages.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    $conversation = [];
    foreach ($messages as $message) {
        $message_data = explode('|', $message);
        if (($message_data[0] == $user1 && $message_data[1] == $user2) || ($message_data[0] == $user2 && $message_data[1] == $user1)) {
            $conversation[] = [
                'from' => $message_data[0],
                'to' => $message_data[1],
                'message' => $message_data[2],
                'timestamp' => $message_data[3]
            ];
        }
    }

    // Tri des messages par timestamp (du plus ancien au plus récent)
    usort($conversation, function($a, $b) {
        return strtotime($a['timestamp']) - strtotime($b['timestamp']);
    });

    return $conversation;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Messagerie</title>
    <link rel="stylesheet" type="text/css" href="messagerie.css">
</head>
<body>
<header>
    <nav class="navbar">
        <a href="index.php" class="logo">Infinity Love<span>.</span></a>
        <ul class="menu-links">
            <li><a href="index.php#hero-section">Accueil</a></li> 
            <li><a href="index.php#features">Offres</a></li>
            <li><a href="recherche.php">Recherche</a></li>
        </ul>
        <div class="auth-buttons">
            <?php
            if (isset($_SESSION['user_type']) && $_SESSION['user_type'] !== 'visiteur') {
                echo '<button onclick="window.location.href=\'index.php?action=logout\'">Déconnexion</button>';
            } else {
                echo '<button onclick="window.location.href=\'inscription.php\'">Inscription</button>';
                echo '<button onclick="window.location.href=\'connexion.php\'">Connexion</button>';
            }
            ?>
        </div>
    </nav>
</header>

<div class="container">
    <div class="directory">
        <h2>Annuaire</h2>
        <ul>
            <?php foreach ($users as $user): ?>
                <li><?= htmlspecialchars($user['pseudo']) . " (" . htmlspecialchars($user['id']) . ")" ?></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="messages">
        <h2>Messages</h2>
        <?php foreach ($messages as $index => $message): ?>
            <div class="message">
                <strong>From:</strong> <?= htmlspecialchars($message['from']) ?><br>
                <strong>To:</strong> <?= htmlspecialchars($message['to']) ?><br>
                <strong>Message:</strong> <?= nl2br(htmlspecialchars($message['message'])) ?><br>
                <strong>Time:</strong> <?= htmlspecialchars($message['timestamp']) ?><br>
                <form method="post">
                    <input type="hidden" name="index" value="<?= htmlspecialchars($index) ?>">
                    <input type="submit" name="delete" value="Delete">
                    <input type="text" name="reason" placeholder="Enter report reason">
                    <input type="submit" name="report" value="Report">
                    <input type="hidden" name="blocked_user" value="<?= htmlspecialchars($message['from']) ?>">
                    <input type="submit" name="block" value="Block">
                </form>
                <a href="?conversation_with=<?= htmlspecialchars($message['from'] === $user_id_session ? $message['to'] : $message['from']) ?>">View Conversation</a>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if ($selected_conversation): ?>
        <div class="conversation">
            <h2>Conversation with <?= htmlspecialchars($conversation_with) ?></h2>
            <?php foreach ($selected_conversation as $conv_message): ?>
                <div class="message">
                    <strong>From:</strong> <?= htmlspecialchars($conv_message['from']) ?><br>
                    <strong>To:</strong> <?= htmlspecialchars($conv_message['to']) ?><br>
                    <strong>Message:</strong> <?= nl2br(htmlspecialchars($conv_message['message'])) ?><br>
                    <strong>Time:</strong> <?= htmlspecialchars($conv_message['timestamp']) ?><br>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="new-message">
        <h2>Send a Message</h2>
        <form method="post">
            From: <input type="text" name="from" value="<?= htmlspecialchars($user_id_session) ?>" readonly><br>
            To: <input type="text" name="to" placeholder="Enter recipient's user ID"><br>
            Message: <textarea name="message"></textarea><br>
            <input type="submit" name="send" value="Send">
        </form>
    </div>
</div>

</body>
</html>


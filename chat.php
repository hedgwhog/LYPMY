<?php
	require './db/config.php';
    require './db/boot.php';

    $data = sql(false, 'SELECT * FROM groups WHERE groupID = :ID;', [
        'ID' => $_GET['group'] ?? 0
    ]);

    $invites = sql(true, 'SELECT * FROM invite WHERE user = :USER AND accept = TRUE;', [
        'USER' => $_SESSION['user']['user']
    ]);

    $_SESSION['group'] = (int)$_GET['group'];

    if (!$data || ($data['owner'] != $_SESSION['user']['userID'] && count($invites) <= 0)) {
        header('location: ./groups.php');
        exit();
    }

    $members = sql(true, 'SELECT * FROM invite WHERE by = :BY AND accept = TRUE;', [
        'BY' => $data['name']
    ]);

    $weekno = (string)@strftime('%W%Y');
    $weekno2 = (string)@strftime('%W%Y', strtotime('+1 week'));

    $images = sql(true, 'SELECT * FROM image WHERE groups = :GROUP AND stamp = :WEEK', [
        'GROUP' => $data['name'],
        'WEEK' => $weekno
    ]);

    $collages = [];
    foreach ($images as $table) {
        $collages[$table['by']][] = $table;
    }

    // var_dump($collages);

    // var_dump($members);
    // var_dump($invites);
    foreach ($invites as $idx => $invite) {
        if ($invite['user'] == $_SESSION['user']['user'] and $invite['by'] == $data['name']) {
            echo '<hr><i>' . $invite['ban'] . '</i>';
            if (((string)$invites[0]['ban'] ?? '0') == $weekno) {
                echo "<h1>banned</h1>";
                // header('location: groups.php');
            }
        }
    }

    // echo '<br><br>' . $invites[0]['ban'];
    
?>

<h3>
    <?= $data['name'] ?>
</h3>
<p>
    <?= $data['desc'] ?>
</p>

<fieldset id="chat">

</fieldset>
<input type="text" id="sendchat" placeholder="Start Typing">
<button onclick="sendchat()">Send</button>

<script src="./js/chat.js"></script>

<br><button onclick="window.location = './groups.php'">Bak</button>

<ul>
    <li>
        (Owner) <?= id2user($data['owner']) ?>
    </li>
    <?php
        foreach ($members as $member) {
            if (!$member['accept']) {
    ?>
                <li>
                    <?= $member['co'] == 1 ? '(CO)' : '' ?>
                    <?= $member['user'] ?>
                </li>
    <?php
            }
        }
    ?>
</ul>

Debug weekno: <b><?= $weekno ?></b>

<?php foreach ($collages as $owner => $collage) { ?>
    <fieldset>
        <legend><?= $owner ?>'s collage</legend>
        <?php foreach ($collage as $image) { ?>
            <img src="./db/images/<?= $image['img'] ?>" width="100">
        <?php } ?>
    </fieldset>
<?php } ?>
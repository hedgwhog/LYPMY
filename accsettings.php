<?php
   require './db/config.php';
   require './db/boot.php';
?>

<form action="./db/accounthandle.php" method="POST">
   <input type="text" name="name" value="<?= $_SESSION['user']['user'] ?>">
   <input type="text" name="display" value="<?= $_SESSION['user']['display'] ?>">
   <input type="password" name="pass" value="<?= $_SESSION['user']['dehash'] ?>">

   <button type="submit" name="method" value="update">Confirm changes</button>
   <button type="button" onclick="window.location = './db/accounthandle.php?logout=Arf Arf :3'">Logout</button>
</form>

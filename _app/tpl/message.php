<?php
if (@$_SESSION['message']) {
  $class = $_SESSION['message']['class'];
  $text  = $_SESSION['message']['text'];
?>

<input type="checkbox" id="message_close">
<div class="message <?= $class ?>">
    <label for="message_close">&#9746;</label>
    <?= $text ?>
</div>

<? }

unset($_SESSION['message']);
?>

<h1>Edit page</h1>
<? //dump($GLOBALS['meta']) ?>

<form class="edit" action="" method="post">
  <div>
    <label>Page Title:</label>
    <input type="text" id="title" name="title" placeholder="Page Title" required="required"
           value="<?= @$GLOBALS['meta']['title'] ?>">
  </div>

  <div>
    <label>SEF URL:</label>
    <input type="text" id="url" name="url" placeholder="Search engine friendly URL" readonly="readonly"
           value="<?= @$GLOBALS['sef'] ?>">
  </div>

  <div>
    <label>Author:</label>
    <input type="text" id="author" name="author" placeholder="Author"
           value="<?= @$GLOBALS['meta']['author'] ?>">
  </div>

  <div>
    <label>Publish date:</label>
    <input type="text" id="date" name="date" placeholder="Publish date"
           value="<?= @$GLOBALS['meta']['date'] ?>">
  </div>

  <div>
    <label>Keywords:</label>
    <input type="text" id="keywords" name="keywords" placeholder="Keywords"
           value="<?= @$GLOBALS['meta']['keywords'] ?>">
  </div>

  <div>
    <label>Description:</label>
    <input type="text" id="description" name="description" placeholder="Short description"
           value="<?= @$GLOBALS[meta]['description'] ?>">
  </div>

  <div>
    <label>Page Content:</label>
  </div>

  <textarea id="editbox" name="content" class="edit" required="required"><?= htmlspecialchars(content()) ?></textarea>

  <div class="center">

    <div class="center" style="margin-top: 1em;">
        <button type="submit">Save Changes</button>
        <a class="button" href="<?= URL . ITEM ?>/">Cancel</a>
<!--
        <a class="float-right" target="_blank" href="/help/">Help with editing</a>
-->
    </div>

  </div>
</form>

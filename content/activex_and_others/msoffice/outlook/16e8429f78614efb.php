<h1>How to check for unsent email</h1>
<div class="date">01.01.2007</div>


<pre class="delphi">
var
    Outbox: MAPIFolder;
    UnsentMail: integer;
  ...
    Outbox := NmSpace.GetDefaultFolder(olFolderOutbox);
    UnsentMail := Outbox.Items.Count;
    if (UnsentMail &gt; 0) then
      ShowMessage(Format('Unsent items in Outbox: %d', [UnsentMail]));
</pre>
<p>The constant olFolderOutbox is defined in Outlook_TLB as $00000004</p>

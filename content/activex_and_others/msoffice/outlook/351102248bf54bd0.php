<h1>How to check for unread email</h1>
<div class="date">01.01.2007</div>


<pre>
var
    Inbox: MAPIFolder;
    NewMail: boolean;
  ...
    Inbox := NmSpace.GetDefaultFolder(olFolderInbox);
    NewMail := (Inbox.UnreadItemCount &gt; 0);
    if NewMail then
      ShowMessage(Format('Unread items in Inbox: %d', [Inbox.UnreadItemCount]));
</pre>

<p>The constant olFolderInbox is defined in Outlook_TLB as $00000006.</p>

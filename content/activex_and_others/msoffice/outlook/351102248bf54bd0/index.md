---
Title: How to check for unread email
Date: 01.01.2007
---


How to check for unread email
=============================

::: {.date}
01.01.2007
:::

    var
        Inbox: MAPIFolder;
        NewMail: boolean;
      ...
        Inbox := NmSpace.GetDefaultFolder(olFolderInbox);
        NewMail := (Inbox.UnreadItemCount > 0);
        if NewMail then
          ShowMessage(Format('Unread items in Inbox: %d', [Inbox.UnreadItemCount]));

The constant olFolderInbox is defined in Outlook\_TLB as \$00000006.

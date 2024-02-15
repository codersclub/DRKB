---
Title: Как проверить непрочитанную почту
Date: 01.01.2007
ID: 04454
---


Как проверить непрочитанную почту
=============================

How to check for unread email?

    var
        Inbox: MAPIFolder;
        NewMail: boolean;
      ...
        Inbox := NmSpace.GetDefaultFolder(olFolderInbox);
        NewMail := (Inbox.UnreadItemCount > 0);
        if NewMail then
          ShowMessage(Format('Unread items in Inbox: %d', [Inbox.UnreadItemCount]));

The constant olFolderInbox is defined in Outlook\_TLB as $00000006.

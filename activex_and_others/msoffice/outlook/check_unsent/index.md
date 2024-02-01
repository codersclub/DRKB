---
Title: Как проверить неотправленную почту
Date: 01.01.2007
---


Как проверить неотправленную почту
=============================

How to check for unsent email

```
var
  Outbox: MAPIFolder;
  UnsentMail: integer;
begin
  Outbox := NmSpace.GetDefaultFolder(olFolderOutbox);
  UnsentMail := Outbox.Items.Count;
  if (UnsentMail > 0) then
    ShowMessage(Format('Unsent items in Outbox: %d', [UnsentMail]));
end;
```

The constant olFolderOutbox is defined in Outlook\_TLB as $00000004

---
Title: How to check for unsent email
Date: 01.01.2007
---


How to check for unsent email
=============================

::: {.date}
01.01.2007
:::

    var
        Outbox: MAPIFolder;
        UnsentMail: integer;
      ...
        Outbox := NmSpace.GetDefaultFolder(olFolderOutbox);
        UnsentMail := Outbox.Items.Count;
        if (UnsentMail > 0) then
          ShowMessage(Format('Unsent items in Outbox: %d', [UnsentMail]));

The constant olFolderOutbox is defined in Outlook\_TLB as $00000004

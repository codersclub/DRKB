---
Title: How to list all reports and forms
Date: 01.01.2007
---


How to list all reports and forms
=================================

::: {.date}
01.01.2007
:::

Once you\'ve opened a database, you can use the Access application\'s
Reports and Forms properties to list the open reports and forms:

     for i := 0 to Access.Reports.Count - 1 do
        Memo1.Lines.Add(Access.Reports[i].Name);
     for i := 0 to Access.Forms.Count - 1 do
        Memo1.Lines.Add(Access.Forms[i].Name);

But note that these properties return only the open reports and forms in
a database. To get the closed ones you have to use DAO97.pas (or
DAO\_TLB.pas for Delphi 4) and access the Documents collection:

    uses DAO97;
    var
      i: integer;
      Cont: Container;
    begin
      Cont := Access.CurrentDB.Containers.Item['Reports'];
      for i := 0 to Cont.Documents.Count - 1 do
        Memo1.Lines.Add(Cont.Documents[i].Name);
      Cont := Access.CurrentDB.Containers.Item['Forms'];
      for i := 0 to Cont.Documents.Count - 1 do
        Memo1.Lines.Add(Cont.Documents[i].Name);

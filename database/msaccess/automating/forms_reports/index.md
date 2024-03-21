---
Title: Как получить список всех отчетов и форм
Date: 01.01.2007
---


Как получить список всех отчетов и форм
=================================

Открыв базу данных, вы можете использовать свойства «Отчеты и формы» приложения Access,
чтобы вывести список открытых отчетов и форм:

    for i := 0 to Access.Reports.Count - 1 do
       Memo1.Lines.Add(Access.Reports[i].Name);
    
    for i := 0 to Access.Forms.Count - 1 do
       Memo1.Lines.Add(Access.Forms[i].Name);

Но обратите внимание, что эти свойства возвращают только открытые отчеты и формы в базе данных.
Чтобы получить закрытые, вам нужно использовать DAO97.pas (или DAO\_TLB.pas для Delphi 4)
и получить доступ к коллекции документов:

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

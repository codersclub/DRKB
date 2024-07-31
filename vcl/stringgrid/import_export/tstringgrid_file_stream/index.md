---
Title: TStringGrid и файловый поток
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


TStringGrid и файловый поток
============================

> Какое наилучшее решение для сохранения экземпляра TStringGrid (150x10)?

Если вы хотите сохранить это на диске:

    var:
      myStream: TFileStream;
    begin
      myStream1 := TFileStream.Create('grid1.sav', fmCreate);
      myStream1.WriteComponent(StringGrid1);
      myStream1.Destroy;
    end;
     
    //Для обратного чтения:
     
     
    myStream    := TFileStream.Create('grid1.sav', fmOpenRead);
    StringGrid1 := myStream1.ReadComponent(StringGrid1) as TStringGrid;


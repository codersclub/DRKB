---
Title: Как сохранить RTF в TBlobField?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как сохранить RTF в TBlobField?
===============================

В этом примере поле \'Table1Memo\' это paradox \'formatted memo\'. Оно
так же может быть полем blob.

Через TBlobStream содержимое контрола RichEdit можно загружать или
сохранять в базу данных:

    procedure TForm1.BtnGetClick(Sender: TObject); 
    var 
      bs: TBlobStream; 
    begin 
      bs:= Nil; 
      with Table1 Do 
        try 
          open; 
          first; 
          bs:= TBlobStream.Create( table1memo, bmread ); 
          Richedit1.plaintext := false; 
          Richedit1.Lines.Loadfromstream(bs); 
        finally 
          bs.free; 
          close; 
        end; 
    end; 
     
    procedure TForm1.BtnPutClick(Sender: TObject); 
    var 
      bs: TBlobStream; 
    begin 
      bs:= Nil; 
      with Table1 Do 
        try 
          open; 
          first; 
          edit; 
          bs:= TBlobStream.Create( table1memo, bmwrite ); 
          Richedit1.plaintext := false; 
          Richedit1.Lines.Savetostream(bs); 
          post; 
        finally 
          bs.free; 
          close; 
        end; 
    end;


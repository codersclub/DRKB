---
Title: Как текст из TRXRichEdit сохранить в RTF формате?
Author: Vit
Date: 01.01.2007
---


Как текст из TRXRichEdit сохранить в RTF формате?
=================================================

::: {.date}
01.01.2007
:::

    procedure TForm1.Button1Click(Sender: TObject);

     
      var t:TFileStream;
    begin
      t:=TFileStream.create('c:\myfilename.txt', fmCreate or fmOpenWrite);
      t.Size:=0;
      RxRichEdit1.Lines.SaveToStream(t);
      t.free;
    end;

Автор: Vit

Взято с Vingrad.ru <https://forum.vingrad.ru>

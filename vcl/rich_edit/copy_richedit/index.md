---
Title: Как скопировать содержимое одного TRichEdit в другой?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как скопировать содержимое одного TRichEdit в другой?
=====================================================

TMemoryStream - это самый простой инструмент взаимодействия между всеми
VCL компонентами:

    procedure TForm1.Button1Click(Sender: TObject);
    var
      MemoryStream:TMemoryStream;
    begin
      MemoryStream:=TMemoryStream.Create;
      try
        RichEdit1.Lines.SaveToStream(MemoryStream);
        MemoryStream.Seek(0,soFromBeginning);
        RichEdit2.Lines.LoadFromStream(MemoryStream);
      finally
        MemoryStream.Free;
      end;
    end;


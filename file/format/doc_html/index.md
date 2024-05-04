---
Title: Конвертирование DOC -> HTML
Author: jack128
Date: 01.01.2007
Source: <https://forum.sources.ru>
---

Конвертирование DOC -> HTML
===========

    var
      fname: string;
      WordAppl, WordDoc: OleVariant;
    begin
      with TOpenDialog.Create(nil) do
      try
        Filter := 'word documents (*.doc)|*.doc';
        if not Execute then Exit;
        fname := FileName;
      finally
        Free;
      end;
      WordAppl := CreateOleObject('Word.Application');
      try
        WordDoc := WordAppl.Documents.Open(fname);
        fname := ExtractFilePath(fname) + 'test.htm';
        WordDoc.SaveAs(FileName := fname, FileFormat := wdFormatHTML);
      finally
        WordAppl.Quit;
      end;
    end;


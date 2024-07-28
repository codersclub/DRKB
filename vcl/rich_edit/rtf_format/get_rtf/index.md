---
Title: Как получить RTF-текст из TRichEdit?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Как получить RTF-текст из TRichEdit?
====================================

    function GetRTFText(ARichEdit: TRichedit): string;
     var
       ss: TStringStream;
       emptystr: string;
     begin
       emptystr := '';
       ss := TStringStream.Create(emptystr);
       try
         ARichEdit.PlainText := False;
         ARichEdit.Lines.SaveToStream(ss);
         Result := ss.DataString;
       finally
         ss.Free
       end;
     end;
     
     
     procedure TForm1.Button1Click(Sender: TObject);
     begin
       Memo1.Text := GetRTFText(RichEdit1);
     end;


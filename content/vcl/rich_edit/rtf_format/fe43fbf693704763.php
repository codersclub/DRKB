<h1>Как получить RTF-текст из TRichEdit?</h1>
<div class="date">01.01.2007</div>


<pre>
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
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>

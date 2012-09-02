<h1>Как сохранить исходник HTML из TWebBrowser.Document на диск?</h1>
<div class="date">01.01.2007</div>


<p>TWebBrowser.Document включает в себя IPersistStreamInit который содержит метод Save(). Всё, что нам нужно знать, это как использовать данный метод с объектом, который включён в IStream. Для этого мы просто воспользуемся TStreamAdapter.</p>
<p>Обратите внимание, что интерфейсы IPersistStreamInit и IStream объявлены внутри ActiveX unit.</p>
<p>Итак, вот так это выглядит.</p>
<pre>
procedure TForm1.SaveHTMLSourceToFile(const FileName: string; 
  WB: TWebBrowser); 
var 
  PersistStream: IPersistStreamInit; 
  FileStream: TFileStream; 
  Stream: IStream; 
  SaveResult: HRESULT; 
begin 
  PersistStream := WB.Document as IPersistStreamInit; 
  FileStream := TFileStream.Create(FileName, fmCreate); 
  try 
    Stream := TStreamAdapter.Create(FileStream, soReference) as IStream; 
    SaveResult := PersistStream.Save(Stream, True); 
    if FAILED(SaveResult) then 
      MessageBox(Handle, 'Fail to save HTML source', 'Error', 0); 
  finally 
    { В ответ на уничтожение объекта TFileStream, передаём
      soReference в конструктор TStreamAdapter. } 
    FileStream.Free; 
  end; 
end; 
 
procedure TForm1.Button1Click(Sender: TObject); 
begin 
  if SaveDialog1.Execute then 
    SaveHTMLSourceToFile(SaveDialog1.FileName, WebBrowser1); 
end; 
</pre>

<p>А как сохранить вместе с исходником все файлы (.CSS, JPG, GIF Etc..) ?</p>
<pre>try 
  WebBrowser1.ExecWB(4, 0); 
except 
  on E: Exception do  msError:=true; 
end; 
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

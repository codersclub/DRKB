<h1>Загрузка JPEG из ресурсов</h1>
<div class="date">01.01.2007</div>


<pre>
uses Jpeg;
{$R test.res}
 
function LoadJpegRes(const ID: string): TJpegImage;
var
  RS: TResourceStream;
begin
  Result := TJpegImage.Create;
  RS := TResourceStream.Create(HInstance, ID, RT_RCDATA);
  try
    RS.Seek(0, soBeginning);
    Result.LoadFromStream(RS);
  finally
    RS.Free;
  end;
end;
 
procedure TForm1.Button1Click(Sender: TObject);
var
  MyJpeg: TJpegImage;
begin
  MyJpeg := LoadJpegRes('MYJPEG');
  Image1.Canvas.Draw(0, 0, MyJpeg);
end;
</pre>
<p>&nbsp;<br>
Для JPEG, загнанного в ресурсы таким образом:<br>
&nbsp;<br>
<p>&nbsp;</p>
<pre>
MYJPEG RCDATA "Test.jpg" 
</pre>
<p>&nbsp;<br>
&nbsp;<br>
<p class="author">Автор: Smike</p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

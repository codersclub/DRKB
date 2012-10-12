<h1>Как загрузить BMP файл из DLL?</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Button1Click(Sender: TObject);

var
  AModule: THandle;
begin
  AModule := LoadLibrary('Images.dll');
  image1.Picture.BitMap.LoadFromResourceName(AModule, 'StartMine');
  FreeLibrary(AModule);
end;
</pre>
<p class="author">Автор: Baa</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

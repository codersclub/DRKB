<h1>Как поместить JPEG-картинку в exe-файл и потом загрузить её?</h1>
<div class="date">01.01.2007</div>



<p>1)Создайте текстовый файл с расширением ".rc".Имя этого файла должно отличаться</p>
<p>от имени файла - пректа или любого модуля проекта.</p>
<p>Файл должен содержать строку вроде: MYJPEG JPEG C: \DownLoad\MY.JPG</p>
<p>где:</p>
<p>"MYJPEG" имя ресурса</p>
<p>"JPEG" пользовательский тип ресурса</p>
<p>"C: \DownLoad\MY.JPG" руть к JPEG файлу.</p>

<p>Пусть например rc - файл называется "foo.rc"</p>

<p>Запустите BRCC32.exe(Borland Resource CommandLine Compiler) - программа находится</p>
<p>в каталоге Bin Delphi / C + +Builder'а - передав ей в качестве параметра полный путь</p>
<p>к rc - файлу.</p>
<p>В нашем примере:</p>

<p>C: \DelphiPath\BIN\BRCC32.EXE C: \ProjectPath\FOO.RC</p>
<p>Вы получите откомпилированный ресурс - файл с расширением ".res".</p>
<p>(в нашем случает foo.res).</p>
<p>Далее добавте ресурс к своему приложению.</p>
<pre>
{Грузим ресурс}
{$R FOO.RES}
 
uses Jpeg;
 
procedure LoadJPEGFromRes(TheJPEG: string; ThePicture: TPicture);
var
  ResHandle: THandle;
  MemHandle: THandle;
  MemStream: TMemoryStream;
  ResPtr: PByte;
  ResSize: Longint;
  JPEGImage: TJPEGImage;
begin
  ResHandle := FindResource(hInstance, PChar(TheJPEG), 'JPEG');
  MemHandle := LoadResource(hInstance, ResHandle);
  ResPtr := LockResource(MemHandle);
  MemStream := TMemoryStream.Create;
  JPEGImage := TJPEGImage.Create;
  ResSize := SizeOfResource(hInstance, ResHandle);
  MemStream.SetSize(ResSize);
  MemStream.Write(ResPtr^, ResSize);
  FreeResource(MemHandle);
  MemStream.Seek(0, 0);
  JPEGImage.LoadFromStream(MemStream);
  ThePicture.Assign(JPEGImage);
  JPEGImage.Free;
  MemStream.Free;
end;
 
procedure TForm1.Button1Click(Sender: TObject);
begin
  LoadJPEGFromRes('MYJPEG', Image1.Picture);
end;
</pre>


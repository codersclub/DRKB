<h1>Загрузка bitmap из .res без потери палитры</h1>
<div class="date">01.01.2007</div>


<pre>
procedure loadgraphic(naam:string);
var
  HResInfo: THandle;
  BMF: TBitmapFileHeader;
  MemHandle: THandle;
  Stream: TMemoryStream;
  ResPtr: PByte;
  ResSize: Longint;
  null:array [0..8] of char;
begin
  strpcopy (null, naam);
  HResInfo := FindResource(HInstance, null, RT_Bitmap);
  ResSize := SizeofResource(HInstance, HResInfo);
  MemHandle := LoadResource(HInstance, HResInfo);
  ResPtr := LockResource(MemHandle);
  Stream := TMemoryStream.Create;
  try
    Stream.SetSize(ResSize + SizeOf(BMF));
    BMF.bfType := $4D42;
    Stream.write(BMF, SizeOf(BMF));
    Stream.write(ResPtr^, ResSize);
    Stream.Seek(0, 0);
    Bitmap:=tbitmap.create;
    Bitmap.LoadFromStream(Stream);
  finally
    Stream.Free;
  end;
  FreeResource(MemHandle);
end;
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

<h1>Загрузка 256-цветного TBitmap</h1>
<div class="date">01.01.2007</div>


<div class="author">Автор: Steve Schafer</div>

<p>Windows не очень полезен, когда мы имеем дело с 256-цветными изображениями. Что делаю я (поскольку думаю, что это самый простой метод): я создаю в памяти изображение таким образом, чтобы TBitmap.LoadFromStream мог "принять" его. Данным методом я загружаю "сырой" ресурс изображения и размещаю его, используя инфорационный заголовок файла изображения. Вот потомок TBitmap, инкапсулирующий вышесказанное:</p>

<pre>
type
  TMyBitmap = class(TBitmap)
  public
    procedure Load256ColorBitmap(Instance: THandle; BitmapName: PChar);
  end;
 
procedure TMyBitmap.Load256ColorBitmap(Instance: THandle;
  BitmapName: PChar);
var
  HDib: THandle;
  Size: LongInt;
  Info: PBitmapInfo;
  FileHeader: TBitmapFileHeader;
  S: TMemoryStream;
begin
  HDib := LoadResource(Instance, FindResource(Instance, BitmapName,
    RT_BITMAP));
  if HDib &lt;&gt; 0 then
  begin
    Info := LockResource(HDib);
    Size := GetSelectorLimit(Seg(Info^)) + SizeOf(TBitmapFileHeader);
    with FileHeader do
    begin
      bfType := $4D42;
      bfSize := Size;
      bfReserved1 := 0;
      bfReserved2 := 0;
      bfOffBits := SizeOf(TBitmapFileHeader) + SizeOf(TBitmapInfoHeader);
      case Info^.bmiHeader.biBitCount of
        1: bfOffBits := bfOffBits + 2 * 4;
        4: bfOffBits := bfOffBits + 16 * 4;
        8: bfOffBits := bfOffBits + 256 * 4;
      end;
    end;
    S := TMemoryStream.Create;
    try
      S.SetSize(Size);
      S.Write(FileHeader, SizeOf(TBitmapFileHeader));
      S.Write(Info^, Size - SizeOf(TBitmapFileHeader));
      S.Position := 0;
      LoadFromStream(S);
    finally
      S.Free;
      FreeResource(HDib);
    end;
  end
  else
    raise EResNotFound.Create(Format('Не могу найти ресурс изображения %s',
      [BitmapName]));
end;
</pre>


<p>Вот как можно это использовать:</p>
<pre>
Image1.Picture.Bitmap := TMyBitmap.Create;
TMyBitmap(Image1.Picture.Bitmap).Load256ColorBitmap(hInstance, 'BITMAP_1');
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

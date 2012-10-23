<h1>BMP &gt; ICO</h1>
<div class="date">01.01.2007</div>


<div class="author">Автор: Bernhard Angerer</div>

<p>Вам необходимо создать два битмапа, битмап маски (назовём его "AND" bitmap) и битмап изображения (назовём его XOR bitmap). Вы можете пропустить обработчики для "AND" и "XOR"&nbsp; битмапов в Windows API функции CreateIconIndirect() и использовать обработчик возвращённой иконки в Вашем приложении. </p>
<pre>
procedure TForm1.Button1Click(Sender: TObject); 
var 
  IconSizeX : integer; 
  IconSizeY : integer; 
  AndMask : TBitmap; 
  XOrMask : TBitmap; 
  IconInfo : TIconInfo; 
  Icon : TIcon; 
begin 
{Получаем размер иконки} 
  IconSizeX := GetSystemMetrics(SM_CXICON); 
  IconSizeY := GetSystemMetrics(SM_CYICON); 
 
{Создаём маску "And"} 
  AndMask := TBitmap.Create; 
  AndMask.Monochrome := true; 
  AndMask.Width := IconSizeX; 
  AndMask.Height := IconSizeY; 
 
{Рисуем на маске "And"} 
  AndMask.Canvas.Brush.Color := clWhite; 
  AndMask.Canvas.FillRect(Rect(0, 0, IconSizeX, IconSizeY)); 
  AndMask.Canvas.Brush.Color := clBlack; 
  AndMask.Canvas.Ellipse(4, 4, IconSizeX - 4, IconSizeY - 4); 
 
{Рисуем для теста} 
  Form1.Canvas.Draw(IconSizeX * 2, IconSizeY, AndMask); 
 
{Создаём маску "XOr"} 
  XOrMask := TBitmap.Create; 
  XOrMask.Width := IconSizeX; 
  XOrMask.Height := IconSizeY; 
 
{Рисуем на маске "XOr"} 
  XOrMask.Canvas.Brush.Color := ClBlack; 
  XOrMask.Canvas.FillRect(Rect(0, 0, IconSizeX, IconSizeY)); 
  XOrMask.Canvas.Pen.Color := clRed; 
  XOrMask.Canvas.Brush.Color := clRed; 
  XOrMask.Canvas.Ellipse(4, 4, IconSizeX - 4, IconSizeY - 4); 
 
{Рисуем в качестве теста} 
  Form1.Canvas.Draw(IconSizeX * 4, IconSizeY, XOrMask); 
 
{Создаём иконку} 
  Icon := TIcon.Create; 
  IconInfo.fIcon := true; 
  IconInfo.xHotspot := 0; 
  IconInfo.yHotspot := 0; 
  IconInfo.hbmMask := AndMask.Handle; 
  IconInfo.hbmColor := XOrMask.Handle; 
  Icon.Handle := CreateIconIndirect(IconInfo); 
 
{Уничтожаем временные битмапы} 
  AndMask.Free; 
  XOrMask.Free; 
 
{Рисуем в качестве теста} 
  Form1.Canvas.Draw(IconSizeX * 6, IconSizeY, Icon); 
 
{Объявляем иконку в качестве иконки приложения} 
  Application.Icon := Icon; 
 
{генерируем перерисовку} 
  InvalidateRect(Application.Handle, nil, true); 
 
{Освобождаем иконку} 
  Icon.Free; 
end; 
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

<hr />Способ преобразования изображения размером 32x32 в иконку. </p>
<pre>
unit main;
 
interface
 
uses
 
  Windows, Messages, SysUtils, Classes, Graphics, Controls,
  Forms, Dialogs, ExtCtrls, StdCtrls;
 
type
 
  TForm1 = class(TForm)
    Button1: TButton;
    Image1: TImage;
    Image2: TImage;
    procedure Button1Click(Sender: TObject);
    procedure FormCreate(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;
 
var
 
  Form1: TForm1;
 
implementation
 
{$R *.DFM}
 
procedure TForm1.Button1Click(Sender: TObject);
var
  winDC, srcdc, destdc: HDC;
 
  oldBitmap: HBitmap;
  iinfo: TICONINFO;
begin
 
  GetIconInfo(Image1.Picture.Icon.Handle, iinfo);
 
  WinDC := getDC(handle);
  srcDC := CreateCompatibleDC(WinDC);
  destDC := CreateCompatibleDC(WinDC);
  oldBitmap := SelectObject(destDC, iinfo.hbmColor);
  oldBitmap := SelectObject(srcDC, iinfo.hbmMask);
 
  BitBlt(destdc, 0, 0, Image1.picture.icon.width,
    Image1.picture.icon.height,
    srcdc, 0, 0, SRCPAINT);
  Image2.picture.bitmap.handle := SelectObject(destDC, oldBitmap);
  DeleteDC(destDC);
  DeleteDC(srcDC);
  DeleteDC(WinDC);
 
  image2.Picture.Bitmap.savetofile(ExtractFilePath(Application.ExeName)
    + 'myfile.bmp');
end;
 
procedure TForm1.FormCreate(Sender: TObject);
begin
 
  image1.picture.icon.loadfromfile('c:\myicon.ico');
end;
 
end.
</pre>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a>



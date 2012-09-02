<h1>Изменение глубины цвета изображения</h1>
<div class="date">01.01.2007</div>


<pre>
unit Unit1;
 

 
interface
 
uses
  Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms,
  Dialogs, StdCtrls;
 
type
  TForm1 = class(TForm)
    Button1: TButton;
    procedure Button1Click(Sender: TObject);
  public
    function ChangeColorDepth(const FromBMP: TBitmap; out ToBMP: TBitmap;
      const ColorDepth: TPixelFormat): Boolean;
  end;
 
var
  Form1: TForm1;
 
implementation
 
{$R *.dfm}
 
procedure TForm1.Button1Click(Sender: TObject);
var
  B24, B16: TBitmap;
begin
  B24 := TBitmap.Create;
  try
    B24.LoadFromFile('c:\1.bmp');
    if ChangeColorDepth(B24, B16, pf4bit) then
    try
      B16.SaveToFile('c:\2.bmp');
    finally
      B16.Free;
    end;
  finally
    B24.Free;
  end;
end;
 
function TForm1.ChangeColorDepth(const FromBMP: TBitmap;
  out ToBMP: TBitmap; const ColorDepth: TPixelFormat): Boolean;
begin
  Result := True;
  try
    ToBMP := TBitmap.Create;
    ToBMP.Width := FromBMP.Width;
    ToBMP.Height := FromBMP.Height;
    ToBMP.PixelFormat := ColorDepth;
    ToBMP.Canvas.Draw(0, 0, FromBMP);
  except
    if ToBMP &lt;&gt; nil then ToBMP.Free;
    Result := False;
  end;
end;
 
end.
</pre>

<p class="author">Автор Rouse_</p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

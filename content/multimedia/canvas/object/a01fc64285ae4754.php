<h1>Как отбрасывать тень от текста?</h1>
<div class="date">01.01.2007</div>

<p>Вот ещё одну функцию обнаружил DrawShadowText(...), которая позволяет отбрасывать тень от текста на hdc контексте. Большой минус состоит в том, что она появилась только в XP. Чтобы пример заработал, нужно в системной директории найти новую версию библиотеки comctl32.dll и скопировать её в папку с примером. У меня эта библиотека лежала в папке C:\WINDOWS\WinSxS\x86_Microsoft.Windows.Common-Controls_6595b64144ccf1df_6.0.0.0_x-ww_1382d70a</p>
<pre>
unit Unit1;
 
interface
 
uses
  Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
  Dialogs, ExtCtrls, StdCtrls, ComCtrls;
 
 
type
  TShadowText = function (dc       : HDC;
                          pszText  : PWideChar;
                          cch      : DWORD;
                          prc      : PRECT;
                          dwFlags  : DWORD;
                          crText   : TColor;
                          crShadow : TColor;
                          ixOffset : integer;
                          iyOffset : integer):integer;stdcall;
 
type
  TForm1 = class(TForm)
    Image1: TImage;
    TB_PosX: TTrackBar;
    TB_PosY: TTrackBar;
    Label1: TLabel;
    Label2: TLabel;
    procedure TB_PosXChange(Sender: TObject);
    procedure TB_PosYChange(Sender: TObject);
    procedure FormCreate(Sender: TObject);
    procedure FormDestroy(Sender: TObject);
  private
    lib           : THandle;
    DrawShadowText: TShadowText;
    procedure ShadowText;
  public
    { Public declarations }
  end;
 
var
  Form1: TForm1;
 
implementation
 
{$R *.dfm}
 
procedure TForm1.FormCreate(Sender: TObject);
begin
  lib:=LoadLibrary(PChar(GetCurrentDir+'\comctl32.dll'));
  if lib=0 then
     begin
       MessageBox(Handle, 'Библиотеки нет...', '!', MB_OK or MB_ICONERROR);
       exit;
     end;
  @DrawShadowText:=GetProcAddress(lib, 'DrawShadowText');
  if @DrawShadowText=nil then
     begin
       FreeLibrary(lib);
       MessageBox(Handle, 'Функции нет... не та библиотека!', '!', MB_OK or MB_ICONERROR);
       exit;
     end;
  ShadowText;
end;
 
procedure TForm1.ShadowText;
var
  rect          : TRECT;
  text          : PWChar;
begin
  if @DrawShadowText=nil then exit;
  text:='forum.sources.ru'+#13+'самый лучший форум';
  Image1.Canvas.Brush.Color:=clWhite;
  Image1.Canvas.FillRect(Image1.ClientRect);
  rect.Left:=Image1.Width div 10;
  rect.Top:=Image1.Height div 4;
  rect.Right:=Image1.Width;
  rect.Bottom:=Image1.Height;
  Image1.Canvas.Font.Size:=20;
  Image1.Canvas.Font.Style:=Image1.Canvas.Font.Style+[fsBold];
  Image1.Canvas.Font.Name:='Times New Roman';
  DrawShadowText(Image1.Canvas.Handle,
                 text,
                 Length(text),
                 @rect,
                 1,                                                //-&gt; центрировать текст
                 clRed,
                 clBlack,
                 TB_PosX.Position,
                 TB_PosY.Position);
end;
 
procedure TForm1.TB_PosXChange(Sender: TObject);
begin
  ShadowText();
end;
 
procedure TForm1.TB_PosYChange(Sender: TObject);
begin
  ShadowText();
end;
 
procedure TForm1.FormDestroy(Sender: TObject);
begin
  if lib&lt;&gt;0 then FreeLibrary(lib);
end;
 
end.
</pre>
<div class="author">Автор: Deni</div>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>




<h1>Канва для метафайлов</h1>
<div class="date">01.01.2007</div>

Мне необходимо нарисовать Windows-метафайл. Delphi непосредственно это не поддерживает, поэтому для создания нового метафайла я использую функции Windows API. При создании метафайла мне возвращается его THandle, являющийся дескриптором контекста устройства Windows (DC).</p>
<p>Как мне в Delphi использовать возвращаемый THandle для получения или создания канвы (Canvas) для рисования?</p>
<pre>
unit Metaform;
 
interface
 
uses
 
  SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics, Controls,
  Forms, Dialogs, StdCtrls, Buttons, ExtCtrls;
 
type
 
  TForm1 = class(TForm)
    Panel1: TPanel;
    BitBtn1: TBitBtn;
    Image1: TImage;
    procedure BitBtn1Click(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;
 
var
 
  Form1: TForm1;
 
implementation
 
{$R *.DFM}
 
type
 
  TMetafileCanvas = class(TCanvas)
  private
    FClipboardHandle: THandle;
    FMetafileHandle: HMetafile;
    FRect: TRect;
  protected
    procedure CreateHandle; override;
    function GetMetafileHandle: HMetafile;
  public
    constructor Create;
    destructor Destroy; override;
    property Rect: TRect read FRect write FRect;
    property MetafileHandle: HMetafile read GetMetafileHandle;
  end;
 
constructor TMetafileCanvas.Create;
begin
 
  inherited Create;
  FClipboardHandle := GlobalAlloc(
    GMEM_SHARE or GMEM_ZEROINIT, SizeOf(TMetafilePict));
end;
 
destructor TMetafileCanvas.Destroy;
begin
 
  DeleteMetafile(CloseMetafile(Handle));
  if Bool(FClipboardHandle) then
    GlobalFree(FClipboardHandle);
  if Bool(FMetafileHandle) then
    DeleteMetafile(FMetafileHandle);
  inherited Destroy;
end;
 
procedure TMetafileCanvas.CreateHandle;
var
 
  MetafileDC: HDC;
begin
 
  { Создаем в памяти DC метафайла }
  MetafileDC := CreateMetaFile(nil);
  if Bool(MetafileDC) then
  begin
    { Совмещаем верхний левый угол отображаемого прямоугольника с левым верхним углом
    контекста устройства. Создаем границу шириной 10 логических единиц вокруг изображения. }
    with FRect do
      SetWindowOrg(MetafileDC, Left - 10, Top - 10);
    { Устанавливаем размер изображения с бордюром, имеющим ширину 10 логических единиц. }
    with FRect do
      SetWindowExt(MetafileDC, Right - Left + 20, Bottom - Top + 20);
    { Задаем корректное содержание данному метафайлу. }
    if Bool(FMetafileHandle) then
    begin
      PlayMetafile(MetafileDC, FMetafileHandle);
    end;
  end;
  Handle := MetafileDC;
end;
 
function TMetafileCanvas.GetMetafileHandle: HMetafile;
var
 
  MetafilePict: PMetafilePict;
  IC: HDC;
  ExtRect: TRect;
begin
 
  if Bool(FMetafileHandle) then
    DeleteMetafile(FMetafileHandle);
  FMetafileHandle := CloseMetafile(Handle);
  Handle := 0;
  { Подготавливаем метафайл для показа в буфере обмена. }
  MetafilePict := GlobalLock(FClipboardHandle);
  MetafilePict^.mm := mm_AnIsoTropic;
  IC := CreateIC('DISPLAY', nil, nil, nil);
  SetMapMode(IC, mm_HiMetric);
  ExtRect := FRect;
  DPtoLP(IC, ExtRect, 2);
  DeleteDC(IC);
  MetafilePict^.xExt := ExtRect.Right - ExtRect.Left;
  MetafilePict^.yExt := ExtRect.Top - ExtRect.Bottom;
  MetafilePict^.HMF := FMetafileHandle;
  GlobalUnlock(FClipboardHandle);
  { Передаем дескриптор в качестве результата выполнения функции. }
  Result := FClipboardHandle;
end;
 
procedure TForm1.BitBtn1Click(Sender: TObject);
var
 
  MetafileCanvas: TMetafileCanvas;
begin
 
  MetafileCanvas := TMetafileCanvas.Create;
  MetafileCanvas.Rect := Rect(0, 0, 500, 500);
  MetafileCanvas.Ellipse(10, 10, 400, 400);
  Image1.Picture.Metafile.LoadFromClipboardFormat(
    cf_MetafilePict, MetafileCanvas.MetafileHandle, 0);
  MetafileCanvas.Free;
end;
 
end.
 
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

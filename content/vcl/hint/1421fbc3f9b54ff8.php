<h1>Как изменить шрифт hint?</h1>
<div class="date">01.01.2007</div>


<pre>
{ 
  When the application displays a Help Hint, 
  it creates an instance of HintWindowClass to represent 
  the window used for displaying the hint. 
  Applications can customize this window by creating a 
  descendant of THintWindow and assigning it to the 
  HintWindowClass variable at application startup. 
} 
 
type 
  TMyHintWindow = class(THintWindow) 
    constructor Create(AOwner: TComponent); override; 
  end; 
 
 
implementation 
 
{....} 
 
constructor TMyHintWindow.Create(AOwner: TComponent); 
begin 
  inherited Create(AOwner); 
  with Canvas.Font do 
  begin 
    Name := 'Arial'; 
    Size := Size + 5; 
    Style := [fsBold]; 
  end; 
end; 
 
procedure TForm2.FormCreate(Sender: TObject); 
begin 
  HintWindowClass := TMyHintWindow; 
  Application.ShowHint := False; 
  Application.ShowHint := True; 
end; 
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>

<hr />
<p>В примере перехватывается событие Application.OnShowHint и изменяется шрифт Hint'а. </p>

<pre>
 
type
  TForm1 = class(TForm)
  procedure FormCreate(Sender: TObject);
  private
    {Private declarations}
  public
    procedure MyShowHint(var HintStr: string; var CanShow: Boolean;var HintInfo: THintInfo);
    {Public declarations}
end;
 
var
  Form1: TForm1;
 
implementation
 
{$R *.DFM}
 
procedure TForm1.MyShowHint(var HintStr: string; var CanShow: Boolean; var HintInfo: THintInfo);
var
  i: integer;
begin
  for i := 0 to Application.ComponentCount - 1 do
    if Application.Components[i] is THintWindow then
      with THintWindow(Application.Components[i]).Canvas do
      begin
        Font.name := 'Arial';
        Font.Size := 18;
        Font.Style := [fsBold];
        HintInfo.HintColor := clWhite;
      end;
end;
 
procedure TForm1.FormCreate(Sender: TObject);
begin
  Application.OnShowHint := MyShowHint;
end;
 
 
</pre>

<a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>


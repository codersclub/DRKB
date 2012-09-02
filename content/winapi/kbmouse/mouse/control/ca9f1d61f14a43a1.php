<h1>Получить Handle и имя класса окна под мышкой</h1>
<div class="date">01.01.2007</div>


<pre>
type 
  TForm1 = class(TForm) 
    Label1: TLabel; 
    Label2: TLabel; 
    Timer1: TTimer; 
    procedure Timer1Timer(Sender: TObject); 
    procedure FormCreate(Sender: TObject); 
  private 
    procedure ShowHwndAndClassName(CrPos: TPoint); 
  public 
 
end; 
 
var 
  Form1: TForm1; 
 
implementation 
 
{$R *.DFM} 
 
procedure TForm1.Timer1Timer(Sender: TObject); 
var 
  rPos: TPoint; 
begin 
  if Boolean(GetCursorPos(rPos)) then ShowHwndAndClassName(rPos); 
end; 
 
procedure TForm1.ShowHwndAndClassName(CrPos: TPoint); 
var 
  hWnd: THandle; 
  aName: array [0..255] of Char; 
begin 
  hWnd := WindowFromPoint(CrPos); 
  Label1.Caption := 'Handle :  ' + IntToStr(hWnd); 
 
  if Boolean(GetClassName(hWnd, aName, 256)) then 
    Label2.Caption := 'ClassName :  ' + string(aName) 
  else 
    Label2.Caption := 'ClassName :  not found'; 
end; 
 
procedure TForm1.FormCreate(Sender: TObject); 
begin 
  Form1.FormStyle := fsStayOnTop; 
  Timer1.Interval := 50; 
end;
 
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

<h1>Как сделать различные подсказки для каждой ячейки в TStringGrid?</h1>
<div class="date">01.01.2007</div>


<p>Следующий пример демонстрирует отслеживаение движения мышки в компоненте TStringGrid. Если мышка переместится на другую ячейку в гриде, то будет показано новое окно подсказки с номером колонки и строки данной ячейки:</p>
<pre>
type
  TForm1 = class(TForm)
    StringGrid1: TStringGrid;
    procedure StringGrid1MouseMove(Sender: TObject;
      Shift: TShiftState; X, Y: Integer);
    procedure FormCreate(Sender: TObject);
  private
    { Private declarations }
      Col : integer;
      Row : integer;
  public
    { Public declarations }
  end;
 
var
  Form1: TForm1;
 
implementation
 
{$R *.DFM}
 
procedure TForm1.FormCreate(Sender: TObject);
begin
  StringGrid1.Hint := '0 0';
  StringGrid1.ShowHint := True;
end;
 
procedure TForm1.StringGrid1MouseMove(Sender: TObject;
Shift: TShiftState; X, Y: Integer);
var
  r : integer;
  c : integer;
begin
  StringGrid1.MouseToCell(X, Y, C, R);
  if ((Row &lt;&gt; r) or
      (Col &lt;&gt; c)) then begin
    Row := r;
    Col := c;
    Application.CancelHint;
    StringGrid1.Hint := IntToStr(r) + #32 + IntToStr(c);
  end;
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>


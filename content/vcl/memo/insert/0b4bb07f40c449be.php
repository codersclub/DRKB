<h1>Режим вставки и замены</h1>
<div class="date">01.01.2007</div>

<p>Элементы управления Windows TEdit и TMemo не имеют режима замены. Однако этот режим можно эмулировать установив свойство SelLength edit'а или memo в 1 при обработке события KeyPress. Это заставит его перезаписывать символ в текущей позиции курсора. В примере этот способ используется для TMemo. Режим вставка/замена переключается клавишей "Insert".</p>
<pre>
type
  TForm1 = class(TForm)
    Memo1: TMemo;
    procedure Memo1KeyDown(Sender: TObject; var Key: Word; Shift: TShiftState);
    procedure Memo1KeyPress(Sender: TObject; var Key: Char);
  private
    {Private declarations}
    InsertOn : bool;
  public
    {Public declarations}
end;
 
var
  Form1: TForm1;
 
implementation
 
{$R *.DFM}
 
procedure TForm1.Memo1KeyDown(Sender: TObject; var Key: Word; Shift: TShiftState);
begin
  if (Key = VK_INSERT) and (Shift = []) then
    InsertOn := not InsertOn;
end;
 
procedure TForm1.Memo1KeyPress(Sender: TObject; var Key: Char);
begin
  if ((Memo1.SelLength = 0) and (not InsertOn)) then
    Memo1.SelLength := 1;
end;
 
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

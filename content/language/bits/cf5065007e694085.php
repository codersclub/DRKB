<h1>Проверка значения бита</h1>
<div class="date">01.01.2007</div>


<p>Проверка - установлен ли определенный бит?</p>
<pre>
function IsBitSet(Value: cardinal; BitNum : byte): boolean;

begin
  result:=((Value shr BitNum) and 1) = 1
end;
...
if IsBitSet(43691,1) then //установлен (равен 1)
</pre>

<p class="author">Автор ответа: Krid</p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
<hr />
<pre>
function GetBitStat(SetWord, BitNum: Word): Boolean;
begin
  GetBitStat := SetWord and BitNum = BitNum { Если бит установлен }
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
&nbsp;</p>
<hr />
<pre>
unit BitsForm;
 
interface
 
uses
  Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
  ComCtrls, StdCtrls;
 
type
  TForm1 = class(TForm)
    Label1: TLabel;
    GroupBox1: TGroupBox;
    CheckBox1: TCheckBox;
    CheckBox2: TCheckBox;
    CheckBox3: TCheckBox;
    CheckBox4: TCheckBox;
    CheckBox5: TCheckBox;
    Edit1: TEdit;
    UpDown1: TUpDown;
    procedure Edit1Change(Sender: TObject);
    procedure CheckBoxClick(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;
 
var
  Form1: TForm1;
 
implementation
 
{$R *.DFM}
 
function IsBitOn (Value: Integer; Bit: Byte): Boolean;
begin
  Result := (Value and (1 shl Bit)) &lt;&gt; 0;
end;
 
function TurnBitOn (Value: Integer; Bit: Byte): Integer;
begin
  Result := Value or (1 shl Bit);
end;
 
function TurnBitOff (Value: Integer; Bit: Byte): Integer;
begin
  Result := Value and not (1 shl Bit);
end;
 
procedure TForm1.Edit1Change(Sender: TObject);
var
  I: Integer;
  CheckBox: TCheckBox;
begin
  for I := 1 to 5 do
  begin
    Checkbox := FindComponent (
      'Checkbox' + IntToStr (I)) as TCheckbox;
    CheckBox.Checked :=
      IsBitOn (UpDown1.Position, CheckBox.Tag);
  end;
end;
 
procedure TForm1.CheckBoxClick(Sender: TObject);
var
  Val: Integer;
begin
  Val := UpDown1.Position;
  with Sender as TCheckBox do
    if Checked then
      Val := TurnBitOn (Val, Tag)
    else
      Val := TurnBitOff (Val, Tag);
  UpDown1.Position := Val;
end;
 
end.
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
&nbsp;</p>
&nbsp;</p>
<hr />
<pre>
unit BitsForm;
 
interface
 
uses
  Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
  ComCtrls, StdCtrls;
 
type
  TForm1 = class(TForm)
    Label1: TLabel;
    GroupBox1: TGroupBox;
    CheckBox1: TCheckBox;
    CheckBox2: TCheckBox;
    CheckBox3: TCheckBox;
    CheckBox4: TCheckBox;
    CheckBox5: TCheckBox;
    Edit1: TEdit;
    procedure CheckBoxClick(Sender: TObject);
    procedure FormCreate(Sender: TObject);
    procedure FormDestroy(Sender: TObject);
  private
    MyBits: TBits;
    procedure UpdateEdit;
  end;
 
var
  Form1: TForm1;
 
implementation
 
{$R *.DFM}
 
uses
  Math;
 
procedure TForm1.UpdateEdit;
var
  I, Total: Integer;
begin
  Total := 0;
  for I := 0 to 4 do
    if MyBits.Bits [I] then
      Total := Total + Round (Power (2, I));
  Edit1.Text := IntToStr (Total);
end;
 
procedure TForm1.CheckBoxClick(Sender: TObject);
begin
  MyBits.Bits [(Sender as TCheckBox).Tag] :=
    not MyBits.Bits [(Sender as TCheckBox).Tag];
  UpdateEdit;
end;
 
procedure TForm1.FormCreate(Sender: TObject);
begin
  MyBits := TBits.Create;
  MyBits.Size := 5;
end;
 
procedure TForm1.FormDestroy(Sender: TObject);
begin
  MyBits.Free;
end;
 
end.
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
&nbsp;</p>

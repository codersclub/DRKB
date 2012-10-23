<h1>CD Remember</h1>
<div class="date">01.01.2007</div>


<p>Как-то раз в один прекрасный день решил я у друга взять на денек очередной диск поиграть - и в итоге забыл его в дисководе у другого друга&nbsp; Вот и решил я написать программу-напоминалку: при завершении работы она выскакивает и спрашивает юзера, а не хотел бы он вынуть диск (если диска нет - она даже не пикнет )?</p>
<p>Исходный код модуля:</p>
<pre>
unit cd;
 
interface
 
uses
  Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
  Buttons, StdCtrls, MMSystem;
 
type
  TForm1 = class(TForm)
    Label1: TLabel;
    Button1: TButton;
    Label2: TLabel;
    Label3: TLabel;
    BitBtn1: TBitBtn;
    BitBtn2: TBitBtn;
    Edit1: TEdit;
    GroupBox1: TGroupBox;
    RadioButton1: TRadioButton;
    RadioButton2: TRadioButton;
    Button2: TButton;
    procedure FormCreate(Sender: TObject);
    procedure FormCloseQuery(Sender: TObject; var CanClose: Boolean);
    procedure BitBtn2Click(Sender: TObject);
    procedure BitBtn1Click(Sender: TObject);
    procedure Button1Click(Sender: TObject);
    procedure Button2Click(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;
 
var
  Form1: TForm1;
 
implementation
 
{$R *.DFM}
 
function FindCD:Integer;
var
  i, DType:integer;
  str:string;
  drive:integer;
 
begin
  Result:=0;
  for i:=65 to 90 do
  begin
  str:=chr(i)+':\';
  DType:=GetDrivetype(PChar(str));
  case DType of
 
      0: drive:=0;
      1: drive:=1;
      DRIVE_CDROM : drive:=i;
  end;
if not ((DType=0) or (Dtype=1)) then
Result:=drive;
end;
end;
 
function DiskInDrive(Drive: Char): Boolean;
var 
  ErrorMode: word; 
begin 
  { переводим в верхний регистр } 
  if Drive in ['a'..'z'] then Dec(Drive, $20); 
  { убеждаемся, что это буква } 
  if not (Drive in ['A'..'Z']) then 
      raise EConvertError.Create('Not a valid drive ID');
 
  //отключаем критические ошибки// 
 
  ErrorMode := SetErrorMode(SEM_FailCriticalErrors); 
  try 
      if DiskSize (Ord(Drive) - $40) = -1 then 
        Result := False 
      else 
        Result := True; 
  finally 
      { восстанавливаем старый режим ошибок } 
      SetErrorMode(ErrorMode); 
  end; 
end;
 
procedure ChooseCloseMode;
begin
Form1.Height:=290;
Form1.Repaint;
end;
 
procedure TForm1.FormCreate(Sender: TObject);
begin
Edit1.text:=(chr(Findcd)+':\');
Button1.Enabled:=false;
Label1.Enabled:=false;
end;
 
procedure TForm1.FormCloseQuery(Sender: TObject; var CanClose: Boolean);
begin
if DiskInDrive(chr(findcd))=true then
begin
Canclose:=false;
Form1.Show;
end
else // если нет
CanClose:=true;
end;
 
procedure TForm1.BitBtn2Click(Sender: TObject);
begin
ChooseCloseMode;
end;
 
procedure TForm1.BitBtn1Click(Sender: TObject);
begin
mciSendString('Set cdaudio door open wait', nil, 0, handle);
Button1.Enabled:=true;
Label1.Enabled:=true;
BitBtn1.Enabled:=false;
Bitbtn2.Enabled:=false;
end;
 
procedure TForm1.Button1Click(Sender: TObject);
begin
mciSendString('Set cdaudio door closed wait', nil, 0, handle);
ChooseCloseMode;
end;
 
procedure TForm1.Button2Click(Sender: TObject);
begin
if Radiobutton1.Checked=true then
        ExitWindowsEx(EWX_POWEROFF or EWX_SHUTDOWN,0)
else
if Radiobutton2.Checked=true then
        ExitWindowsEx(EWX_REBOOT,0);
 
end;
 
end.
</pre>
<p>Немного кривоваты комментарии, но кому нужно - разберется.</p>
<p>Код .DPR файла:</p>
<pre>
program cdrem;
 
uses
  Forms,
  cd in 'cd.pas' {Form1};
 
{$R *.RES}
 
begin
  Application.Initialize;
  Application.ShowMainForm:=false;
  Application.CreateForm(TForm1, Form1);
  Application.Run;
end.
</pre>
<div class="author">Автор: Blabsadm</div>
<p>Компилятор: Delphi 5</p>

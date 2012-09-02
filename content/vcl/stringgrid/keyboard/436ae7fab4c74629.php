<h1>Как перехватывать горячие клавиши в TStringGrid?</h1>
<div class="date">01.01.2007</div>


<p>Следующий пример демонстрирует перехват сообщения CM_DIALOGCHAR на уровне формы. Это даст нам возможность реагировать на диалоговые комбинации клавишь только, если нажата клавиша Alt, не давая тем самым отработать стандартному обработчику.</p>
<pre>
type
  TForm1 = class(TForm)
    Button1: TButton;
    StringGrid1: TStringGrid;
    procedure FormCreate(Sender: TObject);
    procedure Button1Click(Sender: TObject);
    procedure StringGrid1KeyDown(Sender: TObject; var Key: Word;
      Shift: TShiftState);
  private
    { Private declarations }
    procedure CMDialogChar(var Message: TCMDialogChar);
      message CM_DIALOGCHAR;
  public
    { Public declarations }
  end;
 
var
  Form1: TForm1;
 
implementation
 
{$R *.DFM}
 
procedure TForm1.FormCreate(Sender: TObject);
begin
  Button1.Caption := 'E&amp;xit';
end;
 
procedure TForm1.Button1Click(Sender: TObject);
begin
  Application.Terminate;
end;
 
procedure TForm1.StringGrid1KeyDown(Sender: TObject; 
var Key: Word; Shift: TShiftState);
begin
  ShowMessage('Grid keypress = ' + Char(Key));
  Key := 0;
end;
 
procedure TForm1.CMDialogChar(var Message: TCMDialogChar);
begin
  if ssAlt in KeyDataToShiftState(Message.KeyData) then
    inherited;
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>


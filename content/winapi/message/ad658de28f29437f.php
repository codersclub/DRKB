<h1>Как сообщить что-нибудь всем формам моего приложения?</h1>
<div class="date">01.01.2007</div>


<p>Как сообщить всем формам моего приложения (в том числе и не видимым в данный момент) об изминении каких-то глобальных значений?</p>

<p>Один из способов - создать пользовательское сообщение и использовать метод preform чтобы разослать его всем формам из массива Screen.Forms.</p>
<pre>
{Code for Unit1}
 
const
  UM_MyGlobalMessage = WM_USER + 1;
 
type
  TForm1 = class(TForm)
    Label1: TLabel;
    Button1: TButton;
    procedure FormShow(Sender: TObject);
    procedure Button1Click(Sender: TObject);
  private
  {Private declarations}
    procedure UMMyGlobalMessage(var AMessage: TMessage); message
      UM_MyGlobalMessage;
  public
  {Public declarations}
  end;
 
var
  Form1: TForm1;
 
implementation
 
{$R *.DFM}
 
uses Unit2;
 
procedure TForm1.FormShow(Sender: TObject);
begin
  Form2.Show;
end;
 
procedure TForm1.UMMyGlobalMessage(var AMessage: TMessage);
begin
  Label1.Left := AMessage.WParam;
  Label1.Top := AMessage.LParam;
  Form1.Caption := 'Got It!';
end;
 
procedure TForm1.Button1Click(Sender: TObject);
var
  f: integer;
begin
  for f := 0 to Screen.FormCount - 1 do
    Screen.Forms[f].Perform(UM_MyGlobalMessage, 42, 42);
end;
 
</pre>
<pre>
{Code for Unit2}
 
const
  UM_MyGlobalMessage = WM_USER + 1;
type
  TForm2 = class(TForm)
    Label1: TLabel;
  private
  {Private declarations}
    procedure UMMyGlobalMessage(var AMessage: TMessage);
      message UM_MyGlobalMessage;
  public
  {Public declarations}
  end;
 
var
  Form2: TForm2;
 
implementation
 
{$R *.DFM}
 
procedure TForm2.UMMyGlobalMessage(var AMessage: TMessage);
begin
  Label1.Left := AMessage.WParam;
  Label1.Top := AMessage.LParam;
  Form2.Caption := 'Got It!';
end;
</pre>



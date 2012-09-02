<h1>Как определить, нажал ли пользователь клавишу PrintScreen?</h1>
<div class="date">01.01.2007</div>


<p>В событиях, обрабатывающих нажатия клавишь в TForm, клавиша PrintScreen не обрабатывается. Однако проблему можно решить при помощи 'GetAsyncKeyState'. Функция GetAsyncKeyState определяет, когда клавиша была нажата или отпущена каждый раз, когда функция вызвана, а так же, когда клавиша была нажата после предыдущего вызова GetAsyncKeyState.</p>

<p>Событие OnIdle в TApplication как раз подходит для вызова этой API функции:</p>
<pre>
procedure TForm1.FormCreate(Sender: TObject); 
begin 
  Application.OnIdle := AppIdle; 
end; 
 
 
procedure TForm1.AppIdle(Sender: TObject; var Done: Boolean); 
begin 
  if GetAsyncKeyState(VK_SNAPSHOT) &lt;&gt; 0 then 
  Form1.Caption := 'PrintScreen нажата !'; 
  Done := True; 
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>


<hr />The PrintScreen system key is not processed during the TForm keydown event. The following example tests if the PrintScreen key has</p>
<p>been pressed by calling the Windows API function GetAsyncKeyState() during the Application.OnIdle event.</p>

<p>Example:</p>
<pre>
type
  TForm1 = class(TForm)
    Button1: TButton;
    procedure FormCreate(Sender: TObject);
  private
    { Private declarations }
    procedure AppIdle(Sender: TObject; var Done: Boolean);
  public
    { Public declarations }
  end;
 
var
  Form1: TForm1;
 
implementation
 
{$R *.DFM}
 
procedure TForm1.FormCreate(Sender: TObject);
begin
  Application.OnIdle := AppIdle;
end;
 
procedure TForm1.AppIdle(Sender: TObject; var Done: Boolean);
begin
  if GetAsyncKeyState(VK_SNAPSHOT)  0 then
    Form1.Caption := 'SnapShot';
  Done := True;
end;
</pre>



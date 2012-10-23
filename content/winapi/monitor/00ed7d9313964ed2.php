<h1>Как отследить изменения дисплея?</h1>
<div class="date">01.01.2007</div>


<p>Для этого необходимо создать обработчик для перехвата сообщения WM_DISPLAYCHANGE. Применяется это в тех случаях, если Ваше приложение зависит от разрешения экрана (например, приложение работает с графикой).</p>
<p>Далее следует пример обработчика сообщения:</p>
<pre>
type 
TForm1 = class(TForm) 
  Button1: TButton; 
private 
  procedure WMDisplayChange(var Message: TMessage); message WM_DISPLAYCHANGE; 
public 
{ Public declarations } 
end; 
 
var 
Form1: TForm1; 
 
implementation 
 
{$R *.DFM} 
 
procedure TForm1.WMDisplayChange(var Message: TMessage); 
begin 
  {Do Something here} 
  inherited; 
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
<hr /><p>Эта программа отслеживает изменение характеристик экрана.</p>
<pre>
...
private
  procedure WMDISPLAYCHANGE(var Msg: TWMDISPLAYCHANGE);
    message WM_DISPLAYCHANGE;
...
procedure TForm1.FormCreate(Sender: TObject);
var
  bp: integer;
begin
  bp := GetDeviceCaps(GetDC(0), BITSPIXEL);
  Form1.Caption := 'Бит на точку - ' + IntToStr(bp) +
    ' (' + FloatToStr(IntPower(2, bp)) +
    ' цветов). Разрешение ';
  Form1.Caption := Form1.Caption + 
 
    IntToStr(GetDeviceCaps(GetDC(0), HORZRES)) + 'X';
  Form1.Caption := Form1.Caption + 
    IntToStr(GetDeviceCaps(GetDC(0), VERTRES)) + ' ';
end;
 
procedure TForm1.WMDISPLAYCHANGE(var Msg: TWMDISPLAYCHANGE);
var
  bp: integer;
begin
  bp := Msg.BitsPerPixel;
  Form1.Caption := 'Бит на точку - ' + IntToStr(bp) + 
    ' (' + FloatToStr(IntPower(2, bp)) + 
    ' цветов). Разрешение ';
  Form1.Caption := Form1.Caption + IntToStr(Msg.Width) + 'X';
 
  Form1.Caption := Form1.Caption + IntToStr(Msg.Height) + ' ';
end;
</pre>


<div class="author">Автор: Даниил Карапетян (delphi4all@narod.ru)</div>
<div class="author">Автор справки: Алексей Денисов (aleksey@sch103.krasnoyarsk.su)</div>


<hr />

<pre>
type
  {...} 
  private 
    procedure WMDisplayChange(var msg: TMessage);
      message WM_DISPLAYCHANGE; 
  public 
  {...} 
  end; 
end; 
 
var 
  Form1: TForm1; 
 
implementation 
 
{$R *.DFM} 
 
procedure TForm1.WMDisplayChange(var msg: TMessage); 
begin 
  ShowMessage('Display settings changed!'); 
  inherited; 
end;
 
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>


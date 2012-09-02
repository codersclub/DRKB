<h1>Как определить, изменилось ли системное время?</h1>
<div class="date">01.01.2007</div>


<p>Следующий пример демонстрирует обработку сообщения WM_TIMECHANGE. Приложение, которое изменяет системное время, посылает сообщение WM_TIMECHANGE всем окнам верхнего уровня.</p>
<pre>
type 
TForm1 = class(TForm) 
private 
{ Private declarations } 
  procedure WMTIMECHANGE(var Message: TWMTIMECHANGE); message WM_TIMECHANGE; 
public 
{ Public declarations } 
end; 
 
var 
Form1: TForm1; 
 
implementation 
 
{$R *.DFM} 
 
procedure TForm1.WMTIMECHANGE(var Message: TWMTIMECHANGE); 
begin 
  Form1.Caption := 'Time Changed'; 
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>


<h1>Изменяем заголовок окна</h1>
<div class="date">01.01.2007</div>


<p class="author">Автор: Christian Cristofori</p>

<p>В примере показывается, как изменять заголовок окна (видимый в списке задач при переключении между приложениями) при минимизации окна в иконку.</p>

<p>Сперва необходимо определить сообщение поумолчанию: </p>
<pre>
const 
  DefMsgNorm = 'MyApp version 1.0'; 
  DefMsgIcon = 'MyApp. (Use F12 to turn of)'; 
</pre>


<p>И добавить две глобальных переменных: </p>
<pre>
var 
  ActMsgNorm : String; 
  ActMsgIcon : String; 
</pre>


<p>Затем при открытии основной формы инициализируем переменные из констант. </p>
<pre>
procedure TFormMain.FormCreate( Sender : TObject ); 
begin 
  ActMsgNorm := DefMsgNorm; 
  ActMsgIcon := DefMsgIcon; 
  Application.Title := ActMsgNorm; 
end;
</pre>


<p>Затем достаточно в обработчик OnResize добавить следующий код: </p>
<pre>
procedure TFormMain.FormResize( Sender : TObject ); 
begin 
  if ( FormMain.WindowState = wsMinimized ) then 
    Application.Title := ActMsgIcon 
  else 
    Application.Title := ActMsgNorm; 
end; 
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>


<h1>Как консольное приложение может узнать, что Винды завершаются?</h1>
<div class="date">01.01.2007</div>


<p class="author">Автор: Nomadic&nbsp; </p>

<p>Все процессы получают сигналы CTRL_CLOSE_EVENT, CTRL_LOGOFF_EVENT и CTRL_SHUTDOWN_EVENT. А делается это (грубо говоря :) так:</p>
<pre>
 
BOOL Ctrl_Handler( DWORD Ctrl )
{
  if( (Ctrl == CTRL_SHUTDOWN_EVENT) || (Ctrl == CTRL_LOGOFF_EVENT) )
  {
    // Вау! Юзер обламывает!
  }
  else
  {
    // Тут что-от другое можно творить. А можно и не творить :-)
  }
  return TRUE;
}
</pre>

<pre>
function Ctrl_Handler(Ctrl: Longint): LongBool;
begin
  if Ctrl in [CTRL_SHUTDOWN_EVENT, CTRL_LOGOFF_EVENT] then
  begin
    // Вау, вау
  end
  else
  begin
    // Am I creator?
  end;
  Result := true;
end;
</pre>


<p>А где-то в программе:</p>

<p>SetConsoleCtrlHandler( Ctrl_Handler, TRUE ); </p>

<p>Таких обработчиков можно навесить кучу. Если при обработке какого-то из сообщений обработчик возвращает FALSE, то вызывается следующий обработчик. Можно настроить таких этажерок, что ого-го :-))) </p>

<p>Короче, смотри описание SetConsoleCtrlHandler -- там всё есть. </p><p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>


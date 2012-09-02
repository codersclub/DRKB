<h1>Диалог отключения сетевого диска</h1>
<div class="date">01.01.2007</div>


<pre>
{ **** UBPFD *********** by kladovka.net.ru ****
&gt;&gt; Открытие диалогового окна «Отключение сетевого диска»
 
Зависимости: Windows
Автор:       Dimka Maslov, mainbox@endimus.ru, ICQ:148442121, Санкт-Петербург
Copyright:   Dimka Maslov
Дата:        21 мая 2002 г.
********************************************** }
 
function DisconnectNetworkDrive(Wnd: HWND = 0): DWORD;
begin
 if Wnd = 0 then Wnd:=FindWindow('Shell_TrayWnd','');
 Result:=WNetDisconnectDialog(Wnd, RESOURCETYPE_DISK);
end; 
</pre>

<p> Пример использования:</p>
<pre>
DisconnectNetworkDrive(Application.Handle); 
</pre>


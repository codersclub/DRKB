<h1>Процедуры для открытия диалогового окна «Свойства Экрана»</h1>
<div class="date">01.01.2007</div>


<pre>
{ **** UBPFD *********** by kladovka.net.ru ****
&gt;&gt; Процедуры для открытия диалогового окна "Свойства Экрана"
 
Зависимости: ShellApi
Автор:       Gua, gua@ukr.net, ICQ:141585495, Simferopol
Copyright:   Gua
Дата:        18 июля 2002 г.
********************************************** }
 
// Открытие диалогового окна "Display Properties"
procedure DisplayPropertiesWindow;
begin
  ShellExecute(0,'open',Pchar('rundll32.exe'),'shell32.dll,Control_RunDLL Desk.cpl', nil, SW_normal);
end;
 
// Открытие диалогового окна "Display Properties" с закладкой Desktop
procedure DisplayPropertiesWindow_Desktop;
begin
  ShellExecute(0,'open',Pchar('rundll32.exe'),'shell32.dll,Control_RunDLL Desk.cpl @0,0', nil, SW_normal);
end;
 
// Открытие диалогового окна "Display Properties" с закладкой Screen Saver
procedure DisplayPropertiesWindow_ScreenSaver;
begin
  ShellExecute(0,'open',Pchar('rundll32.exe'),'shell32.dll,Control_RunDLL Desk.cpl @0,1', nil, SW_normal);
end;
 
// Открытие диалогового окна "Display Properties" с закладкой Settings
procedure DisplayPropertiesWindow_Settings;
begin
  ShellExecute(0,'open',Pchar('rundll32.exe'),'shell32.dll,Control_RunDLL Desk.cpl @0,3', nil, SW_normal);
end;
</pre>


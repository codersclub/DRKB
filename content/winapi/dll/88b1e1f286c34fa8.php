<h1>Определение полного пути и имени файла DLL</h1>
<div class="date">01.01.2007</div>


<p>Следующий пример демонстрирует функцию, которая позволяет определить полный путь откуда была загружена dll:</p>
<pre>
uses Windows;
 
procedure ShowDllPath stdcall;
var
  TheFileName : array[0..MAX_PATH] of char;
begin
  FillChar(TheFileName, sizeof(TheFileName), #0);
  GetModuleFileName(hInstance, TheFileName, sizeof(TheFileName));
  MessageBox(0, TheFileName, 'The DLL file name is:', mb_ok);
end;
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>


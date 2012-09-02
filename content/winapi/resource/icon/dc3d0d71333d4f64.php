<h1>Как использовать встроенные в Windows иконки в своем приложении?</h1>
<div class="date">01.01.2007</div>


<p>Сперва необходимо узнать, константы, которые соответствуют определённым иконкам. Все они определены в API unit (windows.pas) в Delphi:</p>
<p>IDI_HAND </p>
<p>IDI_EXCLAMATION </p>
<p>or </p>
<p>IDI_QUESTION </p>
<p>Следующий пример рисует иконку вопроса на панели:</p>
<pre>var
  DC: HDC;
  Icon: HICON;
begin
  DC := GetWindowDC(Panel1.Handle);
  Icon := LoadIcon(0, IDI_QUESTION);
  DrawIcon(DC, 5, 5, Icon);
  ReleaseDC(Panel1.Handle, DC);
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

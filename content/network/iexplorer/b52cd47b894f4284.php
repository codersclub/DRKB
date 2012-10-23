<h1>Закрытие всех окон IE</h1>
<div class="date">01.01.2007</div>


<pre>
Procedure CloseAllIE_1;
var
   ie:HWND;
  begine
    //Ищем окно IE
    ie:=FindWindow(`IEFrame`, nil);
    //пока найдено окно IE...
    while ie&lt;&gt;0 do
      begin
        //... закрываем его
        postmessage (ie, WM_CLOSE, 0, 0);
        //ищем следующее
        ie:=FindWindow (`IEFrame`, nil);
      end;
end;
</pre>
<div class="author">Автор: bizar</div>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

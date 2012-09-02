<h1>Как прочитать байт из параллельного порта?</h1>
<div class="date">01.01.2007</div>


<p>Первый способ:</p>
<pre>
Var 
     BytesRead : BYTE; 
begin 
               asm                \{ Читаем порт (LPT1) через встроенный ассемблер  \} 
                 MOV dx,$379; 
                 IN  al,dx; 
                 MOV BytesRead,al; 
               end; 
BytesRead:=(BytesRead OR $07);   \{ OR а затем XOR данных \} 
BytesRead:=(BytesRead XOR $80);  \{ маскируем неиспользуемые биты  \} 
</pre>

<p>Второй способ :</p>
<p>Используем команды Turbo Pascal ...</p>
<pre>
  value:=port[$379]; \{ Прочитать из порта \} 
  port[$379]:=value; \{ Записать в порт \}
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>


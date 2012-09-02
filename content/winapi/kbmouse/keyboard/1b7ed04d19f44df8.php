<h1>Переключение раскладки клавиатуры для приложения</h1>
<div class="date">01.01.2007</div>


<pre>
{ **** UBPFD *********** by kladovka.net.ru ****
&gt;&gt; Переключение раскладки клавиатуры для приложения
 
Зависимости: Windows
Автор:       Dimka Maslov, mainbox@endimus.ru, ICQ:148442121, Санкт-Петербург
Copyright:   Dimka Maslov
Дата:        21 мая 2002 г.
********************************************** }
 
function ChangeLayout(LANG: Integer): Boolean;
var
 Layouts: array [0..16] of HKL;
 i, Count: Integer;
begin
 Result:=False;
 Count:=GetKeyboardLayoutList(High(Layouts)+1, Layouts)-1;
 for i:=0 to Count do if (LoWord(Layouts[i]) and $FF) = LANG then
  Result:=ActivateKeyboardLayout(Layouts[i], 0)&lt;&gt;0;
end; 
 
</pre>
<p> Пример использования:</p>
<pre>
ChangeLayout(LANG_RUSSIAN);
ChangeLayout(LANG_ENGLISH); 
</pre>


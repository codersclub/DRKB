<h1>Как использовать переменную для имени процедуры?</h1>
<div class="date">01.01.2007</div>


<p>Взято из FAQ: <a href="https://blackman.km.ru/myfaq/cont4.phtml" target="_blank">https://blackman.km.ru/myfaq/cont4.phtml</a></p>
<p>Каким образом можно использовать переменную типа String в качестве имени процедуры?</p>
<p>Если все процедуры, которые вы собираетесь вызывать, имеют список с одними и теми же параметрами (или все без параметров), то это не трудно. Для этого необходимы: процедурный тип, соответствующий вашей процедуре, например:</p>
<pre>
type

 
TMacroProc = procedure(param: Integer); 
//массив, сопоставляющий имена процедур их адресам во время выполнения приложения: 
TMacroName = string[32];
TMacroLink = record
name: TMacroName;
proc: TMacroProc;
end;
TMacroList = array [1..MaxMacroIndex] of TMacroLink; 
 
const
Macros: TMacroList = (
(name: 'Proc1'; proc: Proc1),
(name: 'Proc2'; proc: Proc2),
...
); //интерпретатор функций, типа: 
 
procedure CallMacro(name: String; param: Integer);
var
i: Integer;
begin
for i := 1 to MaxMacroIndex do
if CompareText(name, Macros[i].name) = 0 then 
begin
Macros[i].proc(param);
break;
end;
end; 
 
{Макропроцедуры необходимо объявить в секции Interface модуля или с ключевым словом Far, например: }
procedure Proc1(n: Integer); far;
begin
...
end; 
 
procedure Proc2(n: Integer); far;
begin
...
end; 
</pre>

<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

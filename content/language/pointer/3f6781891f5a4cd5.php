<h1>Потеря памяти</h1>
<div class="date">01.01.2007</div>

Если Ваша программа после завершенмя " съест" некоторое количество памяти, Windows тактично об этом умолчит, и ошибка останется не найденной. Поэтому я рекомендую на этапе разработки, в файл проекта вставлять модуль checkMem, который отследит некорректную работу с памятью. Вставлять его нужно первым, для обеспечения чистоты эксперимента. Текст модуля:</p>
<pre>
unit checkMem;                     
interface
implementation
 
uses sysUtils, dialogs;
var HPs : THeapStatus;
var HPe : THeapStatus;
var lost: integer;
initialization
   HPs := getHeapStatus;
finalization
   HPe := getHeapStatus;
   Lost:= HPe.TotalAllocated - HPs.TotalAllocated;
   if lost &gt;  0 then begin
      beep;
      ShowMessage( format('lostMem: %d',[ lost ]) );
   end;
end.
 
 
</pre>
<div class="author">Автор: http://sunsb.dax.ru</div>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>


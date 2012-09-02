<h1>Задать необходимый для печати принтер</h1>
<div class="date">01.01.2007</div>


<p>Кто-нибудь пристально изучал объект TPrinter? Вы можете задать необходимый для печати принтер, используя свойство Printer.PrinterIndex. Для примера:</p>

<pre>
// Устанавливает первый принтер, проинсталлированный в системе
Printer.PrinterIndex:=0;
// Указывает на принтер, установленный в системе по умолчанию
Printer.PrinterIndex:=-1;
</pre>

<p>И все! Не нужно никаких Win API функций и глобальных переменных!</p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

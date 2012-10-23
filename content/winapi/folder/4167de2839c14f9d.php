<h1>Добавляем файлы в Recent Documents</h1>
<div class="date">01.01.2007</div>


<p>Предположим Вам захотелось, чтобы Ваше программа сама умела добавлять файлы "recent documents list" (для тех, кто в танке - это такая менюшка, которая появляется при нажатии на кнопку Пуск(Start) и наведении мышкой на "Документы" (Documents). Сама функция API-шная, так что применять её можно в любом компиляторе.</p>
<p>Добавляем следующий код в интерфейсную часть формы:</p>
<pre>const 
SHARD_PIDL = 1; 
SHARD_PATH = 2; 
 
procedure SHAddToRecentDocs(Flags: Word; pfname: Pointer); stdcall; external 'shell32.dll' name'SHAddToRecentDocs'; 
</pre>
<p>А так выглядит вызов этой функции:</p>
<pre>
SHAddTorecentDocs(SHARD_PATH,pchar('C:\mydir\myprogram.exe')); 
</pre>

<p>файл 'myprogram.exe' будет добавлен в recent documents list</p>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

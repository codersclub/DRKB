<h1>Конфликт IDAPI German и English</h1>
<div class="date">01.01.2007</div>


<p>Я просто установил DtopicsP v1.20 и DtopicsD (03-29-96). При запуске dtopics.exe возникает ошибка DB-Error $3E05 ('cannot load driver') (не могу загрузить драйвер). </p>
<p>Я нашел ответ в German Borland Forum. Ошибка происходит, если установлен German BDE. В этом случае в систему устанавливается вместо IDR10009.DLL (который присутствует в английской версии) файл IDR10007.DLL. После установки данного файла в каталог IDAPI все заработало как часы. </p>
<p>Это означает, что приложения, разработанные под English Delphi не будут работать под German или French Delphi.</p>
<div class="author">Автор: Walter Schell </div>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

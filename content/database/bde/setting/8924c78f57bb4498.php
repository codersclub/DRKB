<h1>Не читаются русские буквы в Database Desktop</h1>
<div class="date">01.01.2007</div>

<div class="author">Автор: Pegas</div>

<p>Для DBD 7.0 нужно исправить реестр: ключ</p>
<p>HKCU\Software\Borland\DBD\7.0\Preferences\Properties\</p>
<p>SystemFont="Fixedsys"</p>
<p>Если такой ключ не существует, его следует создать.</p>
<p>или</p>
<p>[HKEY_LOCAL_MACHINE\SYSTEM\CurrentControlSet\Control\Nls\CodePage]</p>
<p>"1252"="c_1251.nls"</p>

<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

<hr />

<p>Подскажите пожалуйста, у меня вот какая проблема:</p>
<p>Загружаю Database Desktop, открываю таблицу имеющую в полях русский текст,</p>
<p> а отображается не русский текст а не понятно что.</p>
<p>О: MANka</p>
<p>Для DBD 5.0 в файл c:\windows\pdoxwin.ini вставить в секцию</p>
<p>[Properties]</p>
<p>SystemFont=Arial Cyr</p>
<p>Для DBD 7.0 нужно исправить реестр: ключ</p>
<p>HKCU\Software\Borland\DBD\7.0\Preferences\Properties\</p>
<p>SystemFont="Fixedsys"</p>
<p>Если такой ключ не существует, его следует создать. Впрочем, для просмотра таблиц</p>
<p>все равно можно порекомендовать rx Database Explorer -- у него это получается очень хорошо.</p>
<p>О: Sergey V. Baldin</p>
<p>Это - проблема русских .dbf и Desktop'а . Надо установить шрифт</p>
<p> по умолчанию не Arial Cyr , а Fixedsys или System. копать примерно так:</p>
<p>1.находишь производителя Desktop :</p>
<p>Например, если это Borland Desktop 7.0, то находишь строку в реестре</p>
<p>HKEY_CURRENT_USER\SOFTWARE\BORLAND\DBD\7.0\Preferences\Properties\SystemFont и</p>
<p>меняешь Arial Cyr на стандартные для Windows: Fixedsys или System</p>
<p>(писать название шрифта с большой буквы).</p>
<p>2. И в стандартном драйвере BDE ,например DBASE, ставишь русский драйвер dBASE RUS cp866.</p>
<p>Открываешь BDE configurator(administrator), ярлык на 32-BDE находится в панели управления.</p>
<p>И в строке Drivers-&gt;Native-&gt;DBASE-&gt;Langdriver-&gt;ставишь dBASE RUS cp866.</p>
<p>После этого все заиграет</p>
<p>Взято с сайта <a href="https://blackman.wp-club.net/" target="_blank">https://blackman.wp-club.net/</a></p>

<hr />

<div class="author">Автор: Alexey Mahotkin</div>

<p>Для DBD 5.0 в файл c:\windows\pdoxwin.ini</p>
<p>вставить в секцию</p>
<p>[Properties]</p>
<p>SystemFont=Arial Cyr</p>
<p>Для DBD 7.0 нужно исправить реестр: ключ</p>
<p>HKCU\Software\Borland\DBD\7.0\Preferences\Properties\</p>
<p>SystemFont="Fixedsys"</p>
<p>Если такой ключ не существует, его следует создать. Впрочем, для просмотра таблиц все равно можно порекомендовать rx Database Explorer -- у него это получается очень хорошо.</p>
<p>Copyright (C) Alexey Mahotkin 1997-1999</p>

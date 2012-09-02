<h1>Использование BDE в сети</h1>
<div class="date">01.01.2007</div>


<p>1) Может ли мое приложение иметь доступ к файлам, расположенным на сетевых дисках?</p>
<p>Да.</p>

<p>2) Когда я попытался это сделать, программа выдала сообщение об ошибке "Not initialized for accessing network files" (не инициализировано для доступа к сетевым файлам).</p>
<p>Вероятно вам необходимо задать правильный путь к каталогу в поле 'NET DIR' файла IDAPI.CFG. Директория должна быть одна и быть доступна всем пользователям приложения с применением одинаковых подключенных сетевых дисков. (т.е.: если NET DIR указывает на F:\PUBLIC\NETDIR, пользователи с подключенным сетевым диском и имеющим путь G:\NETDIR доступа не получат).</p>

<p>3) Возможно ли запустить приложение, относящееся к описываемой категории, с сетевого диска без установленного на локальной машине BDE (за исключением возможных ссылок в локальном файле WIN.INI на копии элементов программы BDE/IDAPI, расположенных на сетевом диске)?</p>
<p>Да. Установите BDE в сети и затем добавьте следующие секции в файл WIN.INI каждой рабочей станции:</p>

<p>[IDAPI]</p>
<p>CONFIGFILE01=F:\IDAPI\IDAPI.CFG</p>
<p>DLLPATH=F:\IDAPI</p>

<p>[Borland Language Drivers]</p>
<p>LDPath=F:\IDAPI\LANGDRV</p>
<p>...пути должны отражать текущее месторасположение каталога IDAPI.</p>

<p>4) Для установки "NET DIR" мне нужно запустить BDECFG на каждой рабочей станции или просто сделать это на "сервере"?</p>
<p>C помощью утилиты BDECFG отредактируйте файл IDAPI.CFG и сохраните его в сетевом каталоге IDAPI. Следовательно, вам необходимо проделать данную операцию всего-лишь один раз.</p>

<p>5) Если мне нужно сделать это только на сервере, то как все рабочие станции узнают о месторасположении сетевых файлов ("NET DIR")?</p>
<p>Рабочая станция открывает файл IDAPI.CFG из каталога, указанного в WIN.INI, и уже оттуда читает настройки NET DIR.</p>

<p>Eryk</p>
<p>Взято из Советов по Delphi от <a href="mailto:mailto:webmaster@webinspector.com" target="_blank">Валентина Озерова</a></p>
<p>Сборник Kuliba</p>


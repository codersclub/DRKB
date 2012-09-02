<h1>Смена свойств приложения, открываемого по умолчанию</h1>
<div class="date">01.01.2007</div>


<p>Большинство стандартных темплейтов зашиты в delphide70.bpl (70 - версия), остальные - в каталоге Objrepos. Описаны же последние в файле bin\delphi32.dro. Т.о:</p>
<p>1. Добавляем в "delphi32.dro" строки:</p>
<p>[C:\Program Files\Lang\Delphi7\ObjRepos\MyApp\MyApp]</p>
<p>Type=ProjectTemplate</p>
<p>Page=Projects</p>
<p>Name=My Application</p>
<p>Description=This is my application template</p>
<p>Author=Eugene</p>
<p>Icon=C:\Program Files\Lang\Delphi7\ObjRepos\MyApp\MyApp.ico</p>
<p>DefaultProject=1</p>
<p>Designer=dfm</p>
<p>(для темплейтов формы Type=FormTemplate, DefaultMainForm=0/1, DefaultNewForm=0/1)</p>
<p>2. Размещаем нашу темплейт-прогу в каталоге "C:\Program Files\Lang\Delphi7\ObjRepos\MyApp\" и называем её "MyApp.dpr".</p>
<p>3. Жмём "File/New/Application" (т.к. у нас DefaultProject=1), либо заходим во вкладку "Projects", а затем кликаем два раза по "My Application".</p>
<p>4. Радуемся!&nbsp; </p>
<p class="author">Автор: Jin X</p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

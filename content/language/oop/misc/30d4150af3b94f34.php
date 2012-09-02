<h1>Как внести изменения в код VCL?</h1>
<div class="date">01.01.2007</div>


<p class="note">Примечание</p>
<p>Внесение изменений в VCL не поддерживается Borland или Borland Developer Support.</p>
<p>-Но если Вы решили сделать это...</p>
<p>Изменения в код VCL никогда не должны вносится в секцию "interface" модуля - только в секцию "implimentation". Наиболее безопасный способ внести изменения в VCL - создать новый каталог названный "исправленный VCL". Скопируйте файл VCL который Вы хотите изменить в этот каталог. Внесите изменения (лучше прокомментировать их) в этот файл. Затем добавьте путь к Вашему каталогу "исправленный VCL" в самое начало "library path". Перезапустите Delphi/C++ Builder и перекомпилируйте Ваш проект. "library path" можно изменить в меню: </p>

<p>Delphi 1 :&nbsp;&nbsp;&nbsp; Options | Environment | Library</p>
<p>Delphi 2 :&nbsp;&nbsp;&nbsp; Tools&nbsp;&nbsp; | Options&nbsp;&nbsp;&nbsp;&nbsp; | Library</p>
<p>Delphi 3 :&nbsp;&nbsp;&nbsp; Tools&nbsp;&nbsp; | Environment Options | Library</p>
<p>Delphi 4 :&nbsp;&nbsp;&nbsp; Tools&nbsp;&nbsp; | Environment Options | Library</p>
<p>C++ Builder : Options | Environment | Library</p>


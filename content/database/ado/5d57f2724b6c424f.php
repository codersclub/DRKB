<h1>Как работать с ADO компонентами в DLL?</h1>
<div class="date">01.01.2007</div>


<p>В оконных приложениях инициализацию COM берет на себя строка в файле проекта:</p>
<p>Application.Initialize;</p>
<p>А вот в DLL и консольных программах обэекта Application нет, и при попытке работать с любыми ActiveX, включая широко используемые ADO компоненты генерится ошибка, которую исправить очень просто: достаточно в секцию Uses в DPR файле добавить модуль oleauto</p>
<div class="author">Автор: Vit</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>


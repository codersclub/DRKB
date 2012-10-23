<h1>EOleSysError &ndash; как бороться?</h1>
<div class="date">01.01.2007</div>


<p>Перед тем как Дельфи сможет использовать любые ActiveX/COM (в том числе и ADO компоненты) должна быть выполнена строка Application.Initialize - которая инициализирует использование COM. Если пишется DLL или консольное приложение, которые не имеют объекта Application, то надо просто добавить в Uses ещё один модуль: "oleauto"</p>

<div class="author">Автор: Vit</div>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>


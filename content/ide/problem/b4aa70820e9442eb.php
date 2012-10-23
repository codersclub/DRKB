<h1>Установка справки для сторонних компонент под Delphi 2005 и Delphi 2006</h1>
<div class="date">01.01.2007</div>

<p>Установка справки для сторонних компонент под d2005, d2006<br>
&nbsp;<br>
Новый формат справки, используемый в d2005, d2006 использует файлы с расширением HXI, HXS и ini. Хуже он или лучше предыдущих реализаций &#8211; судить не имеет смысла, он просто есть и им приходится пользоваться. Для установки справки для сторонних компонентов, например DevExpress нужно сделать следующее:<br>
1. Воспользоваться утилитой H2Reg.exe, поставляемой вместе с <br>
BDS (../Help/Thirdparty) для каждого ini файла в поставке.<br>
Команда для регистрации будет выглядеть так<br>
"c:\Program Files\Borland\BDS\4.0\Help\Thirdparty\H2Reg.exe" -r -m "CmdFile=&lt;path&gt;HelpFile.ini" "UserDir1=&lt;path&gt;<br>
2. Перезапустить BDS. (Вещь, в общем-то не обязательная, но желательная)<br>
&nbsp;<br>
Примечание для DevExpress: перед регистрацией необходимо во всех ini файлах заменить <br>
строки типа %IDE_Namespace_Postfix% на bds4 (для D2006).<br>
&nbsp;<br>
<p>по материалам sql.ru</p>

<div class="author">Автор: phanatos</div>

<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

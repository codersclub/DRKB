<h1>Libqt для Kylix с поддержкой сглаживания</h1>
<div class="date">01.01.2007</div>

<div class="author">Автор: haword</div>

<p>Люди, просьба, проверте работает ли на ваших дистрибутивах сие чудо перед запуском программы на Kylix напишите в командной строке</p>
<p>export CLX_USE_LIBQT="True"</p>
<p>export QT_XFT="1"</p>
<p>скопируйте эти библиотеки в /usr/lib и попробуйте запустить потом свою прогу из этой же консоли, чтоб переменные окружения не пропали! Надеюсь заработает</p>
<p>https://cracker-shym.narod.ru/program/Kylix/libqt.zip</p>
<p>У меня на 10 SlackWare заработало</p>
<p>Добавил еще откомпилированную версию libqt версии 2.3.2, последнюю из QT2, вроде также работает на СлакВаре 10, попутно велез баг, известный у QT2 давно, не видит шрифты некоторые при включенном сглаживании шрифтов, так что некоторые надписи могут не показыватся пока не сменишь шрифт, а так вроде работает!</p>

<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

<h1>Русификация Kylix</h1>
<div class="date">01.01.2007</div>



<p>В этой статье я решил рассказать тебе, как можно заставить Kylix уважать русский язык. Для этого нужно полностью русифицировать Linux. Это не так уж и сложно и мы сейчас полностью опишем этот процесс.</p>

<p>Для Kylix желательно использовать кодовую страницу KOI-8r, которая является практически стандартом русского языка в Linux. Для того, чтобы Kylix мог понимать русские шрифты, нужно сделать следующее:</p>

<p>1. Открыть файл /etc/sysconfig/i18n и добавить в него следующие недостающие строки:</p>

<p>LANG=ru</p>
<p>LANGUAGE=ru_RU.KOI8-R:ru #опционально</p>
<p>LC_CTYPE=ru_RU.KOI8-R</p>
<p>LC_NUMERIC=ru_RU.KOI8-R</p>
<p>LC_TIME=ru_RU.KOI8-R</p>
<p>LC_COLLATE=ru_RU.KOI8-R</p>
<p>LC_MONETARY=ru_RU.KOI8-R</p>
<p>LC_MESSAGES=ru_RU.KOI8-R</p>
<p>LC_ALL=ru_RU.KOI8-R&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
<p>SYSFONT=UniCyr_8x16</p>
<p>SYSFONTACM=koi8-r&nbsp;&nbsp;</p>

<p>Если какие-то из этих строк уже есть в файле, то нужно отредактировать существующие.</p>

<p>В системе уже должны быть установлены русские шрифты. В последних дистрибутивах почти всегда идут шрифты Cronyx Cyrillic, которых достаточно для нормальной работы Kylix.</p>

<p>И последнее, что надо сделать - настрокить переключение клавиатуры в файле /etc/X11/XF86Config. Там нужно отредактировать следующие строки:</p>

<p>Option "XkbLayout" "ru(winkeys)"</p>
<p>Option "XkbOptions" "grp:ctrl_shift_toggle"</p>

<p>Последняя строка показывает как будет переключатся раскладка. В данном случае будет использоваться сочетание клавишь Ctrl+Shift.</p>

<p>Вот и всё!!! Желательно ещё и перегрузить Linux, чтобы он заговорил по русски.</p>


<p>Взято с сайта <a href="https://delphi.h5.ru" target="_blank">https://delphi.h5.ru</a></p>


<h1>Загрузка иконки</h1>
<div class="date">01.01.2007</div>

Если ваша иконка хранится в компоненте Image (видимым или иным способом), вы можете написать:</p>
<pre>
Application.Icon := Image1.Picture.Icon;
</pre>
<p>Если в файле ресурса:</p>
<pre>
Application.Icon.Handle := LoadIcon(hInstance, 'ICONNAME');
</pre>
<p>В любом случае для форсирования показа иконки необходимо вызвать следующую функцию:</p>

<pre>
InvalidateRect(Application.Handle, NIL, True);
</pre>
<p>.. и новая иконка предстанет свету. </p>
<p>Иконка, расположенная в .RES-файле, должна быть видима в .EXE-файле, к примеру, при просмотре файла посредством Program Manager. Иконка, расположенная в компоненте Image, в этом случае не видна. </p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

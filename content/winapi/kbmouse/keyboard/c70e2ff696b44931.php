<h1>Имитация Tab</h1>
<div class="date">01.01.2007</div>


<pre>
SelectNext(screen.ActiveControl, True, True);
</pre>
<p>Разместите приведенный код в обработчике одного из собитий. SelectNext - защищенный метод TWinControl со следующим прототипом:</p>
<pre>
procedure SelectNext(CurControl: TWinControl;
GoForward, CheckTabStop: Boolean);
</pre>
<p>Так как форма также является потомком TWinControl, то она имеет доступ к защищенным методам.</p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>


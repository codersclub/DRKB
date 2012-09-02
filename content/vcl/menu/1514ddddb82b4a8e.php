<h1>Кнопка в TMainMenu с правой стороны</h1>
<div class="date">01.01.2007</div>


<pre>

ModifyMenu(MainMenu.Handle, 3 { индекс меню, начиная слева с нуля}, 
    mf_ByPosition or mf_Popup or mf_Help, mnuHelp.Handle, 
    PChar('Help'));
</pre>
<p>&nbsp;<br>
<p class="author">Автор: Smike</p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

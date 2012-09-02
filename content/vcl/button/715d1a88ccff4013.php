<h1>Из ресурсов поочередно загружать глифы для кнопок SpeedButton</h1>
<div class="date">01.01.2007</div>

Автор: Dennis Passmore </p>
<p>Могу ли я из ресурсов поочередно загружать глифы для кнопок speedbutton и, если да, то как это сделать? </p>
<p>Например, если в вашем проекте используется TDBGrid, то иконки кнопок компонента DBNavigator могут линковаться вашей программой, и их можно загрузить для использования в ваших speedbutton следующим образом:</p>
<pre>
SpeedButton.Caption := '';
SpeedButton1.Glyph.LoadFromResourcename(HInstance,'DBN_REFRESH');
SpeedButton1.NumGlyphs := 2;
</pre>
<p>Другие зарезервированные имена:</p>
<p>DBN_PRIOR, DBN_DELETE, DBN_CANCEL, DBN_EDIT, DBN_FIRST, DBN_INSERT, DBN_LAST, DBN_NEXT, DBN_POST </p>
<p>Все имена должны использовать верхний регистр.</p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

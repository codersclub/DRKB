<h1>Свойства кнопок TDBNavigator</h1>
<div class="date">01.01.2007</div>


<p>Как можно узнать значения свойств кнопок компонента DBNavigator (enabled/disabled или видимая/невидимая)?</p>

<p>Для определения видимости вы можете использовать свойство VisibleButtons. Например:</p>
<pre>
if nbRefresh in DBNavigator1.VisibleButtons then
  ShowMessage('Кнопка Refresh видимая') ;
</pre>


<p>Для того, чтобы узнать, активизирована (enabled/disabled) кнопка или нет:</p>
<pre>
{Вместо nbFirst вы можете определить другой
член TNavigateBtn (например, nbFirst, nbPrior,
nbNext, nbLast, nbInsert, nbDelete, nbEdit,
nbPost, nbCancel, nbRefresh)}
 
if DBNavigator1.Controls[Ord(nbFirst)].Enabled then
  ShowMessage('Кнопка First активизирована') ;
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>



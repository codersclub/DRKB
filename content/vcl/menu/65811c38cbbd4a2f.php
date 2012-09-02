<h1>Пишем свой текст в TMainMenu</h1>
<div class="date">01.01.2007</div>


<p class="author">Автор: Ido Kanner</p>

<p>Когда играешь во встроенную&nbsp; в Windows игру freecell, то справа в меню постоянно пишется сколько осталось карт. Давайте посмотрим, как это делается.</p>

<p>Перво наперво положим компонент главного меню на форму.</p>
<p>Теперь установим свойство OwnerDraw в true. </p>

<p>Далее создайте, то что Вы хотите вырисовывать в меню и создайте OnDrawItem. </p>
<p>И добавьте в него следующую строку: </p>
<pre>
... 
ACanvas.TextOut(1,ARect.Top+1,'I am in the MainMenuDrawbar'); 
... 
</pre>

<p>Не забудьте, если Вы используете изменяющуюся переменную, то измените её в другой функции и всё что надо будет сделать - это вызвать API функцию DrawMenuBar. </p>

<p>Если Вы используете Delphi 2,3 пользуйтесь сообщениями WM_MESUREITEM и WM_DRAWITEM, чтобы сделать данный эффект. </p>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>


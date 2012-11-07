<h1>Ввести пароль Paradox</h1>
<div class="date">01.01.2007</div>


<p>Как мне при соединении с таблицей Paradox устранить/"удовлетворить" окошко с требованием ввести пароль, защищающей таблицу?</p>

<p>Свойство компонента Table ACTIVE должно быть установлено в FALSE. (Если она активна прежде, чем вы ввели пароль, вы получите это окошко.) Затем поместите следующий код в обработчике события формы OnCreate:</p>

<p>session.AddPassword('Мой секретный пароль');</p>
<p>table1.active := true;</p>
<p>Взято из Советов по Delphi от <a href="mailto:mailto:webmaster@webinspector.com" target="_blank">Валентина Озерова</a></p>
<p>Сборник Kuliba</p>


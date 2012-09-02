<h1>Первая программа с базами данных</h1>
<div class="date">01.01.2007</div>


<p>После небольшого теоретизирования спустимся с небес на землю откроем Дельфи и напишем простейшую программу для баз данных. Напишем, это громко сказано, потому что писать ничего не прийдётся, только компоненты потыкаем.</p>
<p>Открываем новый проект. Открываем форму. Кладём на форму компонент TTable (с закладки "Data Access" или "BDE" - у кого какая версия Дельфей). Оп! Не ожидали - вроде бы и таблица, а компонт не визуальный! Итак компонент TTable - это пока основной компонент для нашей базы - всё обращение к таблице идёт только через него. Теперь давай-те его подсоединим к базе данных. </p>
<p>К Дельфи прилогается учебная база данных, её мы и будем пользовать. Найдите свойство DatabaseName и из выпадающего списка выберите "DBDEMOS" - это и есть учебная база данных. Теперь берём свойство TableName и в выпадающем списке обнаруживаем список имён всех таблиц в базе данных "DBDEMOS", выбираем например "biolife.db" - это таблица так называется (а в данном случае и название файла) </p>
<p>Всё - таблица подсоединена, и с ней даже можно работать, но только в коде. А мы, как особо ленивые, попробуем на сегодня без кода обойтись, а подключить к таблице грид и другие визуальные компоненты. </p>
<p>Но все визуальные компоненты могут подсоединится к TTable только через вспомогательный компонент TDataSource - находящийся на той же закладке. Ставим и его на форму. Находим свойство DataSet у этого компонента и в выпадающем списке указываем на Table1. Теперь визуальные компоенты будут "видеть" инфу в таблице через TDataSource.</p>
<p>Переходим на другую закладку компонентов - "Data Controls" и ставим компоент TDBGrid. В его свойстве DataSource указываем на DataSource1. Что видим? Пока ничего! Таблица то не открыта - кликаем на Table1 и устанавливаем свойство Active в True. Работает!</p>
<p>Можно программу откомпиллировать и поиграться со своим первым приложением для баз данных. Неправда ли очень просто! </p>


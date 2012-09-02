<h1>Приемы работы с BDE</h1>
<div class="date">01.01.2007</div>


<p>Те примеры с которыми мы работали использовали именно BDE. Давайте рассмотрим вопросы, напрямую связанные с BDE:</p>
<p>1) Где физически хранится моя база данных</p>
<p>2) Как создать базу данных </p>
<p>3) Как создать таблицу</p>
<p>Итак, где физически хранится моя база данных и собственно куда мы обращались в наших примерах? Если вы помните, в наших примерах мы свойство DatabaseName для Table установили в "DBDemos". Что же это такое "DBDemos"? - это название базы данных, или в терминологии BDE - Alias (перевод на русский язык "Псевдоним"). Alias - это некая "структура" BDE, которая указывает на физическое расположение файлов базы данных, а так же хранит некоторые свойства (параметры) доступа к базе данных. Эти параметры можно посмотреть, настроить, а также добавить или удалить Alias используя программу "BDE Administrator" которую можно найти в Control Panel (панель управления Windows). Запустите BDE Administrator и найдите в левом дереве DBDemos. Теперь на правой части можно увидеть его свойства, например там вы найдёте путь к базе данных. С помощью BDE можно удалить Alias или добавить новый. </p>

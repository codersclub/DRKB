<h1>Delphi-компонент для подкраски синтаксиса</h1>
<div class="date">01.01.2007</div>


<p>Результат совместной работы Fanasist'а и меня. Это компонент для Дельфи для известного пакета SynEdit (http://synedit.sourceforge.net), позволяющий на лету создавать подкраску синтаксиса по любым правилам любых форматов (создание и загрузка в run-time, хранение шаблонов на диске). В настоящее время пакет включает в себя более 300 готовых шаблонов для наиболее распространённых форматов, но каждый может создать свой собственный шаблон (можно с помошью компонента или используя прилагающуюся утилиту). Пример использования - простенький текстовый редактор с поддержкой любых расскрасок.</p>
<p>Загрузить можно с:</p>
<p><a href="https://www.unihighlighter.com" target="_blank">https://www.unihighlighter.com</a></p>
<p>Платформа: Delphi 5/6/7</p>
<p>Для работы необходимо установить предварительно установить пакет SynEdit (<a href="https://synedit.sourceforge.net" target="_blank">https://synedit.sourceforge.net</a>).</p>
<p>Компонент свободен для распространения и поставляется с исходными кодами.</p>
<p>Логика работы:</p>
<p>Для подкраски синтаксиса необходимо предусмотреть следующие правила:</p>
<p>1) расскраска всего кода в промежутке от одного слова до второго - например комментарии /*...*/ или строки "...."</p>
<p>2) расскраска ключевых слов</p>
<p>Это реализовано, кроме того бывают ситуации когда промежуток должен быть расскрашен по другому с другими правилами например ASP код внутри HTML или ассемблерные вставки внутри Дельфи - это тоже реализовано тем что внутри промежутка можно использовать свои правила и промежутки. Вложенность не лимитирована.</p>
<p>Всем кому интересно, я создал форум для обсуждения компонента, правда сообщения писать только на английском, там уже идёт дискуссия с авторами проекта SynEdit:</p>
<p><a href="https://forum.vingrad.ru/SynUniHighlighter.html" target="_blank">https://forum.vingrad.ru/SynUniHighlighter.html</a></p>
<div class="author">Автор: Vit</div>
<p>Открыт русскоязыйчный портал для пользователей и разработчиков компонентов подкраски синтаксиса здесь: <a href="https://forum.vingrad.ru/index.php?act=SF&f=170" target="_blank">https://forum.vingrad.ru/index.php?act=SF&amp;f=170</a></p>

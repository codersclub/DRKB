<h1>Как переносить базы данных между разными IB?</h1>
<div class="date">01.01.2007</div>


<p>Как переносить базы данных между разными IB ? Например между Local IB и IB for Linux? </p>

<p>Для переноса нужно использовать операцию backup/restore, т.к. формат хранения данных для разных платформ разный. Переносить БД без backup/restore можно только в том случае, если у IB-источника и IB-приемника совпадает версия ODS - OnDisk Structure. Версию ODS можно увидеть в Server Manager после подсоединения к БД и вызову пункта меню Tasks/Database Statistics (Database Header, ODS version). Как правило, даже у одной и той же версии IB, но для разных операционных систем версия ODS разная. </p>
<div class="author">Автор: <a href="mailto:delphi@demo.ru" target="_blank">Дмитрий Кузьменко</a> (<a href="https://www.ibase.ru" target="_blank">https://www.ibase.ru</a>)</div>

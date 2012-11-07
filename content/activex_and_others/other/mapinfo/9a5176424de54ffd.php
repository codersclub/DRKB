<h1>Настройка панелей и меню</h1>
<div class="date">01.01.2007</div>

<div class="author">Автор: Дмитрий Кузан</div>

<p>Доброе время суток !</p>
<p>Этой статьей я заканчиваю введение в интегрированную картографию MapInfo.Надеюсь, что данный цикл статей открыл вам возможность применять MapInfo в ваших программах. Перед началом я хочу дать вам ссылку на сайт пользователй MapInfo , где вы найдете исчерпывающеюся информацию по MapInfo и MapBasic в частности на русском языке. Многое что я дал вам по MapBasic в этих частях взято оттуда.</p>
<p>Интеграция инструментальных панелей Maplnfo краткий вводный курс.</p>
<p>Вы не можете переподчинить стандартные инструментальные панели MapInfo. Если Вы хотите, чтобы Ваша клиентская программа имела такие панели вы должны сами создать панели и кнопки на Delphi (например используя Tpanel и Tbutton) и их обработчике посылать специальные команды MapInfo для того что-бы MapInfo включало или переключала режимы работы (например с выбора объекта на перемещения окна карты (ладошка)).</p>
<p>Если Вы хотите, чтобы кнопка панели эмулировала стандартную кнопку MapInfo, используйте метод MapInfo Run Menu Command.</p>
<p>Например в обработчике OnClick пропишите следующею команду</p>
<p>KDMapInfoServer1.ExecuteCommandMapBasic('Run Menu Command 1702',[]);</p>

<p>Когда пользователь нажмет на эту кнопку, программа вызывовет метод MapInfo - Run Menu Command, который активизирует инструмент под номером 1702 (инструмент перемещение карты "рука" ).</p>
<p>"Магический" номер 1702 ссылается на инструмент "рука" служащий для перемещения (сдвига) карты.</p>
<p>Вместо того, чтобы использовать такие числа. Вы можете использовать идентификаторы, более понятные в тексте программы. MapBasic определяет стандартный идентификатор M_TOOLS_RECENTER который имеет значение 1702. Таким образом, этот пример можно записать так:</p>
<p>KDMapInfoServer1.ExecuteCommandMapBasic('Run Menu Command %S', [M_TOOLS_RECENTER]);</p>

<p>Использование идентификаторов (типа M_TOOLS_RECENTER) делает Вашу программу более читательной, но перед использование вы должны включить в программу (в Uses) соответствующий заголовочный файл MapBasic. Для Delphi я положил файл Global.pas (содержимое файла опубликовано в приложении 1).</p>
<p>В следующей таблице приведены кратко идентификаторы основных инструментальных кнопок MapInfo (для более побробной информации смотрите документацию по MapBasic).</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<th ><p>Кнопки панели Операции</p>
</th>
<th ><p>Номер</p>
</th>
<th ><p>Идентификатор</p>
</th>
<th ><p>Примечание</p>
</th>
</tr>
<tr>
<td><p>Выбор</p>
</td>
<td><p>1701</p>
</td>
<td><p>М_TOOLS_SELECTOR</p>
</td>
<td><p>Панель ОПЕРАЦИИ</p>
</td>
</tr>
<tr>
<td><p>Выбор в прямоугольнике</p>
</td>
<td><p>1722</p>
</td>
<td><p>M_TOOLS_SEARCH_RECT</p>
</td>
<td><p>Панель ОПЕРАЦИИ</p>
</td>
</tr>
<tr>
<td><p>Выбор в круге</p>
</td>
<td><p>1703</p>
</td>
<td><p>M_TOOLS_SEARCH_RADIUS</p>
</td>
<td><p>Панель ОПЕРАЦИИ</p>
</td>
</tr>
<tr>
<td><p>Выбор в области</p>
</td>
<td><p>1704</p>
</td>
<td><p>M_TOOLS_SEARCH_BOUNDARY</p>
</td>
<td><p>Панель ОПЕРАЦИИ</p>
</td>
</tr>
<tr>
<td><p>Увеличивающая лупа</p>
</td>
<td><p>1705</p>
</td>
<td><p>M_TOOLS_EXPAND</p>
</td>
<td><p>Панель ОПЕРАЦИИ</p>
</td>
</tr>
<tr>
<td><p>Уменьшающая лупа</p>
</td>
<td><p>1706</p>
</td>
<td><p>M_TOOLS_SHRINK</p>
</td>
<td><p>Панель ОПЕРАЦИИ</p>
</td>
</tr>
<tr>
<td><p>Ладошка (рука)</p>
</td>
<td><p>1702</p>
</td>
<td><p>M_TOOLS_RECENTER</p>
</td>
<td><p>Панель ОПЕРАЦИИ</p>
</td>
</tr>
<tr>
<td><p>Информация</p>
</td>
<td><p>1707</p>
</td>
<td><p>M_TOOLS_PNT_QUERY</p>
</td>
<td><p>Панель ОПЕРАЦИИ</p>
</td>
</tr>
<tr>
<td><p>Подпись</p>
</td>
<td><p>1708</p>
</td>
<td><p>M_TOOLS_LABELER</p>
</td>
<td><p>Панель ОПЕРАЦИИ</p>
</td>
</tr>
<tr>
<td><p>Линейка</p>
</td>
<td><p>1710</p>
</td>
<td><p>M_TOOLS_RULER</p>
</td>
<td><p>Панель ОПЕРАЦИИ</p>
</td>
</tr>
<tr>
<td><p>Переноска</p>
</td>
<td><p>1734</p>
</td>
<td><p>M_TOOLS_DRAGWINDOW</p>
</td>
<td><p>Панель ОПЕРАЦИИ</p>
</td>
</tr>
<tr>
<td><p>Символ</p>
</td>
<td><p>1711</p>
</td>
<td><p>M_TOOLS_POINT</p>
</td>
<td><p>Панель ПЕНАЛ</p>
</td>
</tr>
<tr>
<td><p>Линия</p>
</td>
<td><p>1712</p>
</td>
<td><p>M_TOOLS_LINE</p>
</td>
<td><p>Панель ПЕНАЛ</p>
</td>
</tr>
<tr>
<td><p>Полилиния</p>
</td>
<td><p>1713</p>
</td>
<td><p>M_TOOLS_POLYLINE</p>
</td>
<td><p>Панель ПЕНАЛ</p>
</td>
</tr>
<tr>
<td><p>Дуга</p>
</td>
<td><p>1716</p>
</td>
<td><p>M_TOOLS_ARC</p>
</td>
<td><p>Панель ПЕНАЛ</p>
</td>
</tr>
<tr>
<td><p>Полигон</p>
</td>
<td><p>1714</p>
</td>
<td><p>M_TOOLS_POLYGON</p>
</td>
<td><p>Панель ПЕНАЛ</p>
</td>
</tr>
<tr>
<td><p>Эллипс</p>
</td>
<td><p>1715</p>
</td>
<td><p>M_TOOLS_ELLIPSE</p>
</td>
<td><p>Панель ПЕНАЛ</p>
</td>
</tr>
<tr>
<td><p>Прямоугольник</p>
</td>
<td><p>1717</p>
</td>
<td><p>M_TOOLS_RECTANGLE</p>
</td>
<td><p>Панель ПЕНАЛ</p>
</td>
</tr>
<tr>
<td><p>Прямоугольник скругленный</p>
</td>
<td><p>1718</p>
</td>
<td><p>M_TOOLS_ROUNDEDRECT</p>
</td>
<td><p>Панель ПЕНАЛ</p>
</td>
</tr>
<tr>
<td><p>Текст</p>
</td>
<td><p>1709</p>
</td>
<td><p>M_TOOLS_TEXT</p>
</td>
<td><p>Панель ПЕНАЛ</p>
</td>
</tr>
<tr>
<td><p>Рамка</p>
</td>
<td><p>1719</p>
</td>
<td><p>M_TOOLS_FRAME</p>
</td>
<td><p>Панель ПЕНАЛ</p>
</td>
</tr>
<tr>
<td>
</td>
<td>
</td>
<td>
</td>
<td><p> 
</td>
</tr>
</table>

<p>Настройка "быстрых" меню Maplnfo</p>
<p>MapInfo вызывает "быстрые" меню, если пользователь нажимает правую кнопку мышки в окне MapInfo. Эти меню появляются даже во внедренных приложениях. В зависимости от характера Вашего приложения Вы можете захотеть модифицировать или даже удалить такое меню. Например, Вы, возможно, захотите удалить команду ДУБЛИРОВАТЬ ОКНО, так как эта команда не работает в OLE-приложении.</p>
<p>Чтобы удалить одну или несколько команд из локального меню, используйте оператор MapBasic Alter Menu... Remove или переопределите меню целиком, используя оператор Create Menu. Подробнее смотрите в Справочнике MapBasic.</p>
<p>Чтобы добавить команду к локальному меню, используйте оператор MapBasic Alter Menu ... Add и синтаксис предложений Calling OLE.</p>
<p>Чтобы удалить "быстрое" меню полностью, используйте оператор MapBasic Create Menu и управляющий код "(-" как новое определение меню. Например, следующий оператор разрушает "быстрое" меню для окон Карты:</p>
<p>KDMapInfoServer1.ExecuteCommandMapBasic(' "Create Menu ""MapperShortcut"" ID 17 As ""(-"" " ', []);</p>

<p>Создание собственных уведомляющих вызовов (Callbacks).</p>
<p>Во второй части мы рассмотрели возможность перехвата двух стандартных вызовов MapInfo - это дало нам возможность подключить к своей программе статус бар MapInfo и узнавать об изменениях окон MapInfo.Все это очень неплохо, но сразу возник вопрос, а как создавать и обрабатывать сообщения собственные, не входящие в MapInfo.</p>
<p>Если Вы хотите, чтобы MapInfo сообщало Вашей клиентской программе, когда пользователь применяет инструментальную кнопку, создайте такую кнопку оператором Alter ButtonPad... Add. Определите кнопку в соответствии с именем метода для обработки (прим. Этот метод определен мной как MyEnvent в OLE объекте)</p>
<p>Пример :</p>
<p>KDMapInfoServer1.ExecuteCommandMapBasic('Alter ButtonPad ID 1 Add ToolButton calling ole</p>
<p>"MyEvent" ID 1 Icon 0 Cursor 0 DrawMode 34 uncheck',[]);</p>

<p>Заметьте, что инструментальные панели MapInfo скрыты, подобно остальной части интерфейса пользователя MapInfo. Пользователь не будет видеть новую кнопку. Вы можете добавить иконку, кнопку или другой видимый элемент управления к интерфейсу пользователя Вашей клиентской программы. Когда пользователь укажет на него мышкой, пошлите MapInfo оператор Run Menu Command ID , c индентификатором созданной кнопки чтобы активизировать этот инструмент.</p>
<p>KDMapInfoServer1.ExecuteCommandMapBasic('Run Menu Command ID 1',[]);</p>

<p class="note">Примечание:</p>
<p>Информацию по Alter Button Pad смотрите в документации.</p>
<p>Если Вы хотите, чтобы MapInfo сообщала Вашей клиентской программе, когда пользователь выбирает созданную Вами команду меню, определите такую кнопку оператором Alter Menu... Add с указанием имени OLE метода (см. выше).</p>
<p>Внутри метода (в данном случае в обработчике компонента MyEventChange) обработайте аргументы (Info), посланные MapInfo.</p>
<p>Обработка переданных данных</p>
<p>Когда пользователь использует команды или кнопки, MapInfo посылает Вашему OLE-методу строку, содержащую восемь элементов, разделенных запятыми. Например, строка, посланная MapInfo, может выглядеть так:</p>
<p>"MI:-73.5548,42.122,F,F,-72.867702,43.025,202,"</p>

<p>Содержание такой строки проще понять, если Вы уже знакомы с функцией MapBasic CommandInfo(). Когда Вы пишете приложения, Вы можете создать новые команды меню и кнопки, вызывающие MapBasic-процедуры. Внутри процедуры-обработчика вызовите функцию CommandInfo(), чтобы получить информацию. Например, следующее обращение к функции определяет, координату Х и У места на карте где пользователи применил инструмент.</p>

<pre class="delphi">
var
  X, Y : string;
begin
  KDMapInfoServer1.ExecuteCommandMapBasic('Set CoordSys Layout Units "mm"',[]);
  X := KDMapInfoServer1.Eval('CommandInfo(%S)',[CMD_INFO_X]).AsString;
  Y := KDMapInfoServer1.Eval('CommandInfo(%S)',[ CMD_INFO_Y]).AsString;
  ShowMessage('X= ' + X + ' Y = ' + Y);
</pre>


<p>Значения:</p>
<p>Код для событий, связанных с меню Код для событий, связанных с кнопкой</p>
<p>1 CMD_INFO_X</p>
<p>2 CMD_INFO_Y</p>
<p>3 CMD_INFO_SHIFT</p>
<p>4 CMD_INFO_CTRL</p>
<p>5 CMD_INFO_X2</p>
<p>6 CMD_INFO_Y2</p>
<p>7 CMD_INFO_TOOLBTN</p>
<p>8 CMD_INFO_MENUITEM</p>
<p>Когда Вы создаете команду меню или кнопку, которая использует синтаксис вызова OLE, MapInfo создает строку, содержащую разделенные запятой все восемь возвращаемых CommandInfo() значений. Строка начинается с префикса "MI:", чтобы Ваш OLE-сервер мог определять, что обращение метода было сделано MapInfo.</p>
<p>Строка, которую MapInfo посылает Вашему методу, выглядит следующим образом:</p>
<p>"MI:" +</p>
<p>CommandInfo(l) + "," + CommandInfo (2) + "," +</p>
<p>CommandInfo(3) + "," + CommandInfo (4) + "," +</p>
<p>CommandInfo(5) + "," + CommandInfo (6) + "," +</p>
<p>CommandInfo (7) + "," + CommandInfo (8)</p>

<p>Предположим, что Ваше приложение добавляет команду меню к локальному меню OLE-методу строку. Если команда меню имеет номер 101 , строка будут выглядеть следующим образом:</p>
<p>"Ml :,,,,,,, 101"</p>

<p>В этом случае большинство элементов строки пусто, потому что функция CommandInfo( ) может возвращать только эту одну часть информации.</p>
<p>Теперь предположим что вы создаете кнопку которая позволяет пользователю выбирать линии на карте.Строка теперь примет вид -</p>
<p>"MI:-73.5548,42.122,F,F,-72.867702,43.025,202,"</p>

<p>Теперь строка включает несколько элементов:</p>
<p>Первые два элемента содержат х- и у координаты точки на которые пользователь указал мышкой</p>
<p>Следующие два элемента сообщают, была ли нажата клавиша SHIFT или CTRL</p>
<p>Предпоследнии два элемента содержат координаты точки где пользователь отпустил кнопку мышки.</p>
<p>И последний - указывает номер идентификатора кнопки.</p>
<p>Совет:</p>
<p>Если Вы приписываете уникальный идентификатор каждой из Ваших кнопок, Вы можете сделать так, что все кнопки будут вызывать один и тот же метод. Ваш метод может определять, какая из кнопка вызвала его, используя седьмой аргумент в переданной строке.</p>

<p class="note">Примечание 1</p>
<p>Описание констант MapInfo (Global.pas)</p>

<p class="note">Примечание</p>
<p>Данный файл был взят мной с Интернета. Хочу сразу сделать предупреждение - разработчики MapInfo заявляют что набор констант может быть подвергнут изменениям в следующих редакциях MapInfo.Данный набор констант адаптирован под пятую версию. К сожалению шестой версии у меня нет (может кто поделиться ;-) ) и соответственно нет возможности проверить изменился ли набор констант или нет.</p>
<p>Вот в принципе и все что нужно для работы с MapInfo в Delphi, дерзайте</p>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

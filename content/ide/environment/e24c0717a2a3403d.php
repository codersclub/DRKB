<h1>Эта незнакомая IDE</h1>
<div class="date">01.01.2007</div>


<p>Небольшой список приёмов для эффективной работы</p>
<p>IDE - интегрированная среда разработки Дельфи. Все хоть чуть чуть соприкасавшиеся с Дельфи знают эту простую и интуитивно понятную среду. Тем ни менее, эта среда имеет огромное количество функций, которые не столь очевидны для пользователя и не очень хорошо документированы. Целью этой статьи является рассказать о некоторых приёмах работы в среде Дельфи, не столь очевидных даже для профессионалов. Описание базируется на Дельфи 7, но подавляющее большинство приёмов будет доступно и в других версиях, как ранних, так и поздних.</p>
<p>Текстовый редактор </p>
<p>1) Отмеченный блок текста можно сдвинуть вправо или влево нажатием Ctrl-Shift-U или Ctrl-Shift-I - это особенно удобно при форматировании текста, оформлении процедур, циклов и т.п.</p>
<p>2) Отмеченный блок текста можно сохранить в файл непосредственно, минуя стадии создания файла и т.п. Нажмите Ctrl-K и затем W - откроется диалог сохранения файла выберите имя и блок будет сохранён в виде отдельного файла. Вообще-то редактор дельфи берёт начало ещё от очень древнего Word star редактора(речь идёт о начале 80х годов), на базе которого был сделан IDE для Turbo Pascal. В том Wordstar очень многие функции были реализованы через префиксы. Т.е. нажимается какой-то префикс, и потом клавиша функции. Такими префиксами в Дельфи остались Ctrl-K и Ctrl-O - сами по себе эти комбинации ничего не делают, но после их нажатия следующая буква определяет функциональность. Итак Ctrl-K,W - записывают выделенный блок в файл (от слова Write - писать)</p>
<p>3) Содержимое текстового файла можно легко загрузить по месту курсора (вставить в текущий текст) нажав Ctrl-K,R (Read). При нажатии комбинации откроется диалог открытия файла.</p>
<p>4) Переходы на метки. Скорее всего это почти все знают, но тем ни менее. Можно запомнить текущую позицию курсора поставив метку, и потом перейти к метке. Всего меток можно поставить до 10 штук. Метка ставится нажатием Ctrl-Shift+ цифра, переход к поставленной метке по нажатию Ctrl+цифра. Для тех кто в танке: нажмите Ctrl-Shift+1 затем пролистайте текущий файл куда-нибудь вверх или вниз, нажмите Ctrl-1 и курсор перескочит на запомненную позицию.</p>
<p>5) Чтобы открыть в редакторе исходник файла указанный в Uses, поставте курсор на имя модуля и нажмите Ctrl-Enter. Исходник сразу будет открыт в новом окне. Только 2 замечания: во-перывых это не обязательно должно быть имя модуля из uses, редактор будет пробовать открыть любой файл по имени слова над которым стоит курсор, во-вторых IDE должно знать где искать файл, если в списке путей этого файла нет, IDE его не найдёт и просто откроет диалог открытия файла.</p>
<p>6)Вертикальные блоки - очень удобная фишка. Можно выделить вертикальный блок текста и манипулировать им. Для выделения вертикального блока можно воспользоваться клавиатурой: Удерживая Shift и Alt перемещать курсор или мышкой - для этого при выделении мышкой удерживайте Alt нажатым. Для выхода из режима отметки вертикального блока используйте или мышку - выделив что-нибудь без Alt или используя Ctrl+O, K. Ещё один способ перейти в режим выделения вертикальным блоком - это нажать Ctrl+O, C и после этого блоки будут вертикальными при выделении их клавиатурой.</p>
<p>7) Строковые блоки - ещё один вид блоков пришедших из wordstar и сейчас подзабытых. В этом случае редактор выделяет строку целиком, вне зависимости от того где стоит курсор. Иногда удобно. Перейти в режим строкового блока можно комбинацией Ctrl+O, L</p>
<p>8) Удалить целую строку можно нажав Ctrl-Y, а нажатие Ctrl-T приводит к удалению конца слова (от позиции курсора до конца слова), применение Ctrl+Shift+Y позволяет удалить весь текст от курсора до конца строки.</p>
<p>9) Можно вставить любой символ в текст при помощи Ctrl-P, после нажатия этой комбинации следующий символ с клавиатуры не будет восприниматься как управляющий а будет введен в текст, например Ctrl-P и потом Ctrl-A вставят в текст символ #1</p>
<p>10) Копирование без буффера обмена. Ещё одна удобная фишка, пришедшая со времён ДОС. Наверное все встречались с ситуацией когда например в буффере обмена лежит название объекта, но чтобы вставить его надо скопировать кусок кода. Если копировать по привычному Ctrl-C/Ctrl-V то предыдущая информация в буффере исчезнет. На этот случай есть 2 удобных приёма. Во первых можно скопировать блок клавиатурой без использования буффера обмена - выделите блок текста, нажмите Ctrl-K, C - блок скопирован, содержимое буффера обмена не пострадало. Второй способ - мышкой: отмечаем блок, удерживая нажатым Ctrl перетаскиваем блок на новое место - блок копируется.</p>
<p>11) Макросы! Редактор Дельфи позволяет запомнить нажатые клавиши и потом произвести точно такую-же последовательность нажатий. Делается это следующим образом. Допустим у нас есть код:</p>
<pre>
Table1.fieldByName('aaaaa').asString:='чего-то там';
Table1.fieldByName('sdweewr').asString:='чего-то там 1';
Table1.fieldByName('sdfsdfga').asString:='чего-то там2';
Table1.fieldByName('a').asString:='чего-то там 4';
Table1.fieldByName('pyoruw').asString:='чего-то там 5';
</pre>
<p>Этот код надо заменить на аналогичный, но с использованием параметров, причём добавить ещё переменную v. В конечном итоге мы хотим каждую строку преобразовать в нечто типа:</p>
<pre>
Table1.params.parambyname('aaaaa').value:='чего-то там'+v;
</pre>
<p>Если строк очень много то процесс переделки может быть весьма трудоёмкий. Что мы делаем:</p>
<p>- ставим курсор на первую букву первой строки.</p>
<p>- нажимает Ctrl-Shift-R (начать запись макро) с этого момента все нажатия на клавиатуре будут запоминаться, поэтому действуем осторожно чего попало не нажимая:</p>
<p>- нажимаем Ctrl-вправо и удаляем fieldByName</p>
<p>- печатаем на его место params.parambyname</p>
<p>- нажимаем Ctrl-вправо пока курсор не станет на asString (просто вправо жать нельзя так как значение имени поля у нас разной длинны в разных строках)</p>
<p>- удаляем asString нажатием delete</p>
<p>- записываем value</p>
<p>-нажимаем End и клавишу влево</p>
<p>- записываем +v</p>
<p>- теперь нажимаем клавишу вниз и клавишу home - чтобы курсор стал на начало следующей строки</p>
<p>- нажимает Ctrl-Shift-R- закончить запись макро.</p>
<p>Теперь по нажатию Ctrl-Shift-P редактор будет обрабатывать любую текущую строку так же как и ту над которой работали мы.</p>
<p>12) Быстрый поиск. Нажмите Ctrl-E и начинайте печатать слово которое вы хотите найти - редактор будет искать по мере ввода слова...</p>
<p>13) Чтобы вставить в текст GUID (CLSID) - нажмите Ctrl-Shift-G </p>
<p>14) Все знают что после точки Дельфи выдаёт список доступных методов и свойств объекта, а как вызвать этот список вручную, если он уже исчез? - нажмите Ctrl-Space. Кстати нажатие Ctrl-Shift-Space приведёт к появлению всплывающей подсказки о параметрах функции или метода, если нажатие произведено когда курсор стоит после скобки, например напишите write( и нажмите Ctrl-Shift-Space - будет выведен hint о параметрах функции.</p>
<p>15) Путём нажатия Ctrl+Shift+Up и Ctrl+Shift+Down можно быстро перейти от тела метода к его объявлению и наоборот. Аесли нажать Ctrl-Shift-C на методе то удет автоматически создано его объявление в классе и наоборот, если есть объявление метода в классе - то будет создан шаблон для его реализации.</p>
<p>16) Если кликнуть на идентификаторе с нажатым Ctrl, то курсор перейдёт на объявление этого идентификатора. А если нажать Ctrl-Shift-B на имени класса, то будет выведена вся иерархия данного класса.</p>
<p>17) Если нажать Ctrl-O, O то по текущему положению курсора будут выведены все опции компилляции установленные для проекта.</p>
<p>18) Можно изменить регистр букв выделенного текста на противоположный нажав Ctrl+O, U, а нажатие Ctrl+K, E приведёт к переводу текущего слова в нижний регистр (Ctrl+K, F - в верхний).</p>
<p>19) Ctrl+O, G позволит вам быстро перейти к строке по её номеру</p>
<p>20) Alt+[ и Alt+] осуществляют поиск парных скобок, что удобно при сложных выражениях.</p>
<p>Отладчик:</p>
<p>1) Наверное все знают функции трассировки F7/F8, но есть ещё одна - Shift-F7 - она аналогична F7 т.е. трассирует программу с заходом в каждую процедуру, но в дополнении ещё отлавливает и случающиеся события и трассирует их.</p>
<p>2) Ctrl-F3 - вызов стека вызовов функций. Крайне удобная штука - в точке останова можно заглянуть в него и выяснить кто вызывал данную процедуру, увидеть всю цепочку вызовов и быстро перейти к вызывающей функции.</p>
<p>3) Ctrl-F7 - позволяет посмотреть любую переменную, изменить её значение, и даже выполнить какой-нибудь код прямо в процессе отладки. Его же можно использовать и как калькулятор по мере разработки программы. Кстати, если надо просмотреть значение переменной типа TStrings - например memo.lines то не надо писать memo.lines.text - так как при этом текст не будет разбит на строки, пишите memo.lines.gettext - это сделает вывод значения гораздо более читаемым. Кстати есть и ещё одна особенность - при выводе значения TStrings, а так же массивов и т.п. "объёмных" структур просмотрщик выводит только первые несколько килобайт, поэтому не волнуйтесь, если у вас вдруг просмотрщик покажет только кусок значения - это не глюк, это особенность просмотрщика, скомпиллированный код работает правильно </p>
<p>4) При наличии многочисленных ошибок компилляции можно легко переходить к последующей/предыдущей ошибке нажатием Alt-F8/Alt-F7 </p>
<div class="author">Автор: Vit</div>

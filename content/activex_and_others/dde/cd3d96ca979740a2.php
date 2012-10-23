<h1>Регистрация программ в меню «Пуск» Windows 95</h1>
<div class="date">01.01.2007</div>

Подобная проблема возникает при создании инсталляторов и деинсталляторов. Наиболее простой и гибкий путь - использование DDE. При этом посылаются запросы к PROGMAN. Для этого необходимо поместить на форму компонент для посылки DDE запросов - объект типа TDdeClientConv. Для определенности назовем его DDEClient. Затем добавим метод для запросов к PROGMAN:</p>
<pre>
function TForm2.ProgmanCommand(Command: string): boolean;
var
  macrocmd: array[0..88] of char;
begin
  DDEClient.SetLink('PROGMAN', 'PROGMAN');
  DDEClient.OpenLink; { Устанавливаем связь по DDE }
  strPCopy(macrocmd, '[' + Command + ']'); { Подготавливаем ASCIIZ строку }
  ProgmanCommand := DDEClient.ExecuteMacro(MacroCmd, false);
  DDEClient.CloseLink; { Закрываем связь по DDE }
end;
 
// Пример использования:
ProgmanCommand('CreateGroup(Комплекс программ для
  каталогизации литературы, )');
ProgmanCommand('AddItem(' + path + 'vbase.hlp, Справка по VBase,
  '+ path +' vbase.hlp, 0, , , '+ path + ', , )');
// где path - строка типа String, содержащая
// полный путь к каталогу ('C:\Catalog\');
</pre>

<p>При вызове ProgmanCommand возвращает true, если посылка макроса была успешна. Система команд (основных) приведена ниже:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>Create(Имя группы, путь к GRP файлу) Создать группу с именем "Имя группы", причем в нем могут быть пробелы и знаки препинания. Путь к GRP файлу можно не указывать, тогда он создастся в каталоге Windows.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>Delete(Имя группы) Удалить группу с именем "Имя группы"</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>ShowGroup(Имя группы, состояние) Показать группу в окне, причем состояние - число, определяющее параметры окна:</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 72px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9633;</td><td>1-нормальное состояние + активация</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 72px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9633;</td><td>2-миним.+ активация</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 72px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9633;</td><td>3-макс. + активация</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 72px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9633;</td><td>4-нормальное состояние</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 72px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9633;</td><td>5-Активация</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>AddItem(командная строка, имя раздела, путь к иконке, индекс иконки (с 0), Xpos,Ypos, рабочий каталог, HotKey, Mimimize) Добавить раздел к активной группе. В командной строке, имени размера и путях допустимы пробелы,</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>Xpos и Ypos - координаты иконки в окне, лучше их не задавать, тогда PROGMAN использует значения по умолчанию для свободного места.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>HotKey - виртуальный код горячей клавиши.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>Mimimize - тип запуска, 0-в обычном окне, &lt;&gt;0 - в минимизированном.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>DeleteItem(имя раздела) Удалить раздел с указанным именем в активной группе</td></tr></table></div>&nbsp;</p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

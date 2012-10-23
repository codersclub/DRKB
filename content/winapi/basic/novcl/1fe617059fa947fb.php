<h1>Запись сообщений в журнал событий Windows на Delphi</h1>
<div class="date">01.01.2007</div>


<p>Запись сообщений в журнал событий Windows на Delphi</p>
<p>Автор: c "FMI Solutions" 2002</p>
<p>https://www.fmisolutions.com</p>
<p>Перевод: &#169; Digimaster 2005</p>
<p>Приложение может записывать сообщения в журнал используя следующие функции WinAPI. Подробное описание параметров этих функций содержится в документации к API.</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>RegisterEventSource - Открывает handle для доступа к журналу на локальной или удаленной машине.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>ReportEvent - Собственно записывает сообщение.</td></tr></table></div><p>Для записи сообщений в журнал в упрощенной манере просто произведите вызов RegisterEventSource с именем машины (UNC), в журнал которой вы хотите поместить сообщение (nil для локальной машины), и именем события. Имя события это обычно имя приложения, но может быть чем-то более информативным. Как только источник событий зарегистрирован, можно записывать события при помощи ReportEvent с handle, который вернула RegisterEventSource.</p>
<p>Пример:</p>
<pre>
VAR EventLog:THandle;
EventLog:=RegisterEventSource(nil,PChar('MyApplication'));
 
VAR MyMsg:Array[0..2] of PChar;
MyMsg[0]:='A test event message';
 
ReportEvent(EventLog,EVENTLOG_INFORMATION_TYPE,0,0,nil,1,0,@MyMsg,nil);
</pre>
<p>Однако текст сообщения, записанного в журнал будет предварен текстом: "The description for Event ID ( 0 ) in Source ( MyApplication ) cannot be found. The local computer may not have necessary registry information or message DLL files to display messages from a remote computer. The following information is part of the event:" (Не найдено описание для события с кодом ( 0 ) в источнике ( MyApplication ). Возможно, на локальном компьютере нет нужных данных в реестре или файлов DLL сообщений для отображения сообщений удаленного компьютера. В записи события содержится следующая информация:) (Замечание: Это сообщение специфично для Windows2000 и может немного отличаться на других версиях). Для предотвращения появления этого текста необходимо внести в реестр некоторые ключи, как показано ниже, и определить строковые ресурсы (это может быть выполнено любым компонентом вашего приложения, не обязательно приложением, которое будет записывать события). Соответствующие записи реестра описаны ниже. Примеры кода предполагают, что строковые ресурсы и категории расположены в том же исполняемом файле, который содержит программу, записывающую события. Ключи категорий являются опциональными. Смысл этих ключей реестра и строковых ресурсов в том, что журнал событий использует строку, а приложение записывает в журнал в виде форматированного аргумента, и журналу необходимо знать, где находится описатель формата для этой строки. Кроме того, в журнале может храниться информация о категории события, полезная для просмотра событий. Это удобнее, чем просто отображать множество однотипный событий "Нет". Самый простой определитель формата это %1, который просто передаст в журнал входную строку. Для более подробного изучения определителей формата см. API документацию для FormatMessage.</p>
<p>Ключи реестра</p>
<p>Создайте следующий ключ реестра:</p>
<p>HKEY_LOCAL_MACHINESYSTEM - CurrentControlSet - Services - Eventlog - Application - &lt;AppName&gt;</p>
<p>Имя приложения AppName должно совпадать с именем источника, использованного при вызове RegisterEventSource, потому что просмотрщик событий будет использовать это имя для отыскивания событий.</p>
<p>Создайте следующие ключи:</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td>Имя ключа</p>
</td>
<td>Тип</p>
</td>
<td>Описание</p>
</td>
</tr>
<tr>
<td><p>CategoryCount (Optional)</p>
</td>
<td><p>Integer</p>
</td>
<td><p>Количество категорий событий, которые вы собираетесь использовать. (Это максимальная величина, и не будет проблем, если не все категории на самом деле будут применяться).</p>
</td>
</tr>
<tr>
<td><p>CategoryMessageFile (Optional)</p>
</td>
<td><p>String</p>
</td>
<td><p>Файл, содержащий ресурсы строк категорий.</p>
</td>
</tr>
<tr>
<td><p>EventMessageFile</p>
</td>
<td><p>String</p>
</td>
<td><p>Файл, содержащий ресурсы строк событий.</p>
</td>
</tr>
<tr>
<td><p>TypesSupported</p>
</td>
<td><p>Integer</p>
</td>
<td><p>Допустимые типы событий.
</td>
</tr>
</table>
<p>Пример кода для создания необходимых записей в реестре:</p>
<pre>
VAR
 Reg:TRegistry;
 RegKey:String;
 AppPath:String;
 AppName:String;
 NumCategories:Integer;
 
Begin
Reg:=TRegistry.Create;
Try
 AppPath:=Application.ExeName;
 AppName:='MyApplication';
 NumCategories:=2;
 RegKey:=
 Format('SYSTEMCurrentControlSetServicesEventLogApplication%s',[AppName]);
 Reg.RootKey:=HKEY_LOCAL_MACHINE;
 Reg.OpenKey(RegKey,True);
 // Собственное имя
 Reg.WriteString('CategoryMessageFile',AppPath); 
 // Собственное имя
 Reg.WriteString('EventMessageFile',AppPath); 
 // Максимальное количество категорий
 Reg.WriteInteger('CategoryCount',NumCategories); 
 // Разрешаем все типы
 Reg.WriteInteger('TypesSupported',EVENTLOG_SUCCESS or
                                   EVENTLOG_ERROR_TYPE or
                                   EVENTLOG_WARNING_TYPE or
                                   EVENTLOG_INFORMATION_TYPE); 
 Reg.CloseKey;
 EventLog:=RegisterEventSource(nil,PChar(AppName));
Finally
 Reg.Free;
End; //try..finally
 
End;
</pre>
<p>Сообщение и ресурсы категорий.</p>
<p>Информация, помещаемая в реестр вышеприведенным кодом, информирует журнал событий о том, где искать строки событий и категорий, основываясь на имени источника, которое использует приложение для записи в журнал. И, как мы уже говорили, чтобы журнал событий искал эти строки в нашем исполняемом файле, нам нужно включить эти строковые ресурсы в наш файл. Этот процесс состоит из следующих шагов:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Написание исходного файла таблицы сообщений (файл .mc).</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Компиляция .mc файла при помощи Microsoft message compiler.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Подключение получившейся информации к нашему Delphi приложению.</td></tr></table></div><p>Есть много примеров по написанию .mc файлов в Windows SDK и на различных сайтах, включая MSDN, однако документация не достаточно проста, поэтому приводим минимально достаточное описание для создания файла таблицы сообщений:</p>
<p>;//Example Message source file exmess.mc</p>
<p>MessageId=0</p>
<p>Language=English</p>
<p>%1</p>
<p>.</p>
<p>MessageId=1</p>
<p>Language=English</p>
<p>Category1</p>
<p>.</p>
<p>MessageId=2</p>
<p>Language=English</p>
<p>Category2</p>
<p>.</p>
<p>Строки, начинающиеся с ;// являются комментариями и не компилируются. Этот пример содержит три строковых ресурса - один определитель формата сообщения и две категории, хотя файл может содержать только первый ресурс. Каждый ресурс отделен одной отдельной точкой на строке, так же, как и в конце файла. Если в конце файла отсутствует перевод строки после точки, то файл не будет скомпилирован. Первая строка каждого ресурса является MessageID (index), при помощи которого приложение будет обращаться к строке. Следующая строка указывает язык ресурса. В нашем случае "English" - означает international English, язык по умолчанию для всех Windows платформ. Информацию по многоязыковым ресурсам см. в справке к компилятору ресурсов. Последняя строка определяет собственно текст сообщения. В случае ресурса 0, строка будет "%1", что означает, что передается сама строка. Если, например, нужен префикс сообщения "An Event Message" (Сообщение события), то строка будет иметь вид: "An Event Message %1". Более полное описание форматов см. в API справке по FormatMessage и компилятору ресурсов. Ресурсы категорий не требуют форматированных аргументов. Как видно в примере, мы определили две категории "Category1" и "Category2". Следующий этап - компиляция .mc файла при помощи Microsoft message compiler (mc.exe), который можно взять у Microsoft (входит в состав Platform SDK). Наш пример, имеющий имя "exmess.mc" может быть скомпилирован из командной строки таким образом:</p>
<p>Mc exmess.mc</p>
<p>В результате получаем три файла: exmess.rc, bin00001.msg и exmess.h. emess.h может быть использован как заголовочный файл для обращения к ресурсам по их символическим именам, если таковые указаны (в нашем примере нет). .bin файл это откомпилированный бинарный ресурс с сообщениями, .rc это файл ресурсов Windows. Он может быть откомпилирован в Delphi .res файл при помощи brcc32.exe - компилятора ресурсов Delphi или просто добавлен в проект при помощи project manager, и тогда Delphi автоматически его откомпилирует при компиляции проекта (build).</p>
<p>Запись событий с категориями.</p>
<p>Теперь наше приложение имеет ресурсы и необходимые записи в реестре или код, который их внесет. Значит, приложение может записывать события в журнал без сообщения об отсутствии ресурсов и с добавочным индексом категории события:</p>
<pre>
VAR EventLog: THandle;
EventLog:=RegisterEventSource(nil,PChar('MyApplication'));
 
VAR MyMsg:Array[0..2] of PChar;
MyMsg[0]:='A test event message';
 
ReportEvent(EventLog, EVENTLOG_INFORMATION_TYPE,1,0,nil,1,0,@MyMsg,nil);
</pre>
<p>Вышеприведенный код запишет событие в журнал с текстом "A test event message" и, потому что 1 следует за параметром EventLogType, это будет событие категории "Category1". Это достигнуто указанием 0 в качестве идентификатора события, который соответствует определителю формата в ресурсе 0 ("%1"). В результате текст сообщения события будет передан без изменения. Точно так же, категория указана 1, что соответствует "Category1" в нашем ресурсе 1. Журнал событий поддерживает "живую связь" с файлами сообщений и категорий, указанных в реестре, что означает, что когда пользователь захочет просмотреть журнал, просмотрщик событий получит доступ к файлам ресурсов для детального отображения событий. Это также означает, что если вы создадите множество событий, при помощи указанного файла ресурсов, и, затем, измените значения в файле ресурсов и произведете обновление (refresh) в просмотрщике событий, тексты событий и номера категорий так же изменятся в соответствии с ресурсами. Точно так же, если файл ресурсов вдруг будет удален или записи в реестре будут уничтожены или повреждены, то журнал не сможет получить доступ к ресурсам, и отобразит сообщение с ошибкой в виде префикса события, как было описано в начале статьи. В этом случае вместо номера категории события будет отображен индекс категории.</p>

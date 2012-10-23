<h1>Работа с Bluetooth в Delphi</h1>
<div class="date">01.01.2006</div>


<p>Часть 1</p>
<p>&#169; 2006 Петриченко Михаил,</p>
<p>Soft Service Company</p>
<p>Вступление</p>
<p>Этой статьей хочу начать серию по работе с Bluetooth в Delphi под Microsoft Windows XP. Так как тема весьма сложная, прошу внимательно читать. Повторяться не буду.</p>
<p>Все программы написаны на Delphi 6 и тестировались со стандартным стеком Bluetooth от Microsoft под Windows XP + SP2.</p>
<p>Все необходимые библиотеки прилагаются. Так что дополнительно ничего качать не нужно. При разработке использовал только API функции с JEDI.</p>
<p>Описание функций будут даны в стиле Object Pascal. Сионистов просьба обращаться к MSDN и Microsoft Platform SDK.</p>
<p>Получение списка установленных радиомодулей Bluetooth</p>
<p>Итак, для начала попробуем получить список установленных на компьютере радиомодулей Bluetooth.</p>
<p>BluetoothFindFirstRadio - начинает перечисление локальных радиомодулей Bluetooth.</p>
<p>Объявление функции:</p>
<pre>
function BluetoothFindFirstRadio(
                const pbtfrp : PBlueToothFindRadioParams;
                var phRadio : THandle): HBLUETOOTH_RADIO_FIND; stdcall; 
</pre>
<p>Параметры:</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>pbtfrp</p>
</td>
<td><p>указатель на структуру BLUETOOTH_FIND_RADIO_PARAMS. Член dwSize этой структуры должен содержать размер структуры (устанавливается посредством SizeOf(BLUETOOTH_FIND_RADIO_PARAMS)).</p>
</td>
</tr>
<tr>
<td><p>phRadio</p>
</td>
<td><p>описатель (Handle) найденного устройства.
</td>
</tr>
</table>
<p>Возвращаемые значения:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>В случае успешного выполнения функция вернет корректный описатель в phRadio и корректный описатель в качестве результата</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>В случае ошибки будет возвращен 0. Для получения кода ошибки используйте функцию GetLastError</td></tr></table></div><p>BluetoothFindNextRadio - находит следующий установленный радиомодуль Bluetooth.</p>
<p>Объявление функции:</p>
<pre>
function BluetoothFindNextRadio(
             hFind : HBLUETOOTH_RADIO_FIND;
             var phRadio : THandle): BOOL; stdcall; 
</pre>
&nbsp;</p>
<p>Параметры:</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>hFind</p>
</td>
<td><p>Описатель, который вернула функция BluetoothFindFirstRadio</p>
</td>
</tr>
<tr>
<td><p>phRadio</p>
</td>
<td><p>Сюда будет помещен описатель следующего найденного радиомодуля
</td>
</tr>
</table>
<p>Возвращаемые значения:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Вернет TRUE, если устройство найдено. В phRadio корректный описатель на найденный радиомодуль.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Вернет FALSE в случае отсутствия устройства. phRadio содержит некорректный описатель. Используйте GetLastError для получения кода ошибки.</td></tr></table></div><p>BluetoothFindRadioClose - закрывает описатель перечисления радиомодулей Bluetooth.</p>
<p>Объявление функции:</p>
<pre>
function BluetoothFindRadioClose(hFind : HBLUETOOTH_RADIO_FIND): BOOL; stdcall; 
</pre>
&nbsp;</p>
<p>Параметры:</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>hFind</p>
</td>
<td><p>Описатель, который вернула функция BluetoothFindFirstRadio
</td>
</tr>
</table>
<p>Возвращаемые значения:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Вернет TRUE если описатель успешно закрыт.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Вернет FALSE в случае ошибки. Для получения кода ошибки используйте GetLastError.</td></tr></table></div><p>Теперь у нас достаточно знаний, чтобы получить список установленных радиомодулей Bluetooth.</p>
<p>Напишем вот такую процедуру:</p>
<pre>
procedure EnumRadio;
var
  hRadio: THandle;
  BFRP: BLUETOOTH_FIND_RADIO_PARAMS;
  hFind: HBLUETOOTH_RADIO_FIND;
begin
  // Инициализация структуры BLUETOOTH_FIND_RADIO_PARAMS
  BFRP.dwSize := SizeOf(BFRP);
  // Начинаем поиск
  hFind := BluetoothFindFirstRadio(@BFRP, hRadio);
  if (hFind &lt;&gt; 0) then
  begin
  repeat
  // Что-то сделать с полученным описателем
 
  // Закрыть описатель устройства
  CloseHandle(hRadio);
 
  // Находим следующее устройство
  until (not BluetoothFindNextRadio(hFind, hRadio));
  // Закрываем поиск
  BluetoothFindRadioClose(hFind);
  end;
end; 
</pre>
&nbsp;</p>
<p>Это, конечно, все здорово, но в принципе бесполезно. Давайте что-нибудь сделаем еще. Например, получим информацию о радиомодуле Bluetooth.</p>
<p>Получение информации о радиомодуле Bluetooth</p>
<p>Для получения информации о радиомодуле Bluetooth используется функция</p>
<p>BluetoothGetRadioInfo - возвращает информацию о радиомодуле, который представлен описателем.</p>
<p>Объявление функции:</p>
<pre>
function BluetoothGetRadioInfo(hRadio : THandle;
                    var pRadioInfo : BLUETOOTH_RADIO_INFO): DWORD; stdcall; 
</pre>
&nbsp;</p>
<p>Параметры:</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>hRadio</p>
</td>
<td><p>Описатель локального радиомодуля, который получен функцией BluetoothFindRadioFirst или BluetoothFindRadioNext</p>
</td>
</tr>
<tr>
<td><p>pRadioInfo</p>
</td>
<td><p>Структура, в которую записывается информация об указанном радиомодуле. Член dwSize должен быть равен размеру структуры
</td>
</tr>
</table>
<p>Возвращаемые значения:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Вернет ERROR_SUCCESS если информация получена, в противном случае код ошибки.</td></tr></table></div><p>Структура BLUETOOTH_RADIO_INFO выгляди вот так:</p>
<pre>
_BLUETOOTH_RADIO_INFO = record
dwSize : dword;
address : BLUETOOTH_ADDRESS;
szName : array [0..BLUETOOTH_MAX_NAME_SIZE - 1] of widechar;
ulClassofDevice : ulong;
lmpSubversion : word; 
manufacturer : word;
end;
</pre>
&nbsp;<br>
<p>&nbsp;</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>dwSize</p>
</td>
<td><p>Размер структуры в байтах</p>
</td>
</tr>
<tr>
<td><p>address</p>
</td>
<td><p>Адрес локального радиомодуля</p>
</td>
</tr>
<tr>
<td><p>szName</p>
</td>
<td><p>Имя радиомодуля</p>
</td>
</tr>
<tr>
<td><p>ulClassofDevice</p>
</td>
<td><p>Класс устройства</p>
</td>
</tr>
<tr>
<td><p>lmpSubversion</p>
</td>
<td><p>Устанавливается производителем</p>
</td>
</tr>
<tr>
<td><p>manufacturer</p>
</td>
<td><p>Код производителя (константы BTH_MFG_Xxx). Для получения новых кодов обратитесь к сайту спецификаций Bluetooth
</td>
</tr>
</table>
<p>Это уже что-то. Воспользуемся этой информацией и напишем вот такую процедуру.</p>
<pre>
procedure GetRadioInfo(hRadio: THandle);
var RadioInfo: BLUETOOTH_RADIO_INFO;
begin
  // Инициализация структуры BLUETOOTH_RADIO_INFO
  FillChar(RadioInfo, 0, SizeOf(RadioInfo));
  RadioInfo.dwSize := SizeOf(RadioInfo);
  // Получаем информацию
  if (BluetoothGetRadioInfo(hRadio, RadioInfo) = ERROR_SUCCESS) then 
  begin
  // Используем полученную информацию
  end;
end; 
</pre>
&nbsp;</p>
<p>Заключение</p>
<p>Вот пока и все. В следующей статье рассмотрим, как получить список присоединенных устройств и опросить сервисы, которые они представляют.</p>
<p>Работа с Bluetooth в Delphi</p>
<p>Часть 2</p>
&#169; 2006 Петриченко Михаил,<br>
<p>Soft Service Company</p>
<p>Вступление</p>
<p>В первой части статьи мы научились получать список локальных радиомодулей Bluetooth и узнавать их свойства.</p>
<p>Теперь пришло время получить список устройств Bluetooth, которые подключены к нашим локальным радиомодулям.</p>
<p>Получение списка устройств Bluetooth</p>
<p>Для получения списка устройств Bluetooth нам понадобятся следующие функции (они очень похожи на функции, используемые для получения списка локальных радиомодулей).</p>
<p>BluetoothFindFirstDevice - начинает перечисление устройств Bluetooth.</p>
<p>Объявление функции:</p>
<pre>
function BluetoothFindFirstDevice(
           const pbtsp : BLUETOOTH_DEVICE_SEARCH_PARAMS;
           var pbtdi : BLUETOOTH_DEVICE_INFO): HBLUETOOTH_DEVICE_FIND; stdcall; 
</pre>
&nbsp;</p>
<p>Параметры:</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>Pbtsp</p>
</td>
<td><p>Указатель на структуру BLUETOOTH_DEVICE_SEARCH_PARAMS. Член dwSize этой структуры должен содержать размер структуры (устанавливается посредством SizeOf(BLUETOOTH_DEVICE_SEARCH_PARAMS)). Член hRadio должен содержать описатель локального радиомодуля, полученный вызовом функции BluetoothFindFirstRadio.</p>
</td>
</tr>
<tr>
<td><p>Pbtdi</p>
</td>
<td><p>Структура BLUETOOTH_DEVICE_INFO в которую будет возвращена информации об устройстве Bluetooth.
</td>
</tr>
</table>
<p>Возвращаемые значения:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>В случае успешного выполнения функция вернет корректный описатель в качестве результата.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>В случае ошибки будет возвращен 0. Для получения кода ошибки используйте функцию GetLastError</td></tr></table></div><p>BluetoothFindNextDevice - находит следующее устройство Bluetooth.</p>
<p>Объявление функции:</p>
<pre>
function BluetoothFindNextDevice(hFind : HBLUETOOTH_DEVICE_FIND;
                                 var pbtdi : BLUETOOTH_DEVICE_INFO): BOOL; stdcall; 
</pre>
&nbsp;</p>
<p>Параметры:</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>hFind</p>
</td>
<td><p>Описатель, который вернула функция BluetoothFindFirstDevice</p>
</td>
</tr>
<tr>
<td><p>pbtdi</p>
</td>
<td><p>Структура BLUETOOTH_DEVICE_INFO, в которую будет помещена информацию об устройстве
</td>
</tr>
</table>
<p>Возвращаемые значения:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Вернет TRUE, если устройство найдено.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Вернет FALSE в случае отсутствия устройства. Используйте GetLastError для получения кода ошибки.</td></tr></table></div><p>BluetoothFindDeviceClose - закрывает описатель перечисления устройств Bluetooth.</p>
<p>Объявление функции:</p>
<pre>
function BluetoothFindDeviceClose(hFind : HBLUETOOTH_DEVICE_FIND): BOOL; stdcall;
</pre>
&nbsp;</p>
<p>Параметры:</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>hFind</p>
</td>
<td><p>Описатель, который вернула функция BluetoothFindFirstDevice
</td>
</tr>
</table>
<p>Возвращаемые значения:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Вернет TRUE если описатель успешно закрыт.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Вернет FALSE в случае ошибки. Для получения кода ошибки используйте GetLastError.</td></tr></table></div><p>BluetoothGetDeviceInfo - возвращает информацию об указанном устройстве Bluetooth.</p>
<p>Объявление функции:</p>
<pre>
function BluetoothGetDeviceInfo(hRadio : THandle;
                       var pbtdi : BLUETOOTH_DEVICE_INFO): DWORD; stdcall; 
</pre>
&nbsp;</p>
<p>Параметры:</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>hRadio</p>
</td>
<td><p>Описатель локального радиомодуля Bluetooth</p>
</td>
</tr>
<tr>
<td><p>pbtdi</p>
</td>
<td><p>Структура BLUETOOTH_DEVICE_INFO, в которую возвразается информация об устройстве. dwSize должен быть равен размеру структуры. addreess должен содержать адрес устройства, о котором хотим получить информацию.
</td>
</tr>
</table>
<p>Возвращаемые значения:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Вернет ERROR_SUCCESS если выполнено успешно и информация занесена в структуру pbtdi. Остальные значения &#8211; код ошибки.</td></tr></table></div><p>Обладая этими знаниями, можно написать процедуру получения информации об устройствах Bluetooth:</p>
<pre>
procedure GetDevices(_hRadio: THandle);
var
DeviceInfo: PBLUETOOTH_DEVICE_INFO;
DeviceSearchParams: BLUETOOTH_DEVICE_SEARCH_PARAMS;
DeviceFind: HBLUETOOTH_DEVICE_FIND;
begin
// Инициализация структуры BLUETOOTH_DEVICE_SEARCH_PARAMS
with DeviceSearchParams do 
begin
dwSize := SizeOf(BLUETOOTH_DEVICE_SEARCH_PARAMS);
fReturnRemembered := true; // Вернуть запомненные
hRadio := _hRadio;
end;
 
// Инициализация структуры BLUETOOTH_DEVICE_INFO
FillChar(DeviceInfo, SizeOf(BLUETOOTH_DEVICE_INFO), 0);
DeviceInfo.dwSize := SizeOf(PBLUETOOTH_DEVICE_INFO);
 
// Начинаем поиск
DeviceFind := BluetoothFindFirstDevice(DeviceSearchParams, DeviceInfo);
if (DeviceFind &lt;&gt; 0) then begin
repeat
// Что-то сделать с полученными данными
 
// Инициализация структуры BLUETOOTH_DEVICE_INFO
FillChar(DeviceInfo, SizeOf(BLUETOOTH_DEVICE_INFO), 0);
DeviceInfo.dwSize := SizeOf(PBLUETOOTH_DEVICE_INFO);
// Находим следующее устройство
until (not BluetoothFindNextDevice(DeviceFind, DeviceInfo));
 
// Закрываем поиск
BluetoothFindDeviceClose(DeviceFind);
end;
end; 
</pre>
&nbsp;</p>
<p>Заключение</p>
<p>Пока все. В следующей части рассмотрим способы получения информации о сервисах, предоставляемых устройствами Bluetooth.</p>
<p>Работа с Bluetooth в Delphi</p>
<p>Часть 3</p>
&#169; 2006 Петриченко Михаил,<br>
<p>Soft Service Company</p>
<p>Вступление</p>
<p>И так, в предыдущих частях мы научились получать список локальных радиомодулей Bluetooth и удаленных устройств Bluetooth. Нам осталось научиться получать список сервисов, предоставляемых удаленным устройством и управлять локальными радиомодулями. Так же, необходимо разобраться, как же все-таки передаются данные между различными устройствами Bluetooth.</p>
<p>В этой части, а она будет самой длинной и информативной, мы создадим программу, которая поможет нам обобщить полученную информацию и покажет, как использовать новые функции, которые здесь будут описаны.</p>
<p>Прежде, чем мы приступим, давайте определимся в терминах. Microsoft в своей документации вводит два термина: Radio и Device. Radio &#8211; это локальный радиомодуль Bluetooth (USB-брелок, интегрированное решение, в общем то, что установлено на вашем компьютере). Device &#8211; это то устройство Bluetooth с которым вы хотите обмениваться информацией. Будь то телефон, КПК, гарнитура или еще что-то. Важно понимать, что если мы пишем программу для PDA, то когда она работает на PDA - его модуль Bluetooth будет Radio, а компьютер - Device. Если же она работает на компьютере, то компьютерный модуль &#8211; Radio, а PDA &#8211; Device.</p>
<p>Что мы знаем</p>
<p>К сожалению, документация Microsoft по Bluetooth API и работе с Bluetooth настолько скудна (у меня получилось 50 страниц в Word с оформлением), а примеров они вообще не предоставляют, что из нее очень трудно понять, как же все-таки работает эта технология.</p>
<p>Когда я только начинал изучать этот предмет, я перерыл весь Internet, но так ничего вразумительного не нашел.</p>
<p>По-этому, здесь мне хочется дать наиболее полную и подробную информацию об этом вопросе, что бы вы не столкнулись с той же проблемой отсутствия информации.</p>
<p>И так, приступим.</p>
<p>Создание проекта</p>
<p>Давайте создадим в Delphi новый проект и сохраним его под именем BTWork, а модуль &#8211; под именем Main.</p>
<p>Главную и пока единственную форму, назовем fmMain. Заголовок BTWork.</p>
<p>Теперь нам понадобятся файл JwaBluetoothAPI.pas, JwaBtHDef.pas и JwaBthSdpDef.pas. Их можно найти в примерах из предыдущих частей или в библиотеке BTClasses.</p>
<p>Для того, чтобы не тянуть с собой все остальные файлы из JWA, давайте эти чуть-чуть исправим. Найдите в них строку</p>
uses<br>
<p>JwaWindows</p>
<p>и замените JwaWindows на Windows.</p>
<p>Далее удалить из них строки</p>
<pre>
{$WEAKPACKAGEUNIT}
 
{$HPPEMIT ''}
{$HPPEMIT '#include "bluetoothapis.h"'}
{$HPPEMIT ''}
 
{$I jediapilib.inc} 
</pre>
&nbsp;</p>
<p>И в файле JwaBluetoothAPI удалите все, что находится между {$IFDEF DYNAMIC_LINK} и {$ELSE} вместе с этими DEF. И в конце этого файле удалите {$ENDIF}.</p>
<p>Далее, в JwaBluetoothAPI.pas после</p>
implementation<br>
&nbsp;<br>
uses<br>
<p>JwaWinDLLNames;</p>
<p>Напишите</p>
const<br>
<p>btapi = 'irprops.cpl';</p>
<p>Да простят нас ребята, которые эту библиотеку писали!</p>
<p>Все эти действия я делал для того, что бы уменьшить архив примера. Да и не нужно тянуть за собой много лишнего. Хотя сама библиотека весьма полезна. Один модуль JwaWindows чего стоит. Там очень много интересного есть. Ну да ладно &#8211; что-то я отвлекся.</p>
<p>После того, как мы кастрировали эти модули, давайте добавим их в наш проект. Готово?</p>
<p>В этом приложении мы будем получать список локальных радиомодулей, устройств, к ним присоединенных, список сервисов, предоставляемых устройствами. Также мы должны управлять радиомодулями и научиться проходить авторизацию.</p>
<p>Приступаем.</p>
<p>Оформление главной формы</p>
<p>На главную форму поместим компонент TPanel и установите следующие свойства:<br>
<p>&nbsp;</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>Свойство</p>
</td>
<td><p>Значение</p>
</td>
</tr>
<tr>
<td><p>Align</p>
</td>
<td><p>alTop</p>
</td>
</tr>
<tr>
<td><p>Caption</p>
</td>
<td>
</td>
</tr>
<tr>
<td><p>Name</p>
</td>
<td><p>Panel
</td>
</tr>
</table>
<p>Далее поместим компонент TTreeView и установите свойства как в таблице:<br>
<p>&nbsp;</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>Свойство</p>
</td>
<td><p>Значение</p>
</td>
</tr>
<tr>
<td><p>Align</p>
</td>
<td><p>alLeft</p>
</td>
</tr>
<tr>
<td><p>Cursor</p>
</td>
<td><p>crHandPoint</p>
</td>
</tr>
<tr>
<td><p>HideSelection</p>
</td>
<td><p>False</p>
</td>
</tr>
<tr>
<td><p>HotTrack</p>
</td>
<td><p>True</p>
</td>
</tr>
<tr>
<td><p>Name</p>
</td>
<td><p>TreeView</p>
</td>
</tr>
<tr>
<td><p>ReadOnly</p>
</td>
<td><p>True
</td>
</tr>
</table>
<p>Правее TTreeView поместим TSplitter и установим следующие его свойства:<br>
<p>&nbsp;</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>Свойство</p>
</td>
<td><p>Значение</p>
</td>
</tr>
<tr>
<td><p>Name</p>
</td>
<td><p>Splitter</p>
</td>
</tr>
<tr>
<td><p>Width</p>
</td>
<td><p>5
</td>
</tr>
</table>
<p>И, наконец, помещаем компонент TListView еще правее TSplitter. Устанавливаем его свойства как в таблице:<br>
<p>&nbsp;</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>Свойство</p>
</td>
<td><p>Значение</p>
</td>
</tr>
<tr>
<td><p>Align</p>
</td>
<td><p>alClient</p>
</td>
</tr>
<tr>
<td><p>ColumnClick</p>
</td>
<td><p>False</p>
</td>
</tr>
<tr>
<td><p>Cursor</p>
</td>
<td><p>crHandPoint</p>
</td>
</tr>
<tr>
<td><p>GridLines</p>
</td>
<td><p>True</p>
</td>
</tr>
<tr>
<td><p>HideSelection</p>
</td>
<td><p>False</p>
</td>
</tr>
<tr>
<td><p>HotTrack</p>
</td>
<td><p>True</p>
</td>
</tr>
<tr>
<td><p>Name</p>
</td>
<td><p>ListView</p>
</td>
</tr>
<tr>
<td><p>ReadOnly</p>
</td>
<td><p>True</p>
</td>
</tr>
<tr>
<td><p>RowSelect</p>
</td>
<td><p>True</p>
</td>
</tr>
<tr>
<td><p>ShowWorkAreas</p>
</td>
<td><p>True</p>
</td>
</tr>
<tr>
<td><p>ViewStyle</p>
</td>
<td><p>vsReport
</td>
</tr>
</table>
<p>На TPanel поместим кнопку TButton.<br>
<p>&nbsp;</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>Свойство</p>
</td>
<td><p>Значение</p>
</td>
</tr>
<tr>
<td><p>Caption</p>
</td>
<td><p>Refresh</p>
</td>
</tr>
<tr>
<td><p>Name</p>
</td>
<td><p>btRefresh
</td>
</tr>
</table>
<p>Теперь мы готовы писать программу.</p>
<p>Пишем код</p>
<p>При старте нашей программы, желательно чтобы сразу заполнялся TreeView. В нем будут показаны модули Bluetooth и устройства, которые к ним подключены.</p>
<p>Для этого в обработчике OnCreate формы fmMain напишем такой код:</p>
<pre>
procedure TfmMain.FormCreate(Sender: TObject);
begin
btRefresh.Click;
end; 
</pre>
&nbsp;</p>
<p>А в обработчике OnClick кнопки btRefresh напишем следующее:</p>
<pre>
procedure TfmMain.btRefreshClick(Sender: TObject);
var
RootNode: TTreeNode;
hFind: HBLUETOOTH_RADIO_FIND;
hDevFind: HBLUETOOTH_DEVICE_FIND;
FindParams: BLUETOOTH_FIND_RADIO_PARAMS;
SearchParams: BLUETOOTH_DEVICE_SEARCH_PARAMS;
SearchParamsSize: dword;
DevInfo: ^PBLUETOOTH_DEVICE_INFO;
DevInfoSize: dword;
hRadio: THandle;
RadioInfo: PBLUETOOTH_RADIO_INFO;
RadioInfoSize: dword;
RadioNode: TTreeNode;
Loop: integer;
DevNode: TTreeNode;
begin
with TreeView.Items do
begin
BeginUpdate;
 
// Очищаем дерево
for Loop := 0 to Count - 1 do 
begin
if TreeView.Items[Loop].ImageIndex &gt; 0 then
CloseHandle(TreeView.Items[Loop].ImageIndex);
if Assigned(TreeView.Items[Loop].Data) then
Dispose(TreeView.Items[Loop].Data);
end;
Clear;
 
// Корневая ветвь в дереве
RootNode := Add(nil, 'Bluetooth Radios');
with RootNode do 
begin
Data := nil;
ImageIndex := -1;
end;
 
// Начинаем поиск локальных модулей Bluetooth
FindParams.dwSize := SizeOf(BLUETOOTH_FIND_RADIO_PARAMS);
hFind := BluetoothFindFirstRadio(@FindParams, hRadio);
if hFind &lt;&gt; 0 then begin
repeat
// Получить информацию о радиомодуле
New(RadioInfo);
RadioInfoSize := SizeOf(BLUETOOTH_RADIO_INFO);
FillChar(RadioInfo^, RadioInfoSize, 0);
RadioInfo^.dwSize := RadioInfoSize;
// Ошибки не обрабатываем!!!
BluetoothGetRadioInfo(hRadio, RadioInfo^);
 
// Добавляем радио в дерево
RadioNode := AddChild(RootNode,
string(RadioInfo^.szName) + ' [' +
BTAdrToStr(RadioInfo^.address) + ']');
with RadioNode do
begin
// Так как мы сохраняем Handle, то не закрываем его!
ImageIndex := hRadio; 
Data := RadioInfo;
end;
 
// Начинаем поиск устройств для найденного радиомодуля.
SearchParamsSize := SizeOf(BLUETOOTH_DEVICE_SEARCH_PARAMS);
FillChar(SearchParams, SearchParamsSize, 0);
SearchParams.dwSize := SearchParamsSize;
SearchParams.fReturnRemembered := True;
SearchParams.hRadio := hRadio;
 
New(DevInfo);
DevInfoSize := SizeOf(BLUETOOTH_DEVICE_INFO);
FillChar(DevInfo^, DevInfoSize, 0);
DevInfo^.dwSize := DevInfoSize;
 
// Ищем первое
hDevFind := BluetoothFindFirstDevice(SearchParams, DevInfo^);
if hDevFind &lt;&gt; 0 then begin
repeat
// Добавляем в дерево
DevNode := AddChild(RadioNode,
string(DevInfo^.szName) + ' [' +
BTAdrToStr(DevInfo^.Address) + ']');
with DevNode do 
begin
Data := DevInfo;
ImageIndex := -2;
end;
 
// Ищем следующее устройство
New(DevInfo);
DevInfoSize := SizeOf(BLUETOOTH_DEVICE_INFO);
FillChar(DevInfo^, DevInfoSize, 0);
DevInfo^.dwSize := DevInfoSize;
until not BluetoothFindNextDevice(hDevFind, DevInfo^);
 
// Поиск устройств закончен
BluetoothFindDeviceClose(hDevFind);
end;
 
// Находим следующее радио
until not BluetoothFindNextRadio(hFind, hRadio);
 
// Поиск радиомодулей закончен
BluetoothFindRadioClose(hFind);
end;
 
EndUpdate;
end;
 
with TreeView do
begin
Selected := RootNode;
Items[0].Expand(True);
end;
end; 
</pre>
&nbsp;</p>
<p>В uses нашего модуля, который относится к главной форме, допишем:</p>
<pre>
implementation // Уже написано!!!
 
uses // Дописать!
JwaBluetoothAPIs, Windows, SysUtils, Dialogs; 
</pre>
&nbsp;</p>
<p>Ниже добавим функцию:</p>
<pre>// Преобразует адрес из внутреннего формата (dword) в строку,
// принятую для представления адресов устройств Bluetooth.
function BTAdrToStr(const Adr: BLUETOOTH_ADDRESS): string;
var
Loop: byte;
begin
Result := IntToHex(Adr.rgBytes[0], 2);
for Loop := 1 to 5 do
Result := IntToHex(Adr.rgBytes[Loop], 2) + ‘:’ + Result;
end;
</pre>
<p>Здесь хочу привести описание используемых структур, так как ранее я их не описывал:</p>
<p>BLUETOOTH_DEVICE_SEARCH_PARAMS</p>
<p>Объявление:</p>
<pre>
BLUETOOTH_DEVICE_SEARCH_PARAMS = record
dwSize : DWORD;
fReturnAuthenticated : BOOL;
fReturnRemembered : BOOL;
fReturnUnknown : BOOL;
fReturnConnected : BOOL;
fIssueInquiry : BOOL;
cTimeoutMultiplier : UCHAR;
hRadio : THandle;
end; 
</pre>
&nbsp;</p>
<p>Члены:</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>dwSize</p>
</td>
<td><p>Входной параметр. Должен быть равен размеру структуры (dwSize := SizeOf(BLUETOOTH_DEVICE_SEARCH_PARAMS))</p>
</td>
</tr>
<tr>
<td><p>fReturnAuthenticated</p>
</td>
<td><p>Входной параметр. Функция будет возвращать устройства, прошедшие авторизацию.</p>
</td>
</tr>
<tr>
<td><p>fReturnRemembered</p>
</td>
<td><p>Входной параметр. Функция будет возвращать устройства, уже запомненные раннее.</p>
</td>
</tr>
<tr>
<td><p>fReturnUnknown</p>
</td>
<td><p>Входной параметр. Функция будет возвращать новые либо неизвестные устройства.</p>
</td>
</tr>
<tr>
<td><p>fReturnConnected</p>
</td>
<td><p>Входной параметр. Функция будет возвращать подключенные устройства.</p>
</td>
</tr>
<tr>
<td><p>fIssueInquiry</p>
</td>
<td><p>Входной параметр. Заставляет функцию проверять устройства.</p>
</td>
</tr>
<tr>
<td><p>cTimeoutMultiplier</p>
</td>
<td><p>Входной параметр. Тайм-аут для проверки устройства.</p>
</td>
</tr>
<tr>
<td><p>hRadio</p>
</td>
<td><p>Handle радиомодуля, для которого проводится поиск устройств. Если 0, то проверяются все радиомодули.
</td>
</tr>
</table>
<p>BLUETOOTH_DEVICE_INFO</p>
<p>Объявление:</p>
<pre>
BLUETOOTH_DEVICE_INFO = record
dwSize : DWORD;
Address : BLUETOOTH_ADDRESS;
ulClassofDevice : ULONG;
fConnected : BOOL;
fRemembered : BOOL;
fAuthenticated : BOOL;
stLastSeen : SYSTEMTIME;
stLastUsed : SYSTEMTIME;
szName : array [0..BLUETOOTH_MAX_NAME_SIZE - 1] of WideChar;
end; 
</pre>
&nbsp;</p>
<p>Члены:</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>dwSize</p>
</td>
<td><p>Входной параметр. Должен быть равен размеру структуры (dwSize := SizeOf(BLUETOOTH_DEVICE_INFO))</p>
</td>
</tr>
<tr>
<td><p>Address</p>
</td>
<td><p>Адрес устройства Bluetooth.</p>
</td>
</tr>
<tr>
<td><p>ulClassofDevice</p>
</td>
<td><p>Класс устройства. Подробнее по классам смотрите в JwaBluetoothAPIs. Константы с префиксом COD_xxx.</p>
</td>
</tr>
<tr>
<td><p>fConnected</p>
</td>
<td><p>Если TRUE, то устройство подключено/используется</p>
</td>
</tr>
<tr>
<td><p>fRemembered</p>
</td>
<td><p>Если TRUE, то устройство ранее уже было найдено (запомнено)</p>
</td>
</tr>
<tr>
<td><p>fAuthenticated</p>
</td>
<td><p>Если TRUE, то устройство прошло авторизацию (авторизированно)</p>
</td>
</tr>
<tr>
<td><p>stLastSeen</p>
</td>
<td><p>Дата и время последнего обнаружения устройства</p>
</td>
</tr>
<tr>
<td><p>stLastUsed</p>
</td>
<td><p>Дата и время последнего использования устройства</p>
</td>
</tr>
<tr>
<td><p>szName</p>
</td>
<td><p>Название устройства (имя)
</td>
</tr>
</table>
<p>BLUETOOTH_RADIO_INFO</p>
<p>Объявление:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 24px 7px 0px;"><pre>BLUETOOTH_RADIO_INFO = record
dwSize : DWORD;
address : BLUETOOTH_ADDRESS;
szName : array [0..BLUETOOTH_MAX_NAME_SIZE - 1] of WideChar;
ulClassofDevice : ULONG;
lmpSubversion : Word;
manufacturer : Word;
end;
</pre>
<p>Члены:</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>dwSize</p>
</td>
<td><p>Должен быть равен размеру структуры (dwSize := SizeOf(BLUETOOTH_RADIO_INFO))</p>
</td>
</tr>
<tr>
<td><p>Address</p>
</td>
<td><p>Адрес радиомодуля Bluetooth</p>
</td>
</tr>
<tr>
<td><p>szName</p>
</td>
<td><p>Имя радиомодуля</p>
</td>
</tr>
<tr>
<td><p>ulClassofDevice</p>
</td>
<td><p>Класс устройства (см. выше)</p>
</td>
</tr>
<tr>
<td><p>lmpSubversion</p>
</td>
<td><p>Зависит от производителя</p>
</td>
</tr>
<tr>
<td><p>Manufacturer</p>
</td>
<td><p>Код производителя. Определяется константами BTH_MFG_Xxx. Более полную информацию о производителях можно получить на сайте поддержки Bluetooth.
</td>
</tr>
</table>
<p>Далее напишем вот такой обработчик события OnChange для TreeView:</p>
<pre>
procedure TfmMain.TreeViewChange(Sender: TObject; Node: TTreeNode);
var
ASelected: TTreeNode;
 
procedure ShowRadios;
var
Info: PBLUETOOTH_RADIO_INFO;
CurNode: TTreeNode;
begin
// Строим столбцы
with ListView.Columns do 
begin
BeginUpdate;
with Add do Caption := 'Address';
with Add do Caption := 'Name';
with Add do Caption := 'Class Of Device';
with Add do Caption := 'Manufacturer';
with Add do Caption := 'Subversion';
with Add do Caption := 'Connectable';
with Add do Caption := 'Discoverable';
EndUpdate;
end;
 
// Заполняем список
with ListView.Items do 
begin
BeginUpdate;
 
CurNode := ASelected.GetFirstChild;
 
while Assigned(CurNode) do begin
Info := PBLUETOOTH_RADIO_INFO(CurNode.Data);
 
// Перечитать информацию о радиомодуле
BluetoothGetRadioInfo(CurNode.ImageIndex, Info^);
 
with Add do 
begin
Data := Pointer(CurNode.ImageIndex);
Caption := BTAdrToStr(Info.address);
with SubItems do 
begin
Add(string(Info.szName));
Add(IntToStr(Info.ulClassofDevice));
Add(IntToStr(Info.manufacturer));
Add(IntToStr(Info.lmpSubversion));
// NEW FUNCTIONS!!!
Add(BoolToStr(BluetoothIsConnectable(CurNode.ImageIndex), True));
Add(BoolToStr(BluetoothIsDiscoverable(CurNode.ImageIndex), True));
end;
end;
 
CurNode := ASelected.GetNextChild(CurNode);
end;
 
EndUpdate;
end;
end;
 
procedure ShowDevices;
var
Info: ^PBLUETOOTH_DEVICE_INFO;
CurNode: TTreeNode;
begin
// Строим столбцы
with ListView.Columns do
begin
BeginUpdate;
with Add do Caption := 'Address';
with Add do Caption := 'Name';
with Add do Caption := 'Class Of Device';
with Add do Caption := 'Connected';
with Add do Caption := 'Remembered';
with Add do Caption := 'Authenticated';
with Add do Caption := 'Last Seen';
with Add do Caption := 'Last Used';
EndUpdate;
end;
 
// Заполняем список
with ListView.Items do 
begin
BeginUpdate;
 
CurNode := ASelected.GetFirstChild;
 
while Assigned(CurNode) do 
begin
Info := CurNode.Data;
 
// Перечитываем информацию об устройстве
// Так как передаем указатель, то она автоматом
// Обновится и в том месте, где мы ее сохраняли
BluetoothGetDeviceInfo(ASelected.ImageIndex, Info^);
 
with Add do 
begin
Data := Info;
Caption := BTAdrToStr(Info^.Address);
with SubItems do 
begin
Add(string(Info^.szName));
Add(IntToStr(Info^.ulClassofDevice));
Add(BoolToStr(Info^.fConnected, True));
Add(BoolToStr(Info^.fRemembered, True));
Add(BoolToStr(Info^.fAuthenticated, True));
try // stLastSeen может быть 0 и тогда здесь ошибка будет
Add(DateTimeToStr(SystemTimeToDateTime(Info^.stLastSeen)));
except
Add(‘’);
end;
try // stLastUsed может быть 0 и тогда здесь ошибка будет
Add(DateTimeToStr(SystemTimeToDateTime(Info^.stLastUsed)));
except
Add(‘’);
end;
end;
end;
 
CurNode := ASelected.GetNextChild(CurNode);
end;
 
EndUpdate;
end;
end;
 
procedure ShowServices;
var
Info: __PBLUETOOTH_DEVICE_INFO;
ServiceCount: dword;
Services: array of TGUID;
hRadio: THandle;
Loop: integer;
begin
// Строим столбцы
with ListView.Columns do 
begin
BeginUpdate;
with Add do Caption := 'GUID';
EndUpdate;
end;
 
// Заполняем список
with ListView.Items do 
begin
BeginUpdate;
 
// Получаем размер массива сервисов
ServiceCount := 0;
Services := nil;
hRadio := ASelected.Parent.ImageIndex;
Info := ASelected.Data;
// NEW FUNCTION
BluetoothEnumerateInstalledServices(hRadio, Info, ServiceCount, nil);
 
// Выделяем память.
SetLength(Services, ServiceCount);
 
// Получаем список сервисов
BluetoothEnumerateInstalledServices(hRadio, Info, ServiceCount, PGUID(Services));
 
// Рисуем их
for Loop := 0 to ServiceCount - 1 do
with Add do
Caption := GUIDToString(Services[Loop]);
 
// Очищаем память
Services := nil;
 
EndUpdate;
end;
end;
 
begin
ASelected := TreeView.Selected;
 
// Очищаем ListView
with ListView do 
begin
with Columns do
begin
BeginUpdate;
Clear;
EndUpdate;
end;
 
with Items do 
begin
BeginUpdate;
Clear;
EndUpdate;
end;
end;
 
// Заполняем информацией
if Assigned(ASelected) then
case ASelected.ImageIndex of
-2: ShowServices;
-1: ShowRadios;
else
if ASelected.ImageIndex &gt; 0 then ShowDevices;
end;
end; 
</pre>
&nbsp;</p>
<p>В этом коде появилось три новые функции, которые выделены жирным шрифтом. Вот они</p>
<p>BluetoothIsConnectable - определяет, возможно ли подключение к указанному радиомодулю.</p>
<p>Объявление функции:</p>
<pre>
function BluetoothIsConnectable(const hRadio : THandle): BOOL; stdcall; 
</pre>
&nbsp;</p>
<p>Параметры:</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>hRadio</p>
</td>
<td><p>Handle радиомодуля, который мы проверяем. Если 0, то проверяются все радиомодули.
</td>
</tr>
</table>
<p>Возвращаемые значения:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Вернет TRUE, если указанный радиомодуль разрешает входящие подключения. Если hRadio=0, то вернет TRUE, если хотя бы один радиомодуль разрешает входящие подключения.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Если входящие подключения запрещены, то вернет FALSE.</td></tr></table></div><p>BluetoothIsDiscoverable - определяет, будет ли виден указанный радиомодуль другим при поиске. Если просматриваются все радиомодули, то вернет TRUE если хотя бы один разрешает обнаружение.</p>
<p>Объявление функции:</p>
<pre>
function BluetoothIsDiscoverable(const hRadio : THandle): BOOL; stdcall; 
</pre>
&nbsp;</p>
<p>Параметры:</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>hRadio</p>
</td>
<td><p>Handle радиомодуля, который мы проверяем. Если 0, то проверяются все радиомодули.
</td>
</tr>
</table>
<p>Возвращаемые значения:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Вернет TRUE, если указанный радиомодуль разрешает обнаружение. Если hRadio=0, то вернет TRUE, если хотя бы один радиомодуль разрешает обнаружение.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Если обнаружение запрещено, то вернет FALSE.</td></tr></table></div><p>BluetoothEnumerateInstalledServices - получает список GUID сервисов, предоставляемых устройством. Если параметр hRadio=0, то просматривает все радиомодули.</p>
<p>Объявление функции:</p>
<pre>
function BluetoothEnumerateInstalledServices(
              hRadio : THandle;
              pbtdi : __PBLUETOOTH_DEVICE_INFO;
              var pcServices : dword;
              pGuidServices : PGUID): dword; stdcall; 
</pre>
&nbsp;</p>
<p>Параметры:</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>hRadio</p>
</td>
<td><p>Handle радиомодуля, который мы проверяем. Если 0, то проверяются все радиомодули.</p>
</td>
</tr>
<tr>
<td><p>pbtdi</p>
</td>
<td><p>Указатель на структуру BLUETOOTH_DEVICE_INFO, в которой описано проверяемое устройство. Необходимо заполнить поля dwSize и Address.</p>
</td>
</tr>
<tr>
<td><p>pcServices</p>
</td>
<td><p>При вызове &#8211; количество записей в массиве pGuidServices, возвращает в этом параметре реальное количество сервисов, предоставляемых устройством.</p>
</td>
</tr>
<tr>
<td><p>pGuidServices</p>
</td>
<td><p>Указатель на массив TGUID, в который будут записаны GUID предоставляемых устройством сервисом. Если nil и pcServices=0, то в pcServices будет записано количество сервисов. Необходимо выделить для pGuidServices память размером не менее pcServices*SizeOf(TGUID).
</td>
</tr>
</table>
<p>Возвращаемые значения:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Вернет ERROR_SUCCESS, если вызов успешен и количество сервисов в pcServices соответствует реальности.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Вернет ERROR_MORE_DATA, если вызов успешен, но выделенное количество памяти (pcServices при вызове) меньше, чем количество предоставляемых сервисов.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>В случае ошибки &#8211; другие коды ошибок Win32.</td></tr></table></div><p>Примечания:</p>
<p>Посмотрите на код получения списка сервисов:</p>
<pre>
// Получаем размер массива сервисов
ServiceCount := 0;
Services := nil;
hRadio := ASelected.Parent.ImageIndex;
Info := ASelected.Data;
// NEW FUNCTION
BluetoothEnumerateInstalledServices(hRadio, Info, ServiceCount, nil);
 
// Выделяем память.
SetLength(Services, ServiceCount);
 
// Получаем список сервисов
BluetoothEnumerateInstalledServices(hRadio, Info, ServiceCount, PGUID(Services)) 
</pre>
&nbsp;</p>
<p>Сначала мы вызываем функцию с pcServices=0 и pGuidServices=nil для того, чтобы получить количество сервисов, предоставляемых устройством.</p>
<p>Потом выделяем память (SetLength()) и только затем вызываем функцию с реальными параметрами и получаем список сервисов.</p>
<p>Еще важное замечание. В файле JwaBluetoothAPIs.pas параметр pbtdi имеет тип PBLUETOOTH_DEVICE_INFO, который раскрывается в BLUETOOTH_DEVICE_INFO. Заметьте, что это НЕ УКАЗАТЕЛЬ. Это не верно, так как в исходном виде функция требует именно указатель. По-этому, я ввел тип</p>
type<br>
<p>__PBLUETOOTH_DEVICE_INFO = ^PBLUETOOTH_DEVICE_INFO</p>
<p>Так что ИСПОЛЬЗУЙТЕ файл из примера, а не из исходной библиотеки. Иначе получите нарушение доступа к памяти.</p>
<p>Комментарий к коду: Мы перечитываем информацию об устройстве, так как за время, пока мы любуемся программой, могли произойти различные события: устройство отключили, отменили авторизацию и т. п. А мы хотим иметь самую свежую информацию об устройстве.</p>
<p>В принципе то, что описано выше, мы уже знали, кроме двух указанных функций.</p>
<p>Давайте расширим возможности нашего приложения. Добавим функции запрета/разрешения обнаружения радиомодуля и запрета/разрешения подключения к нему.</p>
<p>BluetoothEnableIncomingConnections и BluetoothEnableDiscoverable</p>
<p>Поместим на форму компонент TactionList и изменим его свойства как показано в таблице.</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>Свойство</p>
</td>
<td><p>Значение</p>
</td>
</tr>
<tr>
<td><p>Name</p>
</td>
<td><p>ActionList
</td>
</tr>
</table>
<p>Теперь два раза щелкнем по ActionList и в появившемся окне редактора свойств добавим две TAction со следующими свойствами:</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>Свойство</p>
</td>
<td><p>Значение</p>
</td>
</tr>
<tr>
<td><p>Caption</p>
</td>
<td><p>Connectable</p>
</td>
</tr>
<tr>
<td><p>Name</p>
</td>
<td><p>acConnectable
</td>
</tr>
</table>

<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>Свойство</p>
</td>
<td><p>Значение</p>
</td>
</tr>
<tr>
<td><p>Caption</p>
</td>
<td><p>Discoverable</p>
</td>
</tr>
<tr>
<td><p>Name</p>
</td>
<td><p>acDiscoverable
</td>
</tr>
</table>
<p>На панель Panel добавим две TButton и установим свойства:</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>Свойство</p>
</td>
<td><p>Значение</p>
</td>
</tr>
<tr>
<td><p>Action</p>
</td>
<td><p>acConnectable</p>
</td>
</tr>
<tr>
<td><p>Name</p>
</td>
<td><p>btConnectable
</td>
</tr>
</table>

<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>Свойство</p>
</td>
<td><p>Значение</p>
</td>
</tr>
<tr>
<td><p>Action</p>
</td>
<td><p>acDiscoverable</p>
</td>
</tr>
<tr>
<td><p>Name</p>
</td>
<td><p>btDiscoverable
</td>
</tr>
</table>
<p>Напишем вот такой обработчик события OnUpdate у acConnectable:</p>
<pre>
procedure TfmMain.acConnectableUpdate(Sender: TObject);
var
SelectedItem: TListItem;
SelectedNode: TTreeNode;
begin
SelectedNode := TreeView.Selected;
SelectedItem := ListView.Selected;
 
with TAction(Sender) do 
begin
Enabled := Assigned(SelectedNode) and Assigned(SelectedItem) and (SelectedNode.ImageIndex = -1);
 
if Enabled then
if StrToBool(SelectedItem.SubItems[4])
then Caption := 'Not conn.'
else Caption := 'Connectable';
end;
end; 
</pre>
&nbsp;</p>
<p>И то же самое напишем для обработчика события OnUpdate - acDiscoverable:</p>
<pre>
procedure TfmMain.acDiscoverableUpdate(Sender: TObject);
var
SelectedItem: TListItem;
SelectedNode: TTreeNode;
begin
SelectedNode := TreeView.Selected;
SelectedItem := ListView.Selected;
 
with TAction(Sender) do 
begin
Enabled := Assigned(SelectedNode) and Assigned(SelectedItem) and (SelectedNode.ImageIndex = -1);
 
if Enabled then 
if StrToBool(SelectedItem.SubItems[5])
then Caption := 'Not disc.'
else Caption := 'Discoverable';
end;
end; 
</pre>
&nbsp;</p>
<p>Теперь обработчик события OnExecute для acConnectable:</p>
<pre>
procedure TfmMain.acConnectableExecute(Sender: TObject);
var
SelectedItem: TListItem;
begin
SelectedItem := ListView.Selected;
 
if Assigned(SelectedItem) then
if not BluetoothEnableIncomingConnections(Integer(SelectedItem.Data), TAction(Sender).Caption = 'Not conn.') 
then MessageDlg('Unable to change Radio state', mtError, [mbOK], 0)
else TreeViewChange(TreeView, TreeView.Selected);
end; 
</pre>
&nbsp;</p>
<p>Такой же обработчик напишем и для OnExecute - acDiscoverable:</p>
<pre>
procedure TfmMain.acConnectableExecute(Sender: TObject);
var
SelectedItem: TListItem;
begin
SelectedItem := ListView.Selected;
 
if Assigned(SelectedItem) then
if not BluetoothEnableDiscovery(Integer(SelectedItem.Data), TAction(Sender).Caption = 'Not disc.') 
then MessageDlg('Unable to change Radio state', mtError, [mbOK], 0)
else TreeViewChange(TreeView, TreeView.Selected);
end; 
</pre>
&nbsp;</p>
<p>Вывод окна свойств устройства</p>
<p>Важно: Если Windows сам использует радиомодуль, то он не даст поменять статус, хотя и функция выполнится без ошибок!</p>
<p>Здесь мы ввели две новые функции (выделены жирным):</p>
<p>BluetoothEnableInfomingConnection - функция разрешает/запрещает подключения к локальному радиомодулю Bluetooth.</p>
<p>Объявление функции:</p>
<pre>
function BluetoothEnableIncomingConnections(
hRadio : THandle;
fEnabled : BOOL): BOOL; stdcall; 
</pre>
&nbsp;</p>
<p>Параметры:</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>hRadio</p>
</td>
<td><p>Handle радиомодуля, статус которого мы хотим изменить. Если 0, то меняем у всех.</p>
</td>
</tr>
<tr>
<td><p>fEnabled</p>
</td>
<td><p>TRUE &#8211; разрешаем подключения; FALSE &#8211; запрещаем.
</td>
</tr>
</table>
<p>Возвращаемые значения:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>TRUE - если вызов успешен и статус изменен,</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>FALSE - в противном случае.</td></tr></table></div><p>BluetoothEnableDiscovery - функция разрешает/запрещает обнаружение локального радиомодуля Bluetooth</p>
<p>Объявление функции:</p>
<pre>
function BluetoothEnableDiscovery(hRadio : THandle; fEnabled : BOOL): BOOL; stdcall; 
</pre>
&nbsp;</p>
<p>Параметры:</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>hRadio</p>
</td>
<td><p>Handle радиомодуля, статус которого мы хотим изменить. Если 0, то меняем у всех.</p>
</td>
</tr>
<tr>
<td><p>fEnabled</p>
</td>
<td><p>TRUE &#8211; разрешаем обнаружение; FALSE &#8211; запрещаем.
</td>
</tr>
</table>
<p>Возвращаемые значения:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>TRUE - если вызов успешен и статус изменен,</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>FALSE - в противном случае.</td></tr></table></div><p>Теперь давайте научимся выводить системное окно свойств устройства Bluetooth. Для этого добавим к ActionList еще один TAction вот с такими свойствами:</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>Свойство</p>
</td>
<td><p>Значение</p>
</td>
</tr>
<tr>
<td><p>Caption</p>
</td>
<td><p>Property</p>
</td>
</tr>
<tr>
<td><p>Name</p>
</td>
<td><p>acProperty
</td>
</tr>
</table>
<p>Добавим на Panel кнопку TButton с такими свойствами:</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>Свойство</p>
</td>
<td><p>Значение</p>
</td>
</tr>
<tr>
<td><p>Action</p>
</td>
<td><p>acProperty</p>
</td>
</tr>
<tr>
<td><p>Name</p>
</td>
<td><p>btProperty
</td>
</tr>
</table>
<p>Теперь напишем такой обработчик событий OnUpdate у acProperty:</p>
<pre>
procedure TfmMain.acPropertyUpdate(Sender: TObject);
var
SelectedNode: TTreeNode;
SelectedItem: TListItem;
begin
SelectedNode := TreeView.Selected;
SelectedItem := ListView.Selected;
 
TAction(Sender).Enabled := Assigned(SelectedNode) and
Assigned(SelectedItem) and
(SelectedNode.ImageIndex &gt; 0);
end; 
</pre>
&nbsp;</p>
<p>И обработчик OnExecute для нее же:</p>
<pre>
procedure TfmMain.acPropertyExecute(Sender: TObject);
var
Info: BLUETOOTH_DEVICE_INFO;
begin
Info := BLUETOOTH_DEVICE_INFO(ListView.Selected.Data^);
BluetoothDisplayDeviceProperties(Handle, Info);
end; 
</pre>
&nbsp;</p>
<p>Важно: В исходном виде в файле JwaBluetoothAPIs функция BluetoothDisplayDeviceProperties объявлена не верно. Второй параметр должен быть указателем, а там он передается как структура. Я исправил функцию так, чтобы он передавался как var-параметр (по ссылке). Используйте модуль JwaBluetoothAPIs из этого примера, чтобы не возникало ошибок доступа к памяти.</p>
<p>Важно: Ни в этой процедуре, ни ранее, ни далее я не провожу проверку ошибок, чтобы не загромождать код лишними подробностями. В реальном приложении НЕОБХОДИМО проверять возвращаемые функциями значения и указатели.</p>
<p>И так, в этом коде есть новая функция, выделенная жирным шрифтом.</p>
<p>BluetoothDisplayDeviceProperty - функция выводит стандартное окно свойств устройства Bluetooth.</p>
<p>Объявление функции:</p>
function BluetoothEnableDiscovery(<br>
hwndParent : HWND;<br>
<p>var pbtdi : PBLUETOOTH_DEVICE_INFO): BOOL; stdcall;</p>
<p>Важно: В оригинале (см. примечание выше) функция выглядит вот так:</p>
function BluetoothEnableDiscovery(<br>
hwndParent : HWND;<br>
<p>pbtdi : PBLUETOOTH_DEVICE_INFO): BOOL; stdcall;</p>
<p>Это не верно, так как в документации Microsoft указано, что параметр pbtdi должен передаваться как указатель (что подразумевает запись PBLUETOOTH_DEVICE_INFO), но как я писал выше, этот тип ошибочен. Он не является указателем. Я изменил функцию так, как показано выше (так она и должна быть, если не менять определение типа). Параметры:</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>hwndParent</p>
</td>
<td><p>Handle родительского окна, которому будет принадлежать диалог свойств. Может быть 0, тогда родительским выбирается окно Desktop.</p>
</td>
</tr>
<tr>
<td><p>pbtdi</p>
</td>
<td><p>Указатель на структуру BLUETOOTH_DEVICE_INFO в которой содержится адрес требуемого устройства.
</td>
</tr>
</table>
<p>&nbsp;<br>
<p>Возвращаемые значения:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>TRUE - если вызов успешен</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>FALSE - в противном случае (код ошибки можно узнать вызовом функции GetLastError).</td></tr></table></div><p>Выбор устройства</p>
<p>Рассмотрим, как вызвать окно диалога выбора устройства.</p>
<p>Добавим в наш проект на Panel еще одну кнопку TButton и установите ее свойства как в таблице:</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>Свойство</p>
</td>
<td><p>Значение</p>
</td>
</tr>
<tr>
<td><p>Caption</p>
</td>
<td><p>Select</p>
</td>
</tr>
<tr>
<td><p>Name</p>
</td>
<td><p>btSelect
</td>
</tr>
</table>
<p>Напишем вот такой обработчик события OnClick у этой кнопки:</p>
<pre>
procedure TfmMain.btSelectClick(Sender: TObject);
var
ASelParams: BLUETOOTH_SELECT_DEVICE_PARAMS;
ASelParamsSize: dword;
begin
ASelParamsSize := SizeOf(BLUETOOTH_SELECT_DEVICE_PARAMS);
FillChar(ASelParams, ASelParamsSize, 0);
with ASelParams do 
begin
dwSize := ASelParamsSize;
hwndParent := Handle;
fShowRemembered := True;
fAddNewDeviceWizard := True;
end;
 
BluetoothSelectDevices(@ASelParams);
BluetoothSelectDevicesFree(@ASelParams);
end 
</pre>
&nbsp;</p>
<p>В этой части кода две новые функции.</p>
<p>BluetoothSelectDevices - функция разрешает/запрещает обнаружение локального радиомодуля Bluetooth.</p>
<p>Объявление функции:</p>
function BluetoothSelectDevices(<br>
<p>pbtsdp : PBLUETOOTH_SELECT_DEVICE_PARAMS): BOOL; stdcall;</p>
<p>Параметры:</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>pbtsdp</p>
</td>
<td><p>Описание смотрите ниже в описании структуры.
</td>
</tr>
</table>
<p>Возвращаемые значения:</p>
<p>Если функция вернула TRUE, то пользователь выбрал устройства. Pbtsdp^.pDevices будет указывать на корректные данные. После вызова необходимо проверить флаги fAuthenticated и fRemembered, что бы удостовериться в корректности данных. Для освобождения памяти используйте функцию BluetoothSelectDevicesFree, только если функция вернет TRUE.</p>
<p>Вернет FALSE если вызов прошел не удачно. Используйте GetLastError для получения дополнительных сведений. Возможные ошибки:</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>ERROR_CANCELLED</p>
</td>
<td><p>Пользователь отменил выбор устройства.</p>
</td>
</tr>
<tr>
<td><p>ERROR_INVALID_PARAMETER</p>
</td>
<td><p>Параметр pbsdp равен nil.</p>
</td>
</tr>
<tr>
<td><p>ERROR_REVISION_MISMATCH</p>
</td>
<td><p>Структура, переданная в pbsdp неизвестного или неверного размера.</p>
</td>
</tr>
<tr>
<td><p>Другие ошибки Win32</p>
</td>
<td><p>&nbsp;
</td>
</tr>
</table>
<p>BLUETOOTH_SELECT_DEVICE_PARAMS</p>
<p>Объявление:</p>
<pre>
BLUETOOTH_SELECT_DEVICE_PARAMS = record
dwSize : DWORD;
cNumOfClasses : ULONG;
prgClassOfDevices : PBlueToothCodPairs; 
pszInfo : LPWSTR; 
hwndParent : HWND; 
fForceAuthentication : BOOL;
fShowAuthenticated : BOOL;
fShowRemembered : BOOL;
fShowUnknown : BOOL;
fAddNewDeviceWizard : BOOL;
fSkipServicesPage : BOOL; 
pfnDeviceCallback : PFN_DEVICE_CALLBACK;
pvParam : Pointer;
cNumDevices : DWORD;
pDevices : __PBLUETOOTH_DEVICE_INFO; 
end; 
</pre>
&nbsp;</p>
<p>Члены:</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>dwSize</p>
</td>
<td><p>Должен быть равен размеру структуры (dwSize := SizeOf(BLUETOOTH_RADIO_INFO))</p>
</td>
</tr>
<tr>
<td><p>cNumOfClasses</p>
</td>
<td><p>Входной параметр. Количество записей в массиве prgClassOfDevice. Если 0, то ищутся все устройства.</p>
</td>
</tr>
<tr>
<td><p>prgClassOfDevices</p>
</td>
<td><p>Входной параметр. Массив COD (классов устройств), которые необходимо искать.</p>
</td>
</tr>
<tr>
<td><p>pszInfo</p>
</td>
<td><p>Входной параметр. Если не nil, то задает текст заголовка окна выбора устройства.</p>
</td>
</tr>
<tr>
<td><p>hwndParent</p>
</td>
<td><p>Входной параметр. Handle родительского окна для диалога выбора устройства. Если 0, то родителем будет Desktop.</p>
</td>
</tr>
<tr>
<td><p>fForceAuthentication</p>
</td>
<td><p>Входной параметр. Если TRUE, то требует принудительной авторизации устройств.</p>
</td>
</tr>
<tr>
<td><p>fShowAuthenticated</p>
</td>
<td><p>Входной параметр. Если TRUE, то авторизованные устройства будут доступны для выбора.</p>
</td>
</tr>
<tr>
<td><p>fShowRemembered</p>
</td>
<td><p>Входной параметр. Если TRUE, то запомненные устройства будут доступны для выбора.</p>
</td>
</tr>
<tr>
<td><p>fShowUnknown</p>
</td>
<td><p>Входной параметр. Если TRUE, то неизвестные (неавторизованные и не запомненные) устройства будут доступны для выбора.</p>
</td>
</tr>
<tr>
<td><p>fAddNewDeviceWizard</p>
</td>
<td><p>Входной параметр. Если TRUE, то запускает мастер добавления нового устройства.</p>
</td>
</tr>
<tr>
<td><p>fSkipServicesPage</p>
</td>
<td><p>Входной параметр. Если TRUE, то пропускает страницу Сервисы в мастере.</p>
</td>
</tr>
<tr>
<td><p>pfnDeviceCallback</p>
</td>
<td><p>Входной параметр. Если не nil, то является указателем на функцию обратного вызова, которая вызывается для каждого найденного устройства. Если функция вернет TRUE, то устройства добавляется в список, если нет, то устройство игнорируется.</p>
</td>
</tr>
<tr>
<td><p>pvParam</p>
</td>
<td><p>Входной параметр. Его значение будет передано функции pfnDeviceCallback в качестве параметра pvParam.</p>
</td>
</tr>
<tr>
<td><p>cNumDevices</p>
</td>
<td><p>Как входной параметр &#8211; количество устройств, которое требуется вернуть. Если 0, то нет ограничений. Как выходной параметр &#8211; количество возвращенных устройств (выбранных).</p>
</td>
</tr>
<tr>
<td><p>pDevices</p>
</td>
<td><p>Выходной параметр. Указатель на массив структур BLUETOOTH_DEVICE_INFO. Для его освобождения используйте функцию BluetoothSelectDevicesFree.<br>
Важно: В оригинале этот параметр объявлен как PBLUETOOTH_DEVICE_INFO. По этому поводу здесь много комментариев.
</td>
</tr>
</table>
<p>BluetoothSelectDevicesFree - функция должна вызываться, только если вызов BluetoothSelectDevices был успешен. Эта функция освобождает память и ресурсы, задействованные функцией BluetoothSelectDevices в структуре BLUETOOTH_SELECT_DEVICE_PARAMS.</p>
<p>Объявление функции:</p>
function BluetoothSelectDevices(<br>
<p>pbtsdp : PBLUETOOTH_SELECT_DEVICE_PARAMS): BOOL; stdcall;</p>
<p>Параметры:</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>pbtsdp</p>
</td>
<td><p>Описание смотрите выше в описании структуры.
</td>
</tr>
</table>
<p>Возвращаемые значения:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>TRUE - если вызов успешен,</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>FALSE - нечего освобождать.</td></tr></table></div><p>Управление сервисами</p>
<p>Для управления сервисами Microsoft Bluetooth API предоставляет функцию:</p>
<p>BluetoothSetServiceState - включает или выключает указанный сервис для устройства Bluetooth. Система проецирует сервис Bluetooth на соответствующий драйвер. При отключении сервиса &#8211; драйвер удаляется. При его включении &#8211; драйвер устанавливается. Если выполняется включение не поддерживаемого сервиса, то драйвер не будет установлен.</p>
<p>Объявление функции:</p>
<pre>
function BluetoothSetServiceState(
hRadio : Thandle;
var pbtdi : PBLUETOOTH_DEVICE_INFO;
const pGuidService : TGUID;
dwServiceFlags : DWORD): DWORD; stdcall; 
</pre>
&nbsp;</p>
<p>&nbsp;<br>
<p>Параметры:</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>hRadio</p>
</td>
<td><p>Описатель радиомодуля.</p>
</td>
</tr>
<tr>
<td><p>pbtdi</p>
</td>
<td><p>Указатель на структуру BLUETOOTH_DEVICE_INFO.</p>
</td>
</tr>
<tr>
<td><p>pGuidService</p>
</td>
<td><p>GUID сервиса, который необходимо включить/выключить.</p>
</td>
</tr>
<tr>
<td><p>dwServiceFlags</p>
</td>
<td><p>Флаги управления сервисом:<br>
BLUETOOTH_SERVICE_DISABLE &#8211; отключает сервис;<br>
BLUETOOTH_SERVICE_ENABLE &#8211; включает сервис. 
</td>
</tr>
</table>
<p>&nbsp;<br>
<p>Возвращает ERROR_SUCCESS если вызов прошел успешно. Если вызов не удался вернет один из следующих кодов:</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>ERROR_INVALID_PARAMETER</p>
</td>
<td><p>Неверные флаги в dwServiceFlags</p>
</td>
</tr>
<tr>
<td><p>ERROR_SERVICE_DOES_NOT_EXIST</p>
</td>
<td><p>Указанный сервис не поддерживается</p>
</td>
</tr>
<tr>
<td><p>Другие ошибки Win32</p>
</td>
<td><p>&nbsp;
</td>
</tr>
</table>
<p>Важно: В оригинале (см. примечание выше) функция выглядит вот так:</p>
function BluetoothSetServiceState(<br>
hRadio : Thandle;<br>
pbtdi : PBLUETOOTH_DEVICE_INFO;<br>
const pGuidService : TGUID;<br>
<p>dwServiceFlags : DWORD): DWORD; stdcall;</p>
<p>Это не верно, так как в документации Microsoft указано, что параметр pbtdi должен передаваться как указатель (что подразумевает запись PBLUETOOTH_DEVICE_INFO), но как я писал выше, этот тип ошибочен. Он не является указателем. Я изменил функцию так, как показано выше (так она и должна быть, если не менять определение типа).</p>
<p>Как использовать функцию? Давайте добавим к ActionList еще одну TAction с такими свойствами:</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>Свойство</p>
</td>
<td><p>Значение</p>
</td>
</tr>
<tr>
<td><p>Caption</p>
</td>
<td><p>Disable</p>
</td>
</tr>
<tr>
<td><p>Name</p>
</td>
<td><p>acEnable
</td>
</tr>
</table>
<p>И добавим на Panel еще одну кнопку TButton, установив у нее следующие свойства:</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>Свойство</p>
</td>
<td><p>Значение</p>
</td>
</tr>
<tr>
<td><p>Action</p>
</td>
<td><p>acEnable</p>
</td>
</tr>
<tr>
<td><p>Name</p>
</td>
<td><p>btEnable
</td>
</tr>
</table>
<p>В обработчике события OnUpdate для acEnable напишем вот такой код:</p>
<pre>procedure TfmMain.acEnableUpdate(Sender: TObject);
var
SelectedNode: TTreeNode;
SelectedItem: TListItem;
begin
SelectedNode := TreeView.Selected;
SelectedItem := ListView.Selected;
&nbsp;
TAction(Sender).Enabled := Assigned(SelectedNode) and
Assigned(SelectedItem) and
(SelectedNode.ImageIndex = -2);
end;
</pre>
<p>А в обработчике OnExecute для acEnable вот такой код:</p>
<pre>procedure TfmMain.acEnableExecute(Sender: TObject);
var
GUID: TGUID;
begin
GUID := StringToGUID(ListView.Selected.Caption);
BluetoothSetServiceState(TreeView.Selected.Parent.ImageIndex,
BLUETOOTH_DEVICE_INFO(TreeView.Selected.Data^),
GUID, 
BLUETOOTH_SERVICE_DISABLE);
end;
</pre>
<p>Важно: После нажатия на кнопку btEnable сервис будет удален из системы. Включить его можно будет через окно свойств устройства Bluetooth.</p>
<p>Как определять отключенные сервисы рассмотрим в серии про передачу данных через Bluetooth.</p>
<p>Удаление устройств</p>
<p>Для удаления устройств используется функция:</p>
<p>BluetoothRemoveDevice - функция удаляет авторизацию между компьютером и устройством Bluetooth. Так же очищает кэш-записи об этом устройстве.</p>
<p>Объявление функции:</p>
<pre>
function BluetoothRemoveDevice(
var pAddress : BLUETOOTH_ADDRESS): DWORD; stdcall; 
</pre>
&nbsp;</p>
<p>Параметры:</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>hAddress</p>
</td>
<td><p>Адрес устройства, которое удаляется.
</td>
</tr>
</table>
<p>Возвращаемые значения:</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>ERROR_SUCCESS</p>
</td>
<td><p>устройство удалено</p>
</td>
</tr>
<tr>
<td><p>ERROR_NOT_FOUND</p>
</td>
<td><p>устройство не найдено
</td>
</tr>
</table>
<p>Давайте попробуем. Добавим в ActionList TAction со следующими свойствами:</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>Свойство</p>
</td>
<td><p>Значение</p>
</td>
</tr>
<tr>
<td><p>Caption</p>
</td>
<td><p>Remove</p>
</td>
</tr>
<tr>
<td><p>Name</p>
</td>
<td><p>acRemove
</td>
</tr>
</table>
<p>И на Panel кнопку TButton со свойствами:</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>Свойство</p>
</td>
<td><p>Значение</p>
</td>
</tr>
<tr>
<td><p>Action</p>
</td>
<td><p>acRemove</p>
</td>
</tr>
<tr>
<td><p>Name</p>
</td>
<td><p>btRemove
</td>
</tr>
</table>
<p>В обработчике OnUpdate для acRemove напишем следующий код:</p>
<pre>
procedure TfmMain.acRemoveUpdate(Sender: TObject);
begin
TAction(Sender).Enabled := acProperty.Enabled;
end; 
</pre>
&nbsp;</p>
<p>А для события OnExecute вот такой код:</p>
<pre>
procedure TfmMain.acRemoveExecute(Sender: TObject);
var
Info: BLUETOOTH_DEVICE_INFO;
Res: dword;
begin
Info := BLUETOOTH_DEVICE_INFO(ListView.Selected.Data^);
Res := BluetoothRemoveDevice(Info.Address);
if Res &lt;&gt; ERROR_SUCCESS then
MessageDlg('Device not found', mtError, [mbOK], 0);
TreeViewChange(TreeView, TreeView.Selected);
end; 
</pre>
&nbsp;</p>
<p>Процедура выполняется достаточно долго, так что не думайте, что программа зависла.</p>
<p>Важно: Устройство удаляется из списка. Однако, если уже иметь адрес устройства, то можно получить о нем информацию.</p>
<p>Есть еще одно функция, которая связана с BluetoothRemoveDevice. Это:</p>
<p>BluetoothUpdateDeviceRecord - функция обновляет данные об устройстве в кэше.</p>
<p>Объявление функции:</p>
<pre>
function BluetoothUpdateDeviceRecord(
var pbtdi : BLUETOOTH_DEVICE_INFO): DWORD; stdcall; 
</pre>
&nbsp;</p>
<p>Параметры:</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>pbtdu</p>
</td>
<td><p>Указатель на структуру BLUETOOTH_DEVICE_INFO. В ней должны быть заполнены поля:<br>
dwSize &#8211; размер структуры;<br>
Address &#8211; адрес устройства;<br>
szName &#8211; новое имя устройства. 
</td>
</tr>
</table>
<p>Возвращаемые значения:</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>ERROR_SUCCESS</p>
</td>
<td><p>Функция выполнена успешно</p>
</td>
</tr>
<tr>
<td><p>ERROR_INVALID_PARAMETER</p>
</td>
<td><p>Указатель pbtdi=nil. (Для варианта в Delphi не реально, так как указатель мы получаем из структуры, передавая ее как var-параметр).</p>
</td>
</tr>
<tr>
<td><p>ERROR_REVISION_MISMATCH</p>
</td>
<td><p>Размер структуры в dwSize не правильный</p>
</td>
</tr>
<tr>
<td><p>Другие ошибки Win32</p>
</td>
<td><p>&nbsp;
</td>
</tr>
</table>
<p>Попробуем использовать и ее. Схема стандартная: TAction к ActionList, TButton на Panel:</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>Свойство</p>
</td>
<td><p>Значение</p>
</td>
</tr>
<tr>
<td><p>Caption</p>
</td>
<td><p>Update</p>
</td>
</tr>
<tr>
<td><p>Name</p>
</td>
<td><p>acUpdate
</td>
</tr>
</table>

<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>Свойство</p>
</td>
<td><p>Значение</p>
</td>
</tr>
<tr>
<td><p>Action</p>
</td>
<td><p>acUpdate</p>
</td>
</tr>
<tr>
<td><p>Name</p>
</td>
<td><p>btUpdate
</td>
</tr>
</table>
<p>Код:</p>
<pre>
procedure TfmMain.acUpdateUpdate(Sender: TObject);
begin
TAction(Sender).Enabled := acProperty.Enabled;
end; 
procedure TfmMain.acUpdateExecute(Sender: TObject);
var
Info: BLUETOOTH_DEVICE_INFO;
Res: dword;
NewName: string;
begin
if InputQuery('Имя устройства', 'Новое имя', NewName) then begin
lstrcpyW(Info.szName, PWideChar(WideString(NewName)));
Res := BluetoothUpdateDeviceRecord(Info);
if Res &lt;&gt; ERROR_SUCCESS then RaiseLastOsError;
TreeViewChange(TreeView, TreeView.Selected);
end;
end; 
</pre>
&nbsp;</p>
<p>Как видите, все просто.</p>
<p>И так, удалять устройства мы умеем. Давайте теперь научимся добавлять их. Для этого Bluetooth API предоставляет две функции:</p>
<p>BluetoothAuthenticateDevice - отправляет запрос на авторизацию удаленному устройству Bluetooth. Есть два режима авторизации: "Wizrd mode" и "Blind Mode".</p>
<p>"Wizard Mode" запускается, когда параметр pszPasskey = nil. В этом случае открывается окно "Мастера подключения". У пользователя будет запрошен пароль, который будет отправлен в запросе на авторизацию удаленному устройству. Пользователь будет оповещен системой об успешном или не успешном выполнении авторизации и получит возможность попытаться авторизировать устройства еще раз.</p>
<p>"Blind Mode" вызывается, когда pszPasskey &lt;&gt; nil. В этом случае пользователь не увидит никакого мастера. Вам необходимо программно запросить код авторизации (pszPasskey) и уведомить пользователя о результате.</p>
<p>Объявление функции:</p>
<pre>function BluetoothAuthenticateDevice(
  hwndParent : HWND;
  hRadio : THandle;
  pbtdi : BLUETOOTH_DEVICE_INFO;
  pszPasskey : PWideChar;
  ulPasskeyLength : ULONG): DWORD; stdcall;
</pre>
<p>Параметры:</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>hwndParent</p>
</td>
<td><p>Handle родительского окна. Если 0, то родительским окном станет окно Desktop.</p>
</td>
</tr>
<tr>
<td><p>hRadio</p>
</td>
<td><p>Handle локального радиомодуля. Если 0, то авторизация будет проведена на всех радиомодулях. Если хотя бы один пройдет авторизацию, функция выполнится успешно.</p>
</td>
</tr>
<tr>
<td><p>pbdti</p>
</td>
<td><p>Информация об устройстве, на котором необходимо авторизироваться.</p>
</td>
</tr>
<tr>
<td><p>pszPasskey</p>
</td>
<td><p>PIN для авторизации. Если nil, то вызывается мастер авторизации (описано выше). Важно: pszPasskey не NULL-терминированная строка!</p>
</td>
</tr>
<tr>
<td><p>ulPasskeyLength</p>
</td>
<td><p>Длина строки в байтах. Должна быть меньше либо равна BLUETOOTH_MAX_PASSKEY_SIZE * SizeOf(WCHAR).
</td>
</tr>
</table>
<p>Возвращаемые значения:</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>ERROR_SUCCESS</p>
</td>
<td><p>Функция выполнена успешно</p>
</td>
</tr>
<tr>
<td><p>ERROR_CANCELLED</p>
</td>
<td><p>Пользователь отменил процесс авторизации</p>
</td>
</tr>
<tr>
<td><p>ERROR_INVALID_PARAMETER</p>
</td>
<td><p>Структура pbtdi не верна</p>
</td>
</tr>
<tr>
<td><p>ERROR_NO_MORE_ITEMS</p>
</td>
<td><p>Устройство в pbtdi уже авторизированно</p>
</td>
</tr>
<tr>
<td><p>Другие ошибки Win32</p>
</td>
<td><p>&nbsp;
</td>
</tr>
</table>
<p>Для "Blind Mode" соответствие кодов ошибок Bluetooth кодам ошибок Win32 приведено в таблице:</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>Bluetooth</p>
</td>
<td><p>Win32</p>
</td>
</tr>
<tr>
<td><p>BTH_ERROR_SUCCESS</p>
</td>
<td><p>ERROR_SUCCESS</p>
</td>
</tr>
<tr>
<td><p>BTH_ERROR_NO_CONNECTION</p>
</td>
<td><p>ERROR_DEVICE_NOT_CONNECTED</p>
</td>
</tr>
<tr>
<td><p>BTH_ERROR_PAGE_TIMEOUT</p>
</td>
<td><p>WAIT_TIMEOUT</p>
</td>
</tr>
<tr>
<td><p>BTH_ERROR_HARDWARE_FAILURE</p>
</td>
<td><p>ERROR_GEN_FAILURE</p>
</td>
</tr>
<tr>
<td><p>BTH_ERROR_AUTHENTICATION_FAILURE</p>
</td>
<td><p>ERROR_NOT_AUTHENTICATED</p>
</td>
</tr>
<tr>
<td><p>BTH_ERROR_MEMORY_FULL</p>
</td>
<td><p>ERROR_NOT_ENOUGH_MEMORY</p>
</td>
</tr>
<tr>
<td><p>BTH_ERROR_CONNECTION_TIMEOUT</p>
</td>
<td><p>WAIT_TIMEOUT</p>
</td>
</tr>
<tr>
<td><p>BTH_ERROR_LMP_RESPONSE_TIMEOUT</p>
</td>
<td><p>WAIT_TIMEOUT</p>
</td>
</tr>
<tr>
<td><p>BTH_ERROR_MAX_NUMBER_OF_CONNECTIONS</p>
</td>
<td><p>ERROR_REQ_NOT_ACCEP</p>
</td>
</tr>
<tr>
<td><p>BTH_ERROR_PAIRING_NOT_ALLOWED</p>
</td>
<td><p>ERROR_ACCESS_DENIED</p>
</td>
</tr>
<tr>
<td><p>BTH_ERROR_UNSPECIFIED_ERROR</p>
</td>
<td><p>ERROR_NOT_READY</p>
</td>
</tr>
<tr>
<td><p>BTH_ERROR_LOCAL_HOST_TERMINATED_CONNECTION</p>
</td>
<td><p>ERROR_VC_DISCONNECTED
</td>
</tr>
</table>
<p>Аналогичная функция:</p>
<p>BluetoothAuthenticateMultipleDevices - позволяет авторизироваться сразу на нескольких устройствах при помощи одной копии "Мастера авторизации".</p>
<p>Объявление функции:</p>
<pre>
function BluetoothAuthenticateMultipleDevices(
hwndParent : HWND;
hRadio : THandle;
cDevices : DWORD;
rgpbtdi : __PBLUETOOTH_DEVICE_INFO): DWORD; stdcall; 
</pre>
&nbsp;</p>
<p>Параметры:</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>hwndParent</p>
</td>
<td><p>Handle родительского окна. Если 0, то родительским окном станет окно Desktop.</p>
</td>
</tr>
<tr>
<td><p>hRadio</p>
</td>
<td><p>Handle локального радиомодуля. Если 0, то авторизация будет проведена на всех радиомодулях. Если хотя бы один пройдет авторизацию, функция выполнится успешно.</p>
</td>
</tr>
<tr>
<td><p>cDevices</p>
</td>
<td><p>Количество элементов в массиве rgpbtdi.</p>
</td>
</tr>
<tr>
<td><p>rgpbtdi</p>
</td>
<td><p>Массив структур BLUETOOTH_DEVICE_INFO, в котором представлены устройства для авторизации.
</td>
</tr>
</table>
<p>Возвращаемые значения:</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>ERROR_SUCCESS</p>
</td>
<td><p>Функция выполнена успешно. Проверьте флаг fAuthenticated у каждого устройства, что бы знать, какие прошли авторизацию.</p>
</td>
</tr>
<tr>
<td><p>ERROR_CANCELLED</p>
</td>
<td><p>Пользователь отменил процесс авторизации. Проверьте флаг fAuthenticated у каждого устройства, что бы знать, какие прошли авторизацию.</p>
</td>
</tr>
<tr>
<td><p>ERROR_INVALID_PARAMETER</p>
</td>
<td><p>Один или несколько элементов массива rgpbtdi не верны.</p>
</td>
</tr>
<tr>
<td><p>ERROR_NO_MORE_ITEMS</p>
</td>
<td><p>Все устройства в массиве уже авторизированны.</p>
</td>
</tr>
<tr>
<td><p>Другие ошибки Win32</p>
</td>
<td><p>&nbsp;
</td>
</tr>
</table>
<p>Важно: В оригинале функция выглядит вот так:</p>
<pre>
function BluetoothAuthenticateMultipleDevices(
hwndParent : HWND;
hRadio : THandle;
cDevices : DWORD;
pbtdi : PBLUETOOTH_DEVICE_INFO): DWORD; stdcall; 
</pre>
&nbsp;</p>
<p>Это не верно, так как в документации Microsoft указано, что параметр rgpbtdi должен передаваться как указатель (что подразумевает запись PBLUETOOTH_DEVICE_INFO), но как я писал выше, этот тип ошибочен. Он не является указателем. Я изменил функцию так, как показано выше. По поводу типа __PBLUETOOTH_DEVICE_INFO я писал выше.</p>
<p>Описывать с примером, как использовать эти функции не буду, так как они тривиальны (если вы прочитали все вышеизложенное). Остались последние три функции, которые мы не рассмотрели:</p>
<p>BluetoothRegisterForAuthentication - регистрирует функцию обратного вызова, которая будет вызываться на запрос устройства об авторизации. Если несколько приложений зарегистрировало такую функцию, то будет вызвана функция в последнем приложении.</p>
<p>Объявление функции:</p>
<pre>
function BluetoothRegisterForAuthentication(
  var pbtdi : PBLUETOOTH_DEVICE_INFO;
  var phRegHandle : HBLUETOOTH_AUTHENTICATION_REGISTRATION;
  pfnCallback : PFN_AUTHENTICATION_CALLBACK;
  pvParam : Pointer): DWORD; stdcall; 
</pre>
&nbsp;</p>
<p>Параметры:</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>pbtdi</p>
</td>
<td><p>Указатель на BLUETOOTH_DEVICE_INFO. Используется адрес устройства, для которого регистрируется функция. Обратите внимание на параметр. В оригинале он опять передается не как указатель.</p>
</td>
</tr>
<tr>
<td><p>phRegHandle</p>
</td>
<td><p>Указатель, куда будет возвращен Handle регистрации, которой потом используется в BluetoothUnregisterAuthentication.</p>
</td>
</tr>
<tr>
<td><p>pfnCallback</p>
</td>
<td><p>Функция обратного вызова.</p>
</td>
</tr>
<tr>
<td><p>pvParam</p>
</td>
<td><p>Опциональный параметр, который без изменения передается в функцию обратного вызова.
</td>
</tr>
</table>
<p>Возвращаемые значения:</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>ERROR_SUCCESS</p>
</td>
<td><p>Функция выполнена успешно.</p>
</td>
</tr>
<tr>
<td><p>ERROR_OUTOFMEMORY</p>
</td>
<td><p>Недостаточно памяти.</p>
</td>
</tr>
<tr>
<td><p>Другие ошибки Win32</p>
</td>
<td><p>&nbsp;
</td>
</tr>
</table>
<p>BluetoothUnregisterAuthentication - удаляет функцию обратного вызова, зарегистрированную функцией BluetoothRegisterForAuthentication и закрывает Handle.</p>
<p>Объявление функции:</p>
<pre>
function BluetoothUnregisterAuthentication(
hRegHandle : HBLUETOOTH_AUTHENTICATION_REGISTRATION): BOOL; stdcall; 
</pre>
&nbsp;</p>
<p>Параметры:</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>hRegHandle</p>
</td>
<td><p>Handle регистрации, полученный функцией BluetoothRegisterForAuthentication.
</td>
</tr>
</table>
<p>Возвращаемые значения:</p>
<p>Вернет TRUE, если вызов успешен и FALSE в случае неудачи. Используйте GetLastError для получения дополнительной информации.</p>
<p>BluetoothSendAuthenticationResponse - эта функция должна вызываться из функции обратного вызова при запросе авторизации удаленным устройством для передачи PIN.</p>
<p>Объявление функции:</p>
<pre>
function BluetoothSendAuthenticationResponse(
hRadio : THandle;
pbtdi : PBLUETOOTH_DEVICE_INFO;
pszPasskey : LPWSTR): DWORD; stdcall; 
</pre>
&nbsp;</p>
<p>Параметры:</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>hRadio</p>
</td>
<td><p>Handle радиомодуля, для которого проводим авторизацию. Если 0, то пытаемся на всех.</p>
</td>
</tr>
<tr>
<td><p>pbtdi</p>
</td>
<td><p>Указатель на BLUETOOTH_DEVICE_INFO с данными об устройстве, от которого поступил запрос на авторизацию. Может быть тот же указатель, который передан в функцию обратного вызова.</p>
</td>
</tr>
<tr>
<td><p>pszPasskey</p>
</td>
<td><p>Указатель на UNICODE строку, в которой содержится ключ авторизации (PIN).
</td>
</tr>
</table>
<p>Возвращаемые значения:</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>ERROR_SUCCESS</p>
</td>
<td><p>Функция выполнена успешно.</p>
</td>
</tr>
<tr>
<td><p>ERROR_CANCELLED</p>
</td>
<td><p>Устройство отвергло авторизационный код (PIN). Так же, возможно, имеются проблемы со связью</p>
</td>
</tr>
<tr>
<td><p>E_FAIL</p>
</td>
<td><p>Устройство вернуло ошибку авторизации.</p>
</td>
</tr>
<tr>
<td><p>Другие ошибки Win32</p>
</td>
<td><p>&nbsp;
</td>
</tr>
</table>
<p>И, наконец, функция обратного вызова:</p>
<p>PFN_AUTHENTICATION_CALLBACK</p>
<p>Описание этой функции дано выше. Здесь приведу лишь определеннее.</p>
<p>Объявление функции:</p>
<pre>
PFN_AUTHENTICATION_CALLBACK =
function(pvParam : Pointer;
pDevice : PBLUETOOTH_DEVICE_INFO): BOOL; stdcall; 
</pre>
&nbsp;</p>
<p>Параметры:</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>pvParam</p>
</td>
<td><p>Указатель на параметр, который мы передали в BluetoothRegisterForAuthentication.</p>
</td>
</tr>
<tr>
<td><p>pDevice</p>
</td>
<td><p>Указатель на BLUETOOTH_DEVICE_INFO с данными об устройстве, от которого поступил запрос на авторизацию.
</td>
</tr>
</table>
<p>Заключение</p>
<p>На этот раз все. Мы рассмотрели все функции Bluetooth API от Microsoft. Также мы научились управлять устройствами и радиомодулями Bluetooth, проводить авторизацию и получать информацию об этих устройствах.</p>
<p>Но актуальным остается вопрос, который мне многие задают. Как же все-таки передавать данные между устройствами Bluetooth?</p>
<p>Ответ на этот вопрос читайте в следующей серии статей "Передача данных через Bluetooth".</p>
<p>Конечно, можно было бы всю эту информацию уместить в эти статьи, но объем ее не сравним с предоставленным здесь. Так что наберитесь терпения. Я постараюсь надолго не задерживать с выходом новой серии.</p>
<p>Полностью рабочий пример, рассмотренный в этой статье, вы можете скачать здесь (300K).</p>
<p>Я буду рад любым замечаниям и пожеланиям по данной теме.</p>
<p>P.S. Внимательно относитесь к сторонним библиотекам. Как видите, в JWALIB оказалось много ошибок, которые порой загоняют в тупик. Я минут 20 смотрел на Access Violation, пока не понял, в чем дело.</p>
<p>Работа с Bluetooth в Delphi</p>
<p>Часть 4. Передача данных через Bluetooth</p>
&#169; 2006 Петриченко Михаил,<br>
<p>Soft Service Company</p>
<p>Введение</p>
<p>Наконец, после долгого перерыва я добрался и до заключительной, как я надеюсь, части статьи про Bluetooth.</p>
<p>Здесь я постараюсь изложить в доступной форме, как же все-таки передавать данные через Bluetooth. Я не буду приводить здесь каких-либо готовых примеров приложений. Дам только теорию. К практике, я думаю, вы перейдете сами.</p>
<p>Как вы помните из предыдущих моих статей, мы используем исключительно Windows API для работы с Bluetooth. Сразу хочу оговориться, что описанные здесь способы не будут работать с драйверами BlueSoliel и VIDCOMM. В конце статьи я расскажу, как установить драйвера от Microsoft, если вы это еще не сделали.</p>
<p>И так, приступаем.</p>
<p>Что вы должны знать</p>
<p>Прежде чем начать излагать основной материал, я хочу сформулировать требования к вашим знаниям.</p>
<p>Вы должны понимать работу с сетями в Microsoft Windows и знать термины и определения, данные мною в предыдущих статьях. Я буду часто отсылать к пройденному материалу, что бы не повторяться.</p>
<p>Вы также должны более или менее разбираться в технологии Winsock.</p>
<p>Bluetooth и Winsock</p>
<p>Как не странно это звучит, но Microsoft решила реализовать всю функциональность по передаче данных посредством Windows Socket Model. Тем, кто писал что-либо для IrDA это должно показаться знакомым.</p>
<p>На мой взгляд &#8211; правильное решение. Зачем огород городить, когда уже есть проверенные средства.</p>
<p>Я не буду описывать здесь все правила применения функций WinSock к работе с Bluetooth. Остановлюсь лишь на практической стороне вопроса. А именно - передача данных.</p>
<p>В статье мы сделаем простенький Bluetooth-клиент, который будет подсоединяться к удаленному устройству как к модему и позволит вам выполнять AT-команды. Весьма полезная вещь. Учтите, что данный клиент будет требовать авторизации устройств и не будет требовать наличия в системе каких-либо виртуальных COM-портов.</p>
<p>Сервисы и профили</p>
<p>Сервисы и профили... Это два краеугольных понятия Bluetooth. В некотором смысле &#8211; они идентичны.</p>
<p>Сервис &#8211; приложение-сервер, которое регистрирует определенным образом параметры в стеке протоколов Bluetooth. Наименование (GUID) всех сервисов строго определены Bluetooth.org.</p>
<p>Профиль &#8211; соглашения и стандарты работы сервиса. Понятнее объяснить не смогу.</p>
<p>Начало</p>
<p>И так, прежде чем можно будет использовать библиотеку WinSock, ее необходимо инициализировать. Делается это вызовом функции WSAStartup. Вот как она выглядит:</p>
<pre>
function WSAStartup(wVersionRequired: Word; var lpWSAData: WSAData): Integer; stdcall; 
</pre>
&nbsp;</p>
<p>Не буду описывать все параметры, так как они есть в любой справочной системе (MSDN, Delphi). Скажу только, что для использования WinSock с Bluetooth необходимо указаь в качестве параметра wVersionRequired номер версии $0202.</p>
<p>Вот как выглядит вызов этой функции:</p>
<pre>
var
Data: WSADATA;
begin
if WSAStartUp($0202, Data) &lt;&gt; 0 then
raise Exception.Create('Winsock Initialization Failed.'); 
</pre>
&nbsp;</p>
<p>По окончанию работы с WinSock библиотеку необходимо освободить. Для этого существует функция WSACleanup.</p>
<pre>
function WSACleanup: Integer; stdcall; 
</pre>
&nbsp;</p>
<p>Вызывается она просто, без всяких параметров. Возвращаемое значение, в принципе, можно не проверять:</p>
WSACleanup;</p>
<p>Создание клиента</p>
<p>После того, как библиотека инициализирована, мы можем вызывать функции WinSock. Давайте создадим простой сокет, для работы с Bluetooth устройствами. Для этого необходимо вызвать функцию socket.</p>
<pre>
function socket(af, type_, protocol: Integer): TSocket; stdcall; 
</pre>
&nbsp;</p>
<p>Вот как это делается:</p>
<pre>
var
ASocket: TSocket;
begin
ASocket := socket(AF_BTH, SOCK_STREAM, BTHPROTO_RFCOMM);
if ASocket = INVALID_SOCKET then 
RaiseLastOsError; 
</pre>
&nbsp;</p>
<p>Функция вернет корректный описатель сокета, либо INVALID_SOCKET в случае ошибки. Запомните, что Bluetooth поддерживает только потоковые сокеты (SOCK_STREAM).</p>
<p>Далее нам необходимо заполнить структуру SOCKADDR_BTH. В эту структуру записывается информация о сервере, к которому нам нужно подключиться (адрес, сервис и т.п.). Делается это следующим образом:</p>
<pre>
var
Addr: SOCKADDR_BTH;
AddrSize: DWORD;
begin
AddrSize := SizeOf(SOCKADDR_BTH);
FillChar(Addr, AddrSize, 0);
with Addr do 
begin
addressFamily := AF_BTH;
btAddr := ADeviceAddress;
serviceClassId := SerialPortServiceClass_UUID;
port := DWORD(BT_PORT_ANY);
end; 
</pre>
&nbsp;</p>
<p>Здесь в переменной ADeviceAddress должен быть адрес устройства (Int64), присоединяемся к любому порту (BT_PORT_ANY) сервиса SerialPortServiceClass.</p>
<p>Далее вызываем функцию connect, которая имеет вид:</p>
<pre>
function connect(s: TSocket; name: PSockAddr; namelen: Integer): Integer; stdcall; 
</pre>
<p>Делается это вот так:</p>
<pre>
if connect(ASocket, @Addr, AddrSize) &lt;&gt; 0 then RaiseLastOsError; 
</pre>
&nbsp;</p>
<p>Если функция выполнится успешно, вернет 0, в противном случае отличное от нуля значение.</p>
<p>После того, как соединение установлено, можно передавать и принимать данные через сокет функциями send и recv.</p>
<pre>
function send(s: TSocket; var buf; len, flags: Integer): Integer; stdcall;
function recv(s: TSocket; var buf; len, flags: Integer): Integer; stdcall; 
</pre>
&nbsp;</p>
<p>Функции возвращают количество переданных или принятых байт в случае успеха и отрицательное число в случае ошибки. Количество переданных или принятых байт может быть меньше, чем указанная в параметре len длина буфера. Тогда вам нужно повторить передачу/прием оставшихся байт.</p>
<p>Ну и закрытие сокета осуществляется вызовом функции closesocket:</p>
<pre>
function closesocket(s: TSocket): Integer; stdcall; 
</pre>
&nbsp;</p>
<p>Опять же, возвращаемое значение можно проигнорировать (если вы знаете, что делаете).</p>
<p>В общем то, вышеуказанный материал не представляет ничего нового для тех, кто хоть раз программировал под WinSock. Единственное, на что следует обратить внимание, это новые константы AF_BTH и BTHPROTO_RFCOMM.</p>
<p>Создание сервера</p>
<p>Как и создание клиента, создание сервера ничем не отличается от создания сервера для любой службы WinSock.</p>
<p>И так, начнем. Сокет создается также как и в приведенном выше примере для клиента. Точно также заполняем структуру Addt: SOCKADDR_BTH. Только в качестве адреса устройства указываем 0. Далее, необходимо привязать сокет к адресу. Делается это функцией bind:</p>
<pre>
function bind(s: TSocket; name: PSockAddr; namelen: Integer): Integer; stdcall; 
</pre>
&nbsp;</p>
<p>Которая вызывается следующим образом:</p>
<pre>
if Bind(ASocket, @Addr, AddrSize) &lt;&gt; 0 then 
RaiseLastOsError; 
</pre>
&nbsp;</p>
<p>Далее вызываем функцию listen, для того чтобы сервер начал прослушивать сокет на предмет подключения клиентов и функцию accept для приема входящего подключения:</p>
<pre>
function listen(s: TSocket; backlog: Integer): Integer; stdcall;
function accept(s: TSocket; addr: PSockAddr; addrlen: PINT): TSocket; stdcall; 
</pre>
&nbsp;</p>
<p>Делается это вот так:</p>
<pre>
var
AClientSocket: TSocket;
begin
if listen(ASocket, 10) &lt;&gt; 0 then 
RaiseLastOSError;
AClientSocket = accept(ASocket, nil, nil); 
</pre>
&nbsp;</p>
<p>После подключения клиента можно работать с AClientSocket &#8211; передавать и принимать данные.</p>
<p>Если вы не желаете больше принимать входящие подключения, закройте слушающий сокет.</p>
<p>Что осталось за кадром</p>
<p>Как и обещал, я коротко описал процедуры, необходимые для построения простого клиента и сервера, которые будут работать с Bluetooth через WinSock. Однако, здесь я не рассматривал вопросы регистрации сервисов и протоколы верхнего уровня.</p>
<p>Приведенной здесь информации достаточно для того, что бы вы могли создать приложение "клиент", которое соединится с ваши телефоном по Bluetooth и сможет выполнять AT-команды.</p>
<p>Более полную информацию и рабочие примеры можно найти здесь: http://www.btframework.com. Там же приведено решение по установке драйверов от Microsoft.</p>
<p>Всегда буду рад ответить на ваши вопросы: mike@btframework.com</p>
<p>Copyright&#169; 2006 Петриченко Михаил, Soft Service Company<br>
<p>Специально для Delphi Plus</p>
<div class="author">Автор: Петриченко Михаил</div>

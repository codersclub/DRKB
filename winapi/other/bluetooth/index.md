---
Title: Работа с Bluetooth в Delphi
Author: Петриченко Михаил, mike@btframework.com
Date: 28.06.2006
---


Работа с Bluetooth в Delphi
===========================

© 2006 Петриченко Михаил,

Soft Service Company

## Часть 1

**Вступление**

Этой статьей хочу начать серию по работе с Bluetooth в Delphi под
Microsoft Windows XP. Так как тема весьма сложная, прошу внимательно
читать. Повторяться не буду.

Все программы написаны на Delphi 6 и тестировались со стандартным стеком
Bluetooth от Microsoft под Windows XP + SP2.

Все необходимые библиотеки прилагаются. Так что дополнительно ничего
качать не нужно. При разработке использовал только API функции с JEDI.

Описание функций будут даны в стиле Object Pascal. Сионистов просьба
обращаться к MSDN и Microsoft Platform SDK.

**Получение списка установленных радиомодулей Bluetooth**

Итак, для начала попробуем получить список установленных на компьютере
радиомодулей Bluetooth.

BluetoothFindFirstRadio - начинает перечисление локальных радиомодулей
Bluetooth.

Объявление функции:

    function BluetoothFindFirstRadio(
                    const pbtfrp : PBlueToothFindRadioParams;
                    var phRadio : THandle): HBLUETOOTH_RADIO_FIND;
             stdcall; 

Параметры:

- pbtfrp -
указатель на структуру BLUETOOTH\_FIND\_RADIO\_PARAMS.
Член dwSize этой структуры должен содержать размер структуры
(устанавливается посредством SizeOf(BLUETOOTH\_FIND\_RADIO\_PARAMS)).

- phRadio -
описатель (Handle) найденного устройства.

Возвращаемые значения:

- В случае успешного выполнения функция вернет корректный описатель в phRadio и корректный описатель в качестве результата
- В случае ошибки будет возвращен 0. Для получения кода ошибки используйте функцию GetLastError

BluetoothFindNextRadio - находит следующий установленный радиомодуль Bluetooth.

Объявление функции:

    function BluetoothFindNextRadio(
                 hFind : HBLUETOOTH_RADIO_FIND;
                 var phRadio : THandle): BOOL; stdcall; 

Параметры:

- hFind -
Описатель, который вернула функция BluetoothFindFirstRadio

- phRadio -
Сюда будет помещен описатель следующего найденного радиомодуля

Возвращаемые значения:

- Вернет TRUE, если устройство найдено. В phRadio корректный описатель на найденный радиомодуль.
- Вернет FALSE в случае отсутствия устройства. phRadio содержит некорректный описатель. Используйте GetLastError для получения кода ошибки.

BluetoothFindRadioClose - закрывает описатель перечисления радиомодулей Bluetooth.

Объявление функции:

    function BluetoothFindRadioClose(hFind : HBLUETOOTH_RADIO_FIND): BOOL;
             stdcall; 

Параметры:

- hFind  -
Описатель, который вернула функция BluetoothFindFirstRadio

Возвращаемые значения:

- Вернет TRUE если описатель успешно закрыт.
- Вернет FALSE в случае ошибки. Для получения кода ошибки используйте GetLastError.

Теперь у нас достаточно знаний, чтобы получить список установленных радиомодулей Bluetooth.

Напишем вот такую процедуру:

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
      if (hFind <> 0) then
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

Это, конечно, все здорово, но в принципе бесполезно. Давайте что-нибудь
сделаем еще. Например, получим информацию о радиомодуле Bluetooth.

**Получение информации о радиомодуле Bluetooth**

Для получения информации о радиомодуле Bluetooth используется функция

BluetoothGetRadioInfo - возвращает информацию о радиомодуле, который
представлен описателем.

Объявление функции:

    function BluetoothGetRadioInfo(hRadio : THandle;
                 var pRadioInfo : BLUETOOTH_RADIO_INFO): DWORD;
             stdcall; 

Параметры:

- hRadio -
Описатель локального радиомодуля, который получен функцией
BluetoothFindRadioFirst или BluetoothFindRadioNext

- pRadioInfo -
Структура, в которую записывается информация об указанном
радиомодуле. Член dwSize должен быть равен размеру структуры

Возвращаемые значения:

Вернет ERROR\_SUCCESS если информация получена, в противном случае код ошибки.

Структура BLUETOOTH\_RADIO\_INFO выгляди вот так:

    BLUETOOTH_RADIO_INFO = record
      dwSize : dword;
      address : BLUETOOTH_ADDRESS;
      szName : array [0..BLUETOOTH_MAX_NAME_SIZE - 1] of widechar;
      ulClassofDevice : ulong;
      lmpSubversion : word; 
      manufacturer : word;
    end;

Параметры:

- dwSize          - Размер структуры в байтах
- address         - Адрес локального радиомодуля
- szName          - Имя радиомодуля
- ulClassofDevice - Класс устройства
- lmpSubversion   - Устанавливается производителем
- manufacturer    - Код производителя (константы BTH\_MFG\_Xxx).  
  Для получения новых кодов обратитесь к сайту спецификаций Bluetooth

Это уже что-то. Воспользуемся этой информацией и напишем вот такую
процедуру.

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

**Заключение**

Вот пока и все. В следующей статье рассмотрим, как получить список
присоединенных устройств и опросить сервисы, которые они представляют.

Готовый рабочий пример использования указанных функций вы можете найти здесь:
[btenum.zip](btenum.zip) 791 Кб


## Часть 2

**Вступление**

В первой части статьи мы научились получать список локальных
радиомодулей Bluetooth и узнавать их свойства.

Теперь пришло время получить список устройств Bluetooth, которые
подключены к нашим локальным радиомодулям.

**Получение списка устройств Bluetooth**

Для получения списка устройств Bluetooth нам понадобятся следующие
функции (они очень похожи на функции, используемые для получения списка
локальных радиомодулей).

BluetoothFindFirstDevice - начинает перечисление устройств Bluetooth.

Объявление функции:

    function BluetoothFindFirstDevice(
             const pbtsp : BLUETOOTH_DEVICE_SEARCH_PARAMS;
             var pbtdi : BLUETOOTH_DEVICE_INFO): HBLUETOOTH_DEVICE_FIND;
             stdcall; 

Параметры:

- Pbtsp -
Указатель на структуру BLUETOOTH\_DEVICE\_SEARCH\_PARAMS.
Член dwSize этой структуры должен содержать размер структуры
(устанавливается посредством SizeOf(BLUETOOTH\_DEVICE\_SEARCH\_PARAMS)).
Член hRadio должен содержать описатель локального радиомодуля,
полученный вызовом функции BluetoothFindFirstRadio.

- Pbtdi -
Структура BLUETOOTH\_DEVICE\_INFO,
в которую будет возвращена информации об устройстве Bluetooth.

Возвращаемые значения:

- В случае успешного выполнения функция вернет корректный описатель в качестве результата.
- В случае ошибки будет возвращен 0. Для получения кода ошибки используйте функцию GetLastError

BluetoothFindNextDevice - находит следующее устройство Bluetooth.

Объявление функции:

    function BluetoothFindNextDevice(hFind : HBLUETOOTH_DEVICE_FIND;
                  var pbtdi : BLUETOOTH_DEVICE_INFO): BOOL;
             stdcall; 

Параметры:

- hFind - Описатель, который вернула функция BluetoothFindFirstDevice

- pbtdi - Структура BLUETOOTH\_DEVICE\_INFO,
в которую будет помещена информацию об устройстве

Возвращаемые значения:

- Вернет TRUE, если устройство найдено.
- Вернет FALSE в случае отсутствия устройства. Используйте GetLastError для получения кода ошибки.

BluetoothFindDeviceClose - закрывает описатель перечисления устройств
Bluetooth.

Объявление функции:

    function BluetoothFindDeviceClose(hFind : HBLUETOOTH_DEVICE_FIND):
             BOOL; stdcall;

Параметры:

- hFind - Описатель, который вернула функция BluetoothFindFirstDevice

Возвращаемые значения:

- Вернет TRUE если описатель успешно закрыт.
- Вернет FALSE в случае ошибки. Для получения кода ошибки используйте GetLastError.

BluetoothGetDeviceInfo - возвращает информацию об указанном устройстве
Bluetooth.

Объявление функции:

    function BluetoothGetDeviceInfo(hRadio : THandle;
                  var pbtdi : BLUETOOTH_DEVICE_INFO): DWORD;
             stdcall; 

Параметры:

- hRadio - Описатель локального радиомодуля Bluetooth

- pbtdi - Структура BLUETOOTH\_DEVICE\_INFO, в которую возвразается информация
об устройстве.  
dwSize должен быть равен размеру структуры.  
addreess должен содержать адрес устройства, о котором хотим
получить информацию.

Возвращаемые значения:

- Вернет ERROR\_SUCCESS если выполнено успешно и информация занесена в структуру pbtdi.
  Остальные значения - код ошибки.

Обладая этими знаниями, можно написать процедуру получения информации об
устройствах Bluetooth:

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
      DeviceFind := BluetoothFindFirstDevice(DeviceSearchParams,
                                             DeviceInfo);
      if (DeviceFind <> 0) then begin
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

**Заключение**

Пока все. В следующей части рассмотрим способы получения информации о
сервисах, предоставляемых устройствами Bluetooth.

Желающие могут скачать набор классов для работы с Bluetooth API:
[bt_classes.zip](bt_classes.zip) 22 Кб


## Часть 3

**Вступление**

Итак, в предыдущих частях мы научились получать список локальных
радиомодулей Bluetooth и удаленных устройств Bluetooth. Нам осталось
научиться получать список сервисов, предоставляемых удаленным
устройством и управлять локальными радиомодулями. Так же, необходимо
разобраться, как же все-таки передаются данные между различными
устройствами Bluetooth.

В этой части, а она будет самой длинной и информативной, мы создадим
программу, которая поможет нам обобщить полученную информацию и покажет,
как использовать новые функции, которые здесь будут описаны.

Прежде, чем мы приступим, давайте определимся в терминах. Microsoft в
своей документации вводит два термина: Radio и Device. Radio - это
локальный радиомодуль Bluetooth (USB-брелок, интегрированное решение, в
общем то, что установлено на вашем компьютере). Device - это то
устройство Bluetooth с которым вы хотите обмениваться информацией. Будь
то телефон, КПК, гарнитура или еще что-то. Важно понимать, что если мы
пишем программу для PDA, то когда она работает на PDA - его модуль
Bluetooth будет Radio, а компьютер - Device. Если же она работает на
компьютере, то компьютерный модуль - Radio, а PDA - Device.

**Что мы знаем**

К сожалению, документация Microsoft по Bluetooth API и работе с
Bluetooth настолько скудна (у меня получилось 50 страниц в Word с
оформлением), а примеров они вообще не предоставляют, что из нее очень
трудно понять, как же все-таки работает эта технология.

Когда я только начинал изучать этот предмет, я перерыл весь Internet, но
так ничего вразумительного не нашел.

Поэтому, здесь мне хочется дать наиболее полную и подробную информацию
об этом вопросе, что бы вы не столкнулись с той же проблемой отсутствия
информации.

Итак, приступим.

**Создание проекта**

Давайте создадим в Delphi новый проект и сохраним его под именем BTWork,
а модуль - под именем Main.

Главную и пока единственную форму, назовем fmMain. Заголовок BTWork.

Теперь нам понадобятся файл JwaBluetoothAPI.pas, JwaBtHDef.pas и
JwaBthSdpDef.pas. Их можно найти в примерах из предыдущих частей или в
библиотеке BTClasses.

Для того, чтобы не тянуть с собой все остальные файлы из JWA, давайте
эти чуть-чуть исправим. Найдите в них строку

    uses
      JwaWindows

и замените JwaWindows на Windows.

Далее удалить из них строки

    {$WEAKPACKAGEUNIT}
     
    {$HPPEMIT ''}
    {$HPPEMIT '#include "bluetoothapis.h"'}
    {$HPPEMIT ''}
     
    {$I jediapilib.inc} 


И в файле JwaBluetoothAPI удалите все, что находится между {$IFDEF
DYNAMIC\_LINK} и {$ELSE} вместе с этими DEF. И в конце этого файле
удалите {$ENDIF}.

Далее, в JwaBluetoothAPI.pas после

    implementation
    
    uses
      JwaWinDLLNames;

Напишите

    const
      btapi = 'irprops.cpl';

Да простят нас ребята, которые эту библиотеку писали!

Все эти действия я делал для того, что бы уменьшить архив примера. Да и
не нужно тянуть за собой много лишнего. Хотя сама библиотека весьма
полезна. Один модуль JwaWindows чего стоит. Там очень много интересного
есть. Ну да ладно - что-то я отвлекся.

После того, как мы кастрировали эти модули, давайте добавим их в наш
проект. Готово?

В этом приложении мы будем получать список локальных радиомодулей,
устройств, к ним присоединенных, список сервисов, предоставляемых
устройствами. Также мы должны управлять радиомодулями и научиться
проходить авторизацию.

Приступаем.

**Оформление главной формы**

На главную форму поместим компонент TPanel и установите следующие
свойства:


Свойство                          | Значение
----------------------------------|---------
Align                             | alTop
Caption                           |
Name                              | Panel

Далее поместим компонент TTreeView и установите свойства как в таблице:


Свойство                          | Значение
----------------------------------|---------
Align                             | alLeft
Cursor                            | crHandPoint
HideSelection                     | False
HotTrack                          | True
Name                              | TreeView
ReadOnly                          | True

Правее TTreeView поместим TSplitter и установим следующие его свойства:

Свойство                          | Значение
----------------------------------|---------
Name                              | Splitter
Width                             | 5

И, наконец, помещаем компонент TListView еще правее TSplitter.
Устанавливаем его свойства как в таблице:

Свойство                          | Значение
----------------------------------|---------
Align                             | alClient
ColumnClick                       | False
Cursor                            | crHandPoint
GridLines                         | True
HideSelection                     | False
HotTrack                          | True
Name                              | ListView
ReadOnly                          | True
RowSelect                         | True
ShowWorkAreas                     | True
ViewStyle                         | vsReport

На TPanel поместим кнопку TButton.

Свойство                          | Значение
----------------------------------|---------
Caption                           | Refresh
Name                              | btRefresh

Теперь мы готовы писать программу.

**Пишем код**

При старте нашей программы, желательно чтобы сразу заполнялся TreeView.
В нем будут показаны модули Bluetooth и устройства, которые к ним
подключены.

Для этого в обработчике OnCreate формы fmMain напишем такой код:

    procedure TfmMain.FormCreate(Sender: TObject);
    begin
      btRefresh.Click;
    end; 


А в обработчике OnClick кнопки btRefresh напишем следующее:

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
          if TreeView.Items[Loop].ImageIndex > 0 then
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
        if hFind <> 0 then begin
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
            hDevFind := BluetoothFindFirstDevice(SearchParams,
                                                 DevInfo^);
            if hDevFind <> 0 then begin
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

В uses нашего модуля, который относится к главной форме, допишем:

    implementation // Уже написано!!!
     
    uses // Дописать!
    JwaBluetoothAPIs, Windows, SysUtils, Dialogs; 

Ниже добавим функцию:

    // Преобразует адрес из внутреннего формата (dword) в строку,
    // принятую для представления адресов устройств Bluetooth.
    function BTAdrToStr(const Adr: BLUETOOTH_ADDRESS): string;
    var
      Loop: byte;
    begin
      Result := IntToHex(Adr.rgBytes[0], 2);
      for Loop := 1 to 5 do
        Result := IntToHex(Adr.rgBytes[Loop], 2) + ‘:’ + Result;
    end;

Здесь хочу привести описание используемых структур, так как ранее я их
не описывал:

**BLUETOOTH\_DEVICE\_SEARCH\_PARAMS**

Объявление:

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

Члены:

- dwSize               - Входной параметр. Должен быть равен размеру структуры<br>
                         (dwSize := SizeOf(BLUETOOTH\_DEVICE\_SEARCH\_PARAMS))
- fReturnAuthenticated - Входной параметр. Функция будет возвращать устройства, прошедшие авторизацию.
- fReturnRemembered    - Входной параметр. Функция будет возвращать устройства, уже запомненные раннее.
- fReturnUnknown       - Входной параметр. Функция будет возвращать новые либо неизвестные устройства.
- fReturnConnected     - Входной параметр. Функция будет возвращать подключенные устройства.
- fIssueInquiry        - Входной параметр. Заставляет функцию проверять устройства.
- cTimeoutMultiplier   - Входной параметр. Тайм-аут для проверки устройства.
- hRadio               - Handle радиомодуля, для которого проводится поиск устройств.
  Если 0, то проверяются все радиомодули.

**BLUETOOTH\_DEVICE\_INFO**

Объявление:

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


Члены:

- dwSize          - Входной параметр. Должен быть равен размеру структуры<br>
                    (dwSize := SizeOf(BLUETOOTH\_DEVICE\_INFO))
- Address         - Адрес устройства Bluetooth.
- ulClassofDevice - Класс устройства. Подробнее по классам смотрите в JwaBluetoothAPIs. Константы спрефиксом COD\_xxx.
- fConnected      - Если TRUE, то устройство подключено/используется
- fRemembered     - Если TRUE, то устройство ранее уже было найдено (запомнено)
- fAuthenticated  - Если TRUE, то устройство прошло авторизацию (авторизированно)
- stLastSeen      - Дата и время последнего обнаружения устройства
- stLastUsed      - Дата и время последнего использования устройства
- szName          - Название устройства (имя)

**BLUETOOTH\_RADIO\_INFO**

Объявление:

    BLUETOOTH_RADIO_INFO = record
      dwSize : DWORD;
      address : BLUETOOTH_ADDRESS;
      szName : array [0..BLUETOOTH_MAX_NAME_SIZE - 1] of WideChar;
      ulClassofDevice : ULONG;
      lmpSubversion : Word;
      manufacturer : Word;
    end;

Члены:

- dwSize          - Должен быть равен размеру структуры<br>
                    (dwSize := SizeOf(BLUETOOTH\_RADIO\_INFO))
- Address         - Адрес радиомодуля Bluetooth
- szName          - Имя радиомодуля
- ulClassofDevice - Класс устройства (см. выше)
- lmpSubversion   - Зависит от производителя
- Manufacturer    - Код производителя. Определяется константами BTH\_MFG\_Xxx. Более полную информацию о производителях можно получить на сайте поддержки Bluetooth.

Далее напишем вот такой обработчик события OnChange для TreeView:

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
        if ASelected.ImageIndex > 0 then ShowDevices;
      end;
    end; 


В этом коде появилось три новые функции, которые выделены жирным
шрифтом. Вот они

BluetoothIsConnectable - определяет, возможно ли подключение к
указанному радиомодулю.

Объявление функции:

    function BluetoothIsConnectable(const hRadio : THandle):
             BOOL; stdcall; 

Параметры:

- hRadio - Handle радиомодуля, который мы проверяем.
Если 0, то проверяются все радиомодули.

Возвращаемые значения:

- Вернет TRUE, если указанный радиомодуль разрешает входящие подключения.
- Если hRadio=0, то вернет TRUE, если хотя бы один радиомодуль разрешает входящие подключения.
- Если входящие подключения запрещены, то вернет FALSE.

BluetoothIsDiscoverable - определяет, будет ли виден указанный
радиомодуль другим при поиске. Если просматриваются все радиомодули, то
вернет TRUE если хотя бы один разрешает обнаружение.

Объявление функции:

    function BluetoothIsDiscoverable(const hRadio : THandle):
             BOOL; stdcall; 

Параметры:

- hRadio - Handle радиомодуля, который мы проверяем.  
Если 0, то проверяются все радиомодули.

Возвращаемые значения:

- Вернет TRUE, если указанный радиомодуль разрешает обнаружение.
- Если hRadio=0, то вернет TRUE, если хотя бы один радиомодуль разрешает обнаружение.
- Если обнаружение запрещено, то вернет FALSE.

BluetoothEnumerateInstalledServices - получает список GUID сервисов,
предоставляемых устройством.

Если параметр hRadio=0, то просматривает все радиомодули.

Объявление функции:

    function BluetoothEnumerateInstalledServices(
                  hRadio : THandle;
                  pbtdi : __PBLUETOOTH_DEVICE_INFO;
                  var pcServices : dword;
                  pGuidServices : PGUID): dword; stdcall; 

Параметры:

- hRadio - Handle радиомодуля, который мы
проверяем. Если 0, то проверяются все радиомодули.

- pbtdi - Указатель на структуру BLUETOOTH\_DEVICE\_INFO, в
которой описано проверяемое устройство. Необходимо заполнить
поля dwSize и Address.

- pcServices - При вызове - количество записей
в массиве pGuidServices, возвращает в этом параметре
реальное количество сервисов, предоставляемых устройством.

- pGuidServices - Указатель на массив TGUID, в
который будут записаны GUID предоставляемых устройством
сервисом. Если nil и pcServices=0, то в pcServices
будет записано количество сервисов. Необходимо выделить для
pGuidServices память размером не менее pcServices\*SizeOf(TGUID).

Возвращаемые значения:

- Вернет ERROR\_SUCCESS, если вызов успешен и количество сервисов в pcServices соответствует реальности.
- Вернет ERROR\_MORE\_DATA, если вызов успешен, но выделенное количество памяти (pcServices при вызове) меньше, чем количество предоставляемых сервисов.
- В случае ошибки - другие коды ошибок Win32.

Примечания:

Посмотрите на код получения списка сервисов:

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


Сначала мы вызываем функцию с `pcServices=0` и `pGuidServices=nil` для того,
чтобы получить количество сервисов, предоставляемых устройством.

Потом выделяем память (SetLength()) и только затем вызываем функцию с
реальными параметрами и получаем список сервисов.

**Еще важное замечание.**
В файле JwaBluetoothAPIs.pas параметр pbtdi имеет
тип PBLUETOOTH\_DEVICE\_INFO, который раскрывается в
BLUETOOTH\_DEVICE\_INFO. Заметьте, что это НЕ УКАЗАТЕЛЬ. Это не верно,
так как в исходном виде функция требует именно указатель. По-этому, я
ввел тип

    type
      __PBLUETOOTH_DEVICE_INFO = ^PBLUETOOTH_DEVICE_INFO

Так что ИСПОЛЬЗУЙТЕ файл из примера, а не из исходной библиотеки. Иначе
получите нарушение доступа к памяти.

Комментарий к коду: Мы перечитываем информацию об устройстве, так как за
время, пока мы любуемся программой, могли произойти различные события:
устройство отключили, отменили авторизацию и т. п. А мы хотим иметь
самую свежую информацию об устройстве.

В принципе то, что описано выше, мы уже знали, кроме двух указанных
функций.

Давайте расширим возможности нашего приложения. Добавим функции
запрета/разрешения обнаружения радиомодуля и запрета/разрешения
подключения к нему.

**BluetoothEnableIncomingConnections** и **BluetoothEnableDiscoverable**

Поместим на форму компонент TactionList и изменим его свойства как
показано в таблице.

Свойство | Значение
---------|---------
Name     | ActionList

Теперь два раза щелкнем по ActionList и в появившемся окне редактора
свойств добавим две TAction со следующими свойствами:

Свойство                     | Значение
-----------------------------|---------
Name                         | acConnectable


Свойство                     | Значение
-----------------------------|--------------
Caption                      | Discoverable
Name                         | acDiscoverable

На панель Panel добавим две TButton и установим свойства:

Свойство                     | Значение
-----------------------------|--------------
Action                       | acConnectable
Name                         | btConnectable


Свойство                     | Значение
-----------------------------|---------------
Action                       | acDiscoverable
Name                         | btDiscoverable

Напишем вот такой обработчик события OnUpdate у acConnectable:

    procedure TfmMain.acConnectableUpdate(Sender: TObject);
    var
      SelectedItem: TListItem;
      SelectedNode: TTreeNode;
    begin
      SelectedNode := TreeView.Selected;
      SelectedItem := ListView.Selected;
       
      with TAction(Sender) do 
      begin
        Enabled := Assigned(SelectedNode) and Assigned(SelectedItem)
               and (SelectedNode.ImageIndex = -1);
       
        if Enabled then
          if StrToBool(SelectedItem.SubItems[4])
          then Caption := 'Not conn.'
          else Caption := 'Connectable';
      end;
    end; 


И то же самое напишем для обработчика события OnUpdate - acDiscoverable:

    procedure TfmMain.acDiscoverableUpdate(Sender: TObject);
    var
      SelectedItem: TListItem;
      SelectedNode: TTreeNode;
    begin
      SelectedNode := TreeView.Selected;
      SelectedItem := ListView.Selected;
       
      with TAction(Sender) do 
      begin
        Enabled := Assigned(SelectedNode) and Assigned(SelectedItem)
               and (SelectedNode.ImageIndex = -1);
         
        if Enabled then 
          if StrToBool(SelectedItem.SubItems[5])
          then Caption := 'Not disc.'
          else Caption := 'Discoverable';
      end;
    end; 


Теперь обработчик события OnExecute для acConnectable:

    procedure TfmMain.acConnectableExecute(Sender: TObject);
    var
      SelectedItem: TListItem;
    begin
      SelectedItem := ListView.Selected;
     
      if Assigned(SelectedItem) then
        if not BluetoothEnableIncomingConnections(
                 Integer(SelectedItem.Data),
                 TAction(Sender).Caption = 'Not conn.') 
        then MessageDlg('Unable to change Radio state', mtError, [mbOK], 0)
        else TreeViewChange(TreeView, TreeView.Selected);
    end; 


Такой же обработчик напишем и для OnExecute - acDiscoverable:

    procedure TfmMain.acConnectableExecute(Sender: TObject);
    var
      SelectedItem: TListItem;
    begin
      SelectedItem := ListView.Selected;
     
      if Assigned(SelectedItem) then
        if not BluetoothEnableDiscovery(Integer(SelectedItem.Data),
                 TAction(Sender).Caption = 'Not disc.') 
        then MessageDlg('Unable to change Radio state', mtError, [mbOK], 0)
        else TreeViewChange(TreeView, TreeView.Selected);
    end; 


**Вывод окна свойств устройства**

**Важно:**
Если Windows сам использует радиомодуль, то он не даст поменять
статус, хотя и функция выполнится без ошибок!

Здесь мы ввели две новые функции (выделены жирным):

**BluetoothEnableInfomingConnection** - функция разрешает/запрещает
подключения к локальному радиомодулю Bluetooth.

Объявление функции:

    function BluetoothEnableIncomingConnections(
        hRadio : THandle;
        fEnabled : BOOL): BOOL; stdcall; 


Параметры:

- hRadio - Handle радиомодуля, статус которого мы хотим изменить.
  Если 0, то меняем у всех.
- fEnabled - TRUE - разрешаем подключения; FALSE - запрещаем.

Возвращаемые значения:

- TRUE - если вызов успешен и статус изменен,
- FALSE - в противном случае.

**BluetoothEnableDiscovery** - функция разрешает/запрещает обнаружение
локального радиомодуля Bluetooth

Объявление функции:

    function BluetoothEnableDiscovery(hRadio : THandle; fEnabled : BOOL):
             BOOL; stdcall; 

Параметры:

- hRadio - Handle радиомодуля, статус которого мы хотим изменить. Если 0, то меняем у всех.
- fEnabled - TRUE - разрешаем обнаружение; FALSE - запрещаем.

Возвращаемые значения:

- TRUE - если вызов успешен и статус изменен,
- FALSE - в противном случае.

Теперь давайте научимся выводить системное окно свойств устройства
Bluetooth. Для этого добавим к ActionList еще один TAction вот с такими
свойствами:

Свойство                          | Значение
----------------------------------|-----------
Caption                           | Property
Name                              | acProperty

Добавим на Panel кнопку TButton с такими свойствами:

Свойство                          | Значение
----------------------------------|-----------
Action                            | acProperty
Name                              | btProperty


Теперь напишем такой обработчик событий OnUpdate у acProperty:

    procedure TfmMain.acPropertyUpdate(Sender: TObject);
    var
      SelectedNode: TTreeNode;
      SelectedItem: TListItem;
    begin
      SelectedNode := TreeView.Selected;
      SelectedItem := ListView.Selected;
       
      TAction(Sender).Enabled := Assigned(SelectedNode) and
                                 Assigned(SelectedItem) and
                                 (SelectedNode.ImageIndex > 0);
    end; 


И обработчик OnExecute для нее же:

    procedure TfmMain.acPropertyExecute(Sender: TObject);
    var
      Info: BLUETOOTH_DEVICE_INFO;
    begin
      Info := BLUETOOTH_DEVICE_INFO(ListView.Selected.Data^);
      BluetoothDisplayDeviceProperties(Handle, Info);
    end; 


**Важно:**
В исходном виде в файле JwaBluetoothAPIs функция
BluetoothDisplayDeviceProperties объявлена не верно. Второй параметр
должен быть указателем, а там он передается как структура. Я исправил
функцию так, чтобы он передавался как var-параметр (по ссылке).
Используйте модуль JwaBluetoothAPIs из этого примера, чтобы не возникало
ошибок доступа к памяти.

**Важно:**
Ни в этой процедуре, ни ранее, ни далее я не провожу проверку
ошибок, чтобы не загромождать код лишними подробностями. В реальном
приложении НЕОБХОДИМО проверять возвращаемые функциями значения и
указатели.

Итак, в этом коде есть новая функция, выделенная жирным шрифтом.

**BluetoothDisplayDeviceProperty** - функция выводит стандартное окно
свойств устройства Bluetooth.

Объявление функции:

    function BluetoothEnableDiscovery( hwndParent : HWND;
      var pbtdi : PBLUETOOTH_DEVICE_INFO): BOOL; stdcall;

**Важно:**
В оригинале (см. примечание выше) функция выглядит вот так:

    function BluetoothEnableDiscovery(hwndParent : HWND;
      pbtdi : PBLUETOOTH_DEVICE_INFO): BOOL; stdcall;

Это не верно, так как в документации Microsoft указано, что параметр
pbtdi должен передаваться как указатель (что подразумевает запись
PBLUETOOTH\_DEVICE\_INFO), но как я писал выше, этот тип ошибочен. Он не
является указателем. Я изменил функцию так, как показано выше (так она и
должна быть, если не менять определение типа).

Параметры:

- hwndParent - Handle родительского окна, которому будет принадлежать
  диалог свойств. Может быть 0, тогда родительским выбирается окно Desktop.
- pbtdi - Указатель на структуру BLUETOOTH\_DEVICE\_INFO в которой
  содержится адрес требуемого устройства.

Возвращаемые значения:

- TRUE - если вызов успешен
- FALSE - в противном случае (код ошибки можно узнать вызовом функции GetLastError).

**Выбор устройства**

Рассмотрим, как вызвать окно диалога выбора устройства.

Добавим в наш проект на Panel еще одну кнопку TButton и установите ее
свойства как в таблице:

Свойство                          | Значение
----------------------------------|---------
Caption                           | Select
Name                              | btSelect

Напишем вот такой обработчик события OnClick у этой кнопки:

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


В этой части кода две новые функции.

BluetoothSelectDevices - функция разрешает/запрещает обнаружение
локального радиомодуля Bluetooth.

Объявление функции:

    function BluetoothSelectDevices(pbtsdp : PBLUETOOTH_SELECT_DEVICE_PARAMS):
             BOOL; stdcall;

Параметры:

- pbtsdp - Описание смотрите ниже в описании структуры.

Возвращаемые значения:

- Если функция вернула TRUE, то пользователь выбрал устройства.
Pbtsdp^.pDevices будет указывать на корректные данные. После вызова
необходимо проверить флаги fAuthenticated и fRemembered, что бы
удостовериться в корректности данных. Для освобождения памяти
используйте функцию BluetoothSelectDevicesFree, только если функция
вернет TRUE.

- Вернет FALSE если вызов прошел не удачно. Используйте GetLastError для
получения дополнительных сведений.

Возможные ошибки:

Код                       | Значение
--------------------------|---------------------------
ERROR\_CANCELLED          | Пользователь отменил выбор устройства.
ERROR\_INVALID\_PARAMETER | Параметр pbsdp равен nil.
ERROR\_REVISION\_MISMATCH | Структура, переданная в pbsdp неизвестного или неверного размера.
Другие ошибки Win32       | 

**BLUETOOTH\_SELECT\_DEVICE\_PARAMS**

Объявление:

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


Члены:

- dwSize               - Должен быть равен размеру структуры (`dwSize := SizeOf(BLUETOOTH_RADIO_INFO)`)
- cNumOfClasses        - Входной параметр. Количество записей в массиве `prgClassOfDevice`. Если 0, то ищутся все устройства.
- prgClassOfDevices    - Входной параметр. Массив COD (классов устройств), которые необходимо искать.
- pszInfo              - Входной параметр. Если не nil, то задает текст заголовка окна выбора устройства.
- hwndParent           - Входной параметр. Handle родительского окна для диалога выбора устройства. Если 0, то родителем будет Desktop.
- fForceAuthentication - Входной параметр. Если TRUE, то требует принудительной авторизации устройств.
- fShowAuthenticated   - Входной параметр. Если TRUE, то авторизованные устройства будут доступны для выбора.
- fShowRemembered      - Входной параметр. Если TRUE, то запомненные устройства будут доступны для выбора.
- fShowUnknown         - Входной параметр. Если TRUE, то неизвестные (неавторизованные и не запомненные) устройства будут доступны для выбора.
- fAddNewDeviceWizard  - Входной параметр. Если TRUE, то запускает мастер добавления нового устройства.
- fSkipServicesPage    - Входной параметр. Если TRUE, то пропускает страницу Сервисы в мастере.
- pfnDeviceCallback    - Входной параметр. Если не nil, то является указателем на функцию обратного вызова, которая вызывается для каждого найденного устройства. Если функция вернет TRUE, то устройства добавляется в список, если нет, то устройство игнорируется.
- pvParam              - Входной параметр. Его значение будет передано функции pfnDeviceCallback в качестве параметра pvParam.
- cNumDevices          - Как входной параметр - количество устройств, которое требуется вернуть. Если 0, то нет ограничений. Как выходной параметр - количество возвращенных устройств (выбранных).
- pDevices             - Выходной параметр. Указатель на массив структур BLUETOOTH\_DEVICE\_INFO. Для его освобождения используйте функцию BluetoothSelectDevicesFree.<br/>Важно: В оригинале этот параметр объявлен как PBLUETOOTH\_DEVICE\_INFO. По этому поводу здесь много комментариев.


BluetoothSelectDevicesFree - функция должна вызываться, только если
вызов BluetoothSelectDevices был успешен. Эта функция освобождает память
и ресурсы, задействованные функцией BluetoothSelectDevices в структуре
BLUETOOTH\_SELECT\_DEVICE\_PARAMS.

Объявление функции:

    function BluetoothSelectDevices(
        pbtsdp : PBLUETOOTH_SELECT_DEVICE_PARAMS): BOOL; stdcall;

Параметры:

- pbtsdp - Описание смотрите выше в описании структуры.

Возвращаемые значения:

- TRUE - если вызов успешен,
- FALSE - нечего освобождать.

**Управление сервисами**

Для управления сервисами Microsoft Bluetooth API предоставляет функцию:

BluetoothSetServiceState - включает или выключает указанный сервис для
устройства Bluetooth. Система проецирует сервис Bluetooth на
соответствующий драйвер. При отключении сервиса - драйвер удаляется.
При его включении - драйвер устанавливается. Если выполняется включение
не поддерживаемого сервиса, то драйвер не будет установлен.

Объявление функции:

    function BluetoothSetServiceState( hRadio : Thandle;
      var pbtdi : PBLUETOOTH_DEVICE_INFO;
      const pGuidService : TGUID;
      dwServiceFlags : DWORD): DWORD; stdcall; 

Параметры:

- hRadio - Описатель радиомодуля.
- pbtdi - Указатель на структуруBLUETOOTH\_DEVICE\_INFO.
- pGuidService - GUID сервиса, который необходимо включить/выключить.
- dwServiceFlags - Флаги управления сервисом:
    * BLUETOOTH\_SERVICE\_DISABLE - отключает сервис;
    * BLUETOOTH\_SERVICE\_ENABLE - включает сервис.


Возвращает ERROR\_SUCCESS если вызов прошел успешно. Если вызов не
удался вернет один из следующих кодов:

Код             | Значение
---------------------------------|---------------------------------
ERROR\_INVALID\_PARAMETER        | Неверные флаги в dwServiceFlags
ERROR\_SERVICE\_DOES\_NOT\_EXIST | Указанный сервис не поддерживается
Другие ошибки Win32              | 

**Важно:**
В оригинале (см. примечание выше) функция выглядит вот так:

    function BluetoothSetServiceState(
      hRadio : Thandle;
      pbtdi : PBLUETOOTH_DEVICE_INFO;
      const pGuidService : TGUID;
      dwServiceFlags : DWORD): DWORD; stdcall;

Это не верно, так как в документации Microsoft указано, что параметр
pbtdi должен передаваться как указатель (что подразумевает запись
PBLUETOOTH\_DEVICE\_INFO), но как я писал выше, этот тип ошибочен. Он не
является указателем. Я изменил функцию так, как показано выше (так она и
должна быть, если не менять определение типа).

Как использовать функцию? Давайте добавим к ActionList еще одну TAction
с такими свойствами:

Свойство                          | Значение
----------------------------------|---------
Caption                           | Disable
Name                              | acEnable

И добавим на Panel еще одну кнопку TButton, установив у нее следующие
свойства:

Свойство                          | Значение
----------------------------------|---------
Action                            | acEnable
Name                              | btEnable

В обработчике события OnUpdate для acEnable напишем вот такой код:

    procedure TfmMain.acEnableUpdate(Sender: TObject);
    var
      SelectedNode: TTreeNode;
      SelectedItem: TListItem;
    begin
      SelectedNode := TreeView.Selected;
      SelectedItem := ListView.Selected;
       
      TAction(Sender).Enabled := Assigned(SelectedNode) and
                                 Assigned(SelectedItem) and
                                 (SelectedNode.ImageIndex = -2);
    end;

А в обработчике OnExecute для acEnable вот такой код:

    procedure TfmMain.acEnableExecute(Sender: TObject);
    var
      GUID: TGUID;
    begin
      GUID := StringToGUID(ListView.Selected.Caption);
      BluetoothSetServiceState(TreeView.Selected.Parent.ImageIndex,
        BLUETOOTH_DEVICE_INFO(TreeView.Selected.Data^),
        GUID, BLUETOOTH_SERVICE_DISABLE);
    end;

**Важно:**
После нажатия на кнопку btEnable сервис будет удален из системы.
Включить его можно будет через окно свойств устройства Bluetooth.

Как определять отключенные сервисы рассмотрим в серии про передачу
данных через Bluetooth.

**Удаление устройств**

Для удаления устройств используется функция:

BluetoothRemoveDevice - функция удаляет авторизацию между компьютером и
устройством Bluetooth. Так же очищает кэш-записи об этом устройстве.

Объявление функции:

    function BluetoothRemoveDevice(
        var pAddress : BLUETOOTH_ADDRESS): DWORD; stdcall; 


Параметры:

- hAddress - Адрес устройства, которое удаляется.

Возвращаемые значения:

- ERROR\_SUCCESS          - устройство удалено
- ERROR\_NOT\_FOUND       - устройство не найдено

Давайте попробуем. Добавим в ActionList TAction со следующими
свойствами:

Свойство                | Значение
------------------------|---------
Caption                 | Remove
Name                    | acRemove

И на Panel кнопку TButton со свойствами:

Свойство                | Значение
------------------------|---------
Action                  | acRemove
Name                    | btRemove

В обработчике OnUpdate для acRemove напишем следующий код:

    procedure TfmMain.acRemoveUpdate(Sender: TObject);
    begin
      TAction(Sender).Enabled := acProperty.Enabled;
    end; 

А для события OnExecute вот такой код:

    procedure TfmMain.acRemoveExecute(Sender: TObject);
    var
      Info: BLUETOOTH_DEVICE_INFO;
      Res: dword;
    begin
      Info := BLUETOOTH_DEVICE_INFO(ListView.Selected.Data^);
      Res := BluetoothRemoveDevice(Info.Address);
      if Res <> ERROR_SUCCESS then
        MessageDlg('Device not found', mtError, [mbOK], 0);
      TreeViewChange(TreeView, TreeView.Selected);
    end; 

Процедура выполняется достаточно долго, так что не думайте, что
программа зависла.

**Важно:**
Устройство удаляется из списка. Однако, если уже иметь адрес
устройства, то можно получить о нем информацию.

Есть еще одно функция, которая связана с BluetoothRemoveDevice. Это:

BluetoothUpdateDeviceRecord - функция обновляет данные об устройстве в
кэше.

Объявление функции:

    function BluetoothUpdateDeviceRecord(
      var pbtdi : BLUETOOTH_DEVICE_INFO): DWORD; stdcall; 

Параметры:

- pbtdu - Указатель на структуру BLUETOOTH\_DEVICE\_INFO. В ней
  должны быть заполнены поля:
    * dwSize - размер структуры;
    * Address - адрес устройства;
    * szName - новое имя устройства.

Возвращаемые значения:

- ERROR\_SUCCESS            - Функция выполнена успешно
- ERROR\_INVALID\_PARAMETER - Указатель pbtdi=nil. (Для варианта в Delphi не реально, так как указатель мы получаем из структуры, передавая ее как var-параметр).
- ERROR\_REVISION\_MISMATCH - Размер структуры в dwSize не правильный
- Другие ошибки Win32

Попробуем использовать и ее. Схема стандартная: TAction к ActionList,
TButton на Panel:

Свойство                  | Значение
--------------------------|---------
Caption                   | Update
Name                      | acUpdate

Свойство                  | Значение
--------------------------|---------
Action                    | acUpdate
Name                      | btUpdate

Код:

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
        if Res <> ERROR_SUCCESS then RaiseLastOsError;
        TreeViewChange(TreeView, TreeView.Selected);
      end;
    end; 


Как видите, все просто.

Итак, удалять устройства мы умеем. Давайте теперь научимся добавлять
их. Для этого Bluetooth API предоставляет две функции:

BluetoothAuthenticateDevice - отправляет запрос на авторизацию
удаленному устройству Bluetooth.

Есть два режима авторизации: "Wizard mode" и "Blind Mode".

"Wizard Mode" запускается, когда параметр pszPasskey = nil. В этом
случае открывается окно "Мастера подключения". У пользователя будет
запрошен пароль, который будет отправлен в запросе на авторизацию
удаленному устройству. Пользователь будет оповещен системой об успешном
или не успешном выполнении авторизации и получит возможность попытаться
авторизировать устройства еще раз.

"Blind Mode" вызывается, когда pszPasskey \<\> nil. В этом случае
пользователь не увидит никакого мастера. Вам необходимо программно
запросить код авторизации (pszPasskey) и уведомить пользователя о
результате.

Объявление функции:

    function BluetoothAuthenticateDevice(
      hwndParent : HWND;
      hRadio : THandle;
      pbtdi : BLUETOOTH_DEVICE_INFO;
      pszPasskey : PWideChar;
      ulPasskeyLength : ULONG): DWORD; stdcall;

Параметры:

- hwndParent -Handle родительского окна. Если 0, то родительским окном станет окно Desktop.
- hRadio - Handle локального радиомодуля. Если 0, то авторизация будет проведена на всех радиомодулях. Если хотя бы один пройдет авторизацию, функция выполнится успешно.
- pbdti - Информация об устройстве, на котором необходимоавторизироваться.
- pszPasskey - PIN для авторизации. Если nil, то вызывается мастер авторизации (описано выше). Важно: pszPasskey не NULL-терминированная строка!
- ulPasskeyLength - Длина строки в байтах. Должна быть меньше либо равна BLUETOOTH\_MAX\_PASSKEY\_SIZE * SizeOf(WCHAR).

Возвращаемые значения:

- ERROR\_SUCCESS            - Функция выполнена успешно
- ERROR\_CANCELLED          - Пользователь отменил процесс авторизации
- ERROR\_INVALID\_PARAMETER - Структура pbtdi не верна
- ERROR\_NO\_MORE\_ITEMS    - Устройство в pbtdi уже авторизированно
- Другие ошибки Win32

Для "Blind Mode" соответствие кодов ошибок Bluetooth кодам ошибок
Win32 приведено в таблице:

Bluetooth                         | Win32
----------------------------------|-------------------------------
BTH\_ERROR\_SUCCESS               | ERROR\_SUCCESS
BTH\_ERROR\_NO\_CONNECTION        | ERROR\_DEVICE\_NOT\_CONNECTED
BTH\_ERROR\_PAGE\_TIMEOUT         | WAIT\_TIMEOUT
BTH\_ERROR\_HARDWARE\_FAILURE     | ERROR\_GEN\_FAILURE
BTH\_ERROR\_AUTHENTICATION\_FAILURE | ERROR\_NOT\_AUTHENTICATED
BTH\_ERROR\_MEMORY\_FULL          | ERROR\_NOT\_ENOUGH\_MEMORY
BTH\_ERROR\_CONNECTION\_TIMEOUT   | WAIT\_TIMEOUT
BTH\_ERROR\_LMP\_RESPONSE\_TIMEOUT | WAIT\_TIMEOUT
BTH\_ERROR\_MAX\_NUMBER\_OF\_CONNECTIONS | ERROR\_REQ\_NOT\_ACCEP
BTH\_ERROR\_PAIRING\_NOT\_ALLOWED | ERROR\_ACCESS\_DENIED
BTH\_ERROR\_UNSPECIFIED\_ERROR    | ERROR\_NOT\_READY
BTH\_ERROR\_LOCAL\_HOST\_TERMINATED\_CONNECTION | ERROR\_VC\_DISCONNECTED

Аналогичная функция:

BluetoothAuthenticateMultipleDevices - позволяет авторизироваться сразу
на нескольких устройствах при помощи одной копии "Мастера
авторизации".

Объявление функции:

    function BluetoothAuthenticateMultipleDevices(
      hwndParent : HWND;
      hRadio : THandle;
      cDevices : DWORD;
      rgpbtdi : __PBLUETOOTH_DEVICE_INFO): DWORD; stdcall; 

Параметры:

- hwndParent - Handle родительского окна. Если 0, то родительским окном станет окно Desktop.
- hRadio- Handle локального радиомодуля. Если 0, то авторизация будет проведена на всех радиомодулях. Если хотя бы один пройдет авторизацию, функция выполнится успешно.
- cDevices- Количество элементов в массиве rgpbtdi.
- rgpbtdi- Массив структур BLUETOOTH\_DEVICE\_INFO, в котором представлены устройства для авторизации.

Возвращаемые значения:

- ERROR\_SUCCESS            - Функция выполнена успешно. Проверьте флаг fAuthenticated у каждого устройства, что бы знать, какие прошли авторизацию.
- ERROR\_CANCELLED          - Пользователь отменил процесс авторизации. Проверьте флаг fAuthenticated у каждого устройства, что бы знать, какие прошли авторизацию.
- ERROR\_INVALID\_PARAMETER - Один или несколько элементов массива rgpbtdi не верны.
- ERROR\_NO\_MORE\_ITEMS    - Все устройства в массиве уже авторизированны.
- Другие ошибки Win32

Важно: В оригинале функция выглядит вот так:

    function BluetoothAuthenticateMultipleDevices(
      hwndParent : HWND;
      hRadio : THandle;
      cDevices : DWORD;
      pbtdi : PBLUETOOTH_DEVICE_INFO): DWORD; stdcall; 

Это не верно, так как в документации Microsoft указано, что параметр
rgpbtdi должен передаваться как указатель (что подразумевает запись
PBLUETOOTH\_DEVICE\_INFO), но как я писал выше, этот тип ошибочен. Он не
является указателем. Я изменил функцию так, как показано выше. По поводу
типа \_\_PBLUETOOTH\_DEVICE\_INFO я писал выше.

Описывать с примером, как использовать эти функции не буду, так как они
тривиальны (если вы прочитали все вышеизложенное). Остались последние
три функции, которые мы не рассмотрели:

BluetoothRegisterForAuthentication - регистрирует функцию обратного
вызова, которая будет вызываться на запрос устройства об авторизации.
Если несколько приложений зарегистрировало такую функцию, то будет
вызвана функция в последнем приложении.

Объявление функции:

    function BluetoothRegisterForAuthentication(
      var pbtdi : PBLUETOOTH_DEVICE_INFO;
      var phRegHandle : HBLUETOOTH_AUTHENTICATION_REGISTRATION;
      pfnCallback : PFN_AUTHENTICATION_CALLBACK;
      pvParam : Pointer): DWORD; stdcall; 

Параметры:

- pbtdi - Указатель на BLUETOOTH\_DEVICE\_INFO. Используется адрес устройства, для которого регистрируется функция. Обратите внимание на параметр. В оригинале он опять передается не как указатель.
- phRegHandle - Указатель, куда будет возвращен Handle регистрации, которой потом используется в BluetoothUnregisterAuthentication.
- pfnCallback - Функция обратного вызова.
- pvParam - Опциональный параметр, который без изменения передается в функцию обратного вызова.

Возвращаемые значения:

- ERROR\_SUCCESS          - Функция выполнена успешно.
- ERROR\_OUTOFMEMORY      - Недостаточно памяти.
- Другие ошибки Win32

BluetoothUnregisterAuthentication - удаляет функцию обратного вызова,
зарегистрированную функцией BluetoothRegisterForAuthentication и
закрывает Handle.

Объявление функции:

    function BluetoothUnregisterAuthentication(
      hRegHandle : HBLUETOOTH_AUTHENTICATION_REGISTRATION): BOOL; stdcall; 

Параметры:

- hRegHandle - Handle регистрации, полученный функцией BluetoothRegisterForAuthentication.

Возвращаемые значения:

Вернет TRUE, если вызов успешен и FALSE в случае неудачи. Используйте
GetLastError для получения дополнительной информации.

BluetoothSendAuthenticationResponse - эта функция должна вызываться из
функции обратного вызова при запросе авторизации удаленным устройством
для передачи PIN.

Объявление функции:

    function BluetoothSendAuthenticationResponse(
      hRadio : THandle;
      pbtdi : PBLUETOOTH_DEVICE_INFO;
      pszPasskey : LPWSTR): DWORD; stdcall; 

Параметры:

- hRadio     - Handle радиомодуля, для которого проводим авторизацию. Если 0, то пытаемся на всех.
- pbtdi      - Указатель на BLUETOOTH\_DEVICE\_INFO с данными об устройстве, от которого поступил запрос на авторизацию. Может быть тот же указатель, который передан в функцию обратного вызова.
- pszPasskey - Указатель на UNICODE строку, в которой содержится ключ авторизации (PIN).

Возвращаемые значения:

- ERROR\_SUCCESS   - Функция выполнена успешно.
- ERROR\_CANCELLED - Устройство отвергло авторизационный код (PIN). Так же, возможно, имеются проблемы со связью
- E\_FAIL          - Устройство вернуло ошибку авторизации.
- Другие ошибки Win32

И, наконец, функция обратного вызова:

    PFN_AUTHENTICATION_CALLBACK

Описание этой функции дано выше. Здесь приведу лишь определеннее.

Объявление функции:

    PFN_AUTHENTICATION_CALLBACK = function(pvParam : Pointer;
      pDevice : PBLUETOOTH_DEVICE_INFO): BOOL; stdcall; 


Параметры:

- pvParam - Указатель на параметр, который мы передали в BluetoothRegisterForAuthentication.
- pDevice - Указатель на BLUETOOTH\_DEVICE\_INFO с данными об устройстве, от которого поступил запрос на авторизацию.

**Заключение**

На этот раз все. Мы рассмотрели все функции Bluetooth API от Microsoft.
Также мы научились управлять устройствами и радиомодулями Bluetooth,
проводить авторизацию и получать информацию об этих устройствах.

Но актуальным остается вопрос, который мне многие задают. Как же
все-таки передавать данные между устройствами Bluetooth?

Ответ на этот вопрос читайте в следующей серии статей "Передача данных
через Bluetooth".

Конечно, можно было бы всю эту информацию уместить в эти статьи, но
объем ее не сравним с предоставленным здесь. Так что наберитесь
терпения. Я постараюсь надолго не задерживать с выходом новой серии.

Полностью рабочий пример, рассмотренный в этой статье, вы можете скачать
здесь:
[bt_work.zip](bt_work.zip) 307K

Я буду рад любым замечаниям и пожеланиям по данной теме.

P.S. Внимательно относитесь к сторонним библиотекам. Как видите, в
JWALIB оказалось много ошибок, которые порой загоняют в тупик. Я минут
20 смотрел на Access Violation, пока не понял, в чем дело.

## Часть 4. Передача данных через Bluetooth

**Введение**

Наконец, после долгого перерыва я добрался и до заключительной, как я
надеюсь, части статьи про Bluetooth.

Здесь я постараюсь изложить в доступной форме, как же все-таки
передавать данные через Bluetooth. Я не буду приводить здесь каких-либо
готовых примеров приложений. Дам только теорию. К практике, я думаю, вы
перейдете сами.

Как вы помните из предыдущих моих статей, мы используем исключительно
Windows API для работы с Bluetooth. Сразу хочу оговориться, что
описанные здесь способы не будут работать с драйверами BlueSoliel и
VIDCOMM. В конце статьи я расскажу, как установить драйвера от
Microsoft, если вы это еще не сделали.

Итак, приступаем.

**Что вы должны знать**

Прежде чем начать излагать основной материал, я хочу сформулировать
требования к вашим знаниям.

Вы должны понимать работу с сетями в Microsoft Windows и знать термины и
определения, данные мною в предыдущих статьях. Я буду часто отсылать к
пройденному материалу, что бы не повторяться.

Вы также должны более или менее разбираться в технологии Winsock.

**Bluetooth и Winsock**

Как ни странно это звучит, но Microsoft решила реализовать всю
функциональность по передаче данных посредством Windows Socket Model.
Тем, кто писал что-либо для IrDA это должно показаться знакомым.

На мой взгляд - правильное решение. Зачем огород городить, когда уже
есть проверенные средства.

Я не буду описывать здесь все правила применения функций WinSock к
работе с Bluetooth. Остановлюсь лишь на практической стороне вопроса. А
именно - передача данных.

В статье мы сделаем простенький Bluetooth-клиент, который будет
подсоединяться к удаленному устройству как к модему и позволит вам
выполнять AT-команды. Весьма полезная вещь. Учтите, что данный клиент
будет требовать авторизации устройств и не будет требовать наличия в
системе каких-либо виртуальных COM-портов.

**Сервисы и профили**

Сервисы и профили... Это два краеугольных понятия Bluetooth. В
некотором смысле - они идентичны.

Сервис - приложение-сервер, которое регистрирует определенным образом
параметры в стеке протоколов Bluetooth. Наименование (GUID) всех
сервисов строго определены Bluetooth.org.

Профиль - соглашения и стандарты работы сервиса. Понятнее объяснить не
смогу.

**Начало**

Итак, прежде чем можно будет использовать библиотеку WinSock, ее
необходимо инициализировать. Делается это вызовом функции WSAStartup.
Вот как она выглядит:

    function WSAStartup(wVersionRequired: Word; var lpWSAData: WSAData):
             Integer; stdcall; 

Не буду описывать все параметры, так как они есть в любой справочной
системе (MSDN, Delphi). Скажу только, что для использования WinSock с
Bluetooth необходимо указаь в качестве параметра wVersionRequired номер
версии $0202.

Вот как выглядит вызов этой функции:

    var
      Data: WSADATA;
    begin
      if WSAStartUp($0202, Data) <> 0 then
        raise Exception.Create('Winsock Initialization Failed.'); 

По окончанию работы с WinSock библиотеку необходимо освободить. Для
этого существует функция WSACleanup.

    function WSACleanup: Integer; stdcall; 

Вызывается она просто, без всяких параметров. Возвращаемое значение, в
принципе, можно не проверять:

    WSACleanup;

Создание клиента

После того, как библиотека инициализирована, мы можем вызывать функции
WinSock. Давайте создадим простой сокет, для работы с Bluetooth
устройствами. Для этого необходимо вызвать функцию socket.

    function socket(af, type_, protocol: Integer): TSocket; stdcall; 

Вот как это делается:

    var
      ASocket: TSocket;
    begin
      ASocket := socket(AF_BTH, SOCK_STREAM, BTHPROTO_RFCOMM);
      if ASocket = INVALID_SOCKET then 
        RaiseLastOsError; 

Функция вернет корректный описатель сокета, либо INVALID\_SOCKET в
случае ошибки. Запомните, что Bluetooth поддерживает только потоковые
сокеты (SOCK\_STREAM).

Далее нам необходимо заполнить структуру SOCKADDR\_BTH. В эту структуру
записывается информация о сервере, к которому нам нужно подключиться
(адрес, сервис и т.п.). Делается это следующим образом:

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

Здесь в переменной ADeviceAddress должен быть адрес устройства (Int64),
присоединяемся к любому порту (BT\_PORT\_ANY) сервиса
SerialPortServiceClass.

Далее вызываем функцию connect, которая имеет вид:

    function connect(s: TSocket; name: PSockAddr; namelen: Integer):
             Integer; stdcall; 

Делается это вот так:

    if connect(ASocket, @Addr, AddrSize) <> 0 then RaiseLastOsError; 

Если функция выполнится успешно, вернет 0, в противном случае отличное
от нуля значение.

После того, как соединение установлено, можно передавать и принимать
данные через сокет функциями send и recv.

    function send(s: TSocket; var buf; len, flags: Integer):
             Integer; stdcall;
    function recv(s: TSocket; var buf; len, flags: Integer):
             Integer; stdcall; 

Функции возвращают количество переданных или принятых байт в случае
успеха и отрицательное число в случае ошибки. Количество переданных или
принятых байт может быть меньше, чем указанная в параметре len длина
буфера. Тогда вам нужно повторить передачу/прием оставшихся байт.

Ну и закрытие сокета осуществляется вызовом функции closesocket:

    function closesocket(s: TSocket): Integer; stdcall; 

Опять же, возвращаемое значение можно проигнорировать (если вы знаете,
что делаете).

В общем то, вышеуказанный материал не представляет ничего нового для
тех, кто хоть раз программировал под WinSock. Единственное, на что
следует обратить внимание, это новые константы AF\_BTH и
BTHPROTO\_RFCOMM.

**Создание сервера**

Как и создание клиента, создание сервера ничем не отличается от создания
сервера для любой службы WinSock.

Итак, начнем. Сокет создается также как и в приведенном выше примере
для клиента. Точно также заполняем структуру Addt: SOCKADDR\_BTH. Только
в качестве адреса устройства указываем 0. Далее, необходимо привязать
сокет к адресу. Делается это функцией bind:

    function bind(s: TSocket; name: PSockAddr; namelen: Integer):
             Integer; stdcall; 

Которая вызывается следующим образом:

    if Bind(ASocket, @Addr, AddrSize) <> 0 then 
      RaiseLastOsError; 

Далее вызываем функцию listen, для того чтобы сервер начал прослушивать
сокет на предмет подключения клиентов и функцию accept для приема
входящего подключения:

    function listen(s: TSocket; backlog: Integer):
             Integer; stdcall;
    function accept(s: TSocket; addr: PSockAddr; addrlen: PINT):
             TSocket; stdcall; 

Делается это вот так:

    var
      AClientSocket: TSocket;
    begin
      if listen(ASocket, 10) <> 0 then 
        RaiseLastOSError;
      AClientSocket = accept(ASocket, nil, nil); 

После подключения клиента можно работать с AClientSocket - передавать и
принимать данные.

Если вы не желаете больше принимать входящие подключения, закройте
слушающий сокет.

**Что осталось за кадром**

Как и обещал, я коротко описал процедуры, необходимые для построения
простого клиента и сервера, которые будут работать с Bluetooth через
WinSock. Однако, здесь я не рассматривал вопросы регистрации сервисов и
протоколы верхнего уровня.

Приведенной здесь информации достаточно для того, что бы вы могли
создать приложение "клиент", которое соединится с ваши телефоном по
Bluetooth и сможет выполнять AT-команды.

Более полную информацию и рабочие примеры можно найти здесь:
http://www.btframework.com. Там же приведено решение по установке
драйверов от Microsoft.

Всегда буду рад ответить на ваши вопросы: mike@btframework.com

Copyright © 2006 Петриченко Михаил, Soft Service Company

Специально для Delphi Plus

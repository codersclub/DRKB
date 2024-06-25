---
Title: Подключение сетевого диска
Author: Eber Irigoyen
Date: 01.01.2007
---


Подключение сетевого диска
==========================

Вариант 1:

Source: <https://forum.sources.ru>

Если возникла необходимость, чтобы Ваше приложение самостоятельно
подключало сетевой ресурс, то это можно сделать двумя способами: вызвать
стандартный диалог подключения ресурса либо использоваться следующий
код.

    //Пример открытия стандартного диалога 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      WNetConnectionDialog(Handle,RESOURCETYPE_DISK) 
    end; 
     
    //Так же можно подключить и принтер 
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      WNetConnectionDialog(Handle,RESOURCETYPE_PRINT) 
    end; 
     
    //либо можно использовать следующий код 
    procedure TForm1.Button2Click(Sender: TObject); 
    var 
    NetResource: TNetResource; 
    begin 
      { заполняем структуру TNetResource } 
      NetResource.dwType       := RESOURCETYPE_DISK; 
      NetResource.lpLocalName  := 'S:'; 
      NetResource.lpRemoteName := '\\myserver\public'; 
      NetResource.lpProvider   := ''; 
     
      { подключаем сетевой ресурс, используя структуру TNetResource } 
      If ( WNetAddConnection2(NetResource, 
                             '', {Password (if needed) or empty} 
                             '', {User name (if needed) or empty} 
                             CONNECT_UPDATE_PROFILE)<>NO_ERROR) Then 
         Raise Excepcion.Create('unable to map drive') 
      //так же существуют другие константы для определения возникшей ошибки 
      //ERROR_ACCESS_DENIED, ERROR_ALREADY_ASSIGNED, и т.д. 
    end; 
     
    //так же можно и отключить сетевой ресурс... 
    procedure TForm1.Button2Click(Sender: TObject); 
    begin 
      if WNetCancelConnection2( 'S:',0,TRUE) <> NO_ERROR then 
        Raise Exception.create('Error disconnecting map drive'); 
      //соответственно можно использовать другие константы для определения ошибки
      //ERROR_DEVICE_IN_USE, ERROR_NOT_CONNECTED, и т.д. 
    end;


------------------------------------------------------------------------

Вариант 2:

Source: <https://dmitry9.nm.ru/info/>

Подключение и отключение сетевых дисководов

Для работы с сетевыми дисководами (и ресурсами типа LPT порта) в WIN API
16 и WIN API 32 следующие функции:

**Подключить сетевой ресурс:**

    WNetAddConnection(NetResourse,Password,LocalName:PChar):longint;

где `NetResourse` - имя сетевого ресурса (например `'\\P166\c\'`)

`Password` - пароль на доступ к ресурсу (если нет пароля, то пустая строка)

`LocalName` - имя, под которым сетевой ресурс будет отображен на данном
компьютере (например 'F:')

Пример подключения сетевого диска:

    WNetAddConnection('\\P166\C\','','F:');

Функция возвращает код ошибки. Для всех кодов предописаны константы,
наиболее часто используемые :

`NO_ERROR` - Нет ошибок - успешное завершение

`ERROR_ACCESS_DENIED` - Ошибка доступа

`ERROR_ALREADY_ASSIGNED` - Уже подключен. Наиболее часто возникает при
повторном вызове данной функции с теми-же параметрами.

`ERROR_BAD_DEV_TYPE` - Неверный тип устройства.

`ERROR_BAD_DEVICE` - Неверное устройство указано в LocalName

`ERROR_BAD_NET_NAME` - Неверный сетевой путь или сетевое имя

`ERROR_EXTENDED_ERROR` - Некоторая ошибка сети (см. функцию
WNetGetLastError для подробностей)

`ERROR_INVALID_PASSWORD` - Неверный пароль

`ERROR_NO_NETWORK` - Нет сети

**Отключить сетевой ресурс:**

    WNetCancelConnection(LocalName:PChar;ForseMode:Boolean):Longint;

где

`LocalName` - имя, под которым сетевой ресурс был подключен к данному
компьютеру (например 'F:')

`ForseMode` - режим отключения:

- False - корректное отключение. Если отключаемый ресурс еще используется,
то отключения не произойдет (например, на сетевом диске открыт файл)
- True - скоростное некорректное отключение. Если ресурс используется,
отключение все равно произойдет и межет привести к любым последствиям
(от отсутствия ошибок до глухого повисания)

Функция возвращает код ошибки. Для всех кодов предописаны константы,
наиболее часто используемые :

`NO_ERROR` - Нет ошибок - успешное завершение

`ERROR_DEVICE_IN_USE` - Ресурс используется

`ERROR_EXTENDED_ERROR` - Некоторая ошибка сети (см. функцию
WNetGetLastError для подробностей)

`ERROR_NOT_CONNECTED` - Указанное ус-во не является сетевым

`ERROR_OPEN_FILES` - На отключаемом сетевом диске имеются открытые файлы
и параметр ForseMode=false

**Рекомендация:**
при отключении следует сначала попробовать отключить
устройство с параметром ForseMode=false и при ошибке типа
`ERROR_OPEN_FILES` выдать запрос с сообщением о том, что ус-во еще
используется и предложением отключить принудительно, и при согласии
пользователя повторить вызов с ForseMode=true


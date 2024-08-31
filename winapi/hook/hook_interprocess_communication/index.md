---
Title: Interprocess communication на примере keyboard hook (статья)
Date: 01.01.2007
Author: Тенцер А.Л., tolik@katren.nsk.ru
---


Interprocess communication на примере keyboard hook (статья)
============================================================

**Взаимодействие процессов**

Архитектура Win32 подразумевает максимальную изоляцию выполняющихся
приложений друг от друга. Каждое приложение выполняется в своем
виртуальном адресном пространстве, которое полностью обособлено и не
имеет доступа к памяти других программ. Однако иногда возникает
необходимость в передаче данных их одного выполняющегося процесса в
другой. Рассмотрим подробно одну из таких задач, а затем основные
способы связи между процессами и рекомендации по их применению.

**Пишем перехватчик клавиатуры**

Итак, стоит задача - перехватить события от клавиатуры во всех
выполняющихся процессах. Для перехвата событий Win32 API предоставляет
механизм, называемый «ловушками» (hook). Ловушка может быть установлена
на многие события, возникающие в Windows, такие, как события от мыши,
создание окон, вызов оконной процедуры и т.п. Для её установки
используется функция:

    function SetWindowsHookEx(
      idHook: Integer;      // Идентификатор, показывающий какая
                            // ловушка устанавливается
      lpfn: TFNHookProc;    // Адрес функции-ловушки
      hmod: HINST;          // Идентификатор модуля, в котором находится
                            // процедура-ловушка
      dwThreadId: DWORD     // Идентификатор потока, для которого ловушка
                            // устанавливается
    ): HHOOK; stdcall;      // Функция возвращает идентификатор ловушки.

Рассмотрим эти параметры подробнее:

IdHook - Целое число, инструктирующее Windows какое событие должно
вызывать срабатывание «ловушки». Должно быть одной из констант, WH\_XXX,
описанных в Windows.pas. Нас интересует WH\_KEYBOARD

lpFn - Адрес функции, которая будет автоматически вызываться каждый раз при
возникновении события.

hMod - Идентификатор модуля, в котором
расположена функция. Если ловушка устанавливается на события,
происходящие в других процессах (а не только в вызывающем), то функция
lpfn должна находиться в DLL. Эта DLL загружается в адресное
пространство каждого процесса Windows. Если ловушка ставится только на
события, происходящие в вызывающем процессе, то функция может находиться
прямо в EXE файле, а в качестве этого параметра передается 0.

dwThreadId - Идентификатор потока, события в котором нас
интересуют. Если этот параметр равен 0, то ловушка ставится на все
потоки в системе.

Поскольку нам нужны события во всех потоках - необходимо написать DLL,
содержащую функцию-ловушку. В эту же DLL удобно поместить функцию для
включения и отключения ловушки.

Функция-ловушка для WH\_KEYBOARD должна соответствовать прототипу:

    function KeyboardProc(
      Code: Integer;   // Определяет способ обработки события
                       // если Code < 0, функция должна немедленно
                       // вызвать CallNextHookEx и возвратить
                       // её результат
      wParam: WPARAM;  // Содержит код клавиши
      lParam: LPARAM   // Содержит набор битовых флагов с дополнительной
                       // информацией
    ): Integer;        // Функция должна вернуть 0 для разрешения Windows
                       // дальнейшей обработки события или другое число
                       // для её запрета
    stdcall;           // Функция должна соответствовать соглашению о
                       // вызовах stdcall

В простейшем случае функция должна содержать следующий код:

    function KeyboardProc(Code: Integer; wParam: WPARAM;
      lParam: LPARAM): Integer; stdcall;
    begin
      if Code < 0 then
        Result := CallNextHookEx(HookHandle, Code, wParam, lParam );
    end;

HookHandle - это глобальная переменная, которая должна содержать
идентификатор ловушки, полученный от SetWindowsHookEx. Для установки
ловушки напишем функцию:

    function SetHook(Activate : BOOL): BOOL; stdcall; export;
    begin
      Result := FALSE;
      if Activate then 
      begin
        HookHandle := SetWindowsHookEx(WH_KEYBOARD, @KeyboardProc,
          hInstance, 0);
        Result := (HookHandle <> 0);
      end 
      else
      begin
        if HookHandle <> 0 then 
        begin
          Result := UnhookWindowsHookEx(HookHandle);
          if Result then
            HookHandle := 0;
        end;
      end;
    end;

Здесь возникает первая сложность. Для корректной обработки событий в
каждом из процессов DLL загружается в адресное пространство всех
процессов в системе. Если объявить HookHandle как глобальную переменную
внутри DLL, то когда эта DLL будет загружена в адресное пространство
разных процессов - в каждом из них она будет иметь свой набор
глобальных переменных. Таким образом, в вызывающем процессе HookHandle
будет равен идентификатору ловушки, а в остальных - нулю. Необходимо
организовать доступ к этой переменной из всех процессов. Лучше всего
использовать механизм отображения файлов на память (memory mapped
files). Он заключается в том, что можно установить соответствие между
каким-либо участком адресного пространства и участком в файле на диске.
При этом, все изменения, сделанные в памяти отображаются на файл. Более
того, если несколько процессов отобразили свою память на один и тот же
участок файла - изменения, сделанные любым из них немедленно становятся
доступными остальным т.е. этот участок памяти становится общим для всех
этих процессов. Такой общий блок переменных удобно создавать прямо в
swap-файле Windows.

Для отображения памяти на файл используются функции:

    function CreateFileMapping(
      hFile: THandle;  // Идентификатор ранее открытого файла. Если hFile
                       // равен -1, то объект создается в swap-файле
      lpFileMappingAttributes: PSecurityAttributes;
                       // Аттрибуты защиты. Для наследования аттрибутов
                       // вызывающего процесса можно передать NIL
      flProtect,       // Права на чтение-запись
      dwMaximumSizeHigh,         // Старшие 32 разряда размера объекта
      dwMaximumSizeLow: DWORD;   // Младшие 32 разряда размера объекта
      lpName: PChar    // Имя объекта
    ): THandle; stdcall;

Функция возвращает идентификатор объекта-отображения файла на память.
Далее этот идентификатор надо передать функции:

    function MapViewOfFile(
      hFileMappingObject: THandle; // Идентификатор объекта-отображения
      dwDesiredAccess: DWORD;      // Тип доступа к файлу
      dwFileOffsetHigh,            // Старшие 32 разряда смещения в файле
      dwFileOffsetLow,             // Младшие 32 разряда смещения в файле
      dwNumberOfBytesToMap: DWORD  // Количество байт для отображения.
                                   // Если параметр равен 0 -
                                   // отображается весь файл
    ): Pointer; stdcall;           // Возвращается адрес отображенного
                                   // участка памяти

Таким образом, необходимо в каждом из процессов, нуждающихся в обмене
данными при загрузке выполнить следующий код:

    type
      PKeyboardHookInfo = ^TKeyboardHookInfo;
      TKeyboardHookInfo = packed record
        HookHandle: THandle;
      end;
     
    const
      UniqueHookId = 'sMyCoolKeyboardHook';
     
    var
      CommonArea: PKeyboardHookInfo = NIL;
      Mapping : THandle = 0;
     
    ...
     
      Mapping := CreateFileMapping(-1, NIL, PAGE_READWRITE, 0,
        SizeOf(CommonArea), UniqueHookId);
      CommonArea := MapViewOfFile(hMapping, FILE_MAP_ALL_ACCESS,
        0, 0, 0);

а по завершении:

    if Assigned(CommonArea) then 
      UnmapViewOfFile(CommonArea);
    if hMapping <> 0 then 
      CloseHandle(Mapping);

Удобно оформить этот код в виде отдельного модуля, поместив создание и
уничтожение объекта, соответственно в его секции initialization и
finalization, которые автоматически выполняются при загрузке модуля в
память и выгрузке его из памяти. Назвав этот модуль Exchange, и поместив
его в список используемых модулей основной программы и DLL, мы
автоматически получим в них глобальную переменную CommonArea,
указывающую на разделяемую память.

**Внимание!**
Если Вы используете такой модуль в разных проектах, то каждый
из них должен содержать свою копию этого модуля с различными значениями
UniqueHookId

Имея этот модуль, мы можем переписать функции KeyboardProc и SetHook

    function KeyboardProc(Code: Integer; wParam: WPARAM;
      lParam: LPARAM): Integer; stdcall;
    begin
      if Code < 0 then
        Result := CallNextHookEx(CommonArea^.HookHandle,
          Code, wParam, lParam );
    end;

HookHandle - это глобальная переменная, которая должна содержать
идентификатор ловушки, полученный от SetWindowsHookEx. Для установки
ловушки напишем функцию:

    function SetHook(Activate : BOOL): BOOL; stdcall; export;
    begin
      Result := FALSE;
      if Activate then 
      begin
        CommonArea^.HookHandle := SetWindowsHookEx(WH_KEYBOARD,
          @KeyboardProc, hInstance, 0);
        Result := (CommonArea^.HookHandle <> 0);
      end 
      else
      begin
        if CommonArea^.HookHandle <> 0 then 
        begin
          Result := UnhookWindowsHookEx(CommonArea^.HookHandle);
          if Result then
            CommonArea^.HookHandle := 0;
        end;
      end;
    end;

Теперь наша ловушка вполне работоспособна, и можно приступать к
насыщению её функциональностью. Поскольку функция может быть вызвана в
адресном пространстве другого процесса, она не может вызывать функции
главной программы. Простейший способ известить программу о срабатывании
ловушки - послать сообщение какому-то из её окон. Но какому окну, и
какое сообщение? Рассмотрим эти вопросы по отдельности.

**Какому окну?**

Для того чтобы послать окну сообщение, необходимо знать его
идентификатор (handle). Можно, конечно, послать сообщение сразу всем
окнам Windows, указав в качестве идентификатора окна HWND\_BROADCAST, но
делать это по каждому нажатию клавиши - значит неоправданно увеличить
нагрузку на всю систему. Поэтому, лучше выделить в области обмена,
наряду с HookHandle еще одну переменную - FormHandle - в которую
вызывающая программа перед установкой ловушки должна записать
идентификатор окна, обрабатывающего сообщения от ловушки.

**Какое сообщение?**

В Windows одновременно выполняются десятки программ. Поэтому, особенно
при получении сообщений от других процессов всегда есть некоторая
вероятность, что жестко закодированные номера сообщений (типа WM\_APP +
1234) в разных программах совпадут, что приведет к их некорректной
работе. Поэтому, для целей обмена между процессами лучше получить общий
уникальный номер сообщения. Для этого служит функция:

    function RegisterWindowMessage(
      lpString: PChar  // уникальная текстовая строка
    ): UINT; stdcall; 

Функция проверяет, было ли уже зарегистрировано сообщение с параметром
lpString. Если еще нет - «выдается» уникальный в пределах сессии
Windows номер, если да - возвращается ранее полученный номер.

Получение номера удобно разместить в тот же модуль, что и область
обмена, а в качестве lpString использовать тот же идентификатор
UniqueHookId.

Таким образом, модуль, предназначенный для обмена, принимает
окончательный вид:

    unit Exchange;
     
    interface
     
    uses Windows;
     
    type
      PKeyboardHookInfo = ^TKeyboardHookInfo;
      TKeyboardHookInfo = packed record
        FormHandle: THandle;
        HookHandle: THandle;
      end;
     
    var
      WMKeyHook: Integer = 0;
      CommonArea: PKeyboardHookInfo = NIL;
     
    implementation
     
    var
      Mapping: THandle = 0;
     
    const
      UniqueHookId = '{F61D1A60-4DB8-11D3-89E9-9579FCF8927A}';
    // Для генерации уникального идентификатора удобно использовать GUID
    // Просто нажмите Ctrl+Shift+G в среде разработки Delphi – 
    // и Вы получите статистически уникальную строку
     
    initialization
      Mapping := CreateFileMapping(-1, NIL, PAGE_READWRITE, 0,
        SizeOf(CommonArea), UniqueHookId);
      CommonArea := MapViewOfFile(Mapping, FILE_MAP_ALL_ACCESS,
        0, 0, 0);
      WMKeyHook := RegisterWindowMessage(UniqueHookId);
     
    finalization
      if Assigned(CommonArea) then
        UnmapViewOfFile(CommonArea);
      if Mapping <> 0 then
        CloseHandle(Mapping);
    end.

Вопросы обмена практически решены и можно дописать функцию KeyboardProc.
После этого код DLL тоже можно привести полностью:

    library HookDLL;
     
    uses Windows, Exchange;
     
    function KeyboardProc(Code: Integer; wParam: WPARAM;
      lParam: LPARAM): Integer; stdcall; 
    begin
      if Code < 0 then
        Result := CallNextHookEx(CommonArea^.HookHandle, Code, wParam,
          lParam)
      else
      begin
        PostMessage(CommonArea^.FormHandle, Exchange.WMKeyHook, wParam,
          lParam );
        Result := CallNextHookEx(CommonArea^.HookHandle, Code, wParam,
          lParam );
      end;
    end;
     
    function SetHook(Activate : BOOL): BOOL; stdcall; export;
    begin
      Result := FALSE;
      if Activate then 
      begin
        CommonArea^.HookHandle := SetWindowsHookEx(WH_KEYBOARD,
          @KeyboardProc, hInstance, 0);
        Result := (CommonArea^.HookHandle <> 0);
      end 
      else
      begin
        if CommonArea^.HookHandle <> 0 then 
        begin
          Result := UnhookWindowsHookEx(CommonArea^.HookHandle);
          if Result then
            CommonArea^.HookHandle := 0;
        end;
      end;
    end;
     
    exports
      SetHook;
     
    begin
    end.

Для посылки сообщения лучше использовать PostMessage, т.к. она, в
отличие от SendMessage просто помещает сообщение в очередь, не
задерживая программу на время его обработки.

В вызывающем приложении необходимо написать следующий код:

    unit HookForm;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms,
      Dialogs, StdCtrls;
     
    type
      TForm1 = class(TForm)
        cbSetHook: TCheckBox;
        Memo1: TMemo;
        procedure cbSetHookClick(Sender: TObject);
        procedure FormCreate(Sender: TObject);
        procedure FormDestroy(Sender: TObject);
      private
        procedure AppOnMessage(var Msg: TMsg; var Handled: Boolean);
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    uses Exchange;
     
    {$R *.DFM}
     
    // Объявляем прототип функции SetHook
    function SetHook(Activate: BOOL): BOOL; stdcall;
      external 'HookDLL.DLL';
     
    procedure TForm1.cbSetHookClick(Sender: TObject);
    // Это функция-обработчик компонента TCheckBox
    // В зависимости от него состояния она устанавливает
    // или снимает перехватчик клавиатуры
    begin
      SetHook(cbSetHook.Checked);
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      // Очищаем область обмена
      FillChar(CommonArea^, SizeOf(CommonArea^), 0);
      // Сообщения от ловушки будут посылаться приложению
      CommonArea^.FormHandle := Application.Handle;
      // Устанавливаем обработчик сообщений
      Application.OnMessage := AppOnMessage;
    end;
     
    procedure TForm1.FormDestroy(Sender: TObject);
    // По завершении программы не забываем снять ловушку.
    begin
      if cbSetHook.Checked then
        SetHook( FALSE );
    end;
     
    procedure TForm1.AppOnMessage(var Msg: TMsg; var Handled: Boolean);
    var
      Buffer: array[0..50] of Char;
      S: String;
      Flags : Word;
    begin
      if Msg.Message = Exchange.WMKeyHook then 
      begin
        // Получаем наименование нажатой клавиши
        GetKeyNameText(Msg.lParam, @Buffer, SizeOf(Buffer));
        S := StrPas(Buffer);
        Flags := Msg.lParam shr 16;
        if (Flags and KF_UP) <> 0 then
          S := S + ' down'
        else if (Flags and KF_REPEAT) <> 0 then 
          S := S + ' repeat'
        else S := S + ' up';
        Memo1.Lines.Add(S);
        Handled := TRUE;
      end;
    end;
     
    end.

**Способы обмена данными между процессами**

Далее мы рассмотрим основные способы обмена данными между процессами и
их область применимости.

**Clipboard**

Буфер обмена предназначен для переноса данных пользователем между
приложениями. Приложения должны поддерживать копирование своих данных в
буфер и вставку из него, однако, они не должны использовать буфер обмена
без участия пользователя, поскольку это приведет к уничтожению
помещенных туда данных. В Delphi для работы с буфером обмена имеется
класс TClipboard.

Также необходимо обратить внимание, что некоторые приложения (например,
Microsoft Excel) ведут себя по-разному в Windows 95 и в Windows NT. При
вставке из буфера обмена из под Windows NT, Excel вставляет данные в
кодировке UNICODE, и, если русский текст был помещен в буфер обмена как
8-битовые символы, вставленные данные оказываются некорректными. Для
решения этой проблемы необходимо определять версию Windows и вставлять
текст с её учетом. Сделать это можно следующим образом:

    procedure SendToClipboard(const S: String);
    var
      Data: THandle;
      DataPtr: Pointer;
      Version: TOSVersionInfo;
      Size: Integer;
    begin
      Version.dwOSVersionInfoSize := SizeOf(TOSVersionInfo);
      GetVersionEx(Version);
      if Version.dwPlatformId = VER_PLATFORM_WIN32_NT then
      with Clipboard do
      begin
        Size := Length(S) * SizeOf(WideChar) + 1;
        Open;
        try
          Data := GlobalAlloc(GMEM_MOVEABLE + GMEM_DDESHARE, Size);
          try
            DataPtr := GlobalLock(Data);
            try
              MultiByteToWideChar(CP_ACP, 0, PChar(S), Length(S),
                DataPtr, Size);
              Clear;
              SetClipboardData(CF_UNICODETEXT, Data);
            finally
              GlobalUnlock(Data);
            end;
          finally
            GlobalFree(Data);
          end;
        finally
          Close;
        end;
      end
      else
        Clipboard.SetTextBuf(PChar(S));
    end;

**COM**

COM - это языконезависимая технология, позволяющая одному приложению
вызывать методы другого даже если они находятся в разных процессах или
на разных машинах. Разумеется, для этого вызываемое приложение должно
предоставить совместимый со спецификацией COM интерфейс вызовов, т.е.
быть COM-сервером. Delphi позволяет создавать такие интерфейсы, при
помощи ключевого слова interface. Также Delphi содержит полный набор
инструментов для быстрого создания COM-серверов, а также для написания
клиентов, использующих их возможности.

Типичный сценарий взаимодействия процессов при помощи COM выглядит
следующим образом:

1. Программа, предоставляющая другим программам возможность вызывать свои функции, реализует COM-сервер, создаваемый при помощи мастера File-\>New-\>ActiveX-\>COM object
2. Затем эта программа регистрирует себя в реестре (для этого надо однократно запустить её на компьютере)
3. Программы, нуждающиеся в обращении к функциям, реализованным в COM-сервере запрашивают создание экземпляра сервера при помощи функции

    function CreateComObject(const ClassID: TGUID): IUnknown;

либо при помощи класса-оболочки, автоматически сгенерированного Delphi

Примером работы с COM-объектом может служить следующий код:

    uses MyComServer_TLB;
    …
    var
      MyComObject: IMyComObject;
    …
    MyComObject := CoMyComObject.Create;
    …  // Вызов методов IMyComObject
    MyComObject := NIL;  // Освобождение экземпляра COM-сервера

Остановимся подробнее на некоторых ключевых моментах приведенного
примера.

MyComServer\_TLB.pas - это модуль, автоматически генерируемый Delphi,
при создании нового COM-объекта. Этот модуль содержит описание
интерфейса (IMyComObject) и реализацию ко-класса (CoMyComObject) -
специального класса-оболочки, который позволяет запросить создание
COM-объекта не вдаваясь в подробности архитектуры COM. Метод Create
класса CoMyComObject возвращает ссылку на интерфейс созданного
экземпляра COM-сервера. Для освобождения COM-сервера из памяти
необходимо присвоить ссылке на него значение NIL. При этом автоматически
уменьшится значение счетчика ссылок, и, при достижении им нуля, сервер
будет автоматически выгружен. Если MyComObject является локальной
переменной, то сервер будет выгружен при выходе этой переменной за
пределы диапазона видимости.

**Dynamic Data Exchange (DDE)**

DDE - механизм, поддерживаемы для обеспечения совместимости со старыми
приложениями. Новые программы не должны использовать его для
взаимодействия, однако, если необходимо обеспечить управление старым
приложением, поддерживающим этот протокол - Delphi имеет в составе VCL
компоненты для создания как DDE клиентов (TDdeClientConv,
TDdeClientItem), так и серверов (TDdeServerConv, TDdeServerItem)

**File Mapping**

Отображение файла на память позволяет процессу рассматривать содержимое
файла как часть своего адресного пространства. Если несколько процессов
используют один и тот же объект отображения файла на память, то каждый
из них имеет участок своего адресного пространства, синхронизируемый с
аналогичным участком остальных процессов. Отображение файла на память
является очень эффективным способом совместного использования данных
разными процессами. Разумеется, если существует вероятность
одновременного изменения этих данных несколькими процессами, должна
использоваться синхронизация. Использование этого механизма уже было
подробно рассмотрено при создании перехватчика клавиатуры.

**Mailslots**

Почтовые слоты - способ однонаправленной коммуникации.
Приложение-сервер открывает слот, а клиенты могут писать в него. Слот
сохраняет сообщения до тех пор, как сервер не прочтет их. Разумеется,
одно приложение может быть одновременно сервером и клиентом, обеспечивая
двунаправленную связь. При этом приложения могут находиться даже на
разных компьютерах в сети.

Delphi не содержит компонентов для работы с почтовыми слотами, поэтому
программировать их необходимо используя WinAPI

**Pipes**

Каналы бывают именованные и неименованные.

Неименованные или анонимные каналы обычно используются для
перенаправления стандартных устройств ввода-вывода.

Именованный канал с известным именем обычно создается сервером, позволяя
клиентам связываться с ним. При этом клиенты могут находиться на других
компьютерах в сети. Именованный канал может быть создан только под
Windows NT. Компьютеры под Windows 9x могут подключаться к каналу, но не
могут создавать его сами.

**RPC**

RPC (Remote Procedure Call) - это API, позволяющий приложению удаленно
вызывать функции в других процессах как на своём, так и на удаленном
компьютере. Предоставляемая Win32 API модель RPC совместима со
спецификациями Distributed Computing Environment (DCE), разработанными
Open Software Foundation. Это позволяет приложениям Win32 удаленно
вызывать процедуры приложений, выполняющихся на других компьютерах под
другими операционными системами. RPC обеспечивают автоматическое
преобразование данных между различными аппаратными и программными
архитектурами.

**Windows Sockets**

Надстройка над коммуникационными протоколами, позволяющая писать
независимые от сетевого протокола приложения, обменивающиеся данными.
Спецификация WinSock 2 позволяет работать с сокетами как с обычными
файлами, используя те же функции ввода-вывода.

**WM\_COPYDATA**

Сообщение WM\_COPYDATA позволяет приложениям копировать данные между их
адресными пространствами. При этом приложения не обязательно должны быть
32-разрядными - для 16-разрядных приложений поддерживается
автоматическая трансляция указателей.

Для примера создадим два приложения. В одном из них добавим следующий
код:

    const
      CD_CMD_SETCAPTION = 1;
      // определяем команду для передачи данных
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      CDS: TCopyDataStruct;
    begin
      // задаем команду
      CDS.dwData := CD_CMD_SETCAPTION;
      // задаем длину передаваемых данных
      CDS.cbData := Length(Edit1.Text) + 1;
      // выделяем память под буфер для передачи данных
      GetMem(CDS.lpData, CDS.cbData);
      try
        // копируем данные в буфер
        StrPCopy(CDS.lpData, Edit1.Text);
        // посылаем сообщение в окно с заголовком «CopyData Reciever»
        SendMessage(FindWindow(NIL, 'CopyData Reciever'), 
          WM_COPYDATA, Handle, Integer(@CDS));
      finally
        // освобождаем буфер
        FreeMem(CDS.lpData, CDS.cbData);
      end;
    end;

В принимающем данные приложении создадим окно с заголовком «CopyData
Reciever» и добавим в форму следующий код:

    const
      CD_CMD_SETCAPTION = 1;
     
    type
      TForm1 = class(TForm)
      private
        // создаем обработчик WM_COPYDATA
        procedure WMCopyData(var M: TWMCopyData); message WM_COPYDATA;
      end;
     
    …
     
    procedure TForm1.WMCopyData(var M: TWMCopyData);
    begin
      // Если команда – установить заголовок
      if M.CopyDataStruct.dwData = CD_CMD_SETCAPTION then begin
        // Берем текст заголовка из данных
        Caption := PChar(M.CopyDataStruct.lpData);
        M.Result := 1;
      end else
        M.Result := 0;
    end;

При нажатии кнопки Button1 в первой форме заголовок второй станет равен
тексту компонента Edit1. Отмечу, что сообщение WM\_COPYDATA может быть
послано только при помощи функции SendMessage. Если приложение,
получающее данные, должно использовать их после возврата из обработчика
WM\_COPYDATA, оно должно скопировать данные в локальный буфер.

Тенцер А. Л.

ICQ UIN 15925834

tolik@katren.nsk.ru

---
Title: Crystal Reports 8.0 через API
Author: Андрей Зубарев
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Crystal Reports 8.0 через API
=============================

_Специально для Королевства Delphi_

**Вступление**

Crystal Reports (далее как CR) на сегодняшний день является лидирующим
пакетом для разработки отчетности в крупных компаниях. Для доступа к
отчетам компания Seagate предоставляет несколько вариантов:

- Элемент управления Crystal ActiveX
- Компонент Report Designer Component
- Компоненты VCL сторонних разработчиков.
- Automation Server

Вызовы API реализуются через Report Engine API (далее RE).

По моему мнению, лучшим является доступ посредством API функций, т.к.:

- вы полностью контролируете все, что происходит.
- узнаете, как все это работает.
- не зависите от фирмы разработчика компонент и их версий.
- не платите денег (хотя этот момент расплывчат J).

В 90% случаев необходимо только вывести отчет и передать входящие
параметры, т.е. вы получаете "тонкое" приложения на основе своих же
наработок, что согласитесь, греет душу программиста. Предполагается, что
читатель знаком с работой в Crystal Reports и понимает концепцию
разработки отчетов в данной среде.

> **Примечание Vit:**  
> 
> Позволю себе внести поправку, фирма Seagate имеет свой собственный VCL
> компонент для работы со всеми версиями Crystal Report начиная с 4й и
> заканчивая 9й. К сожалению разработка VCL компонента обычно
> задерживается на пол-года, а иногда и дольше со времени выхода
> очередного релиза. Мне доводилось не однократно самому переделывать
> компонент от старой версии для более новой и обычно это не очень сложная
> задача. Компонент можно взять с FTP Seagate.

**Необходимые файлы**

Библиотека [crpe32.dll] содержит интерфейс вызовов API функций.

Модуль [uCrystalApi.pas] с описаниями API функций. Он был подправлен
мной, так как было несколько синтаксических ошибок.

Для работы примера необходим источник данных, в качестве которого
используется демонстрационная БД MS Access 2000 [source\_db.mdb]. В
качестве драйвера связи используется OLE DB для MS Jet 4.0. БД должна
находиться в той же папке, где и пример отчета.

Если вы хотите распространять ваше приложение с отчетами, тогда
ознакомьтесь с содержимым файла [crpe32.dep], который содержит список
необходимых файлов для работы RE.

Пример реализован на Delphi 6.0.

**Программируем**

Первым надо "запустить машину" CR, посредством вызова функции
PEOpenEngine для инициализации механизма отчетов. Надо заметить, что
вызов данной функции справедлив только для одного потока.

Теперь можно и начать подготовку отчета для вывода. Вызов PEOpenPrintJob
дает нам дескриптор задачи (отчета), который необходимо передавать в
другие функции.

    // Синтаксис функции
    PEOpenPrintJob(PathToReport: PChar): SmallInt;
    {
    где PathToReport - путь к файлу отчета.

    Результат функции - дескриптор полученной задачи.

    Пример:
    FHandleJob := PEOpenPrintJob(PChar(edtPathReport.Text));
    }

Получив дескриптор, мы можем, манипулировать отчетом как нам будет
угодно. Получать информацию о параметрах, об источнике данных, управлять
разделами отчета и формулами.

Далее необходимо сказать системе, куда выводить отчет: в окно
предварительного просмотра (...ToWindow) или на принтер (...ToPrinter).

    // Синтаксис функций:
    PEOutputToWindow(printJob : Smallint; title: PChar;
                     left: Integer; top: Integer;
                     width: Integer; height: Integer;
                     style: DWord;
                     parentWindow : HWnd): Bool;

    PEOutputToPrinter(printJob: Word;
                      nCopies: Integer)): Bool;
    {
    где
        printJob - дескриптор задачи
        title - заголовок окна
        left, top, width, height - координаты окна
        style - стиль окна (типа WS\_VSCROLL, WS\_VISIBLE и т.д.)
        parentWindow - дескриптор окна в котором будет окно отчета.
        nCopies - количество копий.

    Пример:

       Result:= PEOutputToWindow(FHandleJob,
                                 PChar(TForm(Self).Caption),
                                 0, 0, 0, 0, 0, FWindow);
    }

Подготовив механизм вывода отправляем отчет для вывода функцией
PEStartPrintJob.

    // Синтаксис функции:
    function PEStartPrintJob(printJob: Word;
                             waitUntilDone: Bool): Bool;
    {
    где
        printJob - дескриптор задачи.
        WaitUntilDone - зарезервирован. Всегда должен быть True.

    Пример:
        PEStartPrintJob(FHandleJob, True);
    }

После отправки отчета, если не надо производить с ним операций,
закрываем задание функцией PEClosePrintJob.

    // Синтаксис функции:
    function PEClosePrintJob (printJob: Word): Bool;
    {
    где
        printJob - дескриптор задачи.

    Пример:
        PEClosePrintJob(FHandleJob);
    }

Между вызовами функций PEOpenPrintJob и PEClosePrintJob может стоять
сколько угодно вызовов функций PEOutputTo..., PEStartPrintJob.

В итоге получается схема вызовов:

    PEOpenEngine
         |
    PEOpenPrintJob
         |
    PEOutputToWindow
         |
    PEStartPrintJob
         |
    PEClosePrintJob
         |
    PECloseEngine

**Пример просмотра отчета**

Ниже приведен код процедуры для просмотра отчета из примера

    procedure TFrmMain.btnReportPreviewClick(Sender: TObject);
    var
      // Дескриптор окна в котором производится просмотр отчета
      FWindow: THandle;
      // Информация об источнике данных.
      // См. раздел "Получение параметров и свойств источника"
      lt: PELogOnInfo;
    begin
      // В зависимости от флага устанавливаем дескриптор окна.
      // При нуле, отчет будет показан в независимом внешнем окне.
      if chkWindow.Checked then
        FWindow := 0
      else
        FWindow := pnlPreview.Handle;
      // Открываем отчет и получаем дескриптор задачи.
      FHandleJob := PEOpenPrintJob(PChar(edtPathReport.Text));
      // Получение параметров источника данных отчета.
      FillChar(lt, SizeOf(PELogOnInfo), 0);
      lt.StructSize := SizeOf(PELogOnInfo);
      PEGetNthTableLogOnInfo(FHandleJob, 0, lt);
      // Устанавливаем новые параметры источника данных отчета.
      StrPCopy(@lt.ServerName, ExtractFilePath(edtPathReport.Text) +
        'source_db.mdb');
      PESetNthTableLogOnInfo(FHandleJob, 0, lt, False);
      // Настраиваем окно вывода.
      PEOutputToWindow(FHandleJob, PChar(TForm(Self).Caption), 0, 0, 0, 0, 0,
        FWindow);
      // Выводим отчет.
      PEStartPrintJob(FHandleJob, True);
      // Закрываем дескриптор задания.
      PEClosePrintJob(FHandleJob);
    end;

**Получение и установка свойств источника**

Теперь когда мы научились выводить отчет, расширим наши познания в
области манипуляций отчетом, такими как получение параметров отчета и
свойств источника данных.

Свойства источника данных можно получить или установить через функции
PEGetNthTableLogOnInfo и PESetNthTableLogOnInfo. Здесь надо отметить
довольно тонкий момент, связанный с обработкой данных в CR. Источником
данных может выступать любая СУБД как файловая, так и серверная,
текстовый файл и т.п. В свою очередь к примеру из серверной СУБД данные
можно получить через хранимую процедуру (stored procedure),
представление (view), таблицу (table) или через набор таблиц которые
обрабатываются уже внутри отчета. Поэтому используются различные API
функции зависящие от возможностей источника.

Обратите внимание на название в именах функций - сокращение Nth
обозначает, что функция вызывается для определенной таблицы.

Получение свойств через функцию довольно просто. Описываем структуру
данных, передаем дескриптор задачи и порядковый номер таблицы. После
вызова функции получаем заполненную структуру параметров.

    // Синтаксис функции:
    function PEGetNthTableLogOnInfo(
            printJob: Word;
            tableN: Integer;
            var logOnInfo: PELogOnInfo): Bool;
    {
    где
        printJob - дескриптор задачи.
        tableN   - номер таблицы.
        location - струкура со свойствами источника.

    Пример:
        PEGetNthTableLogOnInfo(FHandleJob, 0, lt);
    }

Структура PELogOnInfo содержит свойства источника. Перед ее передачей в
функцию обязательно заполните поле StructSize. Например:

    // Чистим структуру.
    FillChar(lt, SizeOf(PELogOnInfo), 0);

    // Заполняем поле размера.
    lt.StructSize := SizeOf(PELogOnInfo);

    // Вызываем функцию для таблицы с порядковым номером 0 (ноль)
    PEGetNthTableLogOnInfo(FHandleJob, 0, lt);

Описание структуры:

    type
    PELogonServerType = array[0..PE\_SERVERNAME\_LEN - 1] of Сhar;
    PELogonDBType = array[0..PE\_DATABASENAME\_LEN - 1] of Сhar;
    PELogonUserType = array[0..PE\_USERID\_LEN - 1] of Сhar;
    PELogonPassType = array[0..PE\_PASSWORD\_LEN - 1] of Сhar;
    PELogOnInfo = record
      StructSize: Word;
      ServerName: PELogonServerType;
      DatabaseName: PELogonDbType;
      UserId: PELogonUserType;
      Password: PELogonPassType;
    end;
    {
    где
       StructSize - размер структуры.Заполняется обязательно.
       ServerName - имя сервера или путь к файлу БД.
       DatabaseName - имя БД.
       UserId - пользователь.
       Password - пароль пользователя.
    }

Функция установки параметров PESetNthTableLogOnInfo аналогична
предыдущей (в смысле параметров, а действует наоборот - устанавливает
новые свойства источника). У данной функции есть один дополнительный
логический параметр propagateAcrossTables, который указывает как
обработать информацию из структуры PELogOnInfo. Если значение параметра
TRUE, тогда свойства из структуры применяются для всех таблиц в отчете,
иначе только для таблицы с с номером tableN. Например:

    // Скопировать в поле ServerName путь к БД отчета.
    StrPCopy(@lt.ServerName, ExtractFilePath(edtPathReport.Text) +
             'source_db.mdb');

    // Установить параметры для таблицы 0 и только для нее.
    PESetNthTableLogOnInfo(FHandleJob, 0, lt, False);

**Получение параметров отчета**

Теперь о том как получить параметры отчета с помощью которых
производится управление.

Используя PEGetNParameterFields вы получаете общее количество параметров
в отчете. Передавая в функцию PEGetNthParameterField порядковый номер
параметра получаем структуру с данными об имени, размере, значениях и
т.п. Функция PEConvertPFInfoToVInfo позволяет получить значение
параметра.

Функция PEGetNParameterFields имеет только один параметр - дескриптор
задачи, в результате возвращается количество параметров. В примере
показано как работать с параметрами:

    var
      ParameterInfo: PEParameterFieldInfo;
      ValueInfo: PEValueInfo;
    ...
     
    // Получить количество параметров.
    CountParams := PEGetNParameterFields(FHandleJob);
    if CountParams <> -1 then
    begin
      for i := 0 to CountParams - 1 do
      begin
        // Запросить информацию о параметре i.
        PEGetNthParameterField(FHandleJob, i, ParameterInfo);
        ValueInfo.ValueType := ParameterInfo.valueType;
        // Получить значение параметра.
        PEConvertPFInfoToVInfo(@ParameterInfo.DefaultValue,
          ValueInfo.ValueType,
          ValueInfo);
        ...
      end;
    end;

Описания структур довольно большие, поэтому я опишу только те поля,
которые используются в примере.

ParameterInfo.Name // - имя параметра.

ParameterInfo.ValueType // - тип данных параметра.

ParameterInfo.DefaultValue  // - значение по умолчанию.

Структура ValueInfo содержит в одном из своих полей значение параметра.
Вы можете посмотреть в примере функцию FormatCrystalValue, чтобы
разобраться с полями структуры.

**Заключение**

Дополнительные сведения о программировании с использованием API вы может
посмотреть в справочных файлах, которые идут с CR (PROGRAM
FILES\\SEAGATSOFTWARE\\CRYSTAL REPORTS\\DEVELOPER FILES\\HELP\\), файлы
DEVELOPR.HLP и RUNTIME.HLP. Если их у вас нет, то скачайте с FTP сервера
Seagate.

В будущем я надеюсь развить тему CR более углубленно, но это зависит от
интереса читателей и наличия времени :-).


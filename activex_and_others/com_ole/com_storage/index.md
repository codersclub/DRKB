---
Title: СОМ хранилища: подпольная файловая система
Date: 01.01.2007
Author: Михаил Продан
---


СОМ хранилища: подпольная файловая система
==========================================

::: {.date}
01.01.2007
:::

Перед многими программистами рано или поздно встает вопрос:
"В каком формате хранить данные своей программы".
Хорошо, если это тип данных с фиксированной длиной,
а если надо сохранить разнородные данные, да еще чтоб в одном файле
(чтоб потом не разбираться с десятком другим файлов с данными)...
Тут на помощь приходить сама Windows (жуть какую сказал: "Windows... и на помощь")
с технологией структурированного хранилища данных.

## Определения

Структурированные хранилища данных - это файлы особой "самодокументированной" структуры,
в которых могут мирно уживаться разнородные данные
(от простого текста, до фильмов, архивов и... программ).
Так как эта технология есть неотъемлемой частью Windows,
то доступ к ней возможен из любого средства программирования,
которое поддерживает технологию `COM`.
Одним из таких приложений является и Delphi,
на основе которого будет описана технология доступа к структурированным хранилищам данных.

### Структура хранилищ

Как уже было сказано, COM хранилища - файлы особой структуры (рис.1)
и напоминают иерархическую файловую систему.
Так в них есть корневое хранилище (`Root Entry`),
в котором могут содержаться как отдельные потоки ("файлы"),
так и хранилища второго уровня ("каталоги"), в них в свою очередь хранилища третьего уровня и т.д.
Управление каждым хранилищем и потоком осуществляется посредством отдельного экземпляра интерфейса:
`IStorage` - для хранилищ и `IStream` - для потоков.

А теперь рассмотрим конкретнее некоторые операции над ними.

### Создание и открытие хранилищ

Создание структурированных хранилищ осуществляется с использованием
функции `StgCreateDocFile`, из модуля `ActiveX.pas`.
Синтаксис этой функции выглядит таким образом:

    function StgCreateDocfile(pwcsName: POleStr; grfMode: Longint; reserved: Longint; out stgOpen: IStorage): HResult; stdcall;

где  
`pwcsName` - название хранилища (т.е. название файла).  
`grfMode` - флаги доступа (комбинация значений STGM_*).  
`reserved` - он и в Африке RESERVED.  
`StgOpen` - ссылка на интерфейс IStorage нашего главного хранилища.

Результат функции как всегда транслируем в исключения Delphi посредством `OleCheck`.

Для открытия хранилища используется функция `StgOpenStorage`:

    function StgOpenStorage(pwcsName: POleStr; stgPriority: IStorage;
                            grfMode: Longint; snbExclude: TSNB;
                            reserved: Longint; out stgOpen: IStorage): HResult; stdcall;

неизвестный параметр - `stgPriority` указывает на ранее открытый экземпляр
главного хранилища (почти всегда `nil`).

Когда хранилище открыто (запись данных)...

Рассмотрим более подробно методы интерфейса `IStorage`.

### Создание потока - `IStorage.CreateStream`.

    function CreateStream(pwcsName: POleStr; grfMode: Longint;
                          reserved1: Longint; reserved2: Longint;
                          out stm: IStream): HResult; stdcall;

параметры:  
`pwcsName` - название потока.  
`grfMode` - Флаги доступа  
`reserved1, reserved2` - соответственно.  
`stm` - указатель на созданный поток.

### Открытие потока - IStorage.OpenStream.

    function OpenStream(pwcsName: POleStr; reserved1: Pointer; grfMode: Longint;
                        reserved2: Longint; out stm: IStream): HResult; stdcall;

параметры:  
`pwcsName` - название потока.  
`reserved1` - nil  
`grfMode` - флаги доступа  
`reserved2` - 0  
`stm` - указатель на открытый поток.

### Создание подхранилища - IStorage.CreateStorage.

    function CreateStorage(pwcsName: POleStr; grfMode: Longint; dwStgFmt: Longint;
                           reserved2: Longint; out stg: IStorage): HResult;stdcall;

### Открытие подхранилища - IStorage.OpenStorage.

    function OpenStorage(pwcsName: POleStr; const stgPriority: IStorage;
                         grfMode: Longint; snbExclude: TSNB; reserved: Longint;
                         out stg: IStorage): HResult; stdcall;

Теперь мы можем приступить к чтению (записи) данных из (в) потоков
посредством интерфейсов `IStream`. Тут можно заметить до боли знакомые
(для Дельфийцев) методы работы с потоками: `Read, Write, Seek, SetSize,
CopyTo...` а если так, то почему бы не перевести их в более простую и
понятную (по крайней мере для меня) объектную форму. Для этого
воспользуемся наработками Borland собранными в модуле `AxCtrls.pas`,
точнее классом `TOleStream`, который интерпретирует вызовы методов
интерфейса `IStream` в соответствущие методы класса `TStream`.

А для того чтоб не быть пустословным - приведу небольшой примерчик:

    Implementation
     Uses ActiveX,AxCtrls,ComObj;
    {$R *.dfm}
    procedure TForm1.Button1Click(Sender: TObject);
    var Stg:IStorage;
        Strm:IStream;
        OS:TOleStream;
        S:String;
    begin
     OleCheck(StgCreateDocfile('Testing.stg',STGM_READWRITE or STGM_SHARE_EXCLUSIVE ,0,Stg));
     OleCheck(Stg.CreateStream('Testing',STGM_READWRITE or STGM_SHARE_EXCLUSIVE,0,0,Strm));
     OS:=TOleStream.Create(Strm);
     try
      S:='This is the test';
      OS.WriteBuffer(Pointer(S)^,Length(S));
     finally
      OS.free;
      Strm:=nil;
      Stg:=nil;
     end;
    end;
     
    end.
 

В этом фрагменте мы создаем новое хранилище с одним потоком в который
записываем строку `S`. Естественно, ничто нам не мешает вместо:

    S:='This is the test';

    OS.WriteBuffer(Pointer(S)\^,Length(S));

Написать например:

    Image1.Picture.Bitmap.SaveToStream(OS);

и тем самым записать в поток "Testing" изображение
(вот она... "универсальная мусоросвалка").

Теперь ненамного отвлечемся от Delphi и посмотрим на наш файл с точки
зрения, скажем, Far (или VC)...
Посмотрели? А теперь откройте там же любой текстовый документ созданных в Word'е.
Как видим структура та же что и в нашем файле.
То же можно сказать и о Excel. Но как проверить, не прибегая к помощи notepad,
какой файл является хранилищем, а какой нет?
Для этого все в том же модуле ActiveX.pas предусмотрена функция
`StgIsStorageFile`:

    function StgIsStorageFile(pwcsName: POleStr): HResult; stdcall;

которая принимает значение `S_OK` ( 0 ), если файл является структурированным хранилищем данных
и `S_FALSE` ( 1 ) - если файл не является хранилищем.
Кроме того эта функция может принимать значения:
`STG_E_INVALIDFILENAME` и `STG_E_FILENOTFOUND` соответственно,
если имя файла задано неправильно и если файла с таким именем не существует.

### Чтение

Чтение данных из хранилища производится также как и чтение из
стандартного потока Delphi. Все, что для этого требуется - это создать
объект наследник `TOleStream` с использованием возвращаемого функцией
`IStorage.OpenStorage` значения `stm`:

    procedure TForm1.Button2Click(Sender: TObject);
    var Stg:IStorage;
        Strm:IStream;
        OS:TOleStream;
        S:String;
    begin
     OleCheck(StgOpenStorage('Testing.stg',nil,STGM_READWRITE or STGM_SHARE_EXCLUSIVE, nil,0,Stg));
     OleCheck(Stg.OpenStream('Testing',0,STGM_READWRITE or STGM_SHARE_EXCLUSIVE,0,Strm));
     OS:=TOleStream.Create(Strm);
     try
      SetLength(S,OS.Size);
      OS.ReadBuffer(Pointer(S)^,OS.Size);
      Edit1.Text:=S;
     finally
      OS.free;
      Strm:=nil;
      Stg:=nil;
     end;
    end;

 

после выполнения этого кода мы в `Edit1` увидим ранее записанное нами:  
"This is the test".

### Последовательное перемещение по структурам хранилища

Хорошо... мы создали хранилище, записали в него данные и прочитали их.
Но мы это сделали зная имя потока в котором записаны наши данные.
Но как быть, если мы не знаем структуры хранилища?
Для этого в Интерфейсе `IStorage` предусмотрен механизм перечисления его элементов,
который содержится в интерфейсе `IEnumStatStg`,
указатель на который возвращается функцией `IStorage.EnumElements`:

    function EnumElements(reserved1: Longint; reserved2: Pointer; reserved3: Longint;
                          out enm: IEnumStatStg): HResult; stdcall;

употребление этой функции происходит таким образом:

    OleCheck(Stg.EnumElements(0,nil,0,Enum));

После этого используем только методы интерфейса `IEnumStatStg:`

Выборка информации следующего елемента хранилища:

    Next(celt:Longint; out elt; pceltFetched: PLongint): HResult; stdcall;

Пропуск количества елементов заданных в celt:

    Skip(celt:longint):HResult;stdcall;

Reset - он и в Африке Reset:

    Reset:HResult;stdcall;

Клонирование интерфейса

    Clone(out enm:IEnumStatStg):HResult;stdcall;

На данный момент для нас самым важным из этих методов есть метод Next:

    Next(celt:Longint; out elt; pceltFetched: PLongint): HResult; stdcall;

Который принимает следующие параметры:  
`Celt` - количество елементов структуры, которое будет извлечено при его вызове.  
`Elt` - Масив приемник елементов типа TStatStg.  
`PceltFetched` - указатель на переменную куда будет записано действительное количество
извлеченных елементов.

Для примера воспользуемся любым doc файлом и перечислим его потоки
(и подхранилища если они есть):

    procedure TForm1.Button2Click(Sender: TObject);
    var Stg:IStorage;
        Enum:IEnumStatStg;
        Data:TStatStg;
    begin
     OleCheck(StgOpenStorage('D:\1.doc',nil,STGM_READWRITE or STGM_SHARE_EXCLUSIVE,nil,0,Stg));
     OleCheck(Stg.EnumElements(0,nil,0,Enum));
     try
      While Enum.Next(1,Data,nil)=S_Ok do
       ListBox1.Items.Add(Format('%s(%d)',[Data.pwcsName,Data.cbSize]));
     finally
      Stg:=nil;
      Enum:=nil;
     end;
    end;

 

кроме `cbSize` структура `TStatStg` содержит такие поля:

`pwcsName: POleStr;` - Название потока или хранилища  
`dwType: Longint;` - Тип елемента (флаги типа `STGTY_*`)  
`cbSize: Largeint;` - Размер конкретного елемента  
`mtime: TFileTime;` - Дата последней модификации  
`ctime: TFileTime;` - Дата создания  
`atime: TFileTime;` - Дата последнего обращения  
`grfMode: Longint;` - Флаг доступа  
`grfLocksSupported: Longint;` - Не используется в хранилищах  
`clsid: TCLSID;` - Идентификатор класса хранилища  
`grfStateBits: Longint;` - Статусные биты  
`reserved: Longint;` - Зарезервирован

### Создание дополнительных хранилищ

Для создания дополнительных хранилищ главного хранилища используется
метод интерфейса IStorage под названием `CreateStorage`:

    function CreateStorage(pwcsName: POleStr; grfMode: Longint; dwStgFmt: Longint;
                           reserved2: Longint; out stg: IStorage): HResult;stdcall;

параметры:

`pwcsName` - название подхранилища.  
`grfMode` - флаги доступа  
`dwStgFmt,reserved2` - зарезервированы (принимают значение 0).  
`stg` - указатель на интерфейс содержащий ссылку на подхранилище.

После вызова этого метода посредством переменной `stg` вам станут доступны
методы по использованию подхранилища:

    procedure TForm1.Button2Click(Sender: TObject);
    var Stg,Temp:IStorage;
        Str:IStream;
        OS:TOleStream;
        S:String;
    begin
     OleCheck(StgOpenStorage('Testing.stg',nil,STGM_READWRITE or STGM_SHARE_EXCLUSIVE,nil,0,Stg));
     OleCheck(Stg.CreateStorage('SubStorage',STGM_READWRITE or STGM_SHARE_EXCLUSIVE,0,0,Temp));
     OleCheck(Temp.CreateStream('SubTesting',STGM_READWRITE or STGM_SHARE_EXCLUSIVE,0,0,Str));
     try
      OS:=TOleStream.Create(Str);
      S:='SubTesting the stream';
      OS.WriteBuffer(Pointer(S)^,Length(S));
     finally
      Temp:=nil;
      Stg:=nil;
     end;
    end;

 

после проделанной операции в файле 'Testing.stg' появится новое
подхранилище `SubStorage` c одним потоком `SubTesting`,
в котором записана строка `"SubTesting the stream"`.

Чтение из такого подхранилища может быть реализовано следующим образом:

    procedure TForm1.Button2Click(Sender: TObject);
    var Stg,Temp:IStorage;
        Str:IStream;
        OS:TOleStream;
        S:String;
    begin
     OleCheck(StgOpenStorage('Testing.stg',nil,STGM_READWRITE or STGM_SHARE_EXCLUSIVE,nil,0,Stg));
     OleCheck(Stg.OpenStorage('SubStorage',nil,STGM_READWRITE or STGM_SHARE_EXCLUSIVE,nil,0,Temp));
     OleCheck(Temp.OpenStream('SubTesting',nil,STGM_READWRITE or STGM_SHARE_EXCLUSIVE,0,Str));
     try
      OS:=TOleStream.Create(Str);
      SetLength(S,OS.Size);
      OS.ReadBuffer(Pointer(S)^,OS.Size);
      Edit1.Text:=S;
     finally
      Temp:=nil;
      Stg:=nil;
     end;
    end;

 

### Дополнительные возможности

К дополнительным возможностям можно отнести наличие таких методов в
интерфейсе `IStorage`:

* Копирование содержимого хранилища в другое хранилище:

        function CopyTo(ciidExclude: Longint; rgiidExclude: PIID; snbExclude: TSNB;
                        const stgDest: IStorage): HResult; stdcall;

* Перемещение хранилища в другое хранилище:

        function MoveElementTo(pwcsName: POleStr; const stgDest: IStorage;
                               pwcsNewName: POleStr; grfFlags: Longint): HResult; stdcall;

* Подтверждение изменетий внесенных в хранилище. Используется совместно с
флагом STGM_TRANSACTED при открытии или создании хранилища:

        function Commit(grfCommitFlags: Longint): HResult; stdcall;

* Отмена изменений вносимых в хранилище. Используется совместно с флагом
STGM_TRANSACTED при открытии или создании хранилища:

        function Revert: HResult; stdcall;

* Удаление элемента из хранилища:

        function DestroyElement(pwcsName: POleStr): HResult; stdcall;

* Переименование элемента хранилища:

        function RenameElement(pwcsOldName: POleStr; pwcsNewName: POleStr): HResult; stdcall;

* Обновление информации о дате создания, модификации и последнего обращения к элементу хранилища.

        function SetElementTimes(pwcsName: POleStr; const ctime: TFileTime;
                                 const atime: TFileTime; const mtime: TFileTime): HResult; stdcall;

### Сжатие хранилищ

Как и файловая система, ее аналог - структурированные хранилища данных
подвержены фрагментации. Они неспособны "экономично" заполнять
освободившееся пространство от удаленных элементов. А самое главное, что
в них не предусмотрен механизм автоматического сжатия данных и
освобождения незанятых ресурсов диска. Но на каждый фрагмент есть свой
"дефрагмент". Так сжать хранилище можно воспользовавшись методом
интерфейса IStorage под названием CopyTo:

    function CopyTo(ciidExclude: Longint; rgiidExclude: PIID; snbExclude: TSNB;
                    const stgDest: IStorage): HResult; stdcall;

при этом все нужные данные переписываются в новое хранилище, а ненужные
(т.е. уже удаленные) исчезают навеки.  
Примером для такого сжатия может служить код:

    procedure TForm1.Button2Click(Sender: TObject);
    var Stg,Temp:IStorage;
        Enum:IEnumStatStg;
        Data:TStatStg;
    begin
     OleCheck(StgOpenStorage('D:\1.doc',nil,STGM_READ or STGM_SHARE_EXCLUSIVE,nil,0,Stg));
     OleCheck(StgCreateDocFile('D:\1c.doc',STGM_READWRITE or STGM_SHARE_EXCLUSIVE,0,Temp));
     try
     Stg.CopyTo(0,nil,nil,Temp);
     finally
      Temp:=nil;
      Stg:=nil;
     end;
    end;

 

конечно такой метод эффективен если данные обрабатываются
непосредственно в хранилище, а не действует принцип:
"Все прочитал... удалил... изменил... написал наново".

### Флаги доступа к хранилищам и потокам

`STGM_DIRECT` - Каждое изменение содержания сразу же записывается в файл

`STGM_TRANSACTED` - Изменения записываются в буфер, а потом по команде Commit в файл.
Команда Revert отменяет изменения

`STGM_SIMPLE` - Упрощенный вариант хранения данных:

* Нет поддержки подхранилищ
* Нельзя повторно открыть поток для записи
* Все потоки имеют длину не меньше 4096
* Поддерживается ограниченное количество методов интерфейсов IStorage и IStream.

`STGM_READ` - Открытие только для чтения

`STGM_WRITE` - То же для записи

`STGM_READWRITE` - Чтение и запись

`STGM_SHARE_DENY_READ` - Запрет параллельного чтения

`STGM_SHARE_DENY_WRITE` - Запрет параллельной записи

`STGM_SHARE_EXCLUSIVE` - Полный запрет на параллельное использование файла

`STGM_PRIORITY` - Блокирует возможность параллельного внесения изменений в файл по команде
`Commit`

`STGM_DELETEONRELEASE` - Файл автоматически стирается при освобождении интерфейса. Используется
для временных файлов

`STGM_CREATE` - Стирает существующий файл с тем же именем

`STGM_CONVERT` - Создает новый файл в поток CONTENTS которого заносит данные из
существующего файла с тем же именем , если такой существует

`STGM_FAILSAFE` - Если существует файл с таким же именем - возвращает значение
`STG_E_FILEALREADYEXISTS`

`STGM_NOSCRATCH` - При установленном флаге `STGM_TRANSACTED` вместо внешнего буфера
используется незадействованное пространство в самом файле. Более
эффективное использование ресурсов компьютера

::: {.author}
Автор: Михаил Продан
:::

Взято с <https://tdelphi.spb.ru>

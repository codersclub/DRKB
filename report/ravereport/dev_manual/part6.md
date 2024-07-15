---
Title: Настройка подключений данных
Date: 01.01.2007
---


Настройка подключений данных
============================

**Использование событий для настройки ваших подключений данных**

Вы можете управлять, как данные будут поступать в ваш отчет через
события компонент подключения данных.

Для данных, поступающих не из баз,
используйте компонент TrvCustomConnection, Вы можете предоставить доступ
к вашим данным через его события.

Для подключения данных из баз,
используйте компоненты, такие как TRvDataSetConnection, достаточно будет
переписать событие OnValidateRow. События подключений данных следующие:

Событие       | Описание
--------------|--------------------------------
OnEOF         | Вызывается, когда Rave желает определить, достигнут ли конец данных. При отсутствии данных требуется вернуть значение TRUE, если больше нет строк или если вызов события OnNext был сделан за пределы последней строки.
OnFirst       | Вызывается, когда Rave желает, что бы курсор был перемещен на первую строку данных. С развитой системой буферизации Rave, это событие обычно возникает только раз в начале сессии данных.
OnGetCols     | Вызывается, когда Rave желает получить мета данные. Это включает в себя имена полей, типы, размеры символов, полные имена и описание. Подробности смотри ниже.
OnGetRow      | Вызывается, когда Rave желает получить данные для текущей строки. Подробности смотри ниже.
OnGetSorts    | Вызывается, когда Rave желает получить доступные методы сортировки.
OnNext        | Вызывается, когда Rave желает переместить курсор на следующую строку.
OnOpen        | Вызывается, когда Rave желает инициализировать начало сессии. Должно быть сохранено текущее состояние, что бы потом его можно было восстановить в событии OnRestore.
OnRestore     | Вызывается, когда Rave желает восстановить состояние предыдущей сессии, которое было перед ее открытием.
OnSetFilter   | Вызывается, когда Rave желает фильтровать данные, такие как Master-Detail отчеты.
OnSetSort     | Вызывается, когда Rave желает сортировать данные. Подробности смотри ниже.
OnValidateRow | Вызывается для каждой строки, позволяя тем сам управлять фильтрацией данных. Для пользовательских приложений, данное событие обычно не нужно, поскольку фильтрация данных через событие OnNext более эффективно. Тем не менее, данное событие очень полезно для других, более автоматизированных подключений, таких как TRvDataSetConnection. Подробности смотри ниже.

**Примечание:**

Компонент TRvCustomConnection имеет свойства DataIndex и DataRows типа
integer. Они предназначены для использования в событиях пользовательских
подключений и если используются, то могут быть определены в OnFirst,
OnNext и OnEOF событиях.

DataIndex используется как позиция курсора,
первая строка имеет номер 0.

DataRows используется как счетчик строк
данных. Например, если вы определяете пользовательское подключение к
массиву данных, вам будет достаточно установить свойство
Connection.DataRows равным количеству элементов в массиве и затем
позволить Rave управлять OnFirst, OnNext и OnEOF событиями.

В событии OnGetRow Вы должны обратиться к свойству Connection.DataIndex для
определения какой элемент массива требуется вернуть назад (не забывайте,
что нумерация идет с 0).

**Событие OnGetCols**

Событие OnGetCols вызывается, когда Rave желает получить мета данные.
Внутри этого события Вы захотите вызвать метод  Connection.WriteField
для каждого поля (колонки) ваших данных. Определение WriteField
следующее:

    procedure WriteField(Name: string;DataType: TRpDataType;Width: integer;
      FullName: string;Description: string);

Name это короткое имя поля и должно состоять только из
алфавитно-цифровых символов.

DataType это тип данных поля и должен быть
одним из следующих типов: dtString, dtInteger, dtBoolean, dtFloat,
dtCurrency, dtBCD, dtDate, dtTime, dtDateTime, dtBlob, dtMemo или
dtGraphic.

Width это относительная ширина поля в символах.

FullName это
полное, более описательное имя поля и может включать в себя пробелы и
другие не  алфавитно-цифровые символы. Если FullName пустое, то будет
использовано короткое имя поля.

Description это полное описание поля и
обычно редактируется с помощью компонента, поэтому может состоять из
нескольких строк. Используйте свойство Description для описания, как
используется поле или для любой другой более, нужной информации насчет
данного поля.

Пример:

    procedure TDataForm.CustomCXNGetCols(Connection: TRvCustomConnection);
    begin
      With Connection do begin
      WriteField('Index',dtInteger,8,'Index Field','Описание 1');
      WriteField('Name',dtString,30,'Name Field','Описание 2');
      WriteField('Amount',dtFloat,20,'Amount Field','Описание 3');
      end; { with }
    end;

**Событие OnOpen**

Событие OnOpen возбуждается при инициализации сессии данных. В этом
событии Вы можете открыть файлы данных, инициализировать переменные и
сохранить текущее состояние данных для события OnRestore, которое будет
возбуждено при закрытии сессии данных.

Пример:

    procedure TDataForm.CustomCXNOpen(Connection: TRvCustomConnection);
    begin
      AssignFile(DataFile,'DATAFILE.DAT');
      Reset(DataFile,1);
    end;


**Событие OnFirst**

Событие OnFirst вызывается, когда требуется перемещение курсора данных
на первую строку данных.

Пример:

    procedure TDataForm.CustomCXNFirst(Connection: TRvCustomConnection);
    begin
      Seek(DataFile,0);
      BlockRead(DataFile,DataRecord,SizeOf(DataRecord),DataRead);
    end;


**Событие OnNext**

Событие OnNext вызывается, когда требуется перемещение курсора данных на
следующую строку данных.

Пример:

    procedure TDataForm.CustomCXNNext(Connection: TRvCustomConnection);
    begin
      BlockRead(DataFile,DataRecord,SizeOf(DataRecord),DataRead);
    end;


**Событие OnEOF**

Событие OnEOF вызывается для возврата состояния курсора данных,
находится ли он на данных или уже вышел за конец.

Значение TRUE должно
быть возвращено, если данных больше нет или если вызов события OnNext
привел к выходу из последней строки.

Пример:

    procedure TMainForm.CustomCXNEOF(Connection: TRvCustomConnection;var EOF: Boolean);
    begin
      EOF := DataRead < SizeOf(DataRecord);
    end;


**Событие OnGetRow**

Событие OnGetRow вызывается для получения данных для текущей строки.
Имеется несколько методов для записи данных в специальные буферы
используемые Rave. Порядок и типы записываемых полей должен быть точно
таким же, как полученные определения полей в событии OnGetCols.

В следующем списке приведены методы объекта Connection для записи данных
в буфера.

    procedure WriteStrData(FormatData: string; NativeData: string); 
    {dtString}

    procedure WriteIntData(FormatData: string; NativeData: integer);
    {dtInteger}

    procedure WriteBoolData(FormatData: string; NativeData: boolean);
    {dtBoolean}

    procedure WriteFloatData(FormatData: string; NativeData: extended);
    {dtFloat}

    procedure WriteCurrData(FormatData: string; NativeData: currency);
    {dtCurrency}

    procedure WriteBCDData(FormatData: string; NativeData: currency);
    {dtBCD}

    procedure WriteDateTimeData(FormatData: string; NativeData: TDateTime);
    {dtDate, dtTime and dtDateTime}

    procedure WriteBlobData(var Buffer; Len: longint);
    {dtBlob, dtMemo and dtGraphic}

Также имеется специальный метод, названный WriteNullData (без
параметров), который может быть использован для некоторых полей, для
указания неинициализированных данных (null).

Параметр FormatData
используется для передачи строки форматирования данных для данного поля.

Параметр NativeData предназначен для передачи неформатированных или
чистых данных поля. Если строка форматирования определена в отчете Rave,
то она используется для форматирования, иначе используется FormatData.

Пример:

    procedure TDataForm.CustomCXNGetRow(Connection: TRvCustomConnection);
    begin
      With Connection do begin
      WriteIntData('',DataRecord.IntField);
      WriteStrData('',DataRecord.StrField);
      WriteFloatData('',DataRecord.FloatField);
      end; { with }
    end;


**Событие OnValidateRow**

Событие OnValidateRow возникает для каждой строки данных, позволяя
управлять включением строки данных в отчет или нет. Обычно это
единственное событие, которое  определяется для не пользовательских
подключений.

Пример:

    procedure TDataForm.CustomCXNValidateRow(Connection: TRvCustomConnection;
    var ValidRow: Boolean);
    begin
      ValidRow := DataRecord.FloatField >= 0.0;
    end;

**Событие OnRestore**

Событие OnRestore для прекращения текущей сессии и восстановления
предыдущего состояния. В этом событие Вы можете закрыть файлы данных,
освободить ресурсы и восстановить предыдущее состояние, которое было
перед событием OnOpen.

Пример:

    procedure TDataForm.CustomCXNRestore(Connection: TRvCustomConnection);
    begin
      CloseFile(DataFile);
    end;

---
Title: Создание таблицы по образу и подобию
Date: 01.01.2007
---


Создание таблицы по образу и подобию
====================================

Вариант 1.

Создайте во время выполнения программы пустую таблицу, скопируйте
структуру существующей, включая первичный индекс. На практике это
выглядит примерно так:

    var
      Table2  : TTable;
    begin
      Table1.FieldDefs.Update;
      Table1.IndexDefs.Update;
      Table2 := TTable.Create(nil);
      Table2.DatabaseName := Table1.DatabaseName;
      Table2.TableName := 'MyTable';
      Table2.TableType := Table1.TableType;
      Table2.FieldDefs.Assign(Table1.FieldDefs);
      Table2.IndexDefs.Assign(Table1.IndexDefs);
      Table2.CreateTable ;
    end;

------------------------------------------------------------------------

Вариант 2.

На ум сразу приходит операция присваивания значения свойству (стоящему с
левой стороны от \':=\'), при которой Delphi в своих недрах вызывает
метод \'write\' и передает ему в виде единственного параметра все то,
что находится в правой части выражения. Если свойство не имеет метода
write, оно предназначено только для чтения. Вот определение свойства
FieldDefs объекта TDataSet в файле DB.PAS:

    property FieldDefs: TFieldDefs read FFieldDefs write SetFieldDefs;

Как вы можете видеть, у него есть метод write. Следовательно, код:

    Destination.FieldDefs := Source.FieldDefs;

в действительности делает такую операцию:

    Destination.SetFieldDefs(Source.FieldDefs);

(за исключением того, что вы не можете использовать эту строку,
поскольку SetFieldDefs определен в секции Private.)

Вот определение свойства IndexDefs объекта TTable в файле DBTABLES.PAS
file:

    property IndexDefs: TIndexDefs read FIndexDefs;

В этом случае метод write отсутствует, поэтому свойство имеет атрибут
только для чтения. Тем не менее, для самого объекта TIndexDefs
существует метод Assign. Следовательно, следующий код должен работать:

    Source.IndexDefs.Update;
    Destination.IndexDefs.Assign(Source.IndexDefs);

Перед вызовом Assign для Source.IndexDefs вызывайте метод Update, чтобы
быть уверенным в том, что вы получите то, что хотите.

Метод SetFieldDefs является процедурой с одной строкой кода, в которой
вызывается метод FieldDefs Assign.

Также можно проверить, определен ли реально индекс, и, если нет, то при
вызове IndexDefs.Assign вы можете получить исключение типа "List Index
Out Of Bounds" (или что-то типа этого). Например, так:

    if Source.IndexDefs.Count > 0 then...

Вам нужно будет это сделать, поскольку метод TIndexDefs.Assign не
проверяет это перед копированием индекс-информации. Также вам нет
необходимости вызывать Clear до работы с IndexDefs, поскольку метод
Assign сделает это и без вашего участия.

Source: <https://delphiworld.narod.ru>

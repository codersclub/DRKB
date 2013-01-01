---
Title: Особенности использования BLOB-полей в dbExpress на примере MySQL
Author: Андрей Пащенко
Date: 01.01.2007
---


Особенности использования BLOB-полей в dbExpress на примере MySQL
=================================================================

::: {.date}
01.01.2007
:::

Использовать новые компоненты dbExpress удобно. Однако прилагательное
«новые» приносит не только радость... Решение возникающих проблем бывает
затягивается на долгие часы и дни. На помощь Internet увы надеяться не
приходится, т.к. информации по dbExpress там ни так много. Одна из этих
проблем -- работа с BLOB полями. Использовать нативный SQL для работы с
BLOB не всегда возможно, поэтому нужно применять другие, альтернативные
способы.

Для работы с BLOB полями в Delphi имеется несколько классов:

  --- --------------
  ·   TBlobStream;
  --- --------------

  --- --------------------
  ·   TClientBlobStream;
  --- --------------------

  --- -------------
  ·   TBlobField;
  --- -------------

  --- ----------------
  ·   TGraphicField;
  --- ----------------

  --- -------------
  ·   TMemoField;
  --- -------------

Также сюда можно отнести функцию TCustomClientDataSet.CreateBlobStream,
но она реализована посредством класса TClientBlobStream. Классы
TGraphicField и TMemoField являются производными от TBlobField.
TBlobStream не подходит для работы с dbExpress, а применяется только при
манипулировании данным через BDE.

Таким образом для работы с BLOB-полями через dbExpress остаются два
ключевых класса: TBlobField и TClientBlobStream. Следовательно возможно
два, принципиально различных, варианта доступа к BLOB-полям: через
потоки и через свойства объекта. Как указано в справочной системе при
работе с BLOB-полями вообще и dbExpress в частности достаточно удобными
оказываются переменные типа String.

Действительно, максимальный размер данных хранимых в переменных данного
типа составляет 2 Гб, что равняется максимальному размеру BLOB-поля в
MySQL (3.23.47). Строки достаточно удобны для работы с потоками, а также
существует достаточно много функций для работы с ними. Проблем при
работе с BLOB-полями также существует две: чтение данных и их запись.
Рассмотрим каждый из возможных вариантов.

Проблема №1. Чтение данных из BLOB-поля

Для работы с BLOB-полями необходимо присвоить свойству
TCustomClientDataSet.FetchOnDemand значение True, а также необходимо
внимательно изучить свойство Options параметр poFetchBlobsOnDemand.
Данные настройки нужны для того, чтобы получать данные из BLOB-поля в
клиентское приложение. Загрузить данные можно используя метод
FetchBlobs.

Использование потоков

    {описание типов переменных}
    qrProba: TSQLClientDataSet; {поле BLOBF – является BLOB-полем}
    Image: TImage;
    Stream: TStream;
    Memo: TMemo;
    {--------------------------------------}
    begin
      {делаем нужную запись активной, например, методом Locate.}
      Stream := qrProba.CreateBlobStream(qrProba.FieldByName('BlobF'), bmRead);
      try
        Image.Picture.Bitmap.LoadFromStream(Stream); {если это картинка}
        {Memo.Lines.LoadFromStream(Stream); - если это текст}
      finally
        Stream.Free;
      end;
    end;

Использование свойства TDataSet.FieldValues

    {описание типов переменных}
    qrProba: TSQLClientDataSet; {поле BLOBF – является BLOB-полем}
    Image: TImage;
    Stream: TStream;
    Memo: TMemo;
    {----------------------------------}
    begin
      {делаем нужную запись активной, например, методом Locate.}
      Memo.Lines.Text := qrProba['BLOBF'];
    end;

Использование свойства TBlobField.Value

    {описание типов переменных}
    Memo: TMemo;
    BLOBField: TBlobField;
    {----------------------------------}
    begin
      {делаем нужную запись активной, например, методом Locate.}
      Memo.Lines.Text := BlobField.Value; { можно так}
      Memo.Lines.Text := BlobField.AsString; { а можно и так}
      Memo.Lines.Text := BlobField.AsVariant;   { это третий способ}
    end;

Проблема №2. Запись данных в BLOB-поле.

При записи данных в BLOB-поле необходимо учитывать, что для внесения
изменений одного метода Post недостаточно. Для пересылки данных в
таблицу после метода Post необходимо вызывать метод
TCustomClientDataSet.ApplyUpdates. Вместе с данным методом полезно
использовать свойство TCustomClientDataSet.ChangeCount, которое содержит
количество изменений внесенных пользователем. В справочной системе
Delphi содержится пример как совместно использовать это свойство и метод
ApplyUpdates.

Использование потоков

Перед созданием потока необходимо обязательно вызывать метод FetchBlobs
для загрузки данных из BLOB-поля, иначе возникает ошибка. При работе с
полем используя поток, необходимо следовать правилу:

Одна запись -- один поток.

Если необходимо обработать новую запись, то поток необходимо создавать
заново. Естественно нужно не забывать своевременно уничтожать созданные
потоки.

    { описание типов переменных}
    qrProba: TSQLClientDataSet; {поле BLOBF – является BLOB-полем}
    Image: TImage;
    Stream: TClientBlobStream;
    Memo: TMemo;
    {--------------------------------------}
    begin
      {делаем нужную запись активной, например, методом Locate.}
      qrProba.Edit;
      qrProba.FetchBlobs;
      Stream := TClientBlobStream.Create(TBlobField(qrProba.FieldByName('BlobF')),
        bmReadWrite);
      Stream.Position := 0;
      Stream.Clear;
      Image.Picture.Bitmap.SaveToStream(Stream);
      qrProba.Post;
      qrProba.ApplyUpdates(0);
      Stream.Free;
    end;

По непонятным причинам данный код не работает. Точнее данные в Stream
передаются, но в базу не записываются. При этом никаких ошибок не
выдается (может это bug, а может что-то в данном коде не учтено). В
связи с этим, если необходимо использование потоков, следует создать
промежуточный поток, затем загрузить в него данные, а потом эти данные
перебросить в строковую переменную, которую в дальнейшем занести в базу.
Этот способ не является самым оптимальным, но работает безотказно.

    BLOBField: TBlobField;
    Stream1: TMemoryStream;
    d: Char;
    i: Integer;
    s: string;
    {------------------}
    begin
      Stream1 := TMemoryStream.Create;
      Stream.Clear;
      Image.Picture.Bitmap.SaveToStream(Stream1);
      Stream1.Position := 0;
      for i := 1 to Stream1.Size do
      begin
        Stream1.Read(d, 1);
        s := s + d;
      end;
      BlobField.DataSet.Edit;
      BlobField.AsString := s;
      BlobField.DataSet.Post;
      TSQLClientDataSet(BlobField.DataSet).ApplyUpdates(0);
      Stream1.Free;
    end;

Использование свойства TDataSet.FieldValues

    {описание типов переменных}
    qrProba: TSQLClientDataSet; {поле BLOBF – является BLOB-полем}
    Image: TImage;
    Stream: TStream;
    Memo: TMemo;
    {----------------------------------}
    begin
      {делаем нужную запись активной, например, методом Locate.}
      qrProba.Edit;
      qrProba['BLOBF'] := Memo.Lines.Text;
      qrProba.Post;
      qrProba.ApplyUpdates(0);
    end;

Использование свойства TBlobField.Value

    {описание типов переменных}
    Memo: TMemo;
    BLOBField: TBlobField;
    {----------------------------------}
    begin
      {делаем нужную запись активной, например, методом Locate.}
      BlobDield.DataSet.Edit;
      BlobField.Value := Memo.Lines.Text;
      BlobField.DataSet.Post;
      TSQLClientDataSet(BlobField.DataSet).ApplyUpdates(0);
    end;

Вместо заключения

«И зачем все это!?», -- спросит внимательный читатель, -- «Ведь в начале
статьи написано, что данные BLOB-поля неплохо представляются в виде
String. Почему просто не записать SQL запрос UPDATE mytable SET
blobf=\'s\' WHERE id=1, где s -- строковая переменная, которая может
содержать, какие угодно данные?». Действительно, в определенных
ситуациях такое решение пригодно, но предположим, что в данной
переменной содержится символ { ? } , тогда сервер посчитает ее концом
присваемого значения и возникнет ошибка. При использовании вышеописанных
способов такого не происходит. Конечно, для исключения подобных ситуаций
можно проводить предварительную обработку переменной для замены
«запрещенных» символов на другие, но это дополнительная работа. В любом
случае, главное: «ВОЗМОЖНОСТЬ ВЫБОРА. Выбора решения поставленной
задачи».

Автор: Андрей Пащенко

Взято с <https://delphiworld.narod.ru>

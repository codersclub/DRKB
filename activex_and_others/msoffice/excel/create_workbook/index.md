---
Title: Создание или открытие книги
Author: Евгений Старостин
Date: 01.01.2007
---


Создание или открытие книги
===========================

::: {.date}
01.01.2007
:::

Повторюсь, несмотря на то, что я уже писал об этом в предыдущей статье.

В главной форме проекта-примера я объявил свойство IWorkbook. Оно будет
содержать интерфейс книги, которую мы будем создавать и использовать.
Естественно, в обработчике FormDestroy я его освобождаю.

property IWorkbook: Excel8TLB.\_Workbook read FIWorkbook;

Книгу можно создать разными способами и с разными намерениями. Если
необходимо создать абсолютно чистую книгу, достаточно выполнить
следующий код:

if Assigned(IXLSApp) and (not Assigned(IWorkbook) ) then

  FIWorkbook := IXLSApp.Workbooks.Add(EmptyParam, 0);

Вопрос в том, зачем нам может понадобиться новая книга, с количеством
пустых листов, выставленным по умолчанию. Сегодня, я не могу уже
ответить на этот вопрос, ибо не создаю новых пустых книг.

Коллекция Workbooks содержит все открытые книги и предоставляет
возможность кое-как управлять всем этим.

Боже, как убоги коллекции от Microsoft, и особенно поиск в них! Я
отклонюсь, но это надо видеть. Вот пример поиска книги с заданным
именем, приведенный как совет в MSDN Office Developer.

    Public Function SheetExists(strSearchFor As String) As Boolean
    SheetExists = False
    For Each sht In ThisWorkbook.Worksheets
        If sht.Name = strSearchFor Then
            SheetExists = True
        End If
    Next sht
    End Function

Это вам не IndexOf писать. Сами ищите! А я так иделаю. Но, далее...

Метод Add этой коллекции (читай, метод интерфейса) позволяет добавить
книгу к этой коллекции, пустую либо по шаблону. Первый параметр этого
метода, Template (из справки по Excel VBA), может принимать имя файла с
путем. Поэтому, выполнив код

    if Assigned(IXLSApp) and (not Assigned(IWorkbook) ) then
      FIWorkbook := IXLSApp.Workbooks.Add(ExtractFilePath(ParamStr(0)) + 'Test.xls', 0);

вы получите книгу, идентичную файлу \"Test.xls\" с именем Test1.xls.
Именно этим способом я создаю все свои отчеты, так как создаю их по
заранее разработанным шаблонам. Естественно, что это шаблоны XL Report.

Если же необходимо просто открыть уже существующий файл, то используйте
метод Open этой же коллекции:

if Assigned(IXLSApp) and (not Assigned(IWorkbook) ) then

FIWorkbook := IXLSApp.Workbooks.Open(ExtractFilePath(ParamStr(0)) +
\"Test.xls\', EmptyParam,

   EmptyParam, EmptyParam, EmptyParam, EmptyParam, EmptyParam,
EmptyParam, EmptyParam,

   EmptyParam, EmptyParam, EmptyParam, false, 0);

Понимаю, что в душе нормального программиста такой код вызовет
отвращение. Как-то я даже получил гневное письмо о собственной
ненормальности из-за того, что использую ранее связывание и кучу
EmptyParam. Впрочем, я не сильно агрессивный человек (правда, только в
переписке), и отвечать не стал. В конечном итоге, раннее связывание дает
мне немного преимуществ, но я за него. Я не могу помнить все методы и их
параметры из Excel Type Library, поэтому получаю их (только при раннем
связывании, естественно) из подсказок редактора Delphi - продуманная
вещь этот редактор. А чтобы не мучаться с написанием такого количества
EmptyParam, можно написать и так (ответ на «гневное» письмо):

if Assigned(IXLSApp) and (not Assigned(IWorkbook) ) then

IDispatch(FIWorkbook) := OLEVariant(IXLSApp.Workbooks).Open(

   FileName := ExtractFilePath(ParamStr(0)) + \'Test.xls\');

Но, мы отклонились. Что же стоит за таким количеством параметров по
умолчанию в методе Open? Да, много чего. Из этого «громадья» я использую
лишь несколько вещей. Их я и опишу, а заинтересовавшихся остальными
отсылаю к справке по Excel VBA. Вот объявление этого метода в
импортированной библиотеке типов:

function Open(const Filename: WideString; UpdateLinks: OleVariant;
ReadOnly: OleVariant;

             Format: OleVariant; Password: OleVariant; WriteResPassword:
OleVariant;

             IgnoreReadOnlyRecommended: OleVariant; Origin: OleVariant;

             Delimiter: OleVariant; Editable: OleVariant; Notify:
OleVariant;

             Converter: OleVariant; AddToMru: OleVariant; lcid:
Integer): Workbook; safecall;

В FileName необходимо передать имя открываемого файла, желательно указав
путь его нахождения. Иначе, этот файл Excel будет искать в каталоге по
умолчанию. Чтобы файл был запомнен в списке последних открытых файлов, в
AddToMru можно передать true. Иногда я знаю, что файл рекомендован
только для чтения (не путать с «парольной» защитой книги). Тогда при
открытии выдается соответствующее сообщение. Чтобы игнорировать его,
можно передать в IgnoreReadOnlyRecommended true. Вот, пожалуй, и все мои
скудные знания об этом методе. Впрочем, с помощью его мне приходилось
открывать и файлы текстовых форматов с разделителями. Но тогда я
обращался к чудесному «пишущему» плейеру VBA и записывал с его помощью
макросы, затем правил их по необходимости и все отлично получалось. Этим
же способом разрешать «всяческие» тонкие вопросы рекомендую и вам.

На главной форме проекта-примера я создал кнопку, с помощью которой
можно открыть (или создать) файл и RadioGroup к ней, где можно указать
каким из приведенных выше способов файл этот открывается. Для полного
удовлетворения сюда же была добавлена обработка исключения. Вот что у
меня получилось:

    procedure TForm1.btnCreateBookClick(Sender: TObject); 
    var FullFileName: string;
    begin
      FullFileName := ExtractFilePath(ParamStr(0)) + 'Test.xls';
      if Assigned(IXLSApp) and (not Assigned(IWorkbook) ) then
        try
          case rgWhatCreate.ItemIndex of
          // По шаблону
          0: FIWorkbook := IXLSApp.Workbooks.Add(FullFileName, 0);
          // Просто откроем
          1: FIWorkbook := IXLSApp.Workbooks.Open(FullFileName,
               EmptyParam, EmptyParam, EmptyParam, EmptyParam, EmptyParam, EmptyParam,
               EmptyParam, EmptyParam, EmptyParam, EmptyParam, EmptyParam, false, 0);
          // Пустая книга
          2: FIWorkbook := IXLSApp.Workbooks.Add(EmptyParam, 0);
          end;
        except
          raise Exception.Create('Не могу создать книгу!');
        end;
    end; 
     

Автор: Евгений Старостин

Взято с сайта <https://www.delphikingdom.ru/>

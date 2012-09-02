<h1>Создание или открытие книги</h1>
<div class="date">01.01.2007</div>



<p>Повторюсь, не смотря на то, что я уже писал об этом в предыдущей статье. В главной форме проекта-примера я объявил свойство IWorkbook. Оно будет содержать интерфейс книги, которую мы будем создавать и использовать. Естественно, в обработчике FormDestroy я его освобождаю.</p>

<p> property IWorkbook: Excel8TLB._Workbook read FIWorkbook;</p>

<p>Книгу можно создать разными способами и с разными намерениями. Если необходимо создать абсолютно чистую книгу, достаточно выполнить следующий код: </p>

<p>if Assigned(IXLSApp) and (not Assigned(IWorkbook) ) then</p>
<p> &nbsp; FIWorkbook := IXLSApp.Workbooks.Add(EmptyParam, 0);</p>


<p>Вопрос в том, зачем нам может понадобиться новая книга, с количеством пустых листов, выставленным по умолчанию. Сегодня, я не могу уже ответить на этот вопрос, ибо не создаю новых пустых книг. </p>

<p>Коллекция Workbooks содержит все открытые книги и предоставляет возможность кое-как управлять всем этим. </p>

<p>Боже, как убоги коллекции от Microsoft, и особенно поиск в них! Я отклонюсь, но это надо видеть. Вот пример поиска книги с заданным именем, приведенный как совет в MSDN Office Developer. </p>
<pre>
Public Function SheetExists(strSearchFor As String) As Boolean
SheetExists = False
For Each sht In ThisWorkbook.Worksheets
    If sht.Name = strSearchFor Then
        SheetExists = True
    End If
Next sht
End Function
</pre>



<p>Это вам не IndexOf писать. Сами ищите! А я так иделаю. Но, далее… </p>

<p>Метод Add этой коллекции (читай, метод интерфейса) позволяет добавить книгу к этой коллекции, пустую либо по шаблону. Первый параметр этого метода, Template (из справки по Excel VBA), может принимать имя файла с путем. Поэтому, выполнив код </p>
<pre>
if Assigned(IXLSApp) and (not Assigned(IWorkbook) ) then
  FIWorkbook := IXLSApp.Workbooks.Add(ExtractFilePath(ParamStr(0)) + 'Test.xls', 0);
</pre>


<p> вы получите книгу, идентичную файлу "Test.xls" с именем Test1.xls. Именно этим способом я создаю все свои отчеты, так как создаю их по заранее разработанным шаблонам. Естественно, что это шаблоны XL Report. </p>

<p>Если же необходимо просто открыть уже существующий файл, то используйте метод Open этой же коллекции: </p>

<p>if Assigned(IXLSApp) and (not Assigned(IWorkbook) ) then</p>
<p>  FIWorkbook := IXLSApp.Workbooks.Open(ExtractFilePath(ParamStr(0)) + "Test.xls', EmptyParam,</p>
<p> &nbsp;&nbsp; EmptyParam, EmptyParam, EmptyParam, EmptyParam, EmptyParam, EmptyParam, EmptyParam,</p>
<p> &nbsp;&nbsp; EmptyParam, EmptyParam, EmptyParam, false, 0);</p>

<p>Понимаю, что в душе нормального программиста такой код вызовет отвращение. Как-то я даже получил гневное письмо о собственной ненормальности из-за того, что использую ранее связывание и кучу EmptyParam. Впрочем, я не сильно агрессивный человек (правда, только в переписке), и отвечать не стал. В конечном итоге, раннее связывание дает мне немного преимуществ, но я за него. Я не могу помнить все методы и их параметры из Excel Type Library, поэтому получаю их (только при раннем связывании, естественно) из подсказок редактора Delphi - продуманная вещь этот редактор. А чтобы не мучаться с написанием такого количества EmptyParam, можно написать и так (ответ на «гневное» письмо): </p>

<p>if Assigned(IXLSApp) and (not Assigned(IWorkbook) ) then</p>
<p>  IDispatch(FIWorkbook) := OLEVariant(IXLSApp.Workbooks).Open(</p>
<p> &nbsp;&nbsp; FileName := ExtractFilePath(ParamStr(0)) + 'Test.xls');</p>


<p>Но, мы отклонились. Что же стоит за таким количеством параметров по умолчанию в методе Open? Да, много чего. Из этого «громадья» я использую лишь несколько вещей. Их я и опишу, а заинтересовавшихся остальными отсылаю к справке по Excel VBA. Вот объявление этого метода в импортированной библиотеке типов:</p>
<p> function Open(const Filename: WideString; UpdateLinks: OleVariant; ReadOnly: OleVariant;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Format: OleVariant; Password: OleVariant; WriteResPassword: OleVariant; </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; IgnoreReadOnlyRecommended: OleVariant; Origin: OleVariant; </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Delimiter: OleVariant; Editable: OleVariant; Notify: OleVariant; </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Converter: OleVariant; AddToMru: OleVariant; lcid: Integer): Workbook; safecall;</p>

<p>В FileName необходимо передать имя открываемого файла, желательно указав путь его нахождения. Иначе, этот файл Excel будет искать в каталоге по умолчанию. Чтобы файл был запомнен в списке последних открытых файлов, в AddToMru можно передать true. Иногда я знаю, что файл рекомендован только для чтения (не путать с «парольной» защитой книги). Тогда при открытии выдается соответствующее сообщение. Чтобы игнорировать его, можно передать в IgnoreReadOnlyRecommended true. Вот, пожалуй, и все мои скудные знания об этом методе. Впрочем, с помощью его мне приходилось открывать и файлы текстовых форматов с разделителями. Но тогда я обращался к чудесному «пишущему» плейеру VBA и записывал с его помощью макросы, затем правил их по необходимости и все отлично получалось. Этим же способом разрешать «всяческие» тонкие вопросы рекомендую и вам. </p>

<p>На главной форме проекта-примера я создал кнопку, с помощью которой можно открыть (или создать) файл и RadioGroup к ней, где можно указать каким из приведенных выше способов файл этот открывается. Для полного удовлетворения сюда же была добавлена обработка исключения. Вот что у меня получилось: </p>
<pre>
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
 
</pre>


<p class="author">Автор Евгений Старостин</p>
<p>Взято с сайта <a href="https://www.delphikingdom.ru/" target="_blank">https://www.delphikingdom.ru/</a></p>

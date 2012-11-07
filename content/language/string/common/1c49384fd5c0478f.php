<h1>Добавление функций проверки орфографии</h1>
<div class="date">01.01.2007</div>


<p>Предположим, что в вашу задачу, как разработчика программного обеспечения, входит создание некоторого специализированного текстового процессора. Не вдаваясь в рассуждения о необходимости создания еще одного приложения подобного рода, мы просто рассмотрим один прием, который придаст вашей разработке весьма ощутимое преимущество по сравнению с аналогами. К примеру, вам необходимо создать некий HTML-редактор. Как и в случае с любым другим приложением такого типа, ваша программа должна будет обладать функциями орфографической проверки текста. Естественно, можно потратить много времени на создание своего собственного шедевра в данной области, но почему бы нам не воспользоваться уже готовыми решениями? В рамках данной статьи я бы хотел поговорить о технологии использования в ваших приложениях механизмов проверки орфографии, входящих в состав всем известного приложения - Microsoft Word с использованием автоматизации (OLE Automation).</p>
<p>OLE Automation</p>
<p>Идея, заложенная в автоматизацию, включает разработку приложений, функциональность которых может быть доступна и другим программам, а также создание приложений, которые "знают", как использовать функциональность, предоставляемую вам другими программными продуктами. Если говорить техническим языком, приложение, которое предоставляет некоторую повторно используемую функциональность, называется сервером автоматизации (automation server) (также часто называемым сервером COM). Приложение же, использующее функциональность, предоставляемую сервером автоматизации, называется клиентом автоматизации (automation client), также часто называемым контроллером автоматизации. Важно подчеркнуть, что сервер автоматизации может не быть "чистым" сервером автоматизации, так же как и клиент автоматизации может не быть "чистым" клиентом автоматизации. В действительности сервер автоматизации может использовать сервисы другого приложения, которое также является сервером автоматизации. Клиент автоматизации, предоставляющий свои сервисы другому клиенту, также может являться как клиентом, так и сервером автоматизации. Глубинные механизмы (сетевые и транспортные протоколы), с помощью которых клиент автоматизации взаимодействует с сервером, уже являются частью собственно COM.</p>
<p>Сервер автоматизации - это просто двоичный исполняемый модуль, который может состоять из нескольких объектов автоматизации. Объект автоматизации (также называемый объектом COM, хотя технически объект автоматизации является объектом COM особого сорта) - это отдельный, самодостаточный объект, спроектированный для выполнения специфической задачи или функции. В общем, все объекты автоматизации, собранные в одном сервере, предназначены для осуществления каких-то функциональных возможностей. Например, Microsoft Excel является сервером автоматизации, состоящим из нескольких меньших серверов автоматизации (Workbook - книга, Chart - диаграмма, Worksheet - лист, Range - диапазон и т.д.), каждый из которых определяет часть функций, предоставляемых пользователю Microsoft Excel. Идея заключается в том, что сервер автоматизации "позволяет" своим клиентам получать доступ и использовать свои объекты так же легко и просто, как будто это его внутренние объекты.</p>
<p>Для решения задачи, поставленной перед нами в начале данной статьи, мы можем воспользоваться теми возможностями, которые предоставляет нам сервер автоматизации Microsoft Word. C помощью приложения, разработанного в Borland Delphi (программа будет выступать в качестве клиента автоматизации), мы сможем динамически создать новый документ и поместить в него некоторый текст (который и будем проверять). После этого нам останется лишь с помощью MS Word осуществить эту проверку. Если приложение Word будет минимизировано, то пользователи могут и не почувствовать, что выполнение части функций нашего приложения берет на себя другая программа. Обращаю внимание, что для полноценного использования OLE-автоматизации вам надо будет знать как можно больше о возможностях и интерфейсах того приложения, функциональностью которого вы решили воспользоваться. Кроме того, для корректного выполнения всех функций разрабатываемого приложения необходимо, чтобы на компьютере пользователя было установлено соответствующее приложение. В нашем случае - Microsoft Word.</p>
<p>Основные принципы работы</p>
<p>Существует три основных метода использования OLE-автоматизации в Borland Delphi в зависимости от того, какую версию этой среды разработки вы используете.</p>
<p>Delphi 5. Закладка Servers на палитре компонентов.</p>
<p>Если вы являетесь счастливым обладателем этой версии Delphi, то для работы с Microsoft Word можно воспользоваться компонентами, расположенными на закладке Ser-vers (рис. 1). Такие компоненты, как TWord-Application и TWordDocument, предоставляют все необходимые для работы интерфейсы.</p>
<p>Delphi 3, 4. Раннее связывание.</p>
<p>Используя термины автоматизации, для обеспечения в Delphi доступа к методам и свойствам, предоставляемым MS Word, необходимо установить соответствующую библиотеку типов. Библиотека типов предоставляет информацию обо всех свойствах и методах, которые разработчик может использовать при работе с сервером автоматизации. Для использования библиотеки типов Microsoft Word в Delphi (3 или 4 версии) необходимо произвести следующие несложные действия:</p>
<p>выбрать пункт меню Project|Import Type Library;</p>
<p>в открывшемся диалоге найти файл msword8.olb (для Microsoft Office'2000 этот файл будет иметь название msword9.olb), расположенный в подкаталоге "Office" того каталога, в который был установлен Microsoft Office.</p>
<p>После этого будет создан файл с именем word_TLB.pas, в котором в синтаксисе object pascal будут описаны константы, типы, свойства и методы для доступа к серверу автоматизации Microsoft Word. Файл word_TLB.pas должен быть включен в список uses всех модулей, в которых вы планируете использовать функции Microsoft Word. Такая технология работы с серверами автоматизации называется ранним связыванием. Одним из преимуществ раннего связывания является осуществление контроля вызовов и передаваемых параметров на этапе компиляции.</p>
<p>Delphi 2. Позднее связывание.</p>
<p>Для доступа к объектам MS Word без применения библиотеки типов можно использовать так называемое позднее связывание. В данном случае доступ к Word осуществляется так же, как к переменной типа Variant, следствием чего является необходимость знания вами всех предоставляемых сервером автоматизации интерфейсов. Позднего связывания следует по возможности избегать, поскольку при этом отсутствует возможность контроля корректности вызовов процедур и функций со стороны компилятора, и если вы неправильно написали имя того или иного метода, то узнаете об этом, только, когда программа "вывалится" по ошибке в процессе выполнения.</p>
<p>Начнем!</p>
<p>Итак, вернемся к теме статьи. Для демонстрации принципов работы с MS Word я буду использовать механизмы, предоставляемые пятой версией Delphi (т.е. компоненты TWordApplication, TWordDocument). Ниже я приведу код, обеспечивающий соединение и работу с MS Word в случае использования библиотеки типов и позднего связывания и больше не буду касаться этой темы.</p>
<p>Для доступа к объектам Word при работе в Delphi 3, 4 (запуск приложения и создание нового документа) используйте следующий код:</p>
<pre>
uses
  Word_TLB;
...
var
  WordApp: _Application;
  WordDoc: _Document;
  VarFalse: OleVariant;
begin
  WordApp := CoApplication.Create;
  WordDoc := WordApp.Documents.Add(EmptyParam, EmptyParam);
  {
  код для проверки орфографии, описываемы далее в данной статье
  }
  VarFalse:=False;
  WordApp.Quit(VarFalse, EmptyParam, EmptyParam);
end;
</pre>


<p>Обращаю внимание, что в методах MS Word множество параметров описаны как необязательные (optional). При использовании интерфейсов (библиотек типов), Delphi не позволит вам опускать те или иные параметры, даже если в контексте разрабатываемого вами кода они не нужны. В четвертой версии Delphi в модуле system.pas описана переменная EmptyParam, которую можно использовать в качестве "заглушки" для неиспользуемых переменных в вызываемом методе.</p>
<p>Для автоматизации MS Word с использованием переменной Variant (позднее связывание) используйте следующий код:</p>
<pre>
uses
  ComObj;
...
var
  WordApp, WordDoc: Variant;
begin
  WordApp := CreateOleObject('Word.Application');
  WordDoc := WordApp.Documents.Add;
  {
  код для проверки орфографии, описываемы далее в данной статье
  }
  WordApp.Quit(False)
end;
</pre>

<p>При использовании позднего связывания компилятор Delphi позволяет вам опускать те или иные параметры при вызове методов сервера автоматизации.</p>
<p>Как уже упоминалось, Delphi 5 упрощает программисту использование функциональности MS Word в своих приложениях путем предоставления его методов и свойств в виде компонентов. Так как множество параметров, определенных в методах Word'а, описаны как необязательные, то в Delphi данные процедуры и функции переопределены и представляют собой набор из нескольких методов с различным количеством параметров. Таким образом, разработчику предоставляется возможность при вызове метода не указывать последние n параметров, необходимость в которых отсутствует.</p>
<p>Шаг за шагом</p>
<p>Для создания своего редактора с возможностью проверки орфографии в минимальном варианте нам понадобится две формы: одна будет использоваться для редактирования текста, а вторая - для отображения диалога правки найденных ошибок. Однако предлагаю начать с самого начала.</p>
<p>Если у вас не запущен Delphi - запустите его. Создайте новый проект (если он не был создан при открытии приложения). По умолчанию проект будет содержать одну форму. Данная форма будет главной в нашем проекте. Поместите на форму один компонент типа TMemo и две кнопки (TButton). Заполните свойство Lines компонента Memo1 каким-нибудь текстом (содержащим ошибки). Заголовок одной кнопки определите как "Орфография", а второй - "Тезаурус". Затем перейдите на закладку Servers палитры компонентов и поместите на форму по одному компоненту типа TWordApplication и TWordDocument (рис. 2). Установите значения свойства Name первого компонента в Word-App, а второго - WordDoc.</p>
<p>TWordApplication, TWordDocument</p>
<p>При автоматизации MS Word для управления приложением, отображения его рабочего окна, получения доступа к атрибутам и объектной модели MS Word мы используем объект Application. Для того чтобы указать приложению, запускать ли новую копию процесса Word или использовать уже запущенный, применяется свойство Applicati-on.ConnectKind. В нашем случае мы устанавливаем данное свойство в значение ckRunningInstance. Другие возможные значения этого свойства вы сможете узнать, воспользовавшись справочной системой Delphi.</p>
<p>Когда мы открываем в MS Word существующий файл или создаем новый, мы тем самым создаем объект Document. Типичной задачей при использовании автоматизации Word является работа с некоторой областью документа: добавление текста, выделение некоторой области, проверка орфографии и т.д. Объект, определяющий некоторую область в документе, называется Range.</p>
<p>Естественно, в рамках статьи я не смогу подробно рассказать обо всех нюансах работы с компонентами, расположенными на закладке Servers палитры компонентов (кстати, с любой другой закладкой ситуация состоит ничуть не лучше). Для более детального их изучения предлагаю воспользоваться справочной системой Borland Delphi. В нашем же сегодняшнем разговоре я буду упоминать только те свойства и методы, которые будут необходимы.</p>
<p>Как это все будет работать</p>
<p>Алгоритм работы нашего приложения будет достаточно прост. Каждое слово, входящее в состав проверяемого нами текста, будет передаваться в MS Word для проверки. Сервер автоматизации Word содержит метод SpellingErrors, который позволяет вам осуществлять проверку текста, входящего в состав некоторой области Range. Мы же будем каждый раз определять эту область таким образом, чтобы она содержала только переданное нами в Word слово. Метод SpellingErrors в качестве результата своей работы возвращает коллекцию слов, написание которых признано ошибочным. Если эта коллекция пуста, то мы переходим к рассмотрению следующего слова. Иначе - переходим к процедуре замены неправильно напечатанного слова. Путем вызова метода GetSpellingSuggestions можно получить список слов, предлагаемых в качестве замены. Эти слова помещаются в коллекцию SpellingSuggestions. Данную коллекцию мы помещаем в качестве списка (компонент типа TListBox), расположенного во второй форме нашего проекта. Думаю, самое время немного поговорить о ней.</p>
<p>Для того чтобы добавить новую форму в проект, следует выбрать пункт меню File|New Form. Назовем эту форму frSpellCheck. На форму поместим три кнопки типа TBitBtn, два элемента редактирования (TEdit) и один список (TListBox). На форму также следует поместить три метки (см. рис. 3). Компонент edNID (editNotInDictionary) служит для отображения заменяемого слова. edReplaceWith содержит выделенный в данный момент вариант для замены, а список lbSuggestions - список предлагаемых вариантов (заполняемый на основании данных, содержащихся в коллекции SpellingSuggestions). Три кнопки выполняют именно те функции, которым соответствуют их заголовки - не больше и не меньше. Каждой из кнопок соответствует свое значение, возвращаемое функцией frSpellCheck.ModalResult. В зависимости от этого значения в основной обрабатывающей процедуре осуществляется то или иное действие - игнорирование, замена или отмена дальнейшей проверки. Форма frSpellCheck содержит одно общедоступное свойство:</p>
<p>sReplacedWord :String</p>

<p>Оно служит для передачи в основную форму слова для замены в случае нажатия пользователем кнопки "Заменить".</p>
<p>Пишем код!</p>
<p>Ниже приводится код основной процедуры приложения.</p>
<pre>
procedure TForm1.btnSpellCheckClick(Sender: TObject);
var
  colSpellErrors : ProofreadingErrors;
  colSuggestions : SpellingSuggestions;
  i : Integer;
  StopLoop : Boolean;
  itxtLen, itxtStart : Integer;
  varFalse : OleVariant;
begin
  WordApp.Connect;
  WordDoc.ConnectTo(WordApp.Docum-ents.Add(EmptyParam, EmptyParam));
 
  StopLoop:=False;
  itxtStart:=0;
  Memo.SelStart:=0;
  itxtlen:=0;
  while not StopLoop do
  begin
    itxtStart := itxtLen + itxtStart;
    itxtLen := Pos(' ', Copy(Memo.Text,itxtStart+1,MaxInt));
    if itxtLen = 0 then
      StopLoop := True;
    Memo.SelStart := itxtStart;
    Memo.SelLength := -1 + itxtLen;
 
    if Memo.SelText = '' then
      Continue;
 
    Caption:=Memo.SelText;
 
    WordDoc.Range.Delete(EmptyParam,Emp-tyParam);
    WordDoc.Range.Set_Text(Memo.SelText);
    colSpellErrors := WordDoc.SpellingErrors;
    if colSpellErrors.Count &lt;&gt; 0 then
    begin
      colSuggestions := WordApp.GetSpellingSuggestions
      (colSpellErrors.Item(1).Get_Text);
      with frSpellCheck do
      begin
        edNID.text := colSpellErrors.Item(1).Get_Text;
        lbSuggestions.Items.Clear;
        for i:= 1 to colSuggestions.Count do
          lbSuggestions.Items.Add(VarToStr-(colSuggestions.Item(i)));
        lbSuggestions.ItemIndex := 0;
        lbSuggestionsClick(Sender);
        ShowModal;
        case frSpellCheck.ModalResult of
          mrAbort: Break;
          mrIgnore: Continue;
          mrOK:
            if sReplacedWord &lt;&gt; '' then
            begin
              Memo.SelText := sReplacedWord;
              itxtLen := Length(sReplacedWord);
            end;
        end;
      end;
    end;
  end;
  WordDoc.Disconnect;
  varFalse:=False;
  WordApp.Quit(varFalse);
  Memo.SelStart := 0;
  Memo.SelLength := 0;
end;
</pre>


<p>Обработчики событий нажатий на кнопки формы frSpellCheck и список слов, предлагаемых для замены:</p>
<pre>
procedure TfrSpellCheck.lbSuggestionsClick(Sen-der: TObject);
begin
  if lbSuggestions.ItemIndex &lt;&gt; -1 then
    edReplaceWith.Text := lbSuggestions.Items[lbSuggestio-ns.ItemIndex]
  else
    edReplaceWith.Text := '';
end;
 
procedure TfrSpellCheck.btnChangeClick(Sender: TObject);
begin
  sReplacedWord := edReplaceWith.Text;
end;
 
procedure TfrSpellCheck.btnIgnoreClick(Sender: TObject);
begin
  sReplacedWord := '';
end;
</pre>


<p>Тезаурус</p>
<p>Теперь рассмотрим вопрос добавления в нашу программу функций тезауруса. Делается это достаточно просто:</p>
<pre>
procedure TForm1.btnThesaurusClick(Sender: TObject);
var
  varFalse : OleVariant;
begin
  if Memo.SelText &lt;&gt; '' then
  begin
    WordApp.Connect;
    WordDoc.ConnectTo(WordApp.Documen-ts.Add(EmptyParam, EmptyParam));
 
    WordDoc.Range.Delete(EmptyParam,Empty-Param);
    WordDoc.Range.Set_Text(Memo.SelText);
 
    WordDoc.Range.CheckSynonyms;
 
    Memo.SelText := WordDoc.Range.Get_Text;
 
    WordDoc.Disconnect;
    varFalse:=False;
    WordApp.Quit(varFalse);
  end;
end;
</pre>

<p>Тестирование</p>
<p>В тексте, помещенном в компонент Memo, мною было сознательно сделано несколько ошибок, которые вы сможете увидеть, приглядевшись к изображению, представленному на рисунке 1. В частности, вместо слова "своих" я написал "свиох", вместо "путем" - "пуетм", а вместо "виде" - "виед". Как же повела себя программа? На следующих рисунках (рисунки 4-6) можно видеть, что проверка текста действительно работает.</p>
<p>Надеюсь, вы понимаете, что в рамках одной статьи невозможно описать все те возможности, которые открываются перед разработчиком программного обеспечения в случае использования серверов автоматизации. И речь идет не только о Microsoft Word, но и о других приложениях (к примеру, широко распространено применение MS Excel в качестве базы для построения отчетов). Все разнообразие данного направления программирования можно познать, на мой взгляд, только через собственный опыт. Так что удачного вам кода!</p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
</p>

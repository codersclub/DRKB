<h1>Как формировать документ в формате Word?</h1>
<div class="date">01.01.2007</div>

<div class="author">Автор: Василий КОРНЯКОВ</div>

<p>Теперь остановимся на постановке задачи, описанной в этой статье. Как формировать документ в формате Word? Очень просто. Текстовый редактор Word представляет собой COM-сервер и может получать и обрабатывать запросы от внешних программ. Все это позволяет организовать процесс управления и создания документа из внешней программы. Используя этот механизм, можно создать документ программно так же, как это делается вручную (посредством меню, кнопок и клавиатуры), но гораздо быстрей и эффектней.</p>
<p>Приступим к решению задачи. Как было сказано выше, Word является COM-сервером и может управляться внешними программами. Для этого Word предоставляет три объекта, через которые можно получить доступ к внутренним объектам Word`а и документов. Эти объекты - Word.Application, Word.Document и Word.Basic. Ко всем остальным объектам (текст, таблицы, кнопки, меню и др.) доступ возможен только через них.</p>
<p>Чтобы реализовать все эти возможности Word`а и для удобства своей работы мне пришлось разработать динамическую библиотеку процедур и функций, которую можно было использовать в различных своих приложениях для формирования и печати выходных документов. Зачем нужна такая библиотека, почему бы не вставлять программный код непосредственно в программу? Здесь причина в универсальности и гибкости использования библиотеки. Поэтому все ниже описанные коды легко могут быть оформлены в виде библиотеки для того, чтобы вы могли использовать ее непосредственно в своих приложениях, не теряя зря времени.</p>
<p>Чтобы почувствовать эффективность использования объектов Word, для начала попробуем написать несколько функций, которые позволят запустить Word, создать документ, изменить документ (записать текст), сохранить документ и закрыть Word. Для создания объекта и его использования применяем переменную W типа variant и библиотеку ComObj.</p>
<p>Рассмотрим следующий фрагмент кода:</p>

<pre class="delphi">
uses ComObj;
var W:variant;
Function CreateWord:boolean;
begin
 CreateWord:=true;
 try
 W:=CreateOleObject('Word.Application');
 except
 CreateWord:=false;
 end;
End;
</pre>

Для получения доступа к объекту Word.Application в нашей функции CreateWord используем конструктор CreateOleObject ('Word. Application'). Если редактор Word не установлен в системе, то будет сгенерирована ошибка, и мы получим значение функции = false, если Word установлен, и объект будет создан, то получим значение функции = true.</p>
Эта функция создает объект (W), свойства и методы которого мы будем использовать в дальнейшем. Если выполнить нашу функцию CreateWord, то Word будет запущен, но не появится на экране, потому что по умолчанию он запускается в фоновом режиме. Чтобы его активировать (сделать видимым) или деактивировать (сделать невидимым), используйте свойство visible объекта W. Оформим это в виде функции VisibleWord. Скобки try except везде используются для обработки исключительных ситуаций.</p>

<pre class="delphi">
Function VisibleWord (visible:boolean):boolean;
begin
 VisibleWord:=true;
 try
 W.visible:= visible;
 except
 VisibleWord:=false;
 end;
End;
</pre>

Используя эту функцию, мы можем показывать или прятать Word с документами.</p>
Следующим шагом будет создание документа. Для этого используем объект Documents объекта W. Этот объект имеет метод Add, используя который, и создаем новый документ. При этом, как альтернативный вариант, вместо двух операторов Doc_:=W.Documents; Doc_.Add; можем использовать один W.Documents.Add;.</p>

<pre class="delphi">Function AddDoc:boolean;
Var Doc_:variant;
begin
 AddDoc:=true;
 try
 Doc_:=W.Documents;
 Doc_.Add;
 except
 AddDoc:=false;
 end;
End;
</pre>

<p>Создали документ, что дальше? Следующим шагом, естественно, является запись любого текста непосредственно в документ. Создадим для этого функцию SetTextToDoc.</p>

<pre class="delphi">
Function SetTextToDoc(text_: string;InsertAfter_: boolean): boolean;
var Rng_:variant;
begin
 SetTextToDoc:=true;
 try
 Rng_:=W.ActiveDocument.Range;
 if InsertAfter_
  then Rng_.InsertAfter(text_)
  else Rng_.InsertBefore(text_);
 except
 SetTextToDoc:=false;
 end;
End;
</pre>

В этой функции используем объект Range и его методы InsertAfter и InsertBefore для того, чтобы вставить текст в документ с позиции курсора или до позиции курсора. Наша функция будет вставлять текст в активный документ в область курсора или выделенного текста.</p>
Фрагмент кода:</p>

<pre class="delphi">
Rng_:=W.ActiveDocument.Range;
if InsertAfter_
 then Rng_.InsertAfter(text_)
else Rng_.InsertBefore(text_);
</pre>

можно заменить следующим фрагментом:</p>

<pre class="delphi">
if InsertAfter_
 then W.ActiveDocument.Range. InsertAfter(text_)
else W.ActiveDocument.Range. InsertBefore(text_);
</pre>

После того, как документ создан и в него записан текст, его необходимо сохранить. Для этого используем метод SaveAs объекта ActiveDocument. Функция SaveDocAs использует этот метод и сохраняет документ в заданный файл.</p>

<pre class="delphi">
Function SaveDocAs(file_:string):boolean;
begin
 SaveDocAs:=true;
 try
 W.ActiveDocument.SaveAs(file_);
 except
 SaveDocAs:=false;
 end;
End;
</pre>

Закрыть сохраненный документ можно, используя метод Close объекта ActiveDocument.</p>

<pre class="delphi">
Function CloseDoc:boolean;
begin
 CloseDoc:=true;
 try
 W.ActiveDocument.Close;
 except
 CloseDoc:=false;
 end;
End;
</pre>

Закрыть Word можно, используя метод Quit объекта Application(W).</p>

<pre class="delphi">
Function CloseWord:boolean;
begin
 CloseWord:=true;
 try
 W.Quit;
 except
 CloseWord:=false;
 end;
End;
</pre>

Таким образом, мы уже имеем несколько функций, которыми можно создать документ, записать в него текст, сохранить документ и отобразить его на экране монитора. Используя несколько строк, состоящих из функций нашей библиотеки, мы создаем документ, записываем в него текст, сохраняем и закрываем. Для демонстрации этого на новой форме разместим на кнопку и скопируем исходные тексты функций в модуль формы. В процедуру обработки нажатия кнопки разместим следующий программный текст.</p>

<pre class="delphi">procedure TForm1.Button1Click(Sender: TObject);
begin
 if CreateWord
  then begin
   Messagebox(0,'Word запущен.','',0);
   VisibleWord(true);
   Messagebox(0,'Word видим.','',0);
   VisibleWord(false);
   Messagebox(0,'Word невидим.','',0);
   VisibleWord(true);
   Messagebox(0,'Word видим.','',0);
   If AddDoc then begin
    Messagebox(0,'Документ создан.','',0);
    SetTextToDoc('Мой первый текст',true);
    Messagebox(0,'Добавлен текст','',0);
    SaveDocAs('c:\Мой первый текст');
    Messagebox(0,'Текст сохранен','',0);
    CloseDoc;
   end;
   Messagebox(0,' Текст закрыт','',0);
   CloseWord;
  end;
end;
</pre>

<p>Конечно, набора данных функций недостаточно для создания полноценного отчета. Было бы эффективным создать шаблон некоего документа и затем заполнять его реальными значениями из базы данных, но для этого, как минимум, потребуется еще ряд функций. Такими функциями могут быть открытие ранее созданного документа, поиск текста, замена, копирование. Далее будут рассмотрены реализации этих функций и создание на их базе простого документа, например, платежного поручения. По всем вопросам, касающимся материала этой статьи, вы можете обратиться к автору по адресу _kvn@mail.ru.</p>

Литература: Н. Елманова, С. Трепалин, А.Тенцер "Delphi 6 и технология COM" "Питер" 2002.</p>

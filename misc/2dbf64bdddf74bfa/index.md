---
Title: Семь чудес и два фокуса на Delphi
Author: Максим Кузьминский
Date: 01.01.2007
---


Семь чудес и два фокуса на Delphi
=================================

::: {.date}
01.01.2007
:::

Верите ли Вы в чудеса или нет, Вы наверняка согласитесь со мной, что
иногда что-то такое случается с кодом наших программ, и они вдруг
перестают компилироваться или, что еще коварнее, начинают выдавать
совершенно непредсказуемый результат. И вот тогда, сознайтесь, вас
начинают посещать странные мысли об участии во всех этих чудесах неких
потусторонних сил.\
 \
В этой статье мы попытаемся сдернуть таинственный покров с нескольких,
самых простых \"чудес\" и убедимся, что все это - только обман, иллюзия,
а зачастую - искусное мошенничество.\
 \
Мы рассмотрим семь (из многих) таких чудес и попробуем разгадать их
секреты. Поняв механизм их происхождения, мы, в заключении, покажем два
примера использования этих тайных сил в \"мирных целях\". Наша цель -
лучше узнать Delphi и в будущем избежать некоторых труднообъяснимых
ошибок.\
 \
Для того, что бы вы поняли, что я имею в виду, давайте рассмотрим один
очень простой пример.\
 \
Чудо Первое (Round Miracle).\
 \
Откройте Delphi, создайте новый проект, назовите его AllMiracles,
положите кнопку на главную форму и напишите в обработчике события
OnClick следующий код:\

 

    procedure TfrmAllMiracles.btnRoundMrclClick(Sender: TObject);
    begin
    ShowMessage( IntToStr( Round(3.5) - Round(2.5) ) );
    end;

 \
А теперь остановитесь и скажите, какой результат вы ожидаете увидеть. Я
надеюсь вы не сказали \"1\", ведь иначе это не было бы чудо. Те, у кого
хорошо развита интуиция, могут сказать \"0\", и это будет еще дальше от
правильного ответа. И только те, кто часто играет в Спортлото или, на
худой конец, внимательно читает документацию, ответит \"2\" и это будет
правильно. Не верите? - жмите F9.\
 \
Читаем Help по функции Round:\
Round returns an Int64 value that is the value of X rounded to the
nearest whole number. If X is exactly halfway between two whole numbers,
the result is always the even number.\
 \
Вот такое оно, \"Круглое чудо\".\
 \
Надеюсь, теперь вы поняли, о чем мы будем говорить сегодня. В этой
статье нет сложных, замысловатых примеров. Код - предельно упрощен что
бы выделить саму суть проблемы. А наше с вами дело - разобраться в ней
и, если можно, исправить ситуацию. Как, например, в следующем случае.\
 \
Чудо Второе (Absolute Miracle).\
 \
Положите на главную форму созданного ранее проекта новую кнопку и
напишите в его обработчике события OnClick такой код:\

 

    procedure TfrmAllMiracles.btnAbsMrclClick (Sender: TObject);
    var
    i1: int64;
    begin
    i1:= abs(low(integer));
    ShowMessage(IntToStr(i1));
    end;

 \
Прежде чем нажать F9, проанализируем написаное. Low от integer -
значение известное всем, записанное даже в Help\'е и равное -2147483648,
т.е. число отрицательное.\
Help не говорит о функции Abs ничего нового:\
 \
Abs returns the absolute value of the argument X. X is an integer-type
or real-type expression.\
 \
Переменная i1 описана как int64, и это правильно, потому что 2147483648
- уже выходит за границы типа integer. Это значение (2147483648) мы и
ожидаем увидеть на экране, не так ли? А вот и нет. Проверьте. На экране
вновь - 2147483648. Как абсолютное значение может быть отрицательным?\
 \
Давайте еще раз, повнимательнее рассмотрим выражение abs(low(integer)).
Что можно еще сказать про него? Не смотря на наличее в нем функций, это
- константа\
 \
Читаем Help по теме \"Constant expressions\":\
\...Constant expressions cannot include variables, pointers, or function
calls, except calls to the following predefined functions:
Abs\...Low\...\
 \
попробуем описать константу со значением равным этому выражению:\

 

    ...
    const
    ci = abs(low(integer));
    ...

 \
Код компилируется. Значит мы - правы, а это значит, что результат
выражения определяется еще на стадии компиляции. Далее, low(integer))
имеет целый тип. Abs от integer - тоже целое, а нам нужно int64.
Поробуем переписать код следующим образом:\

 

    procedure TfrmAllMiracles.btnAbsMrclClick (Sender: TObject);
    const
    ci = abs(low(integer));
    var
    i1: int64;
    begin
    // i1:= abs((low(integer)));
    i1:= abs(int64(low(integer)));
    ShowMessage(IntToStr(i1));
    end;

 \
 \
Теперь - заработало. Секрет \"Абсолютного чуда\" раскрыт! Кстати,
abs(int64(low(integer))) - тоже константа.\
 \
Следующее чудо - пример того, как вполне правильный код отказывается
компилироваться.\
 \
Чудо третье (One more low integer miracle).\
 \

Новая кнопка на форме будет реагировать на нажатие следующим образом:

    procedure TfrmAllMiracles.btnLowIntMrclClick( Sender: TObject);
    var
    lowInt: integer;
    begin
    lowInt := -2147483648;
    ShowMessageFmt('%d',[lowInt]);
    end;

 \
 \
Совершенно обычная процедура. У нас возникло желание присвоить некоторой
переменной вполне законное значение. Но этот код не компилируется:\
Overflow in conversion or arithmetic operation\
Жмем F1 на сообщении об ошибке и читаем:\
 \
The compiler has detected an overflow in an arithmetic expression: the
result of the expression is too large to be represented in 32 bits.\
 \
Видимо компилятор пытается определить константу целого типа со значением
2147483648, а только затем изменить ее знак, но это ему не удается.
Перепишем код:\

 

    procedure TfrmAllMiracles.btnLowIntMrclClick( Sender: TObject);
    var
    lowInt: integer;
    begin
    lowInt := -int64(2147483648);
    // lowInt := -2147483648;
    ShowMessageFmt('%d',[lowInt]);
    end;

 \
 \
Вот теперь - все нормально. Пример очень незамысловат, но дает нам
представление о том, как компилятор Delphi обрабатывает константы и
определяет их тип.\
 \
А вот следующее чудо - пример того, к какой путанице может привести
перегрузка функций. Такие чудеса мы зачастую сами устраиваем себе по
невнимательности, а потом часами ищем ошибки.\
 \
Чудо четвертое (String Trick).\
 \
Ну, что ж, добавим опять кнопку на нашу форму и зададим следующий код
для события OnClick:\

 

    procedure TfrmAllMiracles.btnCopyMrclClick (Sender: TObject);
    const
    cs: array[0..1] of char='01';
    begin
    ShowMessage(copy(cs,0,1)+copy(cs,1,1));
    end;

 \
Я знаю, что вы уже ждете подвоха и все же результат может оказаться
неожиданным: \"00\".\
 \
Как обычно обратимся к Help\'у, смотрим функцию Copy:\

Returns a substring of a string or a segment of a dynamic array.

    ...
    function Copy(S; Index, Count: Integer): string;
    function Copy(S; Index, Count: Integer): array;
    ... 

 \
 \
Дело в том, что в выражении copy(cs,0,1)+copy(cs,1,1) оба раза
вызываются разные версии функции copy, первый раз - для динамических
массивов, которые нумеруются с 0, а второй раз - для строчек, первый
элемент которых имеет индекс 1. Оба раза cs преобразуется к необходимому
типу, и то, что cs, как массив начинается с нулевого элемента, в данном
случае не имеет никакого значения.\
 \
А теперь, наконец, мы добрались и до обьектов. Множество Дельфийских
чудес связаны с тем, что обьекты в Delphi - автоматически разыменуемые
ссылки, которые могут указывать на освобожденную или занятую кем-то
другим область памяти. О таких случаях написано немало. Наше чудо -
иное.\
 \
Чудо пятое (Is-Miracle).\
 \

Опишите в разделе protected нашей формы поле FControl типа TСontrol и
задайте для еще одной - новой кнопки такую вот реакцию на ее нажатие:

    procedure TfrmAllMiracles.btnIsMrclClick(Sender: TObject);
    begin
    if (FControl is TControl) then
    begin
    if not Assigned(FControl) then
    FControl := TControl.Create(Self);
    end
    else
    ShowMessage('Not a Control');
    end;

 \
 \
Такое \"Чудо\" я видел несколько раз и в разных проявлениях. Сколько раз
бы вы не нажимали на кнопку btnIsMrcl, вы каждый раз будете видеть
сообщение \'Not a Control\', а конструктор TControl так никогда и не
будет вызван.\
 \
Вот, что говорит Help:\
...The expression object is class returns True if object is an instance
of the class denoted by class or one of its descendants, and False
otherwise. (If object is nil, the result is False.)\
 \
Дело в том, что оператор is использует ссылку на класс обьекта, а не то,
как описана переменная, которая по сути - простой указатель. Так что
TControl не всегда TControl.\
 \
Да, я надеюсь вы понимаете, что TControl здесь выбран случайно, с таким
же успехом это мог быть и любой другой класс.\
 \
Случай когда FControl ссылается на уже освобожденный обьект или является
локальной и непроинициализированной переменной, дает непредказуемые
результаты и может привести к совсем не чудесному краху аппликации.\
 \
А вот для следующего чуда я нашел только косвенное обьяснение в Help\'е
и поэтому мы будем вынуждены провести небольшой эксперимент.\
 \
Чудо шестое (Is-Miracle II)\
 \

Давайте посмотрим еще на одно, похожее чудо связанное с оператором is.
Добавим к нашей группе проектов (ProjectGroup1) новый проект - DLL с
именем AllMirrLib, в единственном модуле которого будет следующий код:

    library AllMirrLib;
    uses
    Controls;
     
    function IsControlLib(const anObj: TObject): boolean;
    begin
    Result := anObj is TControl;
    end;
     
    exports
    IsControlLib;

 \
 \
Как вы видите эта библиотека экспортирует только одну очень простую
функцию, которая возвращает знечение True в том случае, если ее
единственный параметр происходит от TControl и False - в остальных
случаях.\
 \

В модуль формы нашего основного проекта добавим следующее определение:

    unit AllMir;
     
    interface
    ...
    implementation
     
    {$R *.DFM}
     
    function IsControlLib(const anObj: TObject): boolean; external 'AllMirrLib.DLL';
    Figure 10.
     
    Теперь, как обычно, добавим на форму новую кнопку: 
     
    procedure TfrmAllMiracles.btnIsMrcl2Click(Sender: TObject);
    begin
    FControl := TControl.Create(nil);
    try
    if not IsControlLib(FControl) then
    ShowMessage('Not a Control');
    finally
    FreeAndNil(FControl);
    end;
    end;

 \

Как вы уже наверное догадались FControl опять окажется не TControl.
Найдите в модуле System процедуру \_IsClass. Хоть она и написана на
ассемблере, нетрудно понять, что в ней происходит - в цикле
просматриваются ссылки на классы (сначала собственная - обьекта, а потом
- всех предков) и среди них ищется равная правому операнду. Давайте
изменим немного процедуру:

    procedure TfrmAllMiracles.btnIsMrcl2Click(Sender: TObject);
    var
    p1, p2: pointer;
    begin
    FControl := TControl.Create(nil);
    try
    p1 := pointer(FControl.ClassType);
    p2 := pointer(TControl);
    if not IsControlLib(FControl) then
    ShowMessage('Not a Control');
    finally
    FreeAndNil(FControl);
    end;
    end;

 \
 \
Посмотрите под отладчиком значения p1 и p2 - они равны. Теперь изменим и
функцию IsControlLib:\

 

    function IsControlLib(const anObj: TObject): boolean;
    var
    p3,p4: pointer;
    begin
    p3 := pointer(anObj.ClassType);
    p4 := pointer(TControl);
    Result := anObj is TControl;
    end;

 \
Здесь тоже поставим точку останова и сравним значения. Переменные p1, p2
и p3 имеют одно и тоже значение, а вот p4 - указывает куда-то ни туда.
Проблема в том, что в аппликации и в DLL сосуществуют два разных класса
TControl, вот поэтому равества быть и не может.\
Косвенное указание на эту проблему в Help\'е можно найти в описании
метода ClassNameIs.\
 \
Читаем Help:\
Use ClassNameIs when writing conditional code based on an object\'s type
or to query objects across modules, or DLLs.\
 \
Да, кстати, не забудьте, что у вас два проекта в группе и компилируется
всегда только активный проект. Так что не забывайте перпеключаться на
нужный проект по мере необходимости или компилируйте сразу все: Alt-P,
U.\
 \
Следующее чудо я встретил в программе одного начинающего программиста и
оно было конечно слегка закамуфлировано, так что я, к своему стыду, даже
не сразу понял в чем дело. Я видел значения переменных, знал, что это -
переменные типа variant, но никак не мог понять почему результат
вычисления некоего несложного выражения все время ошибочный. Проверьте
себя и вы.\
 \
Чудо седьмое (Miracle with Variants).\
 \

Как вы уже догадались, начнем с новой кнопки, которая выполняет
следующие действия при нажатии:

    procedure TfrmAllMiracles.btnVarMrclClick(Sender: TObject);
    var
    X,Y,Z: variant;
    begin
    X := '1';
    Y := '2';
    Z := 3;
    ShowMessage(X+Y+Z);
    end;

Можете ли вы предсказать результат выражения \'1\'+ \'2\'+3? Если вы
сказали \'6\', то вы тоже попались. Посмотрим повнимательнее, \'1\'+
\'2\' будет\... конечно \'12\', 12+3=15. Это и есть правильный ответ.\
 \
Итак, мы увидели семь чудес Delphi, семь - из многих. Это не значит, что
они - самые яркие или самые чудесные. Но на них можно многому научиться.
Возьмем последнее, только что рассмотренное нами, чудо. Задумайтесь, как
Delphi удается сводить в одном выражении значения разных типов? А если
один из членов выражения - variant?\
 \
Фокус первый (Variant trick)\
 \
Читаем Help в разделе \"Variants in expressions\":\
\...In a binary operation, if only one operand is a variant, the other
is converted to a variant..\
 \
Не кажется ли вам это удивительным - variant можно складывать с чем
угодно. Например, integer плюс variant - будет variant, а variant можно
опять складывать с чем угодно\...\
 \

Новая кнопка на форме будет выполнять следующие действия:

    procedure TfrmAllMiracles.btnVarTrickClick(Sender: TObject);
    var
    v: variant;
    b: boolean;
    i: integer;
    s: string;
    d: TDatetime;
    x: Double;
    begin
    v:=0;
    b := true;
    i := 2;
    s := '3';
    d := StrToDateTime('01/01/01');
    x := 5;
    v := v+b+i+s+d+x;
    ShowMessage(VarToStr(v));
    end;

 \
 \
Не кажется ли вам, что чудо уже то, что этот код компилируется, а ведь
он еще и выдает какой-то результат. А ведь все очень просто - \"variant
можно складывать с чем угодно\" и снова получим - variant.\
 \
Однажды ко мне обратился один мой знакомый с вопросом нет ли в Delphi
чего-то подобного скрытому параметру Self, но для оператора with. Нет -
ответил я ему сперва, а потом задумался\...\
 \
Фокус второй (With-trick)\
 \
Предположим у нас есть следующая функция:\

 

    procedure ShowText(sl: TStringList);
    begin
    ShowMessage(sl.text);
    end;

 \

И кнопка на форме:

    procedure TfrmAllMiracles.btnWithSelfTrickClick(Sender: TObject);
    var
    sl: TStringList;
    begin
    sl := TStringList.Create;
    try
    sl.CommaText := '1,2,3,4,5,6,7,8,9,0';
    ShowText(sl);
    finally
    sl.Free;
    end;
    end;

 \
И мы, по каким-то причинам, хотим избавиться от локальной переменной sl.
Но для того, что бы обратиться к функции ShowText, мы должны передать ей
параметр типа TStringList. Откуда же его взять?\
 \
Давайте порассуждаем. Каждый метод получает скрытый параметр Self, может
быть как-то можно вытащить его оттуда? Писать для этого специальный
метод какого-то класса не хотелось бы - ведь это работало бы только для
его потомков.\
 \
Давайте почитаем Help, раздел \"TMethod type\":\
\...This type can be used in a type cast of a method pointer to access
the code and data parts of the method pointer\...\
 \
Не это ли то, что мы ищем?\
Определим тип и функцию:\

 

    type
    TSimpleMethod = procedure of object;
     
    function GetWithSelf(const pr: TSimpleMethod): TObject;
    begin
    Result := TMethod(pr).Data;
    end;
    Figure 

 \
Как видите, функция принимает указатель на метод, а возвращает обьект,
являющийся владельцем этого метода. Но каким же методом мы
воспользуемся? Например, метод Free, ведь его история восходит еще к
самому TObject\'у. Теперь проверим себя:\

 

    procedure TfrmAllMiracles.btnWithSelfTrickClick(Sender: TObject);
    begin
    with TStringList.Create do
    try
    CommaText := '1,2,3,4,5,6,7,8,9,0';
    ShowText(TStringList(GetWithSelf(Free)));
    finally
    Free;
    end;
    end;

 \
 \

Проверьте - работает.

Автор: Максим Кузьминский

Источник: <https://delphikingdom.ru>

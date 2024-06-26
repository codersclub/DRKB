---
Title: Пособие по написанию своих компонентов
Date: 01.01.2007
Source: <https://delphid.dax.ru>
---


Пособие по написанию своих компонентов
======================================

*Пособие по написанию своих компонентов на Delphi для начинающих*

Почему я сел писать это пособие:

Во-первых, потому что когда я очень хотел написать свой первый
компонент, я прочитал две книги, и у меня ничего интересного собственно
не вышло. Потом я прочитал еще одну книгу (в ней хотя бы пример рабочий
был), вроде разобрался. Но там был разобран такой простой компонент, что
всё более сложное мне приходилось делать самому, иногда методом тыка,
иногда сидел разбирался и так далее. Результат - разобрался, чего и вам
желаю и надеюсь помочь этим пособием.

Все мои готовые компоненты можно найти на сайте <http://delphid.dax.ru>.

**Для чего нужны компоненты**

Дельфи имеет открытую архитектуру - это значит, что каждый программист
волен усовершенствовать эту среду разработки, как он захочет. К
стандартным наборам компонентов, которые поставляются вместе с Дельфи
можно создать еще массу своих интересных компонентов, которые заметно
упростят вам жизнь (это я вам гарантирую). А еще можно зайти на
какой-нибудь крутой сайт о Дельфи и там скачать кучу крутых компонентов,
и на их основе сделать какую-нибудь крутую прогу. Так же компоненты
освобождают вас от написания "тысячи тонн словесной руды". Пример: вы
создали компонент - кнопку, при щелчке на которую данные из Memo
сохранятся во временный файл. Теперь как только вам понадобится эта
функция вы просто ставите этот компонент на форму и наслаждаетесь
результатом. И не надо будет каждый раз прописывать это, для ваших новых
программ - просто воспользуйтесь компонентом.

**Шаг 1. Придумывание идеи**

Первым шагом нужно ответить себе на вопрос: "Для чего мне этот
компонент и что он будет делать?". Затем необходимо в общих чертах
продумать его свойства, события, на которые он будет реагировать и те
функции и процедуры, которыми компонент должен обладать. Затем очень
важно выбрать "предка" компонента, то есть наследником какого класса
он будет являться. Тут есть два пути. Либо в качестве наследника взять
уже готовый компонент (то есть модифицировать уже существующий класс),
либо создать новый класс.

Для создания нового класса можно выделить 4 случая:

1. Создание Windows-элемента управления (TWinControl)

2. Создание графического элемента управления (TGraphicControl)

3. Создание нового класса или элемента управления (TCustomControl)

4. Создание невизуального компонента (не видимого) (TComponent)

Теперь попробую объяснить что же такое визуальные и невизуальные
компоненты. Визуальные компоненты видны во время работы приложения, с
ними напрямую может взаимодействовать пользователь, например кнопка
Button - является визуальным компонентом.

Невизуальные компоненты видны только во время разработки приложения
(Design-Time), а во время работы приложения (Run-Time) их не видно, но
они могут выполнять какую-нибудь работу. Наиболее часто используемый
невизуальный компонент - это Timer.

Итак, что бы приступить от слов к делу, попробуем сделать какой-нибудь
супер простой компонент (только в целях ознакомления с техникой создания
компонентов), а потом будем его усложнять.

**Шаг 2. Создание пустого модуля компонента**

Рассматривать этот шаг я буду исходя из устройства Дельфи 3, в других
версиях этот процесс не сильно отличается. Давайте попробуем создать
кнопку, у которой будет доступна информация о количестве кликов по ней.

Чтобы приступить к непосредственному написанию компонента, вам
необходимо сделать следующее:

- Закройте проекты, которые вы разрабатывали (формы и модули)
- В основном меню выберите Component -\> New Component...
- Перед вами откроется диалоговое окно с названием "New Component"
- В поле Ancestor Type (тип предка) выберите класс компонента, который вы хотите модифицировать. В нашем случае вам надо выбрать класс TButton
- В поле Class Name введите имя класса, который вы хотите получить. Имя обязательно должно начинаться с буквы "T". Мы напишем туда, например, TCountBtn
- В поле Palette Page укажите имя закладки на которой этот компонент появиться после установки. Введем туда MyComponents (теперь у вас в Делфьи будет своя закладка с компонентами!).
- Поле Unit File Name заполняется автоматически, в зависимости от выбранного имени компонента. Это путь куда будет сохранен ваш модуль.
- В поле Search Path ничего изменять не нужно.
- Теперь нажмите на кнопку Create Unit и получите следующее:

        unit CountBtn;
         
        interface
         
        uses
        Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
        StdCtrls;
         
        type
        TCountBtn = class(TButton)
        private
        { Private declarations }
        protected
        { Protected declarations }
        public
        { Public declarations }
        published
        { Published declarations }
         
        end;
         
        procedure Register;
         
        implementation
         
        procedure Register;
        begin
        RegisterComponents('MyComponents', [TCountBtn]);
        end;
         
        end.

**Шаг 3. Начинаем разбираться во всех директивах**

Что же здесь написано? да собственно пока ничего интересного. Здесь
объявлен новый класс TCountBtn и процедура регистрации вашего компонента
в палитре компонентов.

Директива Private. Здесь вы будете писать все скрытые поля которые вам
понадобятся для создания компонента. Так же в этой директиве описываются
процедуры и функции, необходимые для работы своего компонента, эти
процедуры и функции пользователю не доступны. Для нашего компонент мы
напишем туда следующее (запись должна состоять из буквы "F" имени
поля: тип этого поля):

    FCount:integer;

Буква "F" должна присутсвовать обязательно. Здесь мы создали скрытое
поле Count, в котором и будет храниться число кликов по кнопке.

Директива Protected. Обычно я здесь пишу различные обработчики событий
мыши и клавиатуры. Мы напишем здесь следующую строку:

    procedure Click; override;

Это указывает на то, что мы будем обрабатывать щелчок мыши по
компоненту. Слово "override" указывает на то, что мы перекроем
стандартное событие OnClick для компонента предка.

В директиве Public описываются те процедуры и функции компонента,
которые будут доступны пользователю. (Например, в процессе написания
кода вы пишите имя компонента, ставите точку и перед вами список
доступных функций, объявленных в диретиве Public). Для нашего
компонента, чтобы показать принцип использования этой директивы создадим
функцию - ShowCount, которая покажет сообщение, уведомляя пользователя
сколько раз он уже нажал на кнопку. Для этого в директиве Public напишем
такой код:

    procedure ShowCount;

Осталась последняя директива Published. В ней также используется
объявления доступных пользователю, свойств и методов компонента. Для
того, чтобы наш компонент появился на форме необходимо описать метод
создания компонента (конструктор), можно прописать и деструктор, но это
не обязательно. Следует обратить внимание на то, что если вы хотите,
чтобы какие-то свойства вашего компонента появились в Инспекторе
Объектов (Object Inspector) вам необходимо описать эти свойства в
директиве Published. Это делается так: property Имя\_свойства (но
помните здесь букву "F" уже не нужно писать), затем ставиться
двоеточие ":" тип свойства, read процедура для чтения значения, write
функция для записи значения;. Но похоже это все сильно запутано.
Посмотрите, что нужно написать для нашего компонента и все поймете:

    constructor Create(aowner:Tcomponent);override; //Конструктор
    property Count:integer read FCount write FCount; //Свойство Count 

Итак все объявления сделаны и мы можем приступить к написанию
непосредственно всех объявленных процедур.

**Шаг 4. Пишем процедуры и функции.**

Начнем с написания конструктора. Это делается примерно так:

    constructor TCountBtn.Create(aowner:Tcomponent);
    begin
    inherited create(Aowner);
    end;

Здесь в принципе понимать ничего не надо. Во всех своих компонентах я
писал именно это (только класс компонента менял и все). Также сюда можно
записывать любые действия, которые вы хотите сделать в самом начале
работы компонента, то есть в момент установки компонента на форму.
Например можно установить начальное значение нашего свойства Count. Но
мы этого делать не будем.

Теперь мы напишем процедуру обработки щелчка мышкой по кнопке:

    procedure Tcountbtn.Click;
    begin
    inherited click;
    FCount:=FCount+1;
    end; 

"Inherited click" означает, что мы повторяем стандартные методы
обработки щелчка мышью (зачем напрягаться и делать лишнюю работу:)).

У нас осталась последняя процедура ShowCount. Она может выглядеть
примерно так:

    procedure TCountBtn.ShowCount;
    begin
    Showmessage('По кнопке '+ caption+' вы сделали: '+inttostr(FCount)+' клик(а/ов)');
    end;

Здесь выводится сообщение в котором показывается количество кликов по
кнопке (к тому же выводится имя этой кнопки, ну это я добавил только с
эстетической целью).

И если вы все поняли и сделали правильно, то у вас должно получится
следующее:

    unit CountBtn;
     
    interface
     
    uses
    Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
    StdCtrls, ExtCtrls;
     
    type
    TCountBtn = class(TButton)
    private
    { Private declarations }
    FCount:integer;
    protected
    { Protected declarations }
    procedure Click;override;
    public
    { Public declarations }
    procedure ShowCount;
    published
    { Published declarations }
    property Count:integer read FCount write FCount;
    constructor Create(aowner:Tcomponent);override;
    end;
     
    procedure Register;
     
    implementation
     
    procedure Register;
    begin
    RegisterComponents('Mihan Components', [TCountBtn]);
    end;
     
    constructor TCountBtn.Create(aowner:Tcomponent);
    begin
    inherited create(Aowner);
    end;
     
    procedure Tcountbtn.Click;
    begin
    inherited click;
    FCount:=FCount+1;
    end;
     
    procedure TCountBtn.ShowCount;
    begin
    Showmessage('По кнопке '+ caption+' вы сделали: '+inttostr(FCount)+' клик(а/ов)');
    end;
    end. 

Скорее сохраняйтесь, дабы не потерять случайным образом байты набранного
кода:)).
 

**Шаг 5. Устанавливаем компонент**

Если вы сумели написать и понять, все то что здесь предложено, то
установка компонента не должна вызвать у вас никаких проблем. Все здесь
делается очень просто. В главном меню выберите пункт Component -\>
Install Component. перед вами открылось диалоговое окно Install
Component. В нем вы увидите две закладки: Into exsisting Package и Into
new Package. Вам предоставляется выбор установить ваш компонент в уже
существующий пакет или в новый пакет соответственно. Мы выберем в уже
существующий пакет.

В поле Unit File Name напишите имя вашего сохранненого модуля
(естественно необходимо еще и указать путь к нему), а лучше
воспользуйтесь кнопкой Browse и выберите ваш файл в открывшемся окне.

В Search Path ничего изменять не нужно, Делфьи сама за вас все туда
добавит.

В поле Package File Name выберите имя пакета, в который будет установлен
ваш компонент. Мы согласимся с предложенным по умолчанию пакетом.

Теперь нажимаем кнопочку Ok. И тут появиться предупреждение Package
dclusr30.dpk will be rebuilt. Continue? Дельфи спрашивает: "Пакет
такой-то будет изменен. Продолжить?". Конечно же надо ответить "Да".
И если вы все сделали правильно, то появиться сообщение, что ваш
компонент установлен. Что ж можно кричать Ура! Это ваш первый компонент.

**Создание свойств своего типа**

Теперь мы попробуем создать свойство нестандартного типа. Рассмотрим это
на примере метки - TLabel. У этого компонента есть такое свойство:
Alignment. Оно может принимать следующие значения: taLeftJustify,
taCenter, taRightJustify. Приступаем к созданию свойства. Ничего
интересного мне придумать не удалось, но тем не менее я вам покажу это
на примере того свойства, которое я придумал. Оно очень простое и
поможет вам разобраться. Свойство будет называться ShowType (тип
TShowTp), в нашем компоненте оно будет отвечать за отображение свойства
Count. Если пользователь установит свойство ShowType в Normal, то кнопка
будет работать, как и работала. А если пользователь присвоит этому
свойтсву значение CountToCaption, то количество кликов, будет
отображаться на самой кнопке.

Для начале нам необходимо объявить новый тип. Описание типа нужно
добавить после слова Type. Вот так это выглядело вначале:

    type
    TCountBtn = class(TButton) 

Вот так это должно выглядеть:

    type 
    TShowTp = (Normal, CountToCaption); 
    TCountBtn = class(TButton) 

Здесь мы объявили новый тип TShowTp, который может принимать только два
значения. Все значения, которые вы хотите добавить перечисляются через
запятую. Теперь нам понадобиться создать поле этого типа. Это мы уже
умеем и делать и поэтому не должно вызвать никаких сложностей. В
директиву Private напишите:

    FShowType:TShowTp; 

Мы создали поле ShowType, типа TShowTp.

Конечно же необходимо добавить это свойство в инспектор объектов:

    property ShowType: TshowTp read FshowType write FShowType;

Ну и наконец, чтобы наш компонент реагировал на изменение этого свойства
пользователем надо слегка изменить обработчик события OnClick. После
небольшой модификации он может иметь примерно такой вид:

    procedure Tcountbtn.Click;
    begin
    inherited click;
    FCount:=Fcount+1;
    if ShowType = Normal then
    Caption:=Caption;
    if ShowType = CountToCaption then
    Caption:='Count= '+inttostr(count);
    end; 

Объясню что произошло. Вначале мы увеличиваем счетчик на единицу. Затем
проверяем какое значение имеет свойство ShowType. Если Normal, то ничего
не делаем, а если CountToCaption, то в надпись на кнопке выводим
количество кликов. Не так уж и сложно как это могло показаться с первого
раза.

**Имплантируем таймер в компонент**

Очень часто бывает, что вам необходимо вставить в компонент,
какой-нибудь другой компонент, например, таймер. Как обычно будем
рассматривать этот процесс на конкретном примере. Сделаем так, что через
каждые 10 секунд значение счетчика кликов будет удваиваться. Для этого
мы встроим таймер в нашу кнопку. Нам понадобиться сделать несколько
несложных шагов.

После раздела uses, где описаны добавленные в программу модули, объявите
переменную типа TTimer. Назовем ее Timer. Приведу небольшой участок
кода:

    unit CountBtn;
     
    interface
     
    uses
    Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
    StdCtrls, ExtCtrls;
     
    var Timer: TTimer;
    type

Дальше в директиву Protected необходимо добавить обработчик события
OnTimer для нашего таймера. Это делается так:

    procedure OnTimer(Sender: TObject);

Поскольку наш таймер это не переменная, а компонент, его тоже надо
создать, для этого в конструктор нашей кнопки напишем:

    constructor TCountBtn.Create(aowner:Tcomponent);
    begin
    inherited create(Aowner);
    Timer:=TTimer.Create(self);
    Timer.Enabled:=true;
    Timer.OnTimer:=OnTimer;
    Timer.Interval:=10000;
    end; 

Здесь создается экземпляр нашего таймера и его свойству Iterval
(измеряется в миллисекундах) присваивается значение 10000 (то есть 10
секунд если по простому).

Собственно осталось написать саму процедуру OnTimer. Я сделал это так:

    procedure TCountBtn.OnTimer(Sender: TObject);
    begin
    FCount:=FCount*2;
    end; 
    Вот примерно то, что у вас должно получиться в конце: 
    unit CountBtn;
     
    interface
     
    uses
    Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
    StdCtrls, ExtCtrls;
     
    var Timer: TTimer;
    type
    TShowTp = (Normal, CountToCaption);
    TCountBtn = class(TButton)
     
    private
    { Private declarations }
     
    FCount:integer;
    FShowType:TShowTp;
    protected
    { Protected declarations }
    procedure OnTimer(Sender: TObject);
    procedure Click;override;
    public
    { Public declarations }
    procedure ShowCount;
    published
    { Published declarations }
    property Count:integer read FCount write FCount;
    constructor Create(aowner:Tcomponent);override;
    property ShowType: TshowTp read FshowType write FShowType;
    end;
     
    procedure Register;
     
    implementation
     
    procedure Register;
    begin
    RegisterComponents('Mihan Components', [TCountBtn]);
    end;
     
    constructor TCountBtn.Create(aowner:Tcomponent);
    begin
    inherited create(Aowner);
    Timer:=TTimer.Create(self);
    Timer.Enabled:=false;
    Timer.OnTimer:=OnTimer;
    Timer.Interval:=1000;
    end;
     
    procedure Tcountbtn.Click;
    begin
    inherited click;
    FCount:=Fcount+1;
    Timer.Enabled:=true;
    if ShowType = Normal then
    Caption:=Caption;
    if ShowType = CountToCaption then
    Caption:='Count= '+inttostr(count);
    end;
     
    procedure TCountBtn.ShowCount;
    begin
    Showmessage('По кнопке '+ caption+' вы сделали: '+inttostr(FCount)+' клик(а/ов)');
    end;
     
    procedure TCountBtn.OnTimer(Sender: TObject);
    begin
    FCount:=FCount*2;
    end;
     
    end. 

Если у вас что-то не сработало, то в начале проверьте все ли у вас
написано правильно. Затем проверьте может у вас не хватает какого-нибудь
модуля в разделе Uses.

**Переустановка компонента**

Очень часто бывает необходимо переустановить ваш компонент. Если вы
попробуете сделать это путем выбора Component-\>Install Component, то
Дельфи вас честно предупредит о том, что пакет уже содержит модуль с
таким именем. Перед вами открывается окно с содержимым пакета. В нем вы
должны найти имя вашего компонента и удалить его (либо нажать кнопочку
Remove). Теперь в пакете уже нет вашего компонента. Затем проделайте
стандартную процедуру по установке компонента.

Редактирование значения, которое ввел пользователь, изменяя какое-нибудь
свойство.

Простой пример. Допустим у нас есть компонент (основанный на Tedit), у
него есть два свойства: FirstNumber и SecondNumber. И у него есть
процедура Division, в которой первое число делится на второе и результат
присаивается свойству текст нашего компонента. Вот код этого компонента:

     
    unit DivEdit;
     
    interface
     
    uses
    Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
    StdCtrls;
     
    type
    TDivEdit = class(Tedit)
    private
    { Private declarations }
    FFirstNumber:integer;
    FSecondNumber:integer;
    FResult:Single; //в компонентах нельзя использовать Real!!!
    protected
    { Protected declarations }
    public
    { Public declarations }
    procedure Division;
    published
    { Published declarations }
    constructor create(aowner:Tcomponent);override;
    property FirstNumber:integer read FFirstNumber write FFirstNumber;
    property SecondNumber:integer read FSecondNumber write FSecondNumber;
    property Result:Single read Fresult write FResult;
    end;
     
    procedure Register;
     
    implementation
     
    Constructor TDivEdit.create(aowner:Tcomponent);
    begin
    inherited create(aowner);
    FFirtsNumber:=1;
    FSecondNumber:=1;
    end;
     
    procedure TDivEdit.Division;
    begin
    FResult:=FFirstNumber/FSecondNumber;
    text:=floattostr(FResult);
    end;
     
    procedure Register;
    begin
    RegisterComponents('Mihan Components', [TDivEdit]);
    end;
     
    end.

Хочется обратить ваше внимание на то, что в компонентах нельзя
использовать переменные и поля типа Real, вместо него нужно брать
переменные типов Single, Double, Extended.

Здесь все просто. Но вот если пользователю вздумается поделить на ноль
(ну вдруг он математики не знает), то компонент выдаст ошибку
DivisionByZero, а кому они нужны. Обойти эту проблему можно так: в код
компонента добавить процедуру, которая проанализирует данные введенные
пользователь и если все будет в порядке, то она присвоит значения
соответствующим свойтсвам. В директиве Private объявите такую процедуру:

    procedure SetSecondNumber(value:integer);

Обычно такие процедуры начинаются с приставки Set, затем идет имя
свойства, и в конце тип переменной. Теперь в директиве Published надо
сделать небольшие изменения:

    property SecondNumber:integer read FSecondNumber write SetSecondNumber;

А теперь напишем саму процедуру:

    procedure TDivEdit.SetSecondNumber(value:Integer);
    begin
    if value<>FSecondNumber then //надо проверить совпадают ли исходное и вводимое значения
    FSecondNumber:=value; //если нет, то изменить значение
    if FSecondNumber=0 then
    FSecondNumber:=1;
    end;

Теперь сколько бы пользователь не вводил нулей значение SecondNumber
будет единицей. Такие процедуры проверки рекомендуется использовать
везде, где только допустимо появление исключительной ситуации.


**Использование другого компонента в вашем**

Попробуем создать такой компонент. Это будет обычная метка (Label), у
которой будет две процедуры: ChangeBackColor и ChangeFontColor, которые
соответственно будут менять цвет фона метки и цвет текста. Для этого нам
понадобиться ColorDialog, который будет создаваться вместе с
компонентом, а потом с помощью процедур он будет активироваться. Назовем
компонент ColorLabel. Вначале добавим в uses два модуля: Dialogs,
StdCtrls (в них находятся описания классаов диалога и метки). Теперь нам
надо объявить переменную типа TColorDialog. Объявление идет сразу после
секции Uses.

Примерно это выглядит так:

    uses
    Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,StdCtrls;
    var ColorDialog:TColorDialog;
    type
    ...

Теперь в конструкторе (Create), нам надо создать этот компонент:

    constructor TColorLabel.create(aowner:Tcomponent);
    begin
    Inherited Create(aowner);
    ColorDialog:=TColorDialog.Create(self);
    end;

Теперь надо объявить процедуры ChangeBackColor, ChangeFontColor. Чтобы
они были доступны пользователю их надо поместить в директиву Public:

    public
    { Public declarations }
    procedure ChangeBackColor;
    procedure ChangeFontColor;
    published 

Осталось написать сами процедуры. Все очень просто: открываете диалог
методом Execute, а затем присваиваете полученное значение цвета метке. У
меня эти процедуры имеют такой вид:

    procedure TColorLabel.ChangeBackColor;
    begin
    if ColorDialog.Execute then
    color:=ColorDialog.color;
    end;
     
    procedure TColorLabel.ChangeFontColor;
    begin
    if ColorDialog.Execute then
    font.color:=ColorDialog.color;
    end;
    Если у вас вдруг что-то не получилось, то взгляните на мой код целиком:
    unit ColorLabel;
     
    interface
     
    uses
    Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,StdCtrls;
    var ColorDialog:TColorDialog;
    type
    TColorLabel = class(Tlabel)
    private
    { Private declarations }
    protected
    { Protected declarations }
    public
    { Public declarations }
    procedure ChangeBackColor;
    procedure ChangeFontColor;
    published
    { Published declarations }
    constructor create(aowner:tcomponent);override;
    end;
     
    procedure Register;
     
    implementation
     
    constructor TColorLabel.create(aowner:Tcomponent);
    begin
    Inherited Create(aowner);
    ColorDialog:=TColorDialog.Create(self);
    end;
     
    procedure TColorLabel.ChangeBackColor;
    begin
    if ColorDialog.Execute then
    color:=ColorDialog.color;
    end;
     
    procedure TColorLabel.ChangeFontColor;
    begin
    if ColorDialog.Execute then
    font.color:=ColorDialog.color;
    end;
     
    procedure Register;
    begin
    RegisterComponents('Mihan Components', [TColorLabel]);
    end;
    end.

**Доступ к свойствам другого компонента**

Сейчас нам предстоит более сложная задача. Мы будем создавать компонент,
вместе с которым будет создаваться какой-нибудь визуальный компонент.
Например создадим кнопку, которая будет сопровождаться поясняющей
надписью сверху. За основу возмем тип TButton. Нам надо будет создать
еще и Label. Здесь существует одна проблемка: при перемещении компонента
по форме, метка должна двигаться вместе с кнопкой, поэтому нам придется
обрабатывать сообщение WmMove. Итак, объявляем переменную Label (в
данном примере она объявлена в директиве Private, что тоже допустимо):

    uses
    SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics, Controls,
    Forms, Dialogs, StdCtrls,buttons;
     
    type
    TLabelButton = class(TButton)
    private
    FLabel : TLabel ;

Теперь я приведу весь код этого компонента и походу буду вставлять
необходимые пояснения:

    unit LabelBtn;
    interface
     
    uses
    SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics, Controls,
    Forms, Dialogs, StdCtrls,buttons;
     
    type
    TLabelButton = class(TButton)
    private
    FLabel : TLabel ; {создаем поле типа Tlabel}
    procedure WMMove( var Msg : TWMMove ) ; message WM_MOVE ;{процедура для обработки сообщения Wm_move, чтобы метка перемещалась вместе с кнопкой}
    protected
    procedure SetParent( Value : TWinControl ) ; override ;{необходимо воспользоваться и этой процедурой, так как нужно убедиться, имеют ли кнопка и метка общего предка}
    function GetLabelCaption : string ; virtual ; {Вот пример доступа из компонента к свойствам другого. Эти две процедуры для изменения текста метки}
    procedure SetLabelCaption( const Value : string ) ; virtual ;
    public
    constructor Create( AOwner : TComponent ) ; override ;
    destructor Destroy ; override ;
    published
    property LabelCaption : string read GetLabelCaption write
    SetLabelCaption ;
    end;
     
    procedure Register;
     
    implementation
     
    constructor TLabelButton.Create( AOwner : TComponent ) ;
    begin
    inherited Create( AOwner ) ;
    { создаем TLabel }
    FLabel := TLabel.Create( NIL ) ;
    FLabel.Caption := 'Описание:' ;
    end ;
     
    procedure TLabelButton.SetParent( Value : TWinControl ) ;
    begin
    {надо убедиться, что у них предок один, чтоб проблем потом не было}
    if ( Owner = NIL ) or not ( csDestroying in Owner.ComponentState ) then
    FLabel.Parent := Value ;
    inherited SetParent( Value ) ;
    end ;
     
    destructor TLabelButton.Destroy ;
    begin
    if ( FLabel <> NIL ) and ( FLabel.Parent = NIL ) then
    FLabel.Free ;{Уничтожаем метку, т.к. она нам больше не нужна}
    inherited Destroy ;
    end ;
     
    function TLabelButton.GetLabelCaption : string ;
    begin
    Result := FLabel.Caption ;
    end ;
     
    procedure TLabelButton.SetLabelCaption( const Value : string ) ;
    begin
    FLabel.Caption := Value ;
    end ;
     
    procedure TLabelButton.WMMove( var Msg : TWMMove ) ;
    begin
    inherited ;
    if FLabel <> NIL then with Flabel do
    SetBounds( Msg.XPos, Msg.YPos - Height, Width,Height ) ; {изменяем левое и верхнее положение метки исходя из полученных координат}
    end;
     
    procedure Register;
    begin
    RegisterComponents('Mihan Components', [TLabelButton]);
    end;
     
    initialization
    RegisterClass( TLabel ) ; {Это делается для обеспечения поточности, но об этом не думайте, этим редко придется пользоваться}
    end.{Вы можете пользоваться этим компонентом сколько угодно, но распространять его можно только указывая авторство}

Можно сделать доступ к любым свойствам метки, например, к шрифту, цвету
и так далее, используя необходимые процедуры.

**Использование в качестве предка класс TWinControl**

Предыдущий пример был очень сложным, к тому же пришлось обрабатывать
системные сообщения. Есть другое решение этой проблемы, более простое
для понимания и для реализации: использовать в качестве контейнера класс
TWinControl и в этот контейнер помещать другие компоненты. Теперь
попробуем совместить Edit и Label. Давайте вместе создадим такой
компонент. В качестве предка нужно выбрать класс TWinControl, а в
качестве типа вашего компонента выберите TlabelEdit. Будем разбирать код
по кусочкам.

    unit LabelEdit;
    interface
    uses
    SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics, Controls, 
    Forms, Dialogs, stdctrls; 
    type 
    TLabelEdit = class(TWinControl) 
    private 
    { Private declarations } 
    FEdit: TEdit; 
    FLabel: TLabel; 
    //Здесь объявляются поля для метки и для Edita. 
    function GetLabelCaption: string; 
    procedure SetLabelCaption(LabelCaption: string); 
    function GetEditText: string; 
    procedure SetEditText(EditText: string); 
    //Здесь объявлены функции для работы со свойствами Caption у метки и Text у Edita.
    protected 
    { Protected declarations } 
    public 
    { Public declarations } constructor Create(AOwner: TComponent); override; published 
    property LabelCaption: string read GetLabelCaption write SetLabelCaption; 
    property EditText: string read GetEditText write SetEditText; 
    { Published declarations } 
    end; 
     
    procedure Register;
     
    implementation
     
    constructor TLabelEdit.Create(AOwner: TComponent);
    begin
    inherited Create(AOwner); 
    FEdit := TEdit.Create(self);{создаем поле редактирования Edit} 
    FLabel := TLabel.Create(self);{создаем Label} 
    with FLabel do begin 
    Width := FEdit.Width; 
    visible := true; 
    Parent := self; 
    Caption := 'Описание:'; 
    end; 
    with FEdit do begin 
    Top := FLabel.Height+2; 
    Parent := self; 
    Visible := true; 
    end; 
    Top := 0;
    Left := 0; 
    Width := FEdit.Width; 
    Height := FEdit.Height+FLabel.Height;{определяются размеры и положение компонентов} 
    Visible := true; 
    end;
     
    function TLabelEdit.GetLabelCaption: string;
    begin 
    Result := FLabel.Caption; 
    end;
     
    procedure TLabelEdit.SetLabelCaption(LabelCaption: string);
    begin 
    FLabel.Caption := LabelCaption; 
    end;
     
    function TLabelEdit.GetEditText: string;
    begin 
    Result := FEdit.Text; 
    end;
     
    procedure TLabelEdit.SetEditText(EditText: string);
    begin 
    FEdit.Text := EditText; 
    end;
     
    procedure Register;
    begin 
    RegisterComponents('Mihan Components', [TLabelEdit]); 
    end;
     
    end. 

Попробуйте установить этот компонент. Когда вы будете размещать его на
форме, то будет виден "контейнер", на котором располагаются Edit и
Label. Использование в качестве предка компонента класса TWinControl,
очень удобно если вы хотите объединить несколько визуальных компонентов.


**Обработка событий OnMouseDown, OnMouseMove и OnMouseUp**

Часто возникает необходимость обработки событий нажатия и отпускания
кнопки в вашем компоненте. Сейчас мы это и рассмотрим. Только ради
примера сделаем компонент, который будет считать количество нажатий и
отпусканий кнопки в его области, допустим это будет панель (Tpanel). Для
этого в директиве Private надо объявить следующие процедуры и поля:

    FClickCount:integer;
    FUpCount:integer;
    procedure MouseDown(Button:TMouseButton; Shift: TShiftState; X,Y: Integer); override;
    procedure MouseMove(Shift: TShiftState; X, Y: Integer); override;
    procedure MouseUp(Button:TMouseButton; Shift:TShiftState; X, Y: Integer); override;

А в директиве Published надо написать:

    constructor create(aowner:tcomponent);override;
    property ClickCount:integer read FclickCount write FClickCount;
    property UpCount:integer read FUpCount write FUpCount;
    property OnMouseDown;
    property OnMouseMove;
    property OnMouseUp;

Ну и теперь осталось описать нужные процедуры:

    procedure TMpanel.MouseDown(Button:TMouseButton; Shift: TShiftState; X,Y: Integer);
    begin
    FClickCount:=FClickCount+1;
    end;
     
    procedure TMpanel.MouseMove(Shift: TShiftState; X, Y: Integer);
    begin
    caption:=inttostr(x)+' '+inttostr(y);{для демонстрации работы этой процедуры. Надпись на панели будет отражать координаты курсора мыши над этой панелью}
    end;
     
    procedure TMpanel.MouseUp(Button:TMouseButton; Shift:TShiftState; X, Y: Integer);
    begin
    FUpCount:=FUpCount+1;
    end;

Таким образом весь код компонента был таким:

    unit Mpanel;
     
    interface
     
    uses
    Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
    ExtCtrls;
     
    type
    TMpanel = class(TPanel)
    private
    { Private declarations }
    FClickCount:integer;
    FUpCount:integer;
    procedure MouseDown(Button:TMouseButton; Shift: TShiftState; X,Y: Integer); override;
    procedure MouseMove(Shift: TShiftState; X, Y: Integer); override;
    procedure MouseUp(Button:TMouseButton; Shift:TShiftState; X, Y: Integer); override;
     
    protected
    { Protected declarations }
    public
    { Public declarations }
    published
    { Published declarations }
    constructor create(aowner:tcomponent);override;
    property ClickCount:integer read FclickCount write FClickCount;
    property UpCount:integer read FUpCount write FUpCount;
    property OnMouseDown;
    property OnMouseMove;
    property OnMouseUp;
    end;
     
    procedure Register;
     
    implementation
     
    constructor TMpanel.create(aowner:Tcomponent);
    begin
    inherited create(aowner);
    end;
     
    procedure TMpanel.MouseDown(Button:TMouseButton; Shift: TShiftState; X,Y: Integer);
    begin
    FClickCount:=FClickCount+1;
    end;
     
    procedure TMpanel.MouseMove(Shift: TShiftState; X, Y: Integer);
    begin
    caption:=inttostr(x)+' '+inttostr(y);
    end;
     
    procedure TMpanel.MouseUp(Button:TMouseButton; Shift:TShiftState; X, Y: Integer);
    begin
    FUpCount:=FUpCount+1;
    end;
     
    procedure Register;
    begin
    RegisterComponents('Mihan Components', [TMpanel]);
    end;
     
    end.

**Создание и использование своей иконки для компонента**

Когда вы создали свой компонент и установили его, та на палитре
компонентов, его иконка будет такой же как и у компонента, который вы
выбрали в качестве предка. Конечно же вам хотелось бы видеть свой
компонент со своей иконкой. Для этого необходимо создать файл ресурсов
компонента. Сейчас я расскажу вам как это делается.

Откройте Image Editor (Tools-\>Image Editor) и выберите
File-\>New-\>Component Resourse File. Перед вами появится небольшое окно
с надписью Untitled.dcr в нем будет только одно слово: Contents. Нажмите
на него правой кнопкой и в появившемся меню выберите New-\>Bitmap.
Откроется диалоговое окно для настройки параметров изображения. Они
должны быть такими: Размер 32x32, цветовой режим VGA (16 colors). Теперь
нажмите ok. Теперь надо нажать правой кнопкой на появившейся надписи
Bitmap1 и выбрать пункт Rename. Название картинки должно совпадать с
названием класса компонента, для которого вы делаете эту иконку
(например, TMPanel). Нажмите два раза на Bitmap1 и перед вами появится
окно для рисования. Нарисуйте, что вам надо и перейдите на окно с
надписью Untitled.dcr и в меню File выберите Save. Имя файла ресурса
компонента должно совпадать с именем модуля компонента (без расширения
конечно же, например, Mpanel). Файл ресурса готов. Теперь установите ваш
компонент заново и в палитре компонентов ваш компонент будет уже с новой
иконкой.


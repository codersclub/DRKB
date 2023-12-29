---
Title: Теория и практика использования RTTI
Date: 01.01.2007
---


Теория и практика использования RTTI
====================================

::: {.date}
01.01.2007
:::

Delphi --- это мощная среда визуальной разработки программ сочетающая в
себе весьма простой и эффективный язык программирования, удивительный по
быстроте компилятор и подкупающую открытость (в состав Delphi входят
исходные тексты стандартных модулей и практически всех компонент
библиотеки VCL). Однако, как и на солнце, так и в Delphi существуют
пятна (на солнце черные, а в Delphi --- белые), пятна
недокументированных (или почти не документированных) возможностей. Одно
из таких пятен --- это информация о типах времени исполнения и методы
работы с ней.

Информация о типах времени исполнения.(Runtime Type Information, RTTI)
---это данные, генерируемые компилятором Delphi о большинстве объектов
вашей программы. RTTI представляет собой возможность языка,
обеспечивающее приложение информацией об объектах (его имя, размер
экземпляра, указатели на класс-предок, имя класса и т. д.) и о простых
типах во время работы программы. Сама среда разработки использует RTTI
для доступа к значениям свойств компонент, сохраняемых и считываемых из
dfm-файлов и для отображения их в Object Inspector,

Компилятор Delphi генерирует runtime информацию для простых типов,
используемых в программе, автоматически. Для объектов, RTTI информация
генерируется компилятором для свойств и методов, описанных в секции
published в следующих случаях:

Объект унаследован от объекта, дня которого генерируется такая
информация. В качестве примера можно назвать объект TPersistent.

Декларация класса обрамлена директивами компилятора {$M+} и {$M-}.

Необходимо отметить, что published свойства ограничены по типу данных.
Они могут быть перечисляемым типом, строковым типом, классом,
интерфейсом или событием (указатель на метод класса). Также могут
использоваться множества (set), если верхний и нижний пределы их
базового типа имеют порядковые значения между 0 и 31 (иначе говоря,
множество должно помещаться в байте, слове или двойном слове). Также
можно иметь published свойство любого из вещественных типов (за
исключением Real48). Свойство-массив не может быть published. Все методы
могут быть published, но класс не может иметь два или более
перегруженных метода с одинаковыми именами. Члены класса могут быть
published, только если они являются классом или интерфейсом.

Корневой базовый класс для всех VCL объектов и компонент, TObject,
содержит ряд методов для работы с runtime информацией. Наиболее часто
используемые из них приведены в таблице 1.

Наиболее часто используемые методы класса TObject для работы с RTTI

Метод Описание

ClassType Возвращает тип класса объекта. Вызывается неявно компилятором
при определении типа объекта при использовании операторов is и as

ClassName Возвращает строку, содержащую название класса объекта.
Например, для объекта типа TForm вызов этой функции вернет строку
\"TForm\"

ClassInfo Возвращает указатель на runtime информацию объекта

InstanceSize Возвращает размер конкретного экземпляра объекта в байтах.

Object Pascal предоставляет в распоряжение программиста два оператора,
работа которых основана на неявном для программиста использовании RTTI
информации. Это операторы is и as. Оператор is предназначен для проверки
соответствия экземпляра объекта заданному объектному типу. Так,
выражение вида:

    AObject is TSomeObjectType

является истинным в том случае, если объект AObject является экземпляром
класса TSomeObjectType или одного из порожденных от него классов.
Следует отметить, что определенная проверка происходит еще на этапе
компиляции программы. если фактические объект и класс несовместимы,
компилятор выдаст ошибку в этом операторе. Так, следующий программный
код

    if Edit1 is TForm then ShowMessage('Враки!');

даже не будет пропущен компилятором, и он выдаст сообщение о не
совместимости типов (разумеется, что Edit1 --- это компонент типа
TEdit):

Incompatible types: \'TForm\' and \'TEdit\'.

Перейдем теперь к оператору as. Он введен в язык специально для
приведения объектных типов. Посредством него можно рассматривать
экземпляр объекта как принадлежащий к другому совместимому типу:

    AObject as TSomeObjectType

Использование оператора as отличается от обычного способа приведения
типов

    TSomeObjectType(AObject)

наличием проверки на совместимость типов. Так при попытке приведения
этого оператора с несовместимым типом он сгенерирует исключение
EInvalidCast. Определенным недостатком операторов is и as является то,
что присваиваемый фактически тип должен быть известен на этапе
компиляции программы и поэтому на месте TSomeObjectType не может стоять
переменная указателя на класс.

Для иллюстрации только что написанного рассмотрим небольшой пример.
Предположим у вас на форме имеется ряд компонент типа TEdit, и вы хотите
реализовать их очистку их свойств перед созданием формы. С применением
RTTI это можно сделать следующим программным кодом:

    var
      I: Integer;
    begin
      for I := 0 to ComponentCount - 1 do
        if Components[I] is TEdit then
          (Components[I] as TEdit).Text := '';
          { или так TEdit (Components[I]).Text := ''; }
    end;

Хочу обратить ваше внимание, а то, что стандартное приведение типа в
данном примере предпочтительнее, поскольку в операторе if мы уже
установили что компонент является объектом нужного нам типа и
дополнительная проверка соответствия типов, проводимая оператором as,
нам уже не нужна.

Первые шаги в понимании RTTI мы уже сделали. Теперь переходим к
подробностям. Все основополагающие определения типов, основные функции и
процедуры для работы с runtime информацией находятся в модуле TypInfo.
Этот модуль содержит две фундаментальные структуры для работы с RTTI ---
TTypeInfo и TTypeData (типы указателей на них --- PTypeInfo и PTypeData
соответственно). Суть работы с RTTI выглядит следующим образом. Получаем
указатель на структуру типа TTypeInfo (для объектов указатель можно
получить, вызвав метод, реализованный в TObject, ClassInfo, а для
простых типов в модуле System существует функция TypeInfo). Затем,
посредством имеющегося указателя и вызова функции GetTypeData получаем
указатель на структуру типа TTypeData. Далее используя оба указателя и
функции модуля TypInfo творим маленькие чудеса. Для пояснения
написанного выше рассмотрим пример получения текстового вида значений
перечисляемого типа. Пусть, например, это будет тип TBrushStyle. Этот
тип описан в модуле Graphics следующим образом:

    TBrushStyle = (bsSolid, bsClear, bsHorizontal, bsVertical, 
      bsFDiagonal, bsBDiagonal, bsCross, bsDiagCross);

Вот мы и попробуем получить конкретные значения этого типа в виде
текстовых строк. Для этого создайте пустую форму. Поместите на нее
компонент типа TListBox с именем ListBox1 и кнопку. Реализацию события
OnClick кнопки замените следующим кодом:

    var
      ATypeInfo: PTypeInfo;
      ATypeData: PTypeData;
      I: Integer;
      S: string;
    begin
      ATypeInfo := TypeInfo(TBrushStyle);
      ATypeData := GetTypeData(ATypeInfo);
      for I := ATypeData.MinValue to ATypeData.MaxValue do
      begin
        S := GetEnumName(ATypeInfo, I);
        ListBox1.Items.Add(S);
      end;
    end;

Ну вот, теперь, когда на вооружении у нас есть базовые знания о
противнике, чье имя, на первый взгляд выглядит непонятно и пугающее ---
RTTI настало время большого примера. Мы приступаем к созданию объекта
опций для хранения различных параметров, использующего в своей работе
мощь RTTI на полную катушку. Чем же примечателен, будет наш будущий
класс? А тем, что он реализует сохранение в ini-файл и считывание из
него свои свойства секции published. Его потомки будут иметь способность
сохранять свойства, объявленные в секции published, и считывать их, не
имея для этого никакой собственной реализации. Надо лишь создать
свойство, а все остальное сделает наш базовый класс. Сохранение свойств
организуется при уничтожении объекта (т.е. при вызове деструктора
класса), а считывание и инициализация происходит при вызове конструктора
класса. Декларация нашего класса имеет следующий вид:

    {$M+}
    TOptions = class(TObject)
      protected
        FIniFile: TIniFile;
        function Section: string;
        procedure SaveProps;
        procedure ReadProps;
      public
        constructor Create(const FileName: string);
        destructor Destroy; override;
    end;
    {$M-}

Класс TOptions является производным от TObject и по этому, что бы
компилятор генерировал runtime информацию его надо объявлять директивами
{$M+/-}. Декларация класса весьма проста и вызвать затруднений в
понимании не должна. Теперь переходим к реализации методов.

    constructor TOptions.Create(const FileName: string);
    begin
      FIniFile:=TIniFile.Create(FileName);
      ReadProps;
    end;
     
    destructor TOptions.Destroy;
    begin
      SaveProps;
      FIniFile.Free;
      inherited Destroy;
    end;

Как видно реализация конструктора и деструктора тривиальна. В
конструкторе мы создаем объект для работы с ini-файлом и организуем
считывание свойств. В деструкторе мы в сохраняем значения свойств в файл
и уничтожаем файловый объект. Всю нагрузку по реализации сохранения и
считывания published-свойств несут методы SaveProps и ReadProps
соответственно.

     
    procedure TOptions.SaveProps;
    var
      I, N: Integer;
      TypeData: PTypeData;
      List: PPropList;
    begin
      TypeData:= GetTypeData(ClassInfo);
      N:= TypeData.PropCount;
      if N <= 0 then
        Exit;
      GetMem(List, SizeOf(PPropInfo)*N);
      try
        GetPropInfos(ClassInfo,List);
        for I:= 0 to N - 1 do
          case List[I].PropType^.Kind of
            tkEnumeration, tkInteger:
              FIniFile.WriteInteger(Section, List[I]^.name,GetOrdProp(Self,List[I]));
            tkFloat:
              FIniFile.WriteFloat(Section, List[I]^.name, GetFloatProp(Self, List[I]));
            tkString, tkLString, tkWString:
              FIniFile.WriteString(Section, List[I]^.name, GetStrProp(Self, List[I]));
          end;
      finally
        FreeMem(List,SizeOf(PPropInfo)*N);
      end;
    end;
     
     
    procedure TOptions.ReadProps;
    var
      I, N: Integer;
      TypeData: PTypeData;
      List: PPropList;
      AInt: Integer;
      AFloat: Double;
      AStr: string;
    begin
      TypeData:= GetTypeData(ClassInfo);
      N:= TypeData.PropCount;
      if N <= 0 then
        Exit;
      GetMem(List, SizeOf(PPropInfo)*N);
      try
        GetPropInfos(ClassInfo, List);
        for I:= 0 to N - 1 do
          case List[I].PropType^.Kind of
            tkEnumeration, tkInteger:
            begin
              AInt:= GetOrdProp(Self, List[I]);
              AInt:= FIniFile.ReadInteger(Section, List[I]^.name, AInt);
              SetOrdProp(Self, List[i], AInt);
            end;
            tkFloat:
            begin
              AFloat:=GetFloatProp(Self,List[i]);
              AFloat:=FIniFile.ReadFloat(Section, List[I]^.name,AFloat);
              SetFloatProp(Self,List[i],AFloat);
            end;
            tkString, tkLString, tkWString:
            begin
              AStr:= GetStrProp(Self,List[i]);
              AStr:= FIniFile.ReadString(Section, List[I]^.name, AStr);
              SetStrProp(Self,List[i], AStr);
            end;
          end;
      finally
        FreeMem(List,SizeOf(PPropInfo)*N);
      end;
    end;
     
    function TOptions.Section: string;
    begin
      Result := ClassName;
    end;

Теперь, для проверки работоспособности, и отладки объекта опций создадим
новое приложение и подключим к нему модуль, в котором описан и
реализован объект TOptions. Ниже приведен программный код,
иллюстрирующий создание наследника от класса TOptions и его
использования в главной (и единственной) форме нашего тестового
приложения интерфейсная часть выглядит так:

    TMainOpt = class(TOptions)
      private
        FText: string;
        FHeight: Integer;
        FTop: Integer;
        FWidth: Integer;
        FLeft: Integer;
        procedure SetText(const Value: string);
        procedure SetHeight(Value: Integer);
        procedure SetLeft(Value: Integer);
        procedure SetTop(Value: Integer);
        procedure SetWidth(Value: Integer);
      published
        property Text: string read FText write SetText;
        property Left: Integer read FLeft write SetLeft;
        property Top: Integer read FTop write SetTop;
        property Width: Integer read FWidth write SetWidth;
        property Height: Integer read FHeight write SetHeight;
    end;
     
    TForm1 = class(TForm)
        Edit1: TEdit;
        procedure Edit1Change(Sender: TObject);
      private
        FMainOpt: TMainOpt;
      public
        constructor Create(AOwner: TComponent); override;
        destructor Destroy; override;
    end;

А вот и реализация:

    constructor TForm1.Create(AOwner: TComponent);
    var
      S: string;
    begin
      inherited Create(AOwner);
      S := ChangeFileExt(Application.ExeName, '.ini');
      FMainOpt := TMainOpt.Create(S);
      Edit1.Text := FMainOpt.Text;
     
      Left := FMainOpt.Left;
      Top := FMainOpt.Top;
      Width := FMainOpt.Width;
      Height := FMainOpt.Height;
    end;
     
    destructor TForm1.Destroy;
    begin
      FMainOpt.Left := Left;
      FMainOpt.Top := Top;
      FMainOpt.Width := Width;
      FMainOpt.Height := Height;
      FMainOpt.Free;
      inherited Destroy;
    end;
     
    { TMainOpt }
     
    procedure TMainOpt.SetText(const Value: string);
    begin
      FText := Value;
    end;
     
    procedure TForm1.Edit1Change(Sender: TObject);
    begin
      FMainOpt.Text := Edit1.Text;
    end;
     
    procedure TMainOpt.SetHeight(Value: Integer);
    begin
      FHeight := Value;
    end;
     
    procedure TMainOpt.SetLeft(Value: Integer);
    begin
      FLeft := Value;
    end;
     
    procedure TMainOpt.SetTop(Value: Integer);
    begin
      FTop := Value;
    end;
     
    procedure TMainOpt.SetWidth(Value: Integer);
    begin
      FWidth := Value;
    end;

В заключение своей статьи хочу сказать, что RTTI является
недокументированной возможностью Object Pascal и поэтому информации на
эту тему в справочной системе и электронной документации весьма мало.
Наиболее легкодоступный способ изучить более подробно эту фишку ---
просмотр и изучение исходного текста модуля TypInfo.

Взято с <https://delphiworld.narod.ru>

---
Title: Вызов MapInfo и встраивание его в свою программу
Author: Дмитрий Кузан
Date: 01.01.2007
---


Вызов MapInfo и встраивание его в свою программу
================================================

::: {.date}
01.01.2007
:::

Автор: Дмитрий Кузан

Доброе время суток !

Данной статьей я начинаю цикл статей посвященных возможностям
интегрированной картографии MapInfo и возможности встраивания
геоинформационной системы в вашу программу. Примечания : Все примеры
распространяются свободно и разработаны в обучающих целях на Delphi 6.
Всю информацию по работе смотрите в прилагаемых исходных кодах.

Итак начнем.

Что такое MapInfo и с чем его едят? Краткое предисловие.

Сейчас нам доступны огромные объемы информации. Данные хранятся в
электронных таблицах, отчетности о торговле и маркетинге. Масса
информации о клиентах, магазинах, персонале, оборудовании и ресурсах
находится на бумаге и в памяти компьютеров Тематическая Карта,
содержащая слой диапазонов (процент занятости) и круговые диаграммы
(производство с/х продуктов) Почти все эти данные имеют географическую
составляющую. По разным оценкам до 85 процентов всех баз данных
содержат, какую либо географическую информацию.

При этой оценке учитывались объемы данных, содержащие адреса, имена
городов, названия областей, государств, почтовые индексы и даже номера
телефонов, включая коды удаленного доступа и добавочные номера.
Настольная картография позволит Вашему компьютеру не просто обрабатывать
данные, а быстро и наглядно представлять их, используя географические
компоненты данных, чтобы Вы могли уловить их общий смысл, отражаемый на
картах.

Как настольная картография может работать на Вас? MapInfo, как средство
настольной картографии, - это мощное средство анализа данных. Вы можете
придать графический вид статистическим и прочим данным. Вы можете
отобразить Ваши данные как точки, как тематически выделенные области,
круговые и столбчатые графики, районы и т.п. К данным можно применять
географические операторы, такие как районирование, комбинация и
разрезание объектов и буферизация. Доступ к данным можно оформлять как
запросы, в том числе к удаленным базам данных непосредственно из
MapInfo. Например, какой из магазинов ближе к самым крупным клиентам
Вашей фирмы? На карте легко увидеть особенности и тенденции, которые
практически невозможно выявить в списочно организованных данных. Можно
легко вычислить расстояния между клиентами и магазинами; можно увидеть
местоположение офиса клиента, потратившего наибольшую сумму за прошлый
год; размер символов, отмечающих местоположение магазинов на Карте,
может зависеть от объема продаж. Все это делает визуализацию Ваших
данных более наглядной. Итак краткое предисловие из руководства
пользователя дает вам общее представление об MapInfo.

Что такое интегрированная картография и какой нам от нее смысл.

Интегрированная картография позволяет управлять пакетом MapInfo,
используя языки программирования отличные от MapBasic. Например если вам
хорошо знакомо программирование на языке Visual Basic или С++ или Delphi
(о чем и пойдет речь далее...) вы можете включить окно MapInfo в ваше
приложение, тем самым обеспечивая интеграцию пакета MapInfo с логикой
(бизнес-правилами) вашей программы.

Причем основную работу по поддержанию векторных карт берет на себя
MapInfo (MapBasic) а вы можете создовать назначать обработчики и
механизмы взаимодействия не свойственные MapBasic а также те механизмы
которые MapBasic не поддерживает напрямую (например обновление карты по
интернету,съем информации с датчиков на территории и обновление на карте
ит.п.)

Итак приступим : в цикле статей будут рассмотрены следующие вещи

Соединение и загрузка MapInfo

Встраивание окна MapInfo и других окон (легенда, информация и т.д) в
программу на Delphi

Отправка команд MapBasic в пакет MapInfo

Получение информации от MapInfo посредством функций

Использование уведомляющих вызовов (CallBack) и подключение их к своей
программе.

Создание собственных уведомляющих вызовов

Переопределение уведомляющих вызовов

Обработка уведомляющих вызовов

Создание простейшего компонента (возможно данная тема будет затрунута)
для управления MapInfo.

и многое другое.

Концепции Интегрированной Картографии

Для создания приложения с Интегрированной Картой Вы должны написать
программу - но не программу на языке MapBasic. Приложения с
Интегрированной Картой могут быть написаны на нескольких языках
программирования, среди которых наиболее часто используются С,Visual
Basic,Delphi.

В Вашей программе должна присутствовать инструкция, запускающая MapInfo
в фоновом режиме. Например, в программе Вы можете запустить MapInfo
вызовом функции CreateObject(). Программа MapInfo запускается в фоновом
режиме незаметно для пользователя, не выводя заставку на дисплей. Ваша
программа осуществляет управление программой MapInfo, конструируя
строки, представляющие операторы языка MapBasic, которые затем
передаются в MapInfo посредством механизмауправления объектами OLE (OLE
Automation) или динамического обмена данных (DDE). MapInfo выполняет эти
операторы точно так же, как если бы пользователь вводил их с клавиатуры
в окно MapBasic.

Примечание:

Переподчинение окон MapInfo другому приложению не дает программе MapInfo
автоматического доступа к данным этого приложения. Для отображения
данных приложения в окне MapInfo Вы должны предварительно записать эти
данные в таблицу MapInfo.

Системные требования

Интегрированная картография требует наличия на компьютере MapInfo версии
4.0 или выше.Вы можете использовать полную версию MapInfo или так
называемый исполняемый (Runtime) модуль (усеченная версия MapInfo
поставляемая в качестве основы для специализированных приложений)

Вы должны иметь опыт работы с Handle.

Ваша программа должна быть способна действовать в качестве контроллера
механизма управления объектами OLE (OLE Automation Controller) или
клиента динамического обмена данных DDE. Рекомендуется применение OLE
контроллера как более быстрого и надежного метода по сравнению c DDE.
Его то мы и будем рассматривать

Другие краткие технические замечания

Интегрированная картография использует механизм управления OLE , но не
использует OLE - внедрение.

Интегрированная картография не использует элементы управления VBX или
OCX (дело не совсем так - существует OCX модуль MapX - для работы с ГИС
MapInfo (не входит в стандартный комплект поставки) , но это уже не
интегрированная картография и он рассматриваться не будет).

Интегрированная картография не предоставляет вам какие либо заголовочные
файлы и библиотеки

Интегрированная картография включает несколько DLL библиотек но не
предоставляет к ним доступ напрямую.

Запуск и связывание с сервером MapInfo

Итак рассмотрим простейший компонент для запуска и управления MapInfo
(TKDMapInfoServer),следует заметить что мной не ставилась написание
специализированного компонента - я представляю основы.

    unit KDMapInfoServer;
     
    interface
     
    uses
      ComObj, Controls, Variants, ExtCtrls, Windows, Messages,
      SysUtils, Classes;
     
    const
      scMapInfoWindowClass = 'xvt320mditask100';
      icWinMapinfo = 1011;
      icWinInfoWindowid = 13;
     
    type
      TEvalResult = record
        AsVariant: OLEVariant;
        AsString: string;
        AsInteger: Integer;
        AsFloat: Extended;
        AsBoolean: Boolean;
      end;
     
      TKDMapInfoServer = class(TComponent)
      private
        { Private declarations }
        // Владелец
        FOwner : TWinControl;
     
        // OLE сервер
        FServer : Variant;
        FHandle : THandle;
        FActive : Boolean;
        FPanel : TPanel;
     
        Connected : Boolean;
     
        MapperID : Cardinal;
        MapperNum : Cardinal;
     
        procedure SetActive(const Value: Boolean);
        procedure SetPanel(const Value: TPanel);
     
        procedure CreateMapInfoServer;
        procedure DestroyMapInfoServer;
      protected
        { Protected declarations }
      public
        { Public declarations }
        constructor Create(AOwner: TComponent); override;
        destructor Destroy; override;
        // Данная процедура выполеняет метод сервера MapInfo - Do
        procedure ExecuteCommandMapBasic(Command: string; const Args: array of const);
        // Данная процедура выполеняет метод сервера MapInfo - Eval
        function Eval(Command: string; const Args: array of const): TEvalResult; virtual;
        procedure WindowMapDef;
        procedure OpenMap(Path : string);
      published
        { Published declarations }
        // Создает соединение с сервером MapInfo
        property Active: Boolean read FActive write SetActive;
        property PanelMap : TPanel read FPanel write SetPanel;
      end;
     
    procedure register;
     
    implementation
     
    procedure register;
    begin
      RegisterComponents('Kuzan', [TKDMapInfoServer]);
    end;
     
    { TKDMapInfoServer }
    constructor TKDMapInfoServer.Create(AOwner: TComponent);
    begin
      inherited Create(AOwner);
      FOwner := AOwner as TWinControl;
      FHandle := 0;
      FActive := False;
      Connected := False;
    end;
     
    destructor TKDMapInfoServer.Destroy;
    begin
      DestroyMapInfoServer;
      inherited Destroy;
    end;
     
    procedure TKDMapInfoServer.CreateMapInfoServer;
    begin
      try
        FServer := CreateOleObject('MapInfo.Application');
      except
        FServer := Unassigned;
      end;
     
      // Скрываем панели управления MapInfo
      ExecuteCommandMapBasic('Alter ButtonPad ID 4 ToolbarPosition (0, 0) Show Fixed', []);
      ExecuteCommandMapBasic('Alter ButtonPad ID 3 ToolbarPosition (0, 2) Show Fixed', []);
      ExecuteCommandMapBasic('Alter ButtonPad ID 1 ToolbarPosition (1, 0) Show Fixed', []);
      ExecuteCommandMapBasic('Alter ButtonPad ID 2 ToolbarPosition (1, 1) Show Fixed', []);
      // Переопределяем окна
      ExecuteCommandMapBasic('Close All', []);
      ExecuteCommandMapBasic('Set ProgressBars Off', []);
      ExecuteCommandMapBasic('Set Application Window %D', [FOwner.Handle]);
      ExecuteCommandMapBasic('Set Window Info Parent %D', [FOwner.Handle]);
     
      FServer.Application.Visible := True;
      if IsIconic(FOwner.Handle)then
        ShowWindow(FOwner.Handle, SW_Restore);
      BringWindowToTop(FOwner.Handle);
    end;
     
    procedure TKDMapInfoServer.DestroyMapInfoServer;
    begin
      ExecuteCommandMapBasic('End MapInfo', []);
      FServer := Unassigned;
    end;
     
    procedure TKDMapInfoServer.ExecuteCommandMapBasic(Command: string;
    const Args: array of const);
    begin
      if Connected then
        try
          FServer.do(Format(Command, Args));
        except
          on E: Exception do MessageBox(FOwner.Handle,
          PChar(Format('Ошибка выполнения () - %S', [E.message])),
          'Warning', MB_ICONINFORMATION or MB_OK);
        end;
    end;
     
    function TKDMapInfoServer.Eval(Command: string;
    const Args: array of const): TEvalResult;
     
      function IsInt(Str : string): Boolean;
      var
        Pos : Integer;
      begin
        Result := True;
        for Pos := 1 to Length(Trim(Str)) do
        begin
          if (Str[Pos] <> '0') and (Str[Pos] <> '1') and
          (Str[Pos] <> '2') and (Str[Pos] <> '3') and
          (Str[Pos] <> '4') and (Str[Pos] <> '5') and
          (Str[Pos] <> '6') and (Str[Pos] <> '7') and
          (Str[Pos] <> '8') and (Str[Pos] <> '9') and
          (Str[Pos] <> '.') then
          begin
            Result := False;
            Exit;
          end;
        end;
      end;
     
    var
      ds_save: Char;
    begin
      if Connected then
      begin
        Result.AsVariant := FServer.Eval(Format(Command, Args));
        Result.AsString := Result.AsVariant;
        Result.AsBoolean := (Result.AsString = 'T') or (Result.AsString = 't');
     
        if IsInt(Result.AsVariant) then
        begin
          try
            ds_save := DecimalSeparator;
            try
              DecimalSeparator := '.';
              Result.AsFloat := StrToFloat(Result.AsString);//Result.AsVariant;
            finally
              DecimalSeparator := ds_save;
            end;
          except
            Result.AsFloat := 0.00;
          end;
     
          try
            Result.AsInteger := Trunc(Result.AsFloat);
          except
            Result.AsInteger := 0;
          end;
        end
        else
        begin
          Result.AsInteger := 0;
          Result.AsFloat := 0.00;
        end;
      end;
    end;
     
    procedure TKDMapInfoServer.SetActive(const Value: Boolean);
    begin
      FActive := Value;
     
      if FActive then
      begin
        CreateMapInfoServer;
        WindowMapDef;
        Connected := True;
      end
      else
      begin
        if Connected then
        begin
          DestroyMapInfoServer;
          Connected := False;
        end;
      end;
    end;
     
    procedure TKDMapInfoServer.SetPanel(const Value: TPanel);
    begin
      FPanel := Value;
    end;
     
    procedure TKDMapInfoServer.WindowMapDef;
    begin
      ExecuteCommandMapBasic('Set Next Document Parent %D Style 1', [FPanel.Handle]);
    end;
     
    procedure TKDMapInfoServer.OpenMap(Path: string);
    begin
      ExecuteCommandMapBasic('Run Application "%S"', [Path]);
      MapperID := Eval('WindowInfo(FrontWindow(),%D)',[12]).AsInteger;
      with PanelMap do
        MoveWindow(MapperID, 0, 0, FPanel.ClientWidth, FPanel.ClientHeight, True);
    end;
     
    end.

И так что мы имеем -

Мы установили связь с сервером MapInfo.

Мы узнали что у сервера MapInfo есть метод Do - он предназначен для
посылки команд MapBasic серверу точно так-же как если бы пользователь
набирал их в окне MapBasic-а самой программы MapInfo.

Мы узнали что у сервера MapInfo есть метод Eval- он предназначен для
получения значение функций после посылки команд MapBasic серверу.

Мы познакомились с командами переопределения направления вывода MapInfo.

Для начала неплохо

Теперь немного теории.

Запуск MapInfo

Запуск уникального экземпляра программы MapInfо осуществляется вызовом
функции CreateObject() Visual Basic с присваиванием возвращаемого
значения объектной переменной. (Вы можете декларировать объектную
переменную как глобальную; в противном случае объект MapInfо
освобождается после выхода из локальной процедуры.)

Например:

FServer := CreateOleObject(\'MapInfo.Application\');

Для подключения к ранее исполнявшемуся экземпляру MapInfo, который не
был запущен вызовом функции CreateObject(), используйте функцию
GetObject().

// Данная реализация оставлена вам уважаемые читатели для тренировки

FServer := GetObject(\'MapInfo.Application\');

Внимание:

Если Вы работаете с Runtime-версией MapInfo, а не с полной копией,
задавайте \"MapInfo. Runtime\" вместо \"MapInfo. Арplication\".
Runtime-версия и полная версия могут работать одновременно.

Функции CreateObject() и GetObject() используют механизм управления
объектами OLE (OLE Automation) для связи с MapInfo.

Примечание:

В 32-разрядной версии Windows (Windows95 или Windows NT) можно запускать
несколько экземпляров MapInfo. Если Вы запустите MapInfo и вслед за этим
программу, использующую Интегрированную Картографию и вызывающую
CreateObjectf), то будут работать два независимых экземпляра MapInfo.
Однако в 16-разрядной версии программа использующая Интегрированную
Картографию с запущенным MapInfo работать не сможет.

Пересылка команд в программу MapInfo

После запуска программы MapInfo необходимо сконструировать текстовые
строки, представляющие операторы языкa Map Basic.

Если Вы установили связь с MapInfo, используя механизм управления
объектами OLE (OLE Automation), передавайте командную строку программе
MapInfo методом Do.

Например:

FServer.Do(\'здесь команда MapBasic\');

Примечание:

В компоненте это реализовано процедурой ExecuteCommandMapBasic, но в
сущносте вызывается FServer.Do

При использовании метода Do программа MapInfo исполняет командную строку
точно так как если б ее ввели в окне команд MapBasic.

Примечание:

Вы можете передать оператор в программу MapInfo, если этот оператор
допустим окне MapBasic. Например, Вы не можете переслать
MapBasic-оператор Dialog, поскольку его использование не разрешено в
окне MapBasic.

Для определения допустимости использования оператора языка MapBasic в
окне MapBasic обратитесь к Справочнику MapBasic или откройте Справочную
систему; искомая информация находится под заголовком \"Предупреждение\".
Например, в Справке по оператору Dialog дано следующее ограничение: \"Вы
не можете использовать оператор Dialog в окне исполнения (такие, как
For..-Next и Goto), не разрешены для исполнения в окне MapBasic.

Запрос данных от программы MapInfo

Для выполнения запроса из Вашей программы-клиента значения MapBasic
используйте OLE-методEval.

Например:

MyVar:= FServer.Eval(\'здесь команда MapBasic\');

Примечание:

В компоненте это реализовано процедурой Eval, но в сущносте вызывается
FServer.Eval

При использовании метода Eval программа MapInfo интерпретирует строку
как выражение языка MapBasic, определяет значение выражения и возвращает
это значение в виде строки. Замечание: Если выражение приводится к
логическому значению (тип Logical), MapInfo возвращает односимвольную
строку, \"Т\" или \"F\" соответственно.

Переподчинение окон MapInfo

После запуска MapInfo используйте оператор Set Application Window языка
MapBasic для обеспечения перехвата управления Вашей программой-клиентом
диалоговых окон и сообщений об ошибках программы MapInfo.

Затем, в желаемой точке включения окна MapInfo в Ваше приложение
передайте MapInfo оператор Set Next Document, за которым следует
MapBasic-оператор, создающий окно.

Оператор Set Next Document позволяет Вам \"переподчинять\" окна
документов. Синтаксис этого оператора требует указания уникального
номера HWND элемента управления в Вашей программе. При последующем
создании окна-документа MapInfo (с использованием операторов Map, Graph,
Browse, Layout или Create Legend) создаваемое окно становится для окна
порождающим объектом.

Примеры приведены из компонента но тоже самое можно выполнить и метолом
Do непосредственно, но вы это уже я думаю поняли

    ExecuteCommandMapBasic('Set Application Window %D', [FOwner.Handle]);
    ExecuteCommandMapBasic('Set Window Info Parent %D', [FOwner.Handle]);
    ExecuteCommandMapBasic('Set Next Document Parent %D Style 1', [FPanel.Handle]); 

Примечание:

В компоненте это реализовано процедурой WindowMapDef которая ссылается
на панель заданную свойством PanelMap.

Для каждого переподчиняемого окна необходимо передать программе MapInfo
из Вашей программы пару операторов - оператор Set Next Document Parent,
а затем оператор, создающий окно. После создания окна Вам может
понадобиться запросить из MapInfo значение функции WindowID(0) -
целочисленный ID-номер окна (Window ID) в MapInfo, так как многие
операторы языка MapBasic требуют задания этого номера. Этот запрос
выполняется на основе компонента следующим образом:

WindowID := Eval(\'WindowID(%D)\',\[0\]).AsInteger;

Заметьте, что даже после переподчинения окна Карты, MapInfo продолжает
управлять им. клиентская программа может не обращать внимания на
сообщения о перерисовке, реализацию данной особенности я оставлю на
потом.

Переподчинение окон Легенд, растровых диалогов и других окон MapInfo

Чтобы изменить (преподчинить) данные окна используется оператор MapBasic
Set Window... Parent.

Например, в компоненте переподчинение окна информации реализовано так -

ExecuteCommandMapBasic(\'Set Window Info Parent %D\',
\[FOwner.Handle\]);

Реализацию переподчинения других окон я оставляю вам уважаемые читатели

Заметьте, что способ переподчинения окна Информации другой, чем для окна
Карты. В последнем случае не используется предложение Set Next Document.
Дело в том, что может существовать несколько окон Карты.

Окна Легенды - особый случай. Обычно существует только одно окно
Легенды, так же, как и одно окно Информации. Однако при помощи оператора
MapBasic Create Legend Вы можете создавать дополнительные окна Легенды.

Для одного окна Легенды используйте оператор MapBasic Window Legend
Parent.

Чтобы создать дополнительное окно Легенды, используйте оператор MapBasic
Set Next Document и оператор Create Legend. Заметьте, что в этом случае
Вы создаете Легенду, которая привязана к одному определенному окну Карты
или окну Графика. Такое окно Легенды не изменяется, когда другое окно
становится активным.

Совет:

Вы можете создать \"плавающее\" окно Легенды внутри окна Карты. В
операторе Set Next Document укажите окно Карты как порождающее окно. Для
получения более подробной информации смотрите в документации по
MapBasic.

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

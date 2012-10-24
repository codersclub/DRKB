<h1>Работа с отчетами Rave Report в режиме Runtime</h1>
<div class="date">01.01.2007</div>

<div class="author">Автор: Турушев Виталий</div>
<p>Введение</p>
<p>С выходом Delphi 7 мы стали свидетелями выхода нового генератора отчетов Rave Report Borland Edition от разработчиков фирмы Nevrona. Среда разработки Rave имеет довольно много новшеств, и в тоже время ряд ошибок и недочетов. Среди положительных качеств можно отметить: сохранение проекта отчета в файл и чтение его из файла, что позволяет удобно загрузить или сохранить необходимый проект отчета, и в дальнейшем работать с ним. Также есть набор компонентов для конвертирования отчета Rave в другие форматы (PDF, HTML, RTF, TEXT). Rave Report значительно облегчает разработку отчетов где используются базы данных, ведь выбор компонентов доступа к источникам данных весьма неплох. Среди недочетов отмечу: недоработку среды разработки отчетов Rave, где присутствует ряд серьезных ошибок. Также Nevrona предоставила довольно таки очень скудную справку для разработчика и не порадовала достаточным количеством примеров работы с отчетами Rave.</p>
<p>Причиной написания данной статьи стало отсутствие примеров и описания работы с отчетами Rave в режиме RunTime, что не позволяет пользователю более гибко работать с отчетом (например: изменение данных/оформления в отчете при наступлении определенного события в программе, а возможности Event Editor в Rave Report увы ограничены), что отталкивает пользователей от использования генератора отчетов Rave. Возможно, по этой причине или по причине недоработки генератора отчета часть пользователей возвращается к генератору отчетов Quick Report или к генераторам отчетов других разработчиков.</p>
<p>Исследование классов в проекте отчета Rave Report</p>
<p>Для работы с отчетами в RunTime потребуется, знание имен подключаемых модулей в раздел uses, создаваемого проекта. Ниже представлена таблица описания основных модулей, которые могут понадобятся для работы с отчетом Rave в RunTime. Примечание: Для разработчиков CLX приложений название модулей почти идентично, только в имени модуля предшествует символ &#171;Q&#187;. Например: QRvCsBars. Все модули находятся в каталоге &#171;\Rave5\Lib&#187; куда установлена среда программирования Delphi 7.</p>
<p>Имя модуля Описание модуля</p>
<p>RvClass&nbsp;&nbsp;&nbsp; Этот модуль содержит реализацию базовых классов</p>
<p>RvProj&nbsp;&nbsp;&nbsp;&nbsp; В этом модуле набор классов реализующие собственно сам проект</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; отчета и отвечающих за работу с ним</p>
<p>RvCsDraw&nbsp;&nbsp; Классы в этом модуле реализуют графические примитивы</p>
<p>RvCsBars&nbsp;&nbsp; В этом модуле реализованы штриховые коды</p>
<p>RvCsStd&nbsp;&nbsp;&nbsp; В этом модуле реализуются основные элементы оформления отчета</p>
<p>RvCsRpt,&nbsp;&nbsp; Набор классов в данном модуле служит для вывода данных из</p>
<p>RvCsData&nbsp;&nbsp;&nbsp;&nbsp; баз данных или других источников данных</p>
<p class="note">Примечание</p>
<p>В качестве файла отчета взят уже готовый демонстрационный пример отчета RaveDemo.rav, поставляемый с генератором отчета Rave Report, который находится в каталоге &#171;\Rave5\Demos&#187;. Поэтому следует указать полный путь к файлу отчета или скопировать данный файл в каталог с текущим проектом.</p>
<p>И так, осталось выяснить, что далее необходимо для работы с отчетом в RunTime. Всю работу с проектом отчета обеспечивает класс TRaveProjectManager &#8211; менеджер отчетов. Следовательно, потребуются некоторые знания о свойствах и методах этого класса.</p>
<p class="note">Примечание</p>
<p>Следует разделять понятие проект отчета и отчет как таковой в отдельности. Проект отчета &#8211; может содержать в себе целую коллекцию отдельных отчетов. Отчет &#8211; это набор страниц, элементов оформления, элементов доступа к различным источникам данных и т.п., то, что подготовлено или подготавливается для печати отчета.</p>
<p>Также могут, пригодиться знания по работе с технологией RTTI для извлечения наименований свойств, событий (методов) и другой информации из объектов (компонентов) отчета Rave Report. Можно и не изучать принципы работы с технологией RTTI, ведь наименование доступных свойств интересующего объекта можно увидеть в среде разработки Rave Report инспектора объектов.</p>
<p>И так, двигаемся далее. Для работы с отчетом в RunTime, конечно, необходимо знать из набора каких объектов состоит данный отчет и, от каких классов произошли эти объекты, ведь в справочной системе Rave Report о них нет ни слова. Для этого необходимо написать процедуру, которая поможет узнать, из каких объектов состоит отчет, а также поможет выяснить имена классов и объектов. Код данной процедуры представлен ниже:</p>
<pre>
procedure GetListObjects(ListClass: TStrings; ClassX: TComponent; TabStr:
  string; AddObjects: Boolean = False);
var
  I: Integer;
begin
  if (ClassX = nil) or (ListClass = nil) then
    EXIT;
  for I := 0 to ClassX.ComponentCount - 1 do
  begin
    if AddObjects then
      ListClass.AddObject(TabStr + ClassX.Components[I].Name +
        ' - ' + ClassX.Components[I].ClassName, ClassX.Components[I])
    else
      ListClass.Add(TabStr + ClassX.Components[I].Name +
        ' - ' + ClassX.Components[I].ClassName);
    if ClassX.Components[I].ComponentCount &gt; 0 then
      GetListObjects(ListClass, ClassX.Components[I], TabStr + '..',
        AddObjects);
  end;
end;
</pre>

<p>Как видите, процедура достаточно проста. В цикле процедуры осуществляется проход по всем дочерним компонентам в компоненте &#171;ClassX&#187; и если дочерний компонент содержит в себе еще вложенные компоненты, то используется рекурсивный вызов процедуры GetListObjects. В результате чего будет получен список всех компонентов. Вполне вероятно, что захочется узнать всех предков исследуемого объекта, тогда можно воспользоваться приведенной ниже процедурой.</p>
<pre>procedure GetListParentClassName(ListClass: TStrings;
  ClassX: TClass; ClearList: Boolean = True);
begin
  if (ClassX = nil) or (ListClass = nil) then
 &nbsp;&nbsp; EXIT;
  if ClearList then
 &nbsp;&nbsp; ListClass.Clear;
  while ClassX &lt;&gt; nil do
  begin
 &nbsp;&nbsp; ListClass.Add(ClassX.ClassName);
 &nbsp;&nbsp; ClassX := ClassX.ClassParent;
  end;
end;
</pre>
<p>Пример вызова процедуры GetListParentClassName:<br>
GetListParentClassName(MemoInfo.Lines, RvProjectRTR.ClassType);<br>
или<br>
<p>GetListParentClassName(MemoInfo.Lines, TRvProject);</p>
<p>Как было сказано выше, для доступа к проекту отчета необходим класс TRaveProjectManager. Чтобы получить к нему доступ, необходимо обратиться к свойству &#171;ProjMan&#187; класса TRvProject. Как известно в проекте отчета Rave Report может содержаться несколько отчетов. Работа с отчетом осуществляется через класс TRaveReport. Для доступа к текущему активному отчету нужно обратиться к свойству &#171;ActiveReport&#187; класса TRaveProjectManager.</p>
<p>Вот для свойства &#171;ActiveReport&#187; класса TRaveProjectManager и следует применить выше описанную процедуру GetListObjects для получения списка объектов из отчета. Для использования процедуры можно использовать, к примеру, такие строки кода:</p>
<p>...</p>
<p>ListObjects.Clear;</p>
<p>GetListObjects(ListObjects.Items, RvProjectRTR.ProjMan.ActiveReport, '', True);</p>
<p>...</p>
<p>Посмотрите на результат работы процедуры GetListObjects. Вы наверняка сразу заметили одну особенность, что все имена классов представленных объектов начинаются с приставки &#171;TRave...&#187;. Ну вот, зная имена классов, работать будет уже намного легче.</p>
<p>Совет: Если известен некий класс, но неизвестно в каком модуле данный класс описан, то это можно выяснить с помощью поисковика файлов с поддержкой поиска текста внутри файлов. В поисковике задать маску для поиска &#171;*.dcu&#187; в папке &#171;\Rave5\Lib&#187;, а в строке для поиска текста указать наименование класса, например: TRaveControl.</p>
<p>Исследование объектов средствами технологии RTTI</p>
<p>Получив список объектов, не мешало бы поподробнее получить информацию об интересующем объекте. В этом, безусловно, поможет технология RTTI. Если вы имеете опыт работы с RTTI, то можете пропустить данный раздел статьи.</p>
<p class="note">Примечание</p>
<p>В данной статье не будет достаточно подробно рассматриваться принцип работы с RTTI так как эта тема довольно-таки велика по объему. Будет рассмотрено только то, что поможет в дальнейшей работе. Более подробно с принципами работы технологии RTTI вы можете познакомиться в книге Стива Тейксейра и Ксавье Пачеко &#171;DELPHI 5 Руководство разработчика. Том 2. Разработка компонентов и работа с базами данных&#187;. Процедуры, реализованные в этой статье, основаны на примерах из этой книги, и были несколько доработаны для работы с проектом, описываемым в данной статье.</p>
<p>Для работы с RTTI в раздел проекта uses необходимо подключить модуль TypInfo. Для извлечения информации RTTI обычно требуется две структуры: PTypeInfo и PTypeData. Ниже приведена процедура, которая выводит базовую информацию об интересующем объекте.</p>
<pre>
// Извлечение базовой информации об объекте
procedure GetListClassInfo(ListInfo: TStrings; ClassX: TObject; ClearList:
  Boolean = True);
var
  // В данные структуры записывается информация об RTTI объекта
  Class_PTI: PTypeInfo;
  Class_PTD: PTypeData;
begin
  if (ClassX = nil) or (ListInfo = nil) then
    EXIT;
  if ClearList then
    ListInfo.Clear;
  // Получение информации об RTTI объекта
  Class_PTI := ClassX.ClassInfo;
  Class_PTD := GetTypeData(Class_PTI);
  // Вывод базовой информации об объекте
  with ListInfo do
  begin
    Add('Базовая информация:');
    Add(Format('Имя класса:                 '#9'  %s',[Class_PTI.Name]));
    Add(Format('Тип класса:                 '#9'  %s',
     [GetEnumName(TypeInfo(TTypeKind),
        Integer(Class_PTI.Kind))]));
    Add(Format('Размер объекта:             '#9'  %d',[ClassX.InstanceSize]));
    Add(Format('Описан в модуле:            '#9'  %s',[Class_PTD.UnitName]));
    Add(Format('Всего доступно свойств:     %d', [Class_PTD.PropCount]));
    if ClassX is TRaveControl then
    begin
      Add('Родительский компонент:');
      Add(Format('Тип класса:     %s',
        [TRaveControl(ClassX).Parent.ClassName]));
      Add(Format('Имя компонента: %s', [TRaveControl(ClassX).Parent.Name]));
    end;
    Add('Генеалогическое дерево класса:');
    // Вывод информации о предках объекта
    GetListParentClassName(ListInfo, ClassX.ClassType, False);
  end;
end;
</pre>
<p class="note">Примечание</p>
<p>Следует помнить, что в RTTI доступны только те свойства и методы, которые определены в секции published исследуемого объекта, т.е. те которые видны в инспекторе объ-ектов среды разработки Delphi. Свойства и методы необъявленные в секции published через технологию RTTI будут недоступны.</p>
<p>Следующая процедура выводит список наименований свойств, свойств-событий (методы) и тип свойств исследуемого объекта. Также данная процедура выводит текущие значения, присвоенные свойствам объекта. Для свойств типа tkClass (в этих свойствах храниться ссылка на некий объект) выводиться имя объекта, на который ссылается данное свойство. Если же это свойство не ссылается на объект, то будет выведено значение &#171;NIL&#187;.</p>
<pre>
// Извлечение информации о наименовании свойств и событий объекта
procedure GetListProperty(ListPropertys: TStrings; ClassX: TObject; AddObjects:
  Boolean = False; ClearList: Boolean = True);
var
  PropList: PPropList;
  Class_PTI: PTypeInfo;
  Class_PTD: PTypeData;
  I, PropertyCount: Integer;
  S, StrVal: string;
  TmpObj: TObject;
begin
  if (ClassX = nil) or (ListPropertys = nil) then
    EXIT;
  if ClearList then
    ListPropertys.Clear;
  Class_PTI := ClassX.ClassInfo;
  Class_PTD := GetTypeData(Class_PTI);
  if Class_PTD.PropCount &lt;&gt; 0 then
  begin
    // Выделение памяти под структуры TPropInfo, в зависимости от количества свойств объекта
    GetMem(PropList, SizeOf(PPropInfo) * Class_PTD.PropCount);
    try
      // Заполнение PropList указателями на структуры TPropInfo
      GetPropInfos(ClassX.ClassInfo, PropList);
      for I := 0 to Class_PTD.PropCount - 1 do
        // Добавляются свойства не являющиеся событиями
        if not (PropList[I]^.PropType^.Kind = tkMethod) then
        begin
          // Извлечение текущего значения свойства
          if PropList[I]^.PropType^.Kind = tkClass then
          begin
            TmpObj := GetObjectProp(ClassX, PropList[I]^.Name);
            if TmpObj = nil then
              StrVal := 'NIL'
            else
              // Если у объекта есть предок TComponent,
              // то извлекается имя объекта иначе имя класса
              if TmpObj is TComponent then
                StrVal := TComponent(TmpObj).Name
              else
                StrVal := '(' + TmpObj.ClassName + ')';
          end
          else
            StrVal := GetPropValue(ClassX, PropList[I]^.Name);
          S := Format('%s: %s = %s', [PropList[I]^.Name,
            PropList[I]^.PropType^.Name, StrVal]);
          if AddObjects then
            ListPropertys.AddObject(S, TObject(PropList[I]^.PropType^))
          else
            ListPropertys.Add(S);
        end;
      // Поиск свойств-событий
      PropertyCount := GetPropList(ClassX.ClassInfo, [tkMethod], PropList);
      ListPropertys.Add('*** Свойства-события ***');
      // Добавляются свойства-события
      for i := 0 to PropertyCount - 1 do
      begin
        S := Format('%s: %s', [PropList[I]^.Name, PropList[I]^.PropType^.Name]);
        if AddObjects then
          ListPropertys.AddObject(S, TObject(PropList[I]^.PropType^))
        else
          ListPropertys.Add(S);
      end;
    finally
      // Освобождение ранее выделенной памяти
      FreeMem(PropList, SizeOf(PPropInfo) * Class_PTD.PropCount);
    end;
  end;
end;
</pre>
<p>Процедур GetListClassInfo и GetListProperty вполне достаточно, чтобы изучить необходимый объект. Но самой полезной является, конечно, процедура GetListProperty. Как видите процедура GetListProperty достаточно сложная по виду. Еще бы, ведь структуры PTypeInfo и особенно PTypeData довольно-таки &#171;ветвистые&#187; по своему строению. Понимание выше приведенных процедур осложняет еще и то, что Borland не документирует данную технологию так как, она может изменяться от одной версии Delphi к другой, вследствие чего это не может гарантировать работоспособность одного и того же кода в различных версиях Delphi.</p>
<p>Для просмотра результата работы приведенных выше двух можно применить следующие строки кода:</p>
<pre>
...
if ListObjects.Items.Objects[ListObjects.ItemIndex] &lt;&gt; nil then
begin
  GetListClassInfo(MemoInfo.Lines,
    ListObjects.Items.Objects[ListObjects.ItemIndex]);
 
  GetListProperty(ListProperty.Items,
    ListObjects.Items.Objects[ListObjects.ItemIndex], True);
end;
...
</pre>
<p>Но и это еще не все возможности технологии RTTI. Также есть возможность получить достаточно полную информацию о свойстве или методе исследуемого объекта. Для извлечения столь немаловажной информации следует воспользоваться приведенной ниже процедурой.</p>
<pre>
// Извлечение информации о свойствах и методах объекта
 
procedure GetPropertyInfo(ListInfo: TStrings; PTI: PTypeInfo; PTD: PTypeData;
  ClearList: Boolean = True);
type
  // Структура для извлечения информации из методов (свойства-события)
  PParamRec = ^TParamRec;
  TParamRec = packed record
    Flags: TParamFlags;
    ParamName: ShortStringBase;
    TypeName: ShortStringBase;
  end;
var
  I: Integer;
  S, S2: string;
  TeStr,
    RStr: ^ShortStringBase;
  ParamRec: PParamRec;
  // Базовая информация для всех свойств
  procedure Name_Info;
  begin
    ListInfo.Add(Format('Тип свойства:             %s', [PTI.Name]));
    ListInfo.Add(Format('Подтип свойства:       %s',
      [GetEnumName(TypeInfo(TTypeKind),
        Integer(PTI^.Kind))]));
  end;
  // Информация для целочисленных, множеств и перечисляемых типов свойств
  procedure Int_Info;
  begin
    ListInfo.Add(Format('Минимальное значение:  %d', [PTD^.MinValue]));
    ListInfo.Add(Format('Максимальное значение: %d', [PTD^.MaxValue]));
  end;
 
  // Информация для типов свойств с плавающей точкой
  procedure Float_Info;
  begin
    // Определение подтипа свойства
    case PTD^.FloatType of
      ftSingle: S := 'ftSingle';
      ftDouble: S := 'ftDouble';
      ftExtended: S := 'ftExtended';
      ftComp: S := 'ftComp';
      ftCurr: S := 'ftCurr';
    end;
    ListInfo.Add(Format('Подтип tkFloat:        %s', [S]));
    ListInfo.Add('Минимальное значение:  ' + FloatToStr(PTD^.MinInt64Value));
    ListInfo.Add('Максимальное значение: ' + FloatToStr(PTD^.MaxInt64Value));
  end;
  // Информация для свойства представленного как класс
  procedure Class_Info;
  begin
    ListInfo.Add(Format('Предок класса свойства:           %s',
      [PTD^.ParentInfo^.Name]));
    ListInfo.Add(Format('Доступно свойств у объекта:    %d', [PTD^.PropCount]));
    ListInfo.Add(Format('Описан в модуле:                       %s',
      [PTD^.UnitName]));
  end;
  // Информация для методов (свойства-события)
  procedure Method_Info;
  var
    J: Integer;
  begin
    // Определение типа метода
    case PTD^.MethodKind of
      mkProcedure: S := 'Procedure ';
      mkFunction: S := 'Function ';
      mkConstructor: S := 'Constructor ';
      mkDestructor: S := 'Destructor ';
      mkClassProcedure: S := 'ClassProcedure ';
      mkClassFunction: S := 'ClassFunction ';
      mkSafeProcedure: S := 'SafeProcedure ';
      mkSafeFunction: S := 'SafeFunction ';
    end;
    // Извлечение информации о передаваемом параметре
    ParamRec := @PTD^.ParamList;
    J := 1;
    ListInfo.Add(Format('Передаваемых параметров:        %d',
      [PTD^.ParamCount]));
    while J &lt;= PTD^.ParamCount do
    begin
      if J = 1 then
        S := S + '(';
      // Определение метода передачи параметра
      if pfVar in ParamRec.Flags then
        S2 := 'var ';
      if pfConst in ParamRec.Flags then
        S2 := 'const ';
      if pfArray in ParamRec.Flags then
        S2 := 'array of ';
      if pfOut in ParamRec.Flags then
        S2 := 'out ';
      // Извлечение информации о типе передаваемого параметра
      TeStr := Pointer(Integer(@ParamRec^.ParamName) +
        Length(ParamRec^.ParamName) + 1);
      S := S + S2;
      S := Format('%s%s: %s', [S, ParamRec^.ParamName, TeStr^]);
      Inc(J);
      // Извлечение информации о следующем передаваемом параметре
      ParamRec := PParamRec(Integer(ParamRec) + SizeOf(TParamFlags) +
        (Length(ParamRec^.ParamName) + 1) + (Length(TeStr^) + 1));
      if J &gt; PTD^.ParamCount then
        S := S + ')';
      // Если метод является функцией, то извлекается информация о возвращаемом параметре
      if PTD^.MethodKind = mkFunction then
      begin
        RStr := Pointer(ParamRec);
        S := Format('%s: %s;', [S, RStr^]);
      end
      else
        S := S + '; ';
    end;
    ListInfo.Add(S);
  end;
  // Вывод информации для строковых типов свойств
  procedure Str_Info;
  begin
    ListInfo.Add(Format('Максимальная длина:  %d', [PTD^.MaxLength]));
  end;
 
begin
  if (ListInfo = nil) or (PTI = nil) or (PTD = nil) then
    EXIT;
  if ClearList then
    ListInfo.Clear;
  Name_Info;
  // Извлечение информации для свойств множеств
  if PTI^.Kind = tkSet then
  begin
    PTI := PTD^.CompType^;
    PTD := GetTypeData(PTI);
    Name_Info;
  end;
 
  case PTI^.Kind of
    tkInteger: Int_Info;
    tkFloat: Float_Info;
    tkString: Str_Info;
    tkLString: Str_Info;
    tkWString: Str_Info;
    // Извлечение информации для перечисляемых свойств
    tkEnumeration:
      begin
        Int_Info;
        ListInfo.Add('Варианты значений:');
        for I := PTD^.MinValue to PTD^.MaxValue do
          ListInfo.Add(Format('Значение: %s', [GetEnumName(PTI, I)]));
      end;
    tkClass: Class_Info;
    tkMethod: Method_Info;
  end;
end;
</pre>
<p class="note">Примечание</p>
<p>Для перечисляемых свойств, информацию &#171;Минимальное значение&#187; и &#171;Максимальное значение&#187; выводимую процедурой GetPropertyInfo следует понимать как первый и последний индекс элемента перечисляемого свойства.</p>
<p>Использовать процедуру GetPropertyInfo можно так:</p>
<pre>
procedure TFormRTR.ListPropertyClick(Sender: TObject);
var
  TI: PTypeInfo;
  TD: PTypeData;
begin
  if ListProperty.Items.Objects[ListProperty.ItemIndex] = nil then
    EXIT;
  TI := PTypeInfo(ListProperty.Items.Objects[ListProperty.ItemIndex]);
  TD := GetTypeData(TI);
  GetPropertyInfo(MemoInfo.Lines, TI, TD);
end;
</pre>
<p>Имея на вооружении такие замечательные процедуры, наконец, то можно изучить интересующие классы, узнать свойства и методы, а также тип свойств исследуемых классов. Получив достаточно подробную информацию с помощью технологии RTTI теперь, наконец, можно перейти к работе с проектом отчета Rave Report в режиме RunTime, но сначала ознакомимся с основными классами, которые встречаются в проекте отчета Rave Report.</p>
<p>Описание классов TRaveXXX</p>
<p>В этом разделе статьи содержится описание классов, из которых в основном состоит проект отчета. Проект отчета формируют три основных класса: TRaveProjectManager, TRaveReport, TRavePage. Для работы с источниками данных могут использоваться классы TRaveDataView, TRaveDataField, а так же TRaveRegion и TRaveDataBand. Разберем эти основные классы более конкретно.</p>
<p>Как описывалось выше, класс TRaveProjectManager обеспечивает всю базовую работу с проектом отчета Rave. Осуществляет такие основные задачи как: чтение/сохранение проекта отчета, работа с коллекцией отчетов и глобальными страницами, поиск необходимого отчета и компонентов TRaveXXX и многое другое. Ниже приведено описание основных свойств класса TRaveProjectManager.</p>
<p class="note">Примечание</p>
<p>* &#8211; предположительное описание свойства, ввиду того, что в справочной системе Rave не предоставлена информация по данному свойству. (скрытый) &#8211; данное свойство доступно через технологию RTTI, но скрыто в инспекторе объектов среды разработки Rave Report.</p>
<p>TRaveProjectManager</p>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>AdminPassword Пароль для доступа к проекту отчета *</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>Categories Хранит список наименования категорий. Далее отдельному отчету можно указать тип категории, что помогает организовать более удобную работу и произвести поиск отчетов по категориям</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>CompileNeeded Необходима компиляция (скрытый) *</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>Description Сюда записывается более подробная информация о компоненте</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>DevLocked Блокировка компонента от случайных изменений его свойств</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>FullName Альтернативное наименование компонента</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>Locked Блокировка компонента от случайных изменений его свойств</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>Name Имя компонента</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>Parameters Описание параметров, которые могут использоваться для сохранения временных вычислений или другой информации</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>PIVars По назначению подобны Parameters, но присваиваются значения, которые определены после передачи команды на печать (After Print)</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>SecurityControl Определяет параметры доступа к серверам баз данных для ввода имени и пароля пользователя</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>Tag Тег, хранит целое число, которое используется разработчиком для собственных нужд</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>Units Определяет единицу измерения для всех отчетов</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>UnitsFactor Коэффициент для перевода текущей единицы измерения в дюймы</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>OnBeforeReport Обработчик события перед генерацией отчета</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>OnAfterReport Обработчик события после генерации отчета</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>OnBeforePrint Обработчик события пред посылкой задания на печать</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>OnAfterPrint Обработчик события после завершения печати</td></tr></table></div>
<p class="note">Примечание</p>
<p>Если вы исследовали, какой либо класс TRaveXXX средствами RTTI, то наверно обратили внимание, что события OnBeforeReport, OnAfterReport, OnBeforePrint, OnAfterPrint не являются методами как в VCL Delphi, а являются ссылками на класс TRaveSimpleEvent.</p>
<p>Теперь познакомимся с классом TRaveReport. Данный класс представляет собой отдельный отчет, который является контейнером, хранящим в себе страницы отчета. Описание основных свойств класса TRaveReport приведены ниже.</p>
<p>TRaveReport</p>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>AlwaysGenerate Перед печатью отчета заполняет переменные типа TotalPages, чтобы их значение было известно перед печатью первой страницы</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>Category Позволяет установить принадлежность отчета к заданной категории. Список доступных категорий задается в свойстве &#171;Categories&#187; менеджера отчетов TRaveProjectManager</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>Collate Определяет тип упорядочивания задания на печать</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>CompileNeeded Необходима компиляция (скрытый) *</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>Copies Хранит количество копий, после печати отчета</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>Description Сюда записывается более подробная информация о компоненте</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>DevLocked Блокировка компонента от случайных изменений его свойств</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>Duplex Установка типа дуплексной печати для принтера (не для всех принтеров)</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>FirstPage Первая страница отчета</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>FullName Альтернативное наименование компонента</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>Locked Блокировка компонента от случайных изменений его свойств</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>MaxPages Ограничивает число генерируемых страниц при генерации отчета после вызова метода Execute, 0 &#8211; генерируются все страницы</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>Name Имя компонента</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>PageList Список страниц для печати. Здесь можно задать какие страницы печатать и в каком порядке</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>Parameters Описание параметров, которые могут использоваться для сохранения временных вычислений или другой информации</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>PIVars По назначению подобны Parameters, но присваиваются значения, которые определены после передачи команды на печать (After Print)</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>Printer Задается имя принтера, на который выводится печать. Если поле пустое, то вывод данных осуществляется на текущий принтер</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>Resolution Установка качества печати</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>SecurityControl Определяет параметры доступа к серверам баз данных для ввода имени и пароля пользователя</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>Tag Тег, хранит целое число, которое используется разработчиком для собственных нужд</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>OnAfterPrint Обработчик события после завершения печати</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>OnAfterReport Обработчик события после генерации отчета</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>OnBeforePrint Обработчик события пред посылкой задания на печать</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>OnBeforeReport Обработчик события перед генерацией отчета</td></tr></table></div><p>Переходим к классу TRavePage. Данный класс реализует страницу отчета и также является контейнером, в который помещаются различные элементы оформления отчета, а также вспомогательные не визуальные элементы, например как TRaveFontMaster. Рассмотрим свойства класса TRavePage в приведенной ниже таблице.</p>
<p>TRavePage</p>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>Bin Указывается тип лотка для подачи бумаги</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>BinCustom Если в представленном списке Bin нет необходимого типа лотка, то указывается пользовательская константа лотка, поддерживаемая принтером</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>CompileNeeded Необходима компиляция (скрытый) *</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>Description Сюда записывается более подробная информация о компоненте</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>DevLocked Блокировка компонента от случайных изменений его свойств</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>FullName Альтернативное наименование компонента</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>GotoMode Определяет метод перехода по страницам &#171;GotoPage&#187; при печати</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>GotoPage Печать указанной страницы после печати текущей страницы</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>GridLines Определяет шаг видимой линии в координатной сетке</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>GridSpacing Размер шага между линиями в координатной сетке</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>Locked Блокировка компонента от случайных изменений его свойств</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>Name Имя компонента</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>Orientation Вид ориентации страницы (книжная/альбомная)</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>PageHeight Высота страницы</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>PageWidth Ширина страницы</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>PaperSize Выбор формата страницы поддерживаемый текущим принтером</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>Parameters Описание параметров, которые могут использоваться для сохранения временных вычислений или другой информации</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>PIVars По назначению подобны Parameters, но присваиваются значения, которые определены после передачи команды на печать (After Print)</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>Tag Тег, хранит целое число, которое используется разработчиком для собственных нужд</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>WasteFit Запрещает или разрешает при генерации отчета, пропорционально располагать элементы оформления на всю рабочую область страницы</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>OnAfterPrint Обработчик события после завершения печати</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>OnAfterReport Обработчик события после генерации отчета</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>OnBeforePrint Обработчик события пред посылкой задания на печать</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>OnBeforeReport Обработчик события перед генерацией отчета</td></tr></table></div><p>TRaveDataView &#8211; данный класс-посредник обеспечивает работу и связь между источниками данных и отчетом (данное назначение класса предположительно ввиду отсутствия справочной информации о нем). Описан он в модуле RvDirectDataView.</p>
<p>TRaveDataView</p>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>CompileNeeded Необходима компиляция *</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>ConnectionName Хранит имя подключенного источника данных</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>Description Сюда записывается более подробная информация о компоненте</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>DevLocked Блокировка компонента от случайных изменений его свойств</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>FullName Альтернативное наименование компонента</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>Locked Блокировка компонента от случайных изменений его свойств</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>Name Имя компонента</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>Tag Тег, хранит целое число, которое используется разработчиком для собственных нужд</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>OnBeforeReport Обработчик события перед генерацией отчета</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>OnAfterReport Обработчик события после генерации отчета</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>OnBeforePrint Обработчик события пред посылкой задания на печать</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>OnAfterPrint Обработчик события после завершения печати</td></tr></table></div><p>TRaveDataField &#8211; данный класс представляет собой поле данных и предоставляет вывод информации из источника данных. Этот класс расположен в модуле RvDataField.</p>
<p>TRaveDataField</p>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>Calculated Вычисляемое поле или нет *</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>Description Сюда записывается более подробная информация о компоненте</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>DevLocked Блокировка компонента от случайных изменений его свойств</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>FieldName Имя поля</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>FullName Альтернативное наименование компонента</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>Locked Блокировка компонента от случайных изменений его свойств</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>Name Имя компонента</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>NullText Текст, выводимый по умолчанию (если нет данных в источнике данных)</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>Size Размер поля</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>Tag Тег, хранит целое число, которое используется разработчиком для собственных нужд</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>OnBeforeReport Обработчик события перед генерацией отчета</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>OnAfterReport Обработчик события после генерации отчета</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>OnBeforePrint Обработчик события пред посылкой задания на печать</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>OnAfterPrint Обработчик события после завершения печати</td></tr></table></div><p>Ниже в таблице приведено описание классов, которые можно встретить в палитре компонентов среды разработки отчетов Rave Report. Визуальные компоненты &#8211; это те самые элементы оформления отчетов, такие как: линия, текст, штриховые коды и др. Не визуальные компоненты выполняют вспомогательные функции в оформлении отчета (TRaveFontMaster, TRavePageNumInit), или выполняют вычисления при генерации отчета, такие компоненты как TRaveCalcController, TRaveCalcOp и другие. Также к не визуальным элементам отчетов относятся компоненты TRaveRegion, TRaveBand, TRaveDataBand и компоненты доступа к источникам данных. В заголовке таблицы приведено имя модуля, где данные классы реализованы.</p>
<p>RvCsDraw</p>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>TRaveGraphicBase Является базовым классом для всех классов данного модуля. Произошел данный класс от TRaveControl.</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>TRaveSurface Происходит от класса TRaveGraphicBase и уже содержит в себе свойства реализующие базовые элементы оформления и стилей.</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>TRaveLine Элемент оформления &#8211; линия.</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>TRaveHLine Элемент оформления &#8211; горизонтальная линия.</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>TRaveVLine Элемент оформления &#8211; вертикальная линия</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>TRaveRectangle Элемент оформления &#8211; прямоугольник</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>TRaveSquare Элемент оформления &#8211; квадрат.</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>TRaveEllipse Элемент оформления &#8211; эллипс.</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>TRaveCircle Элемент оформления &#8211; окружность.</td></tr></table></div><p>RvCsBars</p>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>TRaveBaseBarCode Базовый класс штрихового кода.</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>TRavePostNetBarCode Постсетевой штриховой код (PostNet), используется американской почтовой службой в доставке почты.</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>TRaveI2of5BarCode Числовой штриховой код (I2of5).</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>TRaveCode39BarCode Алфавитно-цифровой штриховой код (Code39). Символ может хранить кодируемые данные. Разработан, чтобы кодировать 26 прописных букв, 10 цифр и 7 специальных символов.</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>TRaveCode128BarCode Алфавитно-цифровой штриховой код с высокой плотностью (Code128). Символ может хранить кодируемые данные. Разработан, чтобы кодировать первые 128 ASCII символов.</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>TRaveUPCBarCode Универсальный штриховой код изделия (UPC).</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>TRaveEANBarCode Европейский международный номер, штриховой код подобен штриховому коду UPC (EAN).</td></tr></table></div><p>RvCsStd</p>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>TRaveText Элемент оформления &#8211; текст.</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>TRaveMemo Элемент оформления &#8211; текстовое поле MEMO.</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>TRaveSection Вспомогательный элемент оформления, реализующий группировку объектов.</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>TRaveBitmap Элемент оформления для вывода растрового изображения.</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>TRaveMetaFile Элемент оформления для вывода метафайла.</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>TRaveFontMaster Вспомогательный элемент оформления, для установки свойства шрифта у текстовых компонентов. Компоненты позволяющие работать с компонентом TRaveFontMaster содержат свойство &#171;FontMirror&#187;.</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>TRavePageNumInit Вспомогательный элемент оформления позволяющий производить нумерацию страниц.</td></tr></table></div><p>RvCsRpt</p>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>TRaveRegion Компонент-контейнер, размещающий в себе элементы оформления отчета. Также позволяет создать печать отчета в несколько столбцов. Используется для работы с источниками баз данных.</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>TRaveBand Компонент-контейнер, также размещающий в себе элементы оформления отчета. В основном используется для создания верхних и нижних колонтитулов или других сносок.</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>TRaveDataBand Компонент-контейнер, размещающий в себе элементы оформления отчета для вывода информации из баз данных.</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>TRaveDataCycle Используется для вычислений, сортировки или фильтрации.</td></tr></table></div><p>RvCsData</p>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>TRaveDataText Элемент оформления отчета, для вывода однострочных данных из источника баз данных.</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>TRaveDataMemo Элемент оформления отчета, для вывода многострочных данных из источника баз данных.</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>TRaveDataMirrorSection Компонент-контейнер, размещающий в себе элементы оформления отчета для доступа к источникам баз данных и объединяющий их в одну группу.</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>TRaveCalcText Элемент оформления отчета, позволяющий производить вычисления по указанному полю источника данных.</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>TRaveCalcOp Вспомогательный элемент, позволяющий производить вычисления по двум указанным полям источника данных.</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>TRaveCalcTotal Вспомогательный элемент, позволяющий производить вычисления по указанному полю источника данных и имеет возможность передать вычисленное значение какому либо элементу оформления отчета.</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#9632;</td><td>TRaveCalcController Вспомогательный элемент, позволяющий задать параметры вычислений. Также данный класс выполняет все заданные функции вычислений.</td></tr></table></div><p>Доступ к объектам проекта отчета Rave Report в режиме RunTime</p>
<p>Ну вот, когда проведена большая работа по исследованию классов в проекте отчета Rave Report, наконец, можно приступить непосредственно к работе с отчетом в режиме RunTime. Еще раз напомню порядок доступа к активному (текущему) отчету Rave:</p>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Для доступа к проекту отчета необходимо обратиться к классу TRaveProjectManager.</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Для доступа к классу TRaveProjectManager следует обратиться к свойству &#171;ProjMan&#187; класса TRvProject.</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Чтобы получить доступ к активному отчету, следует обратиться к свойству &#171;ActiveReport&#187; класса TRaveProjectManager.</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>То есть последовательность такого типа: TRvProject.ProjMan.ActiveReport.</td></tr></table></div><p>Как вы уже знаете в отчете содержаться еще и страницы. К сожалению, разработчики не предоставили методов для навигации по страницам отчета (представлено только одно свойство &#171;FirstPage&#187; &#8211; первая страница), но это проблема вполне решаема. Ниже приведена процедура, которая возвращает список указателей на объекты (если таковые имеются), порожденных от указанного класса.</p>
<pre>
// Возвращает список указателей на объекты, порожденных от указанного класса FindClass
procedure GetObjectList(RootComponent: TComponent; FindClass: TClass; var
  PageList: TList);
var
  I: Integer;
begin
  PageList.Clear;
  if (RootComponent = nil) or (PageList = nil) then
    EXIT;
  for I := 0 to RootComponent.ComponentCount - 1 do
    if RootComponent.Components[I] is FindClass then
      PageList.Add(RootComponent.Components[I]);
end;
</pre>
<p>Пример вызова процедуры:</p>
<p>GetObjectList(RvProjectRTR.ProjMan.ActiveReport, TRavePage, RavePageList);</p>
<p>Данный вызов процедуры заполняет список RavePageList указателями на все найденные страницы в текущем отчете. Теперь используя список RavePageList можно удобно осуществлять навигацию по страницам отчета, точно так же, как по списку отчетов представленный менеджером отчетов TRaveProjectManager. Список отчетов можно получить, обратившись к свойству &#171;ReportList&#187; класса TRaveProjectManager. Используя процедуру GetObjectList можно получить список и других объектов произошедших от определенного класса, что облегчает навигацию по объектам определенного типа.</p>
<p class="note">Примечание</p>
<p>У класса TRaveReport в наличии есть свойство &#171;PageList&#187;. Данное свойство определяет порядок страниц при печати. Допустим, в отчете имеется 10 страниц, а в &#171;PageList&#187; указанно печатать 3-ю и 8-ю страницу. Тогда свойство &#171;PageList.Count&#187;, будет равным 2-ум, и доступ вы сможете получить только к 3-й и 8-й странице отчета. Если же в свойстве &#171;PageList&#187; нет ссылок на страницы отчета (PageList = NIL), то при попытке обратиться к данному свойству будет получено сообщение об ошибке. Поэтому не следует забывать специфику данного свойства.</p>
<p class="note">Примечание</p>
<p>TRaveReport также предоставляет свойство &#171;Page&#187; доступное только для чтения. Можно было бы предположить, что данное свойство хранит ссылку на активную страницу текущего отчета, но по каким то причинам в данном свойстве все время присутствует значение равное NIL. Так что назначение данного свойства для меня пока неизвестно.</p>
<p>Слов сказано уже много, но на практике еще мало чего сделано. Думаю, настало время перейти к практической части. За основу, как оговаривалось в начале статьи, взят демонстрационный проект отчета &#171;RaveDemo.rav&#187;, вот над ним и будут производиться все опыты на практике. Для экспериментов возьмем, к примеру, отчет &#171;Mirror Report&#187;.</p>
<p>Попробуем изменить заголовок первой страницы у отчета &#171;Mirror Report&#187;. Для оттого необходимо:</p>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Найти и активизировать отчет &#171;Mirror Report&#187; средством вызова метода &#171;SelectReport&#187; класса TRvProject.</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Произвести поиск текстового элемента оформления TRaveText на первой странице отчета TRavePage. Для этого можно воспользоваться методом &#171;FindRaveComponent&#187; класса TRaveProjectManager, который в случае успешного поиска в качестве возвращаемого параметра вернет найденный объект, в противном случае возвратится NIL.</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Убедиться, что искомый объект произошел от нужного класса.</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Если искомый объект найден, то произвести с ним все необходимые манипуляции.</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>После внесенных изменений сгенерировать отчет методом &#171;Execute&#187; или &#171;ExecuteReport&#187; класса TRvProject.</td></tr></table></div><p>Ниже представлен пример реализации всего выше изложенного.</p>
<pre>
...
var
  I: Integer;
  TmpRaveComponent: TRaveComponent;
begin
  // Поиск и активизация необходимого отчета. Метод вернет false если отчет не найден
  if not RvProjectRTR.SelectReport('Mirror Report', true) then
    EXIT;
  // Поиск компонента с именем 'Text1' на первой странице отчета
  TmpRaveComponent := RvProjectRTR.ProjMan.FindRaveComponent('Text1',
    RvProjectRTR.ProjMan.ActiveReport.FirstPage);
  // Если объект найден, и он произошел от класса TRaveText
  if (TmpRaveComponent &lt;&gt; nil) and (TmpRaveComponent is TRaveText) then
  begin
    // Замена выводимого текста
    TRaveText(TmpRaveComponent).Text := 'Это мой новый заголовок';
    // Изменение стиля шрифта
    TRaveText(TmpRaveComponent).Font.Style := [fsItalic];
  end;
  // Генерация активного отчета
  RvProjectRTR.Execute;
end;
...
</pre>
<p>Как видите, ничего особо сложного нет. Найдя необходимый объект в отчете с ним можно делать почти все что угодно. Почему почти? Когда вы исследовали визуальные элементы оформления отчета средствами RTTI, то, может быть, обратили внимание на то, что все эти компоненты не имеют свойства &#171;Visible&#187;, хотя данное свойство уже доступно начиная с класса TRaveComponent. К сожалению, разработчики по каким то причинам не стали учитывать значение свойства &#171;Visible&#187;, что в принципе огорчает. Все-таки иногда может возникнуть необходимость скрыть, что-либо из отчета в зависимости от событий в программе.</p>
<p>Есть возможность имитировать свойство &#171;Visible&#187; используя свойство &#171;Parent&#187; нужного объекта. Чаще всего в качестве родителя объектов выступает страница отчета, но для группировки визуальных компонентов отчета в качестве родителя может выступать компонент-контейнер TRaveSection (также группировку объектов выполняют TRaveRegion и TRaveDataBand). Если визуальному компоненту не будет указан родитель в свойстве &#171;Parent&#187;, т.е. значение равное NIL, то данный объект не будет отображен в сгенерированном отчете. Для имитации свойства &#171;Visible&#187; объектов вновь обратимся к отчету &#171;Mirror Report&#187;. В данном отчете скроем все элементы оформления TRaveRectangle путем скрытия объектов TRaveSection. Последовательность действий будет следующей:</p>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Найти и активизировать отчет &#171;Mirror Report&#187; средством вызова метода &#171;SelectReport&#187; класса TRvProject.</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Пробежаться по всем дочерним компонентам страницы и найти компоненты производные от класса TRaveSection.</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>У компонентов TRaveSection в свойстве &#171;Parent&#187; проверить наличие родителя. Если родительский компонент назначен, то данному свойству присвоить значение NIL (скрытие объекта), в ином случае данному свойству в качестве родителя присвоить страницу отчета (отображение объекта на странице).</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>После внесенных изменений сгенерировать отчет.</td></tr></table></div><p>Возможно, некоторые задались вопросом, &#8211; почему бы сразу не скрыть TRaveRectangle напрямую, а через объект TRaveSection? Все возможно, но в данном случае:</p>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Элементы оформления TRaveRectangle объединены в группу компонентом TRaveSection. Следовательно, у объектов TRaveRectangle общий родитель TRaveSection. При назначении свойству &#171;Parent&#187; значения NIL у объекта TRaveSection, данный объект теряет родителя и скрывается со всеми его дочерними компонентами TRaveRectangle.</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Если каждому объекту TRaveRectangle в свойстве &#171;Parent&#187; указать значение равное NIL, а затем в данном свойстве в качестве нового родителя указать страницу отчета, то данные компоненты окажутся не на своем месте. Это вызвано тем, что значения в свойствах &#171;Left&#187; и &#171;Top&#187; компонента TRaveRectangle получены относительно клиентской части компонента TRaveSection. Отсюда вывод, что для корректного восстановления объектов для каждого TRaveRectangle нужно указать своего прежнего родителя, а это несколько усложняет подход к данной задаче. Но при необходимости все это возможно реализовать.</td></tr></table></div><p>Ниже представлен фрагмент кода, имитирующий скрытие объектов.</p>
<pre>
...
var
  I: Integer;
  TmpRaveComponent: TRaveComponent;
begin
  // Поиск и активизация необходимого отчета. Метод вернет false если отчет не найден
  if not RvProjectRTR.SelectReport('Mirror Report', true) then
    EXIT;
  // Проход по всем объектам первой страницы отчета
  for I := 0 to RvProjectRTR.ProjMan.ActiveReport.FirstPage.ComponentCount - 1
    do
    // Если объект является TRaveSection
    if RvProjectRTR.ProjMan.ActiveReport.FirstPage.Components[I] is TRaveSection
      then
    begin
      TmpRaveComponent :=
        TRaveComponent(RvProjectRTR.ProjMan.ActiveReport.FirstPage.Components[I]);
      // Если данный объект не имеет родителя, то в качестве
      // родителя указывается первая страница отчета
      if TmpRaveComponent.Parent = nil then
        TmpRaveComponent.Parent := RvProjectRTR.ProjMan.ActiveReport.FirstPage
          // Если объект имеет родителя, то уничтожается ссылка на родителя,
        // что в следствии приводит к скрытию объекта
      else
        TmpRaveComponent.Parent := nil;
    end;
  // Генерация активного отчета
  RvProjectRTR.Execute;
  ...
</pre>
<p class="note">Примечание</p>
<p>Вместо свойства &#171;Visible&#187; разработчики предусмотрели свойство &#171;DisplayOn&#187; у визуальных элементов оформления. Данное свойство позволяет установить, в каком случае отображать данный элемент оформления. Отображать: только при предварительном просмотре, только при выводе на печать, отображать в обоих случаях или наследовать настройки родителя. Изменение значения данного свойства упорно игнорируется визуальными компонентами. Очень жаль.</p>
<p>Рассмотрим еще одну проблему при оформлении отчета. Следует обратить внимание на отсутствие привычных свойств у некоторых визуальных компонентов. Возьмем, например компонент для вывода текста (TRaveText &#8211; аналог компонента TLabel). Данный компонент не предоставляет свойства для выбора фонового цвета (цвет кисти Brush) и по умолчанию является прозрачным.</p>
<p>На заметку: Фоновый цвет TRaveText останется прозрачным в том случае, если сгенерировать отчет, вызвав метод &#171;Execute&#187; или &#171;ExecuteReport&#187; класса TRvProject. Если отчет сгенерировать из среды разработки Rave Report, то фоновая заливка белого цвета под текстом останется непрозрачной. Такая вот недоработка присутствует в Rave Report.</p>
<p>Также в данном компоненте отсутствует свойство, определяющее его высоту. Не найдется там и привычное свойство &#171;AutoSize&#187; для выравнивания клиентского размера объекта под размер выводимого текста. Отчасти некоторые недостатки можно имитировать. Для придания фонового цвета можно подложить под компонент, к примеру, элемент оформления прямоугольник (TRaveRectangle).</p>
<p>Создать имитацию фонового цвета для текста в редакторе событий &#171;Event Editor&#187; весьма проблематично. Данная проблема выражается в следующем: т.к. в TRaveText не предоставлено свойство &#171;Height&#187; определяющее его высоту, то соответственно нет возможности получить точный размер по высоте компонента. Следовательно, при изменении размера шрифта компонента придется вручную подгонять высоту компонента TRaveRectangle. Также попытка получить доступ к свойству &#171;BoundsRect, Height&#187; (или к другому свойству или методу, не предоставленному в инспекторе объектов среды разработки отчета Rave Report) компонента может привести к плачевным результатам (даже если компиляция кода в &#171;Event Editor&#187; прошла успешно). В лучшем случае можно отделаться сообщением об ошибке, в худшем &#8211; критическое завершение работы генератора отчета Rave Report c потерей всех несохраненных данных, а при работе под</p>
<p>Windows 98 возможен полный &#171;крах&#187; системы.</p>
<p>Как видите, редактор событий &#171;Event Editor&#187; не предоставляет таких гибких возможностей для работы, как доступ к объектам в режиме RunTime. Для имитации фонового цвета как упоминалось выше вполне можно применить TRaveRectangle. Для этого необходимо:</p>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Создать объект производный от TRaveRectangle и придать ему нужное оформление.</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Подогнать размеры TRaveRectangle под размеры TRaveText.</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Поместить объект TRaveRectangle на задний план, воспользовавшись методом объекта &#171;SendToBack&#187;.</td></tr></table></div><p>Реализация имитации фонового цвета под текстом представлена ниже. В данном случае не удалось только создать имитацию &#171;AutoSize&#187; для объекта TRaveText:</p>
<pre>
...
var
  I: Integer;
  TmpRaveComponent: TRaveComponent;
  TmpRavePage: TRavePage;
  BGRect: TRaveRectangle;
begin
  // Поиск и активизация необходимого отчета. Метод вернет false если отчет не найден
  if not RvProjectRTR.SelectReport('Mirror Report', true) then
    EXIT;
  TmpRavePage := RvProjectRTR.ProjMan.ActiveReport.FirstPage;
  // Поиск компонента с именем 'Text1' на первой странице отчета
  TmpRaveComponent := RvProjectRTR.ProjMan.FindRaveComponent('Text1',
    TmpRavePage);
  // Если объект найден, и он произошел от класса TRaveText
  if (TmpRaveComponent &lt;&gt; nil) and (TmpRaveComponent is TRaveText) then
  begin
    // Создание графического примитива - прямоугольник
    BGRect := TRaveRectangle.Create(TmpRavePage);
    // Заполнение свойств вновь созданного объекта
    with BGRect do
    begin
      Name := 'BackGroundRect';
      FillColor := clYellow;
      BorderStyle := psClear;
      // Указание родителя компонента
      Parent := TmpRavePage;
      // Подгонка размеров прямоугольника под размеры компонента TRaveText
      BoundsRect := TRaveText(TmpRaveComponent).BoundsRect;
      // Перемещение объекта на задний план
      SendToBack;
    end;
  end;
  // Генерация активного отчета
  RvProjectRTR.Execute;
end;
...
</pre>
<p>В режиме RunTime вполне самостоятельно возможно создать: отчет, страницу отчета, визуальные элементы оформления или другие объекты, поддерживаемые отчетом Rave Report. Для создания нового отчета необходимо обратиться к методу &#171;NewReport&#187; менеджера отчетов TRaveProjectManager. В качестве возвращаемого параметра, возвращается объект порожденный от класса TRaveReport вновь созданного отчета. Для создания новой страницы для отчета следует обратиться к методу &#171;NewPage&#187; класса TRaveReport. Данный метод, как и в предыдущей ситуации, в качестве возвращаемого параметра возвращает объект типа TRavePage вновь созданной страницы отчета.</p>
<p class="note">Примечание</p>
<p>При создании нового отчета автоматически создается и новая страница.</p>
<p>При создании многостраничного отчета не следует забывать про свойство &#171;GotoPage&#187; компонента TRavePage или свойство &#171;PageList&#187; компонента TRaveReport, ведь данные свойства содержат указатели на следующую генерируемую страницу отчета. Если не воспользоваться ни одним из представленных свойств, то при генерации отчета будет сгенерированна только первая страница отчета. При создании новой страницы или отчета в RunTime нет необходимости указывать вновь созданным объектам хозяина или родителя компонента, все это, данные методы &#171;NewReport&#187; и &#171;NewPage&#187; осуществляют самостоятельно. При создании визуальных и не визуальных компонентов следует указать хозяина объекта. Если в качестве хозяина будет передано значение равное NIL, то после завершения работы с данными объектами, программист должен уничтожить их самостоятельно, воспользовавшись методом &#171;Free&#187; данного объекта. Для всех визуальных элементов оформления отчета следует обязательно указывать нужного родителя в свойстве &#171;Parent&#187;. Вспомните имитацию скрытия объектов</p>
<p>в отчете. Также учитывайте установленную единицу измерения в проекте отчета, для верного размещения визуальных объектов в отчете, иначе можете удивиться полученному результату.</p>
<p>В ниже приведенном примере создается отчет с двумя страницами. На первой странице создается текстовый элемент оформления TRaveText, а на второй странице компонент</p>
<p>TRaveBitMap для вывода графического изображения.</p>
<pre>
const
  NewRep = 'MyNewReport'; // Имя отчета (динамически создаваемого)
  FieldStr = 'FieldStr'; // Имя строкового поля
  FieldInt = 'FieldInt'; // Имя целочисленного поля
  NewDataView = 'NewDataView';
  // Имя компонента для посредника с источником данных
  ...
 
  // Вычисление позиции точки в процентах относительно
  // ширины/высоты визуального компонента
 
function SetPointInPercent(RaveControlWH: TRaveUnits; Percent: Byte):
  TRaveUnits;
begin
  Result := (RaveControlWH / 100) * Percent;
end;
 
...
const
  Picture = '1.bmp';
var
  TmpRaveReport: TRaveReport;
  TmpRavePage: TRavePage;
  TmpRaveText: TRaveText;
  TmpRaveBitMap: TRaveBitmap;
  TmpPageList: TRaveComponentList;
begin
  // Если отчет уже создан, то выходим
  if RvProjectRTR.SelectReport(NewRep, true) then
    EXIT;
  // Добавление нового отчета в проект и заполнение его свойств
  TmpRaveReport := RvProjectRTR.ProjMan.NewReport;
  with TmpRaveReport do
  begin
    Name := NewRep;
    FullName := NewRep;
    // Создание новой страницы для отчета (здесь будет графическое изображение)
    TmpRavePage := NewPage;
    // Указывается следующая страница для генерации отчета,
    // после того, как будет сгенерированна первая страница отчета
    TmpRaveReport.FirstPage.GotoPage := TmpRavePage;
  end;
  // Создание компонента для вывода графического изображения и заполнение его свойств
  TmpRaveBitMap := TRaveBitMap.Create(TmpRavePage);
  with TmpRaveBitMap do
  begin
    Name := 'MyNewRaveBitMap';
    Left := SetPointInPercent(TmpRavePage.PageWidth, 5);
    Top := SetPointInPercent(TmpRavePage.PageHeight, 20);
    Width := SetPointInPercent(TmpRavePage.PageWidth, 30);
    Height := SetPointInPercent(TmpRavePage.PageHeight, 30);
    // Загрузка графического изображения (если найден указанный файл)
    if FileExists(Picture) then
      Image.LoadFromFile(Picture);
    // Размеры изображения будут подогнаны под клиентские размеры компонента
    MatchSide := msBoth;
    // Родителем данного компонента будет страница TmpRavePage
    Parent := TmpRavePage;
  end;
  // Создание элемента TRaveText и заполнение его свойств
  TmpRaveText := TRaveText.Create(TmpRaveReport.FirstPage);
  with TmpRaveText do
  begin
    Left := SetPointInPercent(TmpRaveReport.FirstPage.PageWidth, 10);
    ;
    Top := SetPointInPercent(TmpRaveReport.FirstPage.PageHeight, 15);
    ;
    Font.Size := 18;
    Name := 'MyNewRaveText';
    // Родителем данного объекта будет первая страница отчета
    Parent := TmpRaveReport.FirstPage;
    Text := 'Этот текст расположен на первой странице отчета';
  end;
  // Заполение свойств страницы TmpRavePage
  with TmpRavePage do
  begin
    Name := 'MyNewRavePage';
    FullName := 'Моя новая страница';
  end;
  // Создание списка генерируемых страниц
  TmpPageList := TRaveComponentList.Create;
  TmpPageList.Add(TmpRavePage);
  TmpPageList.Add(TmpRaveReport.FirstPage);
  TmpRaveReport.PageList := TmpPageList;
  // Обновление списка доступных отчетов
  RvProjectRTR.GetReportList(ListReport.Items, True);
end;
...
</pre>
<p>В данном примере для перехода к следующей генерируемой странице применены оба свойства &#171;PageList&#187; и &#171;GotoPage&#187;. Чтобы лучше понять их принцип работы создайте новый отчет по выше представленному примеру и сгенерируйте его.</p>
<pre>
...
if RvProjectRTR.SelectReport('Мой новый отчет', true) then
  RvProjectRTR.Execute;
...
</pre>
<p>Как видите, отчет сгенерировал три страницы. Это происходит потому, что сначала осуществляется проход по списку в свойстве &#171;PageList&#187; (если он не пуст). Вновь генерируемая страница из этого списка также проверяет свое свойство &#171;GotoPage&#187; на наличие перехода на другую страницу. После генерации страницы указанной в свойстве &#171;GotoPage&#187; (если данное свойство указывает на страницу) продолжается обход по списку &#171;PageList&#187;. Следует соблюдать осторожность при указании порядка генерации страниц отчета, при задании неверного порядка может произойти бесконечный цикл генерации страниц (если данный случай имеет место быть). Схематично это можно отобразить так (в скобках указан порядок генерации страниц):</p>
<p>Если очистить список страниц у отчета в свойстве &#171;PageList&#187; (все в том же выше приведенном примере) и вновь сгенерировать отчет, то результат соответственно будет совсем другим.</p>
<pre>
...
if RvProjectRTR.SelectReport('Мой новый отчет', true) then
begin
  RvProjectRTR.ProjMan.ActiveReport.PageList := nil;
  RvProjectRTR.Execute;
end;
...
</pre>
<p>Можно в отчете в RunTime подключить и источник данных. Как оговаривалось выше эти функции выполняют основные классы: TRaveDataView, TRaveDataField и собственно сам источник данных, например TRvDataSetConnection.</p>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Условимся, что некий источник данных в проекте уже существует и содержит некоторые данные. В данном случае рассмотрим пример подключения к текстовому типу поля таблицы. Для начала нам потребуется &#171;связной&#187; с источником данных &#8211; TRaveDataView. Для того, чтобы созданный &#171;связной&#187; присутствовал в проекте отчета Rave Report его нужно добавить в список подключенный модулей данных, воспользовавшись методом &#171;Add&#187; свойства &#171;DataObjectList&#187; у класса TRaveProjectManager. У созданного объекта TRaveDataView достаточно заполнить четыре основных свойства: Name &#8211; имя компонента, Parent &#8211; родительский компонент (TRaveProjectManager), DataCon.Connection &#8211; подключаемый источник данных (в данном примере TRvDataSetConnection), ConnectionName &#8211; имя подключаемого источника данных.</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Далее необходимо найти необходимое поле в источнике данных TDataSet воспользовавшись методом &#171;FindField&#187; и выяснить к какому типу данных это поле принадлежит. После определения типа поля в источнике данных необходимо создать соответствующее (совместимое) поле данных TRaveDataField для отчета Rave Report. Для TRaveDataField также достаточно заполнить четыре основных свойства: Name &#8211; имя компонента, FieldName &#8211; имя поля, Parent &#8211; родительский компонент (TRaveDataView), DataIndex &#8211; порядковый номер в списке полей источника данных (таблице).</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>При необходимости в отчете можно создать TRaveRegion, TRaveDataBand, TRaveDataText (если не созданны). Будем считать, что данные объекты уже созданы в проекте отчета Rave Report. Для TRaveDataBand, TRaveDataText следует указать поставщика источников данных</td></tr></table></div><p>(TRaveDataView) воспользовавшись свойством &#171;DataView&#187; этих классов. Для TRaveDataText следует дополнительно указать имя поля, из которого будет производиться выборка данных, для чего следует обратиться к свойству &#171;DataField&#187; этого класса.</p>
<p>Пример реализации подключения источника данных приведен ниже. Данный пример присоединяет источник данных к вновь созданному отчету ('MyNewReport' &#8211; рассмотренному выше).</p>
<pre>
...
var
  TmpRaveReport: TRaveReport;
  TmpDataView: TRaveDataView;
  TmpDataField: TRaveDataField;
  TmpRaveRegion: TRaveRegion;
  TmpRaveDataBand: TRaveDataBand;
  TmpRaveDataText: TRaveDataText;
  TmpField: TField;
begin
  TmpDataField := nil;
  if not RvProjectRTR.SelectReport(NewRep, true) then
    EXIT;
  if (ADOTableRTR.FieldCount &lt; 1) or (not ADOTableRTR.Active) then
    EXIT;
  // Поиск строкового поля
  TmpField := RvDataSetConnectionRTR.DataSet.FindField(FieldStr);
  if TmpField = nil then
    EXIT;
  TmpRaveReport := RvProjectRTR.ProjMan.ActiveReport;
  // Создание TRaveDataView обеспечивающий работу с источником данных
  TmpDataView := TRaveDataView.Create(RvProjectRTR.ProjMan);
  RvProjectRTR.ProjMan.DataObjectList.Add(TmpDataView);
  with TmpDataView do
  begin
    Name := NewDataView;
    Parent := RvProjectRTR.ProjMan;
    DataCon.Connection := RvDataSetConnectionRTR;
    ConnectionName := TmpDataView.DataCon.Connection.Name;
  end;
 
  // В зависимости от типа данных поля создается поле данных для отчета
  // Rave Report соотвествующего типа
  case TmpField.DataType of
    ftString,
      ftWideString: TmpDataField := TRaveStringField.Create(TmpDataView);
    ftInteger: TmpDataField := TRaveIntegerField.Create(TmpDataView);
  end;
  if TmpDataField = nil then
    EXIT;
  // Заполение свойств поля данных
  with TmpDataField do
  begin
    Name := TmpField.Name; // Имя компонента
    FieldName := TmpField.FieldName; // Имя поля
    FullName := TmpField.DisplayName; // Альтернативное имя поля
    // Порядковый номер в списке полей источника данных (таблице)
    DataIndex := TmpField.Index;
    Parent := TmpDataView; // Родительский компонент
  end;
  // Создание TRaveRegion на котром будут расположены компоненты для работы с источником данных
  TmpRaveRegion := TRaveRegion.Create(TmpRaveReport.FirstPage);
  with TmpRaveRegion do
  begin
    Name := 'NewRaveRegion';
    Parent := TmpRaveReport.FirstPage;
    Left := SetPointInPercent(TmpRaveReport.FirstPage.PageWidth, 5);
    Top := SetPointInPercent(TmpRaveReport.FirstPage.PageHeight, 15);
    Width := SetPointInPercent(TmpRaveReport.FirstPage.PageWidth, 70);
    Height := SetPointInPercent(TmpRaveReport.FirstPage.PageHeight, 60);
  end;
  // Создание TRaveDataBand для размещения елементов оформления отчета на нем
  TmpRaveDataBand := TRaveDataBand.Create(TmpRaveRegion);
  with TmpRaveDataBand do
  begin
    Name := 'NewDataBand';
    Parent := TmpRaveRegion;
    Left := SetPointInPercent(TmpRaveRegion.Width, 5);
    Top := SetPointInPercent(TmpRaveRegion.Height, 5);
    Width := SetPointInPercent(TmpRaveRegion.Width, 90);
    Height := SetPointInPercent(TmpRaveRegion.Height, 5);
    DataView := TmpDataView;
  end;
  // TRaveDataText обеспечит отображение информации из источника данных
  TmpRaveDataText := TRaveDataText.Create(TmpRaveDataBand);
  with TmpRaveDataText do
  begin
    Name := 'NewDataText';
    Parent := TmpRaveDataBand;
    Left := SetPointInPercent(TmpRaveDataBand.Width, 1);
    Top := SetPointInPercent(TmpRaveDataBand.Height, 1);
    Width := SetPointInPercent(TmpRaveDataBand.Width, 50);
    DataView := TmpDataView;
    DataField := TmpDataField.FieldName;
  end;
  RvProjectRTR.ExecuteReport(NewRep);
  ...
</pre>
<p>Создав новый отчет или изменив существующий можно сохранить внесенные изменения. Чтобы ваши труды не пропали даром, измененный проект отчета можно сохранить, воспользовавшись методом &#171;Save&#187;. Если возникнет необходимость сохранить проект отчета Rave Report под другим именем, то следует изменить имя файла проекта в свойстве &#171;ProjectFile&#187; или воспользоваться методом &#171;SetProjectFile&#187; перед сохранением проекта. Все данные свойства и методы доступны у менеджера отчета TRvProject или TRaveProjectManager. Пример сохранения проекта отчета под другим именем:</p>
<pre>
...
// Сохраниение новго отчета под именем 'TestSave.rav'
RvProjectRTR.SetProjectFile('TestSave.rav');
RvProjectRTR.Save;
...
</pre>

<p>P.S. Ну, вот вроде и все о чем хотелось поведать. Надеюсь после выхода данной статьи, у пользователей генератора отчета Rave Report работа хоть сколько-то облегчится. Если вы заметили какие-либо ошибки, недочеты в данной статье, а также если у вас есть какие либо предложения или дополнения к данной статье, то все ваши отзывы будут приятны здесь: Sun-bittern@mail.ru</p>
<p>Турушев Виталий (Sun bittern &#169;)<br>
<p>Нижний Тагил 2004г.</p>

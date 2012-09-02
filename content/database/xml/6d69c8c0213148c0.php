<h1>XML сериализация объекта Delphi</h1>
<div class="date">01.01.2007</div>


<p>XML сериализация объекта Delphi</p>
Язык XML предоставляет нам чрезвычайно удобный и почти универсальный подход к хранению и передаче информации. Не хватает только средств, которые позволили бы удобно и просто организовать работу с XML. Предлагаемая разработка реализует очень эффективную возможность - XML сериализацию объектов любых классов Delphi и из загрузку из XML кода. <br>
&nbsp;<br>
Рассматриваемый подход дает возможность наиболее удобно интегрировать обработку XML объектов в среду разработки Delphi и C++Builder. Возможность доступа к свойствам объектов определяется RTTI. Его возможности в Delphi очень велики, т.к. среда разработки сама хранит ресурсы объектов в текстовом формате. <br>
&nbsp;<br>
Для начала определим ряд простых функций для формирования XML кода. Они позволят нам добавлять открывающие, закрывающие теги и значения в результирующий текст. <br>
<p>&nbsp;</p>
<pre>
  { Добавляет открывающий тег с заданным именем } 
  procedure addOpenTag(const Value: string); 
  begin 
    Result := Result + '&lt;' + Value + '&gt;'; 
    inc(Level); 
  end; 
 
  { Добавляет закрывающий тег с заданным именем } 
  procedure addCloseTag(const Value: string; addBreak: boolean = false); 
  begin 
    dec(Level); 
    Result := Result + '&lt;/' + Value + '&gt;'; 
  end; 
 
  { Добавляет значение в результирующую строку } 
  procedure addValue(const Value: string); 
  begin 
    Result := Result + Value; 
  end;
</pre>
<p>&nbsp;<br>
&nbsp;<br>
<p>Следующее, что предстоит реализовать - это перебор всех свойств объекта и формирование тегов. Сведения о свойствах получаются через интерфейс компонента. Это информация о типе. Для каждого свойства, за исключением классовых получается их имя и текстовое значение, после чего формируется XML-тег. Значение загружается через ф-ию TypInfo.GetPropValue(); </p>
<pre>
 { Playing with RTTI } 
  TypeInf := Component.ClassInfo; 
  AName := TypeInf^.Name; 
  TypeData := GetTypeData(TypeInf); 
  NumProps := TypeData^.PropCount; 
 
 
  GetMem(PropList, NumProps*sizeof(pointer)); 
  try 
    { Получаем список строк } 
    GetPropInfos(TypeInf, PropList); 
 
    for i := 0 to NumProps-1 do 
    begin 
      PropName := PropList^[i]^.Name; 
 
      PropTypeInf := PropList^[i]^.PropType^; 
      PropInfo := PropList^[i]; 
 
      case PropTypeInf^.Kind of 
        tkInteger, tkChar, tkEnumeration, tkFloat, tkString, tkSet, 
        tkWChar, tkLString, tkWString, tkVariant: 
        begin 
          { Получение значения свойства } 
          sPropValue := GetPropValue(Component, PropName, true); 
 
          { Перевод в XML } 
          addOpenTag(PropName); 
          addValue(sPropValue); { Добавляем значение свойства в результат } 
                   addCloseTag(PropName); 
        end;
        ...
</pre>
<p>&nbsp;<br>
Для классовых типов придется использовать рекурсию для загрузки всех свойств соответствующего объекта. <br>
Более того, для ряда классов необходимо использовать особый подход. Сюда относятся, к примеру, строковые списки и коллекции. Ими и ограничимся.<br>
&nbsp;<br>
Для текстового списка TStrings будем сохранять в XML его свойство CommaText, а в случае коллекции после обработки всех ее свойств сохраним в XML каждый элемент TCollectionItem отдельно. При этом в качестве контейнерного тега будем использовать имя класса TCollection(PropObject).Items[j].ClassName. <br>
<p>&nbsp;</p>
<pre>
        ...
        tkClass: { Для классовых типов рекурсивная обработка } 
                begin 
          addOpenTag(PropName); 
 
          PropObject := GetObjectProp(Component, PropInfo); 
          if Assigned(PropObject)then 
          begin 
            { Для дочерних свойств-классов - рекурсивный вызов } 
                    if (PropObject is TPersistent) then 
               Result := Result + SerializeInternal(PropObject, Level); 
 
            { Индивидуальный подход к некоторым классам } 
                    if (PropObject is TStrings) then { Текстовые списки } 
                    begin 
              Result := Result + TStrings(PropObject).CommaText; 
            end else 
            if (PropObject is TCollection) then { Коллекции } 
                    begin 
              Result := Result + SerializeInternal(PropObject, Level); 
              for j := 0 to (PropObject as TCollection).Count-1 do 
              begin 
                addOpenTag(TCollection(PropObject).Items[j].ClassName); 
                Result := Result + 
                 SerializeInternal(TCollection(PropObject).Items[j], Level); 
                addCloseTag(TCollection(PropObject).Items[j].ClassName, true); 
              end 
            end; 
            { Здесь можно добавить обработку остальных классов: TTreeNodes, TListItems } 
          end; 
          addCloseTag(PropName, true); 
        end; 
</pre>
<p>&nbsp;<br>
Описанные функции позволят нам получить XML код для объекта включая все его свойства. Остается только 'обернуть' полученный XML в тег верхнего уровня - имя класса объекта. Если мы поместим вышеприведенный код в функцию SerializeInternal(), то результирующая функция Serialize() будет выглядеть так: <br>
<p>&nbsp;</p>
<pre>
procedure Serialize(Component: TObject;); 
...
  Result := Result + '&lt;' + Component.ClassName + '&gt;'; 
  Result := Result + SerializeInternal(Component);  преобразовать свойства в XML
  Result := Result + '&lt;/' + Component.ClassName + '&gt;'; 
</pre>
<p>&nbsp;<br>
К вышеприведенному можно добавить еще ф-ии для форматирования генерируемого XML кода. Также можно добавить пропуск пустых значений и свойств со значениями по умолчанию. <br>
<p>&nbsp;</p>
Загрузка XML в объект</p>
После того, как мы рассмотрели возможность превода данных объекта в XML следует перейти к следующей задаче. Задача состоит в реализации обратного процесса, а именно - загрузки XML данных в объект. <br>
&nbsp;<br>
Загрузка XML данных в объект, или десериализация, представляет собой более сложный процесс, т.к. в ходе его необходимо осуществить корректный разбор текстового XML документа на предмет инициализации содержащимися в нем данными заданного объекта. <br>
&nbsp;<br>
Примем ряд упрощений, которые сократят число проверок корректности входящего XML документа к минимуму. Первое, что необходимо делать, тек это проверять соответствие тега верхнего уровня имени класса нашего объекта. Синтаксическая правильность документа будет проверяться в ходе загрузки данных. При необходимости более жесткой проверки загружаемых XML документов можно привлечь, к примеру, парсер MSXML. Последний поможет нам проверить документ на синтаксическую, а также семантическую корректность при наличии соответствующего DTD. <br>
&nbsp;<br>
Первое, что следует реализовать, это процедура верхнего уровня, которая получает объект для инициализации, а также потоковый источник данных с текстом XML документа. <br>
<p>&nbsp;</p>
<pre>
var 
  Buffer: PChar; { Буфер, в котором находится XML документ  } 
    TokenPtr: PChar; { Указатель на текущее положение парсера XML документа }
 
{ 
  Загружает в компонент данные из потока с XML-кодом. 
  Вход: 
    Component - компонент для конвертации 
    Stream - источник загрузки XML 
  Предусловия: 
    Объект Component должен быть создан до вызова процедуры 
} 
procedure DeSerialize(Component: TObject; Stream: TStream); 
begin 
  GetMem(Buffer, Stream.Size); 
  try 
    { Получаем данные из потока } 
         Stream.Read(Buffer[0], Stream.Size + 1); 
    { Устанавливаем текущий указатель чтения данных } 
         TokenPtr := Buffer; 
    { Вызываем загрузчик } 
         DeSerializeInternal(Component, Component.ClassName); 
  finally 
    FreeMem(Buffer); 
  end; 
end;
</pre>
<p>&nbsp;<br>
Следующий код занимается тривиальным разбором XML текта. Ищется первый открывающий тег, затем его закрывающая пара. Найденная пара содержит в себе данные для свойств объекта. Внутри найденной пары тегов последовательно выбираются теги (TagName) и текст их содержания (TagValue). Эти теги предположительно соответствуют свойствам объекта, что мы тут же и проверяем. <br>
&nbsp;<br>
Среди свойств объекта отыскивается через FindProperty() оноименное свойство. При неудаче генерируется исключение об ошибочности XML тега. Если для тега найден соответвующее свойство, то передаем дальнейшую обработку процедуре SetPropertyValue(), которая заданное свойство с именем TagName проинициализирует найденным значением TagValue. <br>
&nbsp;<br>
Не забываем также передвигать указатель чтения данных TokenPtr по мере выборки данных. <br>
<p>&nbsp;</p>
<pre>
{ 
  Рекурсивная процедура загрузки объекта их текстового буфера с XML 
  Вызывается из: 
    Serialize() 
  Вход: 
    Component - компонент для конвертации 
    ComponentTagName - имя XML тега объекта 
} 
procedure DeSerializeInternal(Component: TObject; const ComponentTagName: string); 
var 
  BlockStart, BlockEnd, TagStart, TagEnd: PChar; 
  TagName, TagValue: PChar; 
  TypeInf: PTypeInfo; 
  TypeData: PTypeData; 
  PropIndex: integer; 
  AName: string; 
  PropList: PPropList; 
  NumProps: word; 
 
  { Поиск у объекта свойства с заданным именем } 
  function FindProperty(TagName: PChar): integer; 
  var i: integer; 
  begin 
    Result := -1; 
    for i := 0 to NumProps-1 do 
    if CompareText(PropList^[i]^.Name, TagName) = 0 then 
    begin 
      Result := i; 
      break; 
    end; 
  end; 
 
  procedure SkipSpaces(var TagEnd: PChar); 
  begin 
    while (TagEnd[0] in [#0..#20]) do inc(TagEnd); 
  end; 
 
begin 
  { Playing with RTTI } 
  TypeInf := Component.ClassInfo; 
  AName := TypeInf^.Name; 
  TypeData := GetTypeData(TypeInf); 
  NumProps := TypeData^.PropCount; 
  GetMem(PropList, NumProps*sizeof(pointer)); 
 
  try 
    GetPropInfos(TypeInf, PropList); 
 
  { ищем открывающий тег } 
 
     BlockStart := StrPos(TokenPtr, PChar('&lt;' + ComponentTagName + '&gt;')); 
  inc(BlockStart, length(ComponentTagName) + 2); 
  { ищем закрывающий тег } 
     BlockEnd := StrPos(BlockStart, PChar('&lt;&lt;' + ComponentTagName + '&gt;')); 
 
  TagEnd := BlockStart; 
  SkipSpaces(TagEnd); 
 
  { XML парсер } 
  while TagEnd do 
  begin 
    TagStart := StrPos(TagEnd, '&lt;'); 
    TagEnd := StrPos(TagStart, '&gt;'); 
    GetMem(TagName, TagEnd - TagStart + 1); 
    try 
      { TagName - имя тега } 
               StrLCopy(TagName, TagStart + 1, TagEnd - TagStart - 1); 
 
       TagEnd := StrPos(TagStart, PChar('&lt;/' TagName + ?try 
        { TagValue - значение тега } 
                 StrLCopy(TagValue, TagStart, TagEnd - TagStart); 
 
         { поиск свойства, соответствующего тегу } 
                 PropIndex := FindProperty(TagName); 
        if PropIndex = -1 then 
          raise Exception.Create(
         'TglXMLSerializer.DeSerializeInternal: Uncknown property: ' + TagName); 
 
        SetPropertyValue(Component, PropList^[PropIndex], TagValue); 
 
        inc(TagEnd, length('&lt;/' TagName + ?finally 
        FreeMem(TagValue); 
      end; 
    finally 
      FreeMem(TagName); 
    end; 
  end; 
 
  finally 
    FreeMem(PropList, NumProps*sizeof(pointer)); 
  end; 
 
end;
</pre>
<p>&nbsp;<br>
Остается только код, который загрузит найденные данные в заданной свойство. Процедуре SetPropertyValue() передаются данные о соответствующем свойстве (PropInfo), которое на следует проинициализировать. Также процедура получает и текстовое значение, содержащееся в найденном теге. <br>
&nbsp;<br>
В случае, если тип данные не является классовым типом, то, очевидно, текст Value следует просто загрузить в свойство. Это реализуется вызовом процедуры TypInfo.SetPropValue(). Последняя самостоятельно разберется, как корректно преобразовать тестовое значение в значение свойства в завистимости от его типа. <br>
&nbsp;<br>
Если свойство имеет классовый тип, то его значение Value должно содержать XML код, описывающий свойства данного класса. В этом случае воспользуемся рекурсией и передадим обработку вышеприведенной процедуре DeSerializeInternal(). При этом передаем ей в качестве объекта ссылку на найденное свойство PropObject и его имя PropInfo^.Name. <br>
&nbsp;<br>
<p>Нам также необходимо озаботиться отдельной обработкой данных для таких классовых типов как списки TStrings и коллекции TCollection. Данные для списков мы загружаем из значения Value как CommaText. Тут все понятно. В сллучае же коллеций данные о элементах коллекции в XML документе содержаться в виде последовательных контейнерных тегов с именем типа элемента коллекци. Т.е., к примеру, &lt;TMyCollection&gt; ... &lt;/TMyCollection&gt; &lt;TMyCollection&gt; ... &lt;/TMyCollection&gt; &lt;TMyCollection&gt; ... &lt;/TMyCollection&gt; и так далее. Внутри каждой пары тегов &lt;TMyCollection&gt; содержатся свойства объекта TMyCollection. </p>
<pre>
procedure SetPropertyValue(Component: TObject; PropInfo: PPropInfo; Value: PChar); 
var 
  PropTypeInf: PTypeInfo; 
  PropObject: TObject; 
  CollectionItem: TCollectionItem; 
  sValue: string; 
begin 
    PropTypeInf := PropInfo.PropType^; 
 
    case PropTypeInf^.Kind of 
      tkInteger, tkChar, tkEnumeration, tkFloat, tkString, tkSet, 
      tkWChar, tkLString, tkWString, tkVariant: 
      begin 
        sValue := StrPas(Value); 
        { Для корректного преобразования парсером tkSet нужны угловые скобки } 
              if PropTypeInf^.Kind = tkSet then sValue := '[' + sValue + ']'; 
        SetPropValue(Component, PropInfo^.Name, sValue); 
      end; 
      tkClass: 
      begin 
        PropObject := GetObjectProp(Component, PropInfo); 
        if Assigned(PropObject)then 
        begin 
          { Индивидуальный подход к некоторым классам } 
                if (PropObject is TStrings) then { Текстовые списки } 
                  TStrings(PropObject).CommaText := Value 
          else 
          if (PropObject is TCollection) then { Коллекции } 
         begin 
            while true do { Заранее не известно число элементов в коллекции } 
               begin 
              CollectionItem := (PropObject as TCollection).Add; 
              try 
                DeSerializeInternal(CollectionItem, CollectionItem.ClassName); 
              except { Исключение, если очередной элемент не найден } 
                      CollectionItem.Free; 
                break; 
              end; 
            end; 
          end 
          else { Для остальных классов - рекурсивная обработка } 
                         DeSerializeInternal(PropObject, PropInfo^.Name); 
        end; 
 
      end; 
    end; 
end; 
</pre>
<p>&nbsp;<br>
<p>К приведенному коду следует добавить еще ряд возможностей для более корректной реакции для обработки неверного XML кода. Также можно достаточно просто реализовать автоматическую генерацию DTD для любого класса Delphi. После этого можно собрать полноценный компонент, объединяющий в себе всю необходимую функциональность для XML сериализации. </p>
Создание DTD для объекта</p>
За созданием кода для сериализации и десериализации объектов в Delphi логично перейти к рассмотрению вопроса о возможности генерации соответствующего DTD для сохраняемых в XML классов. DTD понадобится нам, если мы захотим провести проверку XML документа на корректность и допустимость с помощью одного из XML анализаторов. Работа с анализатором MSXML рассмотрена в статье Загрузка и анализ документа XML.. <br>
&nbsp;<br>
Автоматическое создание DTD очень простая задача. У нас все для этого есть. Необходимо рекурсивно пройтись по всем свойствам объекта и сгенерировать модели содержания для каждого тега. При сериализации в XML мы не использовали атрибутов, а значит мы не сможем в DTD установить контроль над содержанием конкретных элементов. Остается только определить модель содержания для XML, т.е. вложенность тегов в друг друга. <br>
&nbsp;<br>
Создадим процедуру GenerateDTD(), которая обеспечит запись формируемого DTD для заданного объекта Component в заданный поток Stream. Она создает список DTDList, в котором будут накапливаться атрибуты DTD, после чего передает всю черновую работу процедуре GenerateDTDInternal(). <br>
<p>&nbsp;</p>
<pre>
{ 
  Процедура генерации DTD для заданного объекта в 
  соответсвии с published интерфейсом его класса. 
  Вход: 
    Component - объект 
  Выход: 
    текст DTD в поток Stream 
} 
procedure GenerateDTD(Component: TObject; Stream: TStream); 
var 
  DTDList: TStringList; 
begin 
  DTDList := TStringList.Create; 
  try 
    GenerateDTDInternal(Component, DTDList, Stream, Component.ClassName); 
  finally 
    DTDList.Free; 
  end; 
end; 
</pre>
<p>&nbsp;<br>
Следующий код просматривает свойства объекта, составляет их список, а затем формирует из этого модель содержания для элемента. Для свойств классовых типов используется рекурсия. Поскольку при сериализации объекта мы не использовали атрибутов, то определений для них создавать нет необходимости. <br>
&nbsp;<br>
Для всех неклассовых типов модель содержания это - (#PCDATA). К примеру, свойство объекта Tag: integer превращается в . <br>
&nbsp;<br>
Отдельно подходим к коллекциям. Для них необходимо указать на множественность дочернего тега элемента коллекции. Например, для свойства TMyCollection модель содержания может выглядеть так: . <br>
<p>&nbsp;</p>
<pre>
{ 
  Внутренняя рекурсивная процедура генерации DTD для заданного объекта. 
  Вход: 
    Component - объект 
    DTDList - список уже определенных элементов DTD 
              для предотвращения повторений. 
  Выход: 
    текст DTD в поток Stream 
} 
procedure GenerateDTDInternal(Component: TObject; DTDList: TStrings; 
                Stream: TStream; const ComponentTagName: string); 
var 
  PropInfo: PPropInfo; 
  TypeInf, PropTypeInf: PTypeInfo; 
  EnumInfo: PTypeInfo; 
  TypeData: PTypeData; 
  i, j: integer; 
  AName, PropName, sPropValue, s, TagContent: string; 
  PropList: PPropList; 
  NumProps: word; 
  PropObject: TObject; 
const 
  PCDATA = '#PCDATA'; 
  procedure addElement(const ElementName: string; Data: string); 
  var s: string; 
  begin 
    if DTDList.IndexOf(ElementName) &lt;&gt; -1 then exit; 
    DTDList.Add(ElementName); 
    s := '&lt;!ELEMENT ' + ElementName + ' '; 
    if Data = '' then Data := PCDATA; 
    s := s + '(' + Data + ')&gt;'#13#10; 
    Stream.Write(PChar(s)[0], length(s)); 
  end; 
begin 
  { Playing with RTTI } 
  TypeInf := Component.ClassInfo; 
  AName := TypeInf^.Name; 
  TypeData := GetTypeData(TypeInf); 
  NumProps := TypeData^.PropCount; 
 
 
  GetMem(PropList, NumProps*sizeof(pointer)); 
  try 
    { Получаем список свойств } 
    GetPropInfos(TypeInf, PropList); 
    TagContent := ''; 
 
    for i := 0 to NumProps-1 do 
    begin 
      PropName := PropList^[i]^.Name; 
 
      PropTypeInf := PropList^[i]^.PropType^; 
      PropInfo := PropList^[i]; 
 
      { Пропустить не поддерживаемые типы } 
      if not (PropTypeInf^.Kind in [tkDynArray, tkArray, 
                  tkRecord, tkInterface, tkMethod]) then 
      begin 
        if TagContent &lt;&gt; '' then TagContent := TagContent + '|'; 
        TagContent := TagContent + PropName; 
      end; 
 
 
      case PropTypeInf^.Kind of 
        tkInteger, tkChar, tkFloat, tkString, 
        tkWChar, tkLString, tkWString, tkVariant, tkEnumeration, tkSet: 
        begin 
          { Перевод в DTD. Для данных типов модель содержания - #PCDATA } 
          addElement(PropName, PCDATA); 
        end; 
        { код был бы полезен при использовании атрибутов 
        tkEnumeration: 
        begin 
          TypeData:= GetTypeData(GetTypeData(PropTypeInf)^.BaseType^); 
          s := ''; 
          for j := TypeData^.MinValue to TypeData^.MaxValue do 
          begin 
            if s &lt;&gt; '' then s := s + '|'; 
            s := s + GetEnumName(PropTypeInf, j); 
          end; 
          addElement(PropName, s); 
        end; 
        } 
        tkClass: { Для классовых типов рекурсивная обработка } 
        begin 
          PropObject := GetObjectProp(Component, PropInfo); 
          if Assigned(PropObject)then 
          begin 
            { Для дочерних свойств-классов - рекурсивный вызов } 
            if (PropObject is TPersistent) then 
              GenerateDTDInternal(PropObject, DTDList, Stream, PropName); 
          end; 
        end; 
 
      end; 
    end; 
 
    { Индивидуальный подход к некоторым классам } 
    { Для коллекций необходимо включить в модель содержания тип элемента } 
    if (Component is TCollection) then 
    begin 
      if TagContent &lt;&gt; '' then TagContent := TagContent + '|'; 
      TagContent := TagContent + 
           (Component as TCollection).ItemClass.ClassName + '*'; 
    end; 
 
    { Добавляем модель содержания для элемента } 
    addElement(ComponentTagName, TagContent); 
  finally 
    FreeMem(PropList, NumProps*sizeof(pointer)); 
  end; 
 
end; 
</pre>
<p>&nbsp;<br>
&nbsp;<br>
<p>Закоментированный код нам не нужен, но он не удален, т.к. он демонстрирует получение списка возможных значений для перечисления (Enumeration) и набора (Set). Это может понадобится, если появится необходимость генерировать свойства в виде атрибутов XML тегов и, соответственно, DTD для возможных значений этих атрибутов. </p>
Компонент для XML сериализации</p>
<p>&nbsp;<br>
Объединяя сказанное о сериализации, десериализации объектов и создании DTD соберем <br>
полноценный компонент для XML сериализации. Компонент конвертирует компонент в XML и обратно в соответствии с published-интерфейсом класса компонента. XML формируется в виде пар тегов с вложенными в них значениями. Атрибуты у тегов отсутствуют. Тег верхнего уровня соответствует классу объекта. Вложенные теги соответствуют именам свойств. Для элементов коллекций контейнерный тег соответствует имени класса. Вложенность тегов не ограничена и полностью повторяет published интерфейс класса заданного объекта. Поддерживаются целые типы, типы с плавающей точкой, перечисления, наборы, строки, символы. вариантные типы, классовые типы, стоковые списки и коллекции.<br>
Интерфейс:<br>
&nbsp;<br>
procedure Serialize(Component: TObject; Stream: TStream); - Сериализация объекта в XML procedure <br>
&nbsp;<br>
DeSerialize(Component: TObject; Stream: TStream); - Загрузка XML в объект property<br>
&nbsp;<br>
GenerateFormattedXML - создавать форматированный XML код property <br>
&nbsp;<br>
ExcludeEmptyValues - пропускать пустые значения свойств property <br>
&nbsp;<br>
ExcludeDefaultValues - пропускать значения по умолчанию property OnGetXMLHeader - позволяет указать свой XML заголовок <br>
&nbsp;<br>
Ограничения :<br>
В объекте допустимо использовать только одну коллекцию каждого типа. Для преодоления этого ограничения требуется некоторая доработка. Наследники класса TStrings не могут иметь published свойств. Процедурные типы не обрабатываются. Для генерации DTD у объекта все свойства классовых типов, одноименные со свойствами агрегированных объектов, должны быть одного класса. <br>
&nbsp;<br>
Предусловия:<br>
Объект для (де)сериализации должен быть создан до вызова процедуры. <br>
&nbsp;<br>
Дополнительно:<br>
<p>При загрузке из XML содержимое коллекций в объекте не очищается, что позволяет дозагружать данные из множества источников в один объект. </p>
<pre>
unit glXMLSerializer; 
{ 
Globus Delphi VCL Extensions Library
' GLOBUS LIB '
Copyright (c) 2001 Chudin A.V, chudin@yandex.ru
 =================================================================== 
 glXMLSerializer Unit 08.2001                  component TglXMLSerializer 
 =================================================================== 
 
} 
 
interface 
 
 
uses 
  Windows, Messages, SysUtils, Classes, Graphics, Controls, 
  Forms, Dialogs, comctrls, TypInfo; 
 
type 
  TOnGetXMLHeader = procedure (Sender: TObject; var Value: string) of object; 
 
  XMLSerializerException = class(Exception) 
  end; 
 
  TglXMLSerializer = class(TComponent) 
  private 
    Buffer: PChar; 
    BufferLength: DWORD; 
    TokenPtr: PChar; 
    OutStream: TStream; 
 
    FOnGetXMLHeader: TOnGetXMLHeader; 
    FGenerateFormattedXML: boolean; 
    FExcludeEmptyValues: boolean; 
    FExcludeDefaultValues: boolean; 
    FReplaceReservedSymbols: boolean; 
    procedure check(Expr: boolean; const Message: string); 
    procedure WriteOutStream(Value: string); 
    { Private declarations } 
  protected 
    procedure SerializeInternal(Component: TObject; Level: integer = 1); 
    procedure DeSerializeInternal
(Component: TObject; const ComponentTagName: string; ParentBlockEnd: PChar = nil); 
    procedure GenerateDTDInternal
(Component: TObject; DTDList: TStrings; Stream: TStream; const ComponentTagName: string); 
    procedure SetPropertyValue
(Component: TObject; PropInfo: PPropInfo; Value, ValueEnd: PChar; ParentBlockEnd: PChar); 
  public 
    tickCounter, tickCount: DWORD; 
    constructor Create(AOwner: TComponent); override; 
    { Сериализация объекта в XML } 
    procedure Serialize(Component: TObject; Stream: TStream); 
    { Загрузка XML в объект } 
    procedure DeSerialize(Component: TObject; Stream: TStream); 
    { Генерация DTD } 
    procedure GenerateDTD(Component: TObject; Stream: TStream); 
  published 
    property GenerateFormattedXML: boolean 
     read FGenerateFormattedXML write FGenerateFormattedXML default true; 
    property ExcludeEmptyValues: boolean 
     read FExcludeEmptyValues write FExcludeEmptyValues; 
    property ExcludeDefaultValues: boolean 
     read FExcludeDefaultValues write FExcludeDefaultValues; 
    property ReplaceReservedSymbols: boolean 
     read FReplaceReservedSymbols write FReplaceReservedSymbols; 
    property OnGetXMLHeader: TOnGetXMLHeader 
     read FOnGetXMLHeader write FOnGetXMLHeader; 
  end; 
 
procedure Register; 
 
implementation 
uses dsgnintf, glUtils; 
 
const 
  ORDINAL_TYPES = [tkInteger, tkChar, tkEnumeration, tkSet]; 
  TAB: string = #9; 
  CR: string = #13#10; 
 
procedure Register; 
begin 
  RegisterComponents('Gl Components', [TglXMLSerializer]); 
end; 
 
 
constructor TglXMLSerializer.Create(AOwner: TComponent); 
begin 
  inherited; 
  //...defaults 
  FGenerateFormattedXML := true; 
end; 
 
{ пишет строку в выходящий поток. Исп-ся при сериализации } 
procedure TglXMLSerializer.WriteOutStream(Value: string); 
begin 
  OutStream.Write(Pchar(Value)[0], Length(Value)); 
end; 
 
{ 
  Конвертирует компонент в XML-код в соответствии 
  с published интерфейсом класса объекта. 
  Вход: 
    Component - компонент для конвертации 
  Выход: 
    текст XML в поток Stream 
} 
procedure TglXMLSerializer.Serialize(Component: TObject; Stream: TStream); 
var 
  Result: string; 
begin 
  TAB := IIF(GenerateFormattedXML, #9, ''); 
  CR := IIF(GenerateFormattedXML, #13#10, ''); 
 
  Result := ''; 
  { Получение XML заголовка } 
  if Assigned(OnGetXMLHeader) then OnGetXMLHeader(self, Result); 
 
  OutStream := Stream; 
 
  WriteOutStream( PChar(CR + '&lt;' + Component.ClassName + '&gt;') ); 
  SerializeInternal(Component); 
  WriteOutStream( PChar(CR + '&lt;/' Component.ClassName + ?end; 
 
{ 
  Внутренняя процедура конвертации объекта в XML 
  Вызывается из: 
    Serialize() 
  Вход: 
    Component - компонент для конвертации 
    Level - уровень вложенности тега для форматирования результата 
  Выход: 
    строка XML в выходной поток через метод WriteOutStream() 
} 
procedure TglXMLSerializer.SerializeInternal(Component: TObject; Level: integer = 1); 
var 
  PropInfo: PPropInfo; 
  TypeInf, PropTypeInf: PTypeInfo; 
  TypeData: PTypeData; 
  i, j: integer; 
  AName, PropName, sPropValue: string; 
  PropList: PPropList; 
  NumProps: word; 
  PropObject: TObject; 
 
  { Добавляет открывающий тег с заданным именем } 
  procedure addOpenTag(const Value: string); 
  begin 
    WriteOutStream(CR + DupStr(TAB, Level) + '&lt;' + Value + '&gt;'); 
    inc(Level); 
  end; 
 
  { Добавляет закрывающий тег с заданным именем } 
  procedure addCloseTag(const Value: string; addBreak: boolean = false); 
  begin 
    dec(Level); 
    if addBreak then 
      WriteOutStream(CR + DupStr(TAB, Level)); 
    WriteOutStream('&lt;/' + ? Valueend; 
 
  { Добавляет значение в результирующую строку } 
  procedure addValue(const Value: string); 
  begin 
    WriteOutStream(Value); 
  end; 
begin 
//  Result := ''; 
 
  { Playing with RTTI } 
  TypeInf := Component.ClassInfo; 
  AName := TypeInf^.Name; 
  TypeData := GetTypeData(TypeInf); 
  NumProps := TypeData^.PropCount; 
 
 
  GetMem(PropList, NumProps*sizeof(pointer)); 
  try 
 
    { Получаем список свойств } 
    GetPropInfos(TypeInf, PropList); 
 
    for i := 0 to NumProps-1 do 
    begin 
      PropName := PropList^[i]^.Name; 
 
      PropTypeInf := PropList^[i]^.PropType^; 
      PropInfo := PropList^[i]; 
 
      { Хочет ли свойство, чтобы его сохранили ? } 
      if not IsStoredProp(Component, PropInfo) then continue; 
 
      case PropTypeInf^.Kind of 
        tkInteger, tkChar, tkEnumeration, tkFloat, tkString, tkSet, 
        tkWChar, tkLString, tkWString, tkVariant: 
        begin 
          { Получение значения свойства } 
          sPropValue := GetPropValue(Component, PropName, true); 
 
          { Проверяем на пустое значение и значение по умолчанию } 
          if ExcludeEmptyValues and (sPropValue = '') then continue; 
          if ExcludeDefaultValues and (PropTypeInf^.Kind in ORDINAL_TYPES) 
           and (sPropValue = IntToStr(PropInfo.Default)) then continue; 
 
          { Замена спецсимволов } 
          if FReplaceReservedSymbols then 
          begin 
            sPropValue := StringReplace(sPropValue, '&lt;', '%lt;', [rfReplaceAll]); 
            sPropValue := StringReplace(sPropValue, '&gt;', '%gt;', [rfReplaceAll]); 
            sPropValue := StringReplace(sPropValue, '&amp;', '%', [rfReplaceAll]); 
          end; 
 
          { Перевод в XML } 
          addOpenTag(PropName); 
          addValue(sPropValue); { Добавляем значение свойства в результат } 
          addCloseTag(PropName); 
        end; 
        tkClass: { Для классовых типов рекурсивная обработка } 
        begin 
          addOpenTag(PropName); 
 
          PropObject := GetObjectProp(Component, PropInfo); 
          if Assigned(PropObject)then 
          begin 
            { Для дочерних свойств-классов - рекурсивный вызов } 
            if (PropObject is TPersistent) then 
               SerializeInternal(PropObject, Level); 
 
            { Индивидуальный подход к некоторым классам } 
            if (PropObject is TStrings) then { Текстовые списки } 
            begin 
              WriteOutStream(TStrings(PropObject).CommaText); 
            end else 
            if (PropObject is TCollection) then { Коллекции } 
            begin 
              SerializeInternal(PropObject, Level); 
              for j := 0 to (PropObject as TCollection).Count-1 do 
              begin { Контейнерный тег по имени класса } 
                addOpenTag(TCollection(PropObject).Items[j].ClassName); 
                SerializeInternal(TCollection(PropObject).Items[j], Level); 
                addCloseTag(TCollection(PropObject).Items[j].ClassName, true); 
              end 
            end; 
            { Здесь можно добавить обработку остальных 
              классов: TTreeNodes, TListItems } 
          end; 
          { После обработки свойств закрываем тег объекта } 
          addCloseTag(PropName, true); 
        end; 
 
      end; 
    end; 
  finally 
    FreeMem(PropList, NumProps*sizeof(pointer)); 
  end; 
 
end; 
 
 
{ 
  Загружает в компонент данные из потока с XML-кодом. 
  Вход: 
    Component - компонент для конвертации 
    Stream - источник загрузки XML 
  Предусловия: 
    Объект Component должен быть создан до вызова процедуры 
} 
procedure TglXMLSerializer.DeSerialize(Component: TObject; Stream: TStream); 
begin 
  GetMem(Buffer, Stream.Size); 
  try 
    { Получаем данные из потока } 
    Stream.Read(Buffer[0], Stream.Size + 1); 
    { Устанавливаем текущий указатель чтения данных } 
    TokenPtr := Buffer; 
    BufferLength := Stream.Size-1; 
    { Вызываем загрузчик } 
    DeSerializeInternal(Component, Component.ClassName); 
  finally 
    FreeMem(Buffer); 
  end; 
end; 
 
 
{ 
  Рекурсивная процедура загрузки объекта их текстового буфера с XML 
  Вызывается из: 
    Serialize() 
  Вход: 
    Component - компонент для конвертации 
    ComponentTagName - имя XML тега объекта 
    ParentBlockEnd - указатель на конец XML описания родительского тега 
} 
procedure TglXMLSerializer.DeSerializeInternal(Component: TObject; 
const ComponentTagName: string; ParentBlockEnd: PChar = nil); 
var 
  BlockStart, BlockEnd, TagStart, TagEnd: PChar; 
  TagName, TagValue, TagValueEnd: PChar; 
  TypeInf: PTypeInfo; 
  TypeData: PTypeData; 
  PropIndex: integer; 
  AName: string; 
  PropList: PPropList; 
  NumProps: word; 
 
  { Поиск у объекта свойства с заданным именем } 
  function FindProperty(TagName: PChar): integer; 
  var i: integer; 
  begin 
    Result := -1; 
    for i := 0 to NumProps-1 do 
    if CompareStr(PropList^[i]^.Name, TagName) = 0 then 
    begin 
      Result := i; 
      break; 
    end; 
  end; 
 
  procedure SkipSpaces(var TagEnd: PChar); 
  begin 
    while TagEnd[0] &lt;= #33 do inc(TagEnd); 
  end; 
 
function StrPos2(const Str1, Str2: PChar; Str2Len: DWORD): PChar; assembler; 
asm 
        PUSH    EDI 
        PUSH    ESI 
        PUSH    EBX 
        OR      EAX,EAX         // Str1 
        JE      @@2             // если строка Str1 пуста - на выход 
        OR      EDX,EDX         // Str2 
        JE      @@2             // если строка Str2 пуста - на выход 
        MOV     EBX,EAX 
        MOV     EDI,EDX         // установим смещение для SCASB - подстрока Str2 
        XOR     AL,AL           // обнулим AL 
 
        push ECX                // длина строки 
 
        MOV     ECX,0FFFFFFFFH  // счетчик с запасом 
        REPNE   SCASB           // ищем конец подстроки Str2 
        NOT     ECX             // инвертируем ECX - получаем длину строки+1 
        DEC     ECX             // в ECX - длина искомой подстроки Str2 
 
        JE      @@2             // при нулевой длине - все на выход 
        MOV     ESI,ECX         // сохраняем длину подстроки в ESI 
 
        pop ECX 
 
        SUB     ECX,ESI         // ECX == разница длин строк : Str1 - Str2 
        JBE     @@2             // если длина подсроки больше длине строки - выход 
        MOV     EDI,EBX         // EDI  - начало строки Str1 
        LEA     EBX,[ESI-1]     // EBX - длина сравнения строк 
@@1:    MOV     ESI,EDX         // ESI - смещение строки Str2 
        LODSB                   // загужаем первый символ подстроки в AL 
        REPNE   SCASB           // ищем этот символ в строке EDI 
        JNE     @@2             // если символ не обнаружен - на выход 
        MOV     EAX,ECX         // сохраним разницу длин строк 
        PUSH    EDI             // запомним текущее смещение поиска 
        MOV     ECX,EBX 
        REPE    CMPSB           // побайтно сравниваем строки 
        POP     EDI 
        MOV     ECX,EAX 
        JNE     @@1             // если строки различны - 
// ищем следующее совпадение первого символа 
        LEA     EAX,[EDI-1] 
        JMP     @@3 
@@2:    XOR     EAX,EAX 
@@3:    POP     EBX 
        POP     ESI 
        POP     EDI 
end; 
 
begin 
  { Playing with RTTI } 
  TypeInf := Component.ClassInfo; 
  AName := TypeInf^.Name; 
  TypeData := GetTypeData(TypeInf); 
  NumProps := TypeData^.PropCount; 
 
 
  GetMem(PropList, NumProps*sizeof(pointer)); 
 
 
  try 
    GetPropInfos(TypeInf, PropList); 
 
  { ищем открывающий тег } 
  BlockStart := StrPos2(TokenPtr, PChar('&lt;' + ComponentTagName + '&gt;'), BufferLength); 
  check(BlockStart &lt;&gt; nil, 'Открывающий тег не найден: ' + '&lt;' + ComponentTagName + '&gt;'); 
  inc(BlockStart, length(ComponentTagName) + 2); 
 
  { ищем закрывающий тег } 
  BlockEnd := StrPos2(BlockStart, PChar('&lt;/' + ? ComponentTagName nil, 'Закрывающий тег не найден: ' +
 '&lt;' + ComponentTagName + '&gt;'); 
 
  { проверка на вхождение закр. тега в родительский тег } 
  check((ParentBlockEnd = nil) or 
(BlockEnd ? найден: не тег ?Закрывающий&gt;
{ XML парсер } 
  while TagEnd do 
  begin 
    { быстрый поиск угловых скобок } 
    asm 
      mov CL, '&lt;' 
      mov EDX, Pointer(TagEnd) 
      dec EDX 
@@1:  inc EDX 
      mov AL, byte[EDX] 
      cmp AL, CL 
      jne @@1 
      mov TagStart, EDX 
 
      mov CL, '&gt;' 
@@2:  inc EDX 
      mov AL, byte[EDX] 
      cmp AL, CL 
      jne @@2 
      mov TagEnd, EDX 
    end; 
 
    GetMem(TagName, TagEnd - TagStart + 1); 
    try 
 
      { TagName - имя тега } 
      StrLCopy(TagName, TagStart + 1, TagEnd - TagStart - 1); 
 
      { TagEnd - закрывающий тег } 
      TagEnd := StrPos2(TagEnd, PChar('&lt;/' + ? TagName{ поиск свойства, соответствующего тегу } 
      PropIndex := FindProperty(TagName); 
 
      check(PropIndex &lt;&gt; -1, 
'TglXMLSerializer.DeSerializeInternal: Uncknown property: ' + TagName); 
 
      SetPropertyValue(Component, PropList^[PropIndex], TagValue, TagValueEnd, BlockEnd); 
 
      inc(TagEnd, length('&lt;/' + ? TagNamefinally 
      FreeMem(TagName); 
    end; 
 
  end; 
 
 
  finally 
    FreeMem(PropList, NumProps*sizeof(pointer)); 
  end; 
 
end; 
 
 
{ 
  Процедура инициализации свойства объекта 
  Вызывается из: 
    DeSerializeInternal() 
  Вход: 
    Component - инициализируемый объект 
    PropInfo - информация о типе для устанавливаемого свойства 
    Value - значение свойства 
    ParentBlockEnd - указатель на конец XML описания родительского тега 
                     Используется для рекурсии 
} 
procedure TglXMLSerializer.SetPropertyValue
(Component: TObject; PropInfo: PPropInfo; Value, ValueEnd: PChar; ParentBlockEnd: PChar); 
var 
  PropTypeInf: PTypeInfo; 
  PropObject: TObject; 
  CollectionItem: TCollectionItem; 
  sValue: string; 
  charTmp: char; 
begin 
    PropTypeInf := PropInfo.PropType^; 
 
    case PropTypeInf^.Kind of 
      tkInteger, tkChar, tkEnumeration, tkFloat, tkString, tkSet, 
      tkWChar, tkLString, tkWString, tkVariant: 
      begin 
        { имитируем zero terminated string } 
        charTmp := ValueEnd[0]; 
        ValueEnd[0] := #0; 
        sValue := StrPas(Value); 
        ValueEnd[0] := charTmp; 
 
        { Замена спецсимволов. Актуально только для XML, 
         сохраненного с помощью этого компонента } 
         if FReplaceReservedSymbols then 
         begin 
           sValue := StringReplace(sValue, '%lt;', '&lt;', [rfReplaceAll]); 
           sValue := StringReplace(sValue, '%gt;', '&gt;', [rfReplaceAll]); 
           sValue := StringReplace(sValue, '%', '&amp;', [rfReplaceAll]); 
         end; 
 
        { Для корректного преобразования парсером tkSet нужны угловые скобки } 
        if PropTypeInf^.Kind = tkSet then sValue := '[' + sValue + ']'; 
        SetPropValue(Component, PropInfo^.Name, sValue); 
      end; 
      tkClass: 
      begin 
        PropObject := GetObjectProp(Component, PropInfo); 
        if Assigned(PropObject)then 
        begin 
          { Индивидуальный подход к некоторым классам } 
          if (PropObject is TStrings) then { Текстовые списки } 
          begin 
            charTmp := ValueEnd[0]; 
            ValueEnd[0] := #0; 
            sValue := StrPas(Value); 
            ValueEnd[0] := charTmp; 
            TStrings(PropObject).CommaText := sValue; 
          end 
          else 
          if (PropObject is TCollection) then { Коллекции } 
          begin 
            while true do { Заранее не известно число элементов в коллекции } 
            begin 
              CollectionItem := (PropObject as TCollection).Add; 
              try 
                DeSerializeInternal(CollectionItem, CollectionItem.ClassName, ParentBlockEnd); 
              except { Исключение, если очередной элемент не найден } 
                CollectionItem.Free; 
                break; 
              end; 
            end; 
          end 
          else { Для остальных классов - рекурсивная обработка } 
            DeSerializeInternal(PropObject, PropInfo^.Name, ParentBlockEnd); 
        end; 
 
      end; 
    end; 
end; 
 
 
{ 
  Процедура генерации DTD для заданного объекта в 
  соответствии с published интерфейсом его класса. 
  Вход: 
    Component - объект 
  Выход: 
    текст DTD в поток Stream 
} 
procedure TglXMLSerializer.GenerateDTD(Component: TObject; Stream: TStream); 
var 
  DTDList: TStringList; 
begin 
  DTDList := TStringList.Create; 
  try 
    GenerateDTDInternal(Component, DTDList, Stream, Component.ClassName); 
  finally 
    DTDList.Free; 
  end; 
end; 
 
 
{ 
  Внутренняя рекурсивная процедура генерации DTD для заданного объекта. 
  Вход: 
    Component - объект 
    DTDList - список уже определенных элементов DTD 
              для предотвращения повторений. 
  Выход: 
    текст DTD в поток Stream 
} 
procedure TglXMLSerializer.GenerateDTDInternal
(Component: TObject; DTDList: TStrings; Stream: TStream; const ComponentTagName: string); 
var 
  PropInfo: PPropInfo; 
  TypeInf, PropTypeInf: PTypeInfo; 
  TypeData: PTypeData; 
  i: integer; 
  AName, PropName, TagContent: string; 
  PropList: PPropList; 
  NumProps: word; 
  PropObject: TObject; 
const 
  PCDATA = '#PCDATA'; 
  procedure addElement(const ElementName: string; Data: string); 
  var s: string; 
  begin 
    if DTDList.IndexOf(ElementName) &lt;&gt; -1 then exit; 
    DTDList.Add(ElementName); 
    s := 'then Data := PCDATA'; 
    s := s + '(' + Data + ')&gt;'#13#10; 
    Stream.Write(PChar(s)[0], length(s)); 
  end; 
begin 
  { Playing with RTTI } 
  TypeInf := Component.ClassInfo; 
  AName := TypeInf^.Name; 
  TypeData := GetTypeData(TypeInf); 
  NumProps := TypeData^.PropCount; 
 
 
  GetMem(PropList, NumProps*sizeof(pointer)); 
  try 
    { Получаем список свойств } 
    GetPropInfos(TypeInf, PropList); 
    TagContent := ''; 
 
    for i := 0 to NumProps-1 do     begin 
      PropName := PropList^[i]^.Name; 
 
      PropTypeInf := PropList^[i]^.PropType^; 
      PropInfo := PropList^[i]; 
 
      { Пропустить не поддерживаемые типы } 
      if not (PropTypeInf^.Kind in 
[tkDynArray, tkArray, tkRecord, tkInterface, tkMethod]) then 
      begin 
        if TagContent &lt;&gt; '' then TagContent := TagContent + '|'; 
        TagContent := TagContent + PropName; 
      end; 
 
 
      case PropTypeInf^.Kind of 
        tkInteger, tkChar, tkFloat, tkString, 
        tkWChar, tkLString, tkWString, tkVariant, tkEnumeration, tkSet: 
        begin 
          { Перевод в DTD. Для данных типов модель содержания - #PCDATA } 
          addElement(PropName, PCDATA); 
        end; 
        { код был бы полезен при использовании атрибутов 
        tkEnumeration: 
        begin 
          TypeData:= GetTypeData(GetTypeData(PropTypeInf)^.BaseType^); 
          s := ''; 
          for j := TypeData^.MinValue to TypeData^.MaxValue do 
          begin 
            if s &lt;&gt; '' then s := s + '|'; 
            s := s + GetEnumName(PropTypeInf, j); 
          end; 
          addElement(PropName, s); 
        end; 
        } 
        tkClass: { Для классовых типов рекурсивная обработка } 
        begin 
          PropObject := GetObjectProp(Component, PropInfo); 
          if Assigned(PropObject)then 
          begin 
            { Для дочерних свойств-классов - рекурсивный вызов } 
            if (PropObject is TPersistent) then 
              GenerateDTDInternal(PropObject, DTDList, Stream, PropName); 
          end; 
        end; 
 
      end; 
    end; 
 
    { Индивидуальный подход к некоторым классам } 
    { Для коллекций необходимо включить в модель содержания тип элемента } 
    if (Component is TCollection) then 
    begin 
      if TagContent &lt;&gt; '' then TagContent := TagContent + '|'; 
      TagContent := TagContent + (Component as TCollection).ItemClass.ClassName + '*'; 
    end; 
 
    { Добавляем модель содержания для элемента } 
    addElement(ComponentTagName, TagContent); 
  finally 
    FreeMem(PropList, NumProps*sizeof(pointer)); 
  end; 
 
end; 
 
procedure TglXMLSerializer.check(Expr: boolean; const Message: string); 
begin 
  if not Expr then raise XMLSerializerException.Create
('XMLSerializerException'#13#10#13#10 + Message); 
end; 
 
end. 
 
//(PShortString(@(GetTypeData(GetTypeData(PropTypeInf)^.BaseType^).NameList))) 
 
//tickCount := GetTickCount(); 
//inc(tickCounter, GetTickCount() - tickCount); 
</pre>

Андрей Чудин, ЦПР ТД Библио-Глобус. </p>

<p>Взято из<a href="https://delphi.chertenok.ru" target="_blank"> http://delphi.chertenok.ru</a></p>

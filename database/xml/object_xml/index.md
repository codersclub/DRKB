---
Title: XML сериализация объекта Delphi
Date: 04.10.2001
Author: Андрей Чудин (avchudin@yandex.ru)
Source: Королевство Delphi (http://www.delphikingdom.com/)
---


XML сериализация объекта Delphi
===============================

Язык XML предоставляет нам чрезвычайно удобный и почти универсальный
подход к хранению и передаче информации. Не хватает только средств,
которые позволили бы удобно и просто организовать работу с XML.
Предлагаемая разработка реализует очень эффективную возможность - XML
сериализацию объектов любых классов Delphi и из загрузку из XML кода.

Рассматриваемый подход дает возможность наиболее удобно интегрировать
обработку XML объектов в среду разработки Delphi и C++Builder.
Возможность доступа к свойствам объектов определяется RTTI. Его
возможности в Delphi очень велики, т.к. среда разработки сама хранит
ресурсы объектов в текстовом формате.

Для начала определим ряд простых функций для формирования XML кода. Они
позволят нам добавлять открывающие, закрывающие теги и значения в
результирующий текст.


    { Добавляет открывающий тег с заданным именем } 
    procedure addOpenTag(const Value: string);
    begin 
       Result := Result + '<' + Value + '>';
       inc(Level);
    end;
     
    { Добавляет закрывающий тег с заданным именем } 
    procedure addCloseTag(const Value: string;
                          addBreak: boolean = false);
    begin 
       dec(Level);
       Result := Result + ' + Value + '>';
    end;
     
    { Добавляет значение в результирующую строку } 
    procedure addValue(const Value: string);
    begin 
       Result := Result + Value;
    end;

Следующее, что предстоит реализовать - это перебор всех свойств объекта
и формирование тегов. Сведения о свойствах получаются через интерфейс
компонента. Это информация о типе. Для каждого свойства, за исключением
классовых получается их имя и текстовое значение, после чего формируется
XML-тег. Значение загружается через ф-ию TypInfo.GetPropValue();

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

Для классовых типов придется использовать рекурсию для загрузки всех
свойств соответствующего объекта.
Более того, для ряда классов необходимо использовать особый подход. Сюда
относятся, к примеру, строковые списки и коллекции. Ими и ограничимся.

Для текстового списка TStrings будем сохранять в XML его свойство
CommaText, а в случае коллекции после обработки всех ее свойств сохраним
в XML каждый элемент TCollectionItem отдельно. При этом в качестве
контейнерного тега будем использовать имя класса
`TCollection(PropObject).Items[j].ClassName`.

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

Описанные функции позволят нам получить XML код для объекта включая все
его свойства. Остается только \'обернуть\' полученный XML в тег верхнего
уровня - имя класса объекта. Если мы поместим вышеприведенный код в
функцию SerializeInternal(), то результирующая функция Serialize() будет
выглядеть так:

    procedure Serialize(Component: TObject;);
    ...
    Result := Result + '<' + Component.ClassName + '>';
    Result := Result + SerializeInternal(Component); {преобразовать свойства в XML}
    Result := Result + ' + Component.ClassName + '>'; 

К вышеприведенному можно добавить еще функции для форматирования
генерируемого XML кода. Также можно добавить пропуск пустых значений и
свойств со значениями по умолчанию.
 

## Загрузка XML в объект

После того, как мы рассмотрели возможность превода данных объекта в XML
следует перейти к следующей задаче. Задача состоит в реализации
обратного процесса, а именно - загрузки XML данных в объект.

Загрузка XML данных в объект, или десериализация, представляет собой
более сложный процесс, т.к. в ходе его необходимо осуществить корректный
разбор текстового XML документа на предмет инициализации содержащимися в
нем данными заданного объекта.

Примем ряд упрощений, которые сократят число проверок корректности
входящего XML документа к минимуму. Первое, что необходимо делать, тек
это проверять соответствие тега верхнего уровня имени класса нашего
объекта. Синтаксическая правильность документа будет проверяться в ходе
загрузки данных. При необходимости более жесткой проверки загружаемых
XML документов можно привлечь, к примеру, парсер MSXML. Последний
поможет нам проверить документ на синтаксическую, а также семантическую
корректность при наличии соответствующего DTD.

Первое, что следует реализовать, это процедура верхнего уровня, которая
получает объект для инициализации, а также потоковый источник данных с
текстом XML документа.

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

Следующий код занимается тривиальным разбором XML текта. Ищется первый
открывающий тег, затем его закрывающая пара. Найденная пара содержит в
себе данные для свойств объекта. Внутри найденной пары тегов
последовательно выбираются теги (TagName) и текст их содержания
(TagValue). Эти теги предположительно соответствуют свойствам объекта,
что мы тут же и проверяем.

Среди свойств объекта отыскивается через FindProperty() оноименное
свойство. При неудаче генерируется исключение об ошибочности XML тега.
Если для тега найден соответвующее свойство, то передаем дальнейшую
обработку процедуре SetPropertyValue(), которая заданное свойство с
именем TagName проинициализирует найденным значением TagValue.

Не забываем также передвигать указатель чтения данных TokenPtr по мере
выборки данных.

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
     
        BlockStart := StrPos(TokenPtr, PChar('<' + ComponentTagName + '>'));
        inc(BlockStart, length(ComponentTagName) + 2);

        { ищем закрывающий тег } 
        BlockEnd := StrPos(BlockStart, PChar('</' + ComponentTagName + '>'));
    
        TagEnd := BlockStart;
        SkipSpaces(TagEnd);
     
        { XML парсер } 
        while TagEnd do 
        begin 
          TagStart := StrPos(TagEnd, '<');
          TagEnd := StrPos(TagStart, '>');
          GetMem(TagName, TagEnd - TagStart + 1);
          try 
            { TagName - имя тега } 
            StrLCopy(TagName, TagStart + 1, TagEnd - TagStart - 1);
     
            TagEnd := StrPos(TagStart, PChar('</' + TagName + '>'));
            try 
              { TagValue - значение тега } 
              StrLCopy(TagValue, TagStart, TagEnd - TagStart);
     
              { поиск свойства, соответствующего тегу } 
              PropIndex := FindProperty(TagName);
              if PropIndex = -1 then 
                raise Exception.Create('TglXMLSerializer.DeSerializeInternal: ' +
                                       'Unknown property: ' + TagName);
     
              SetPropertyValue(Component, PropList^[PropIndex], TagValue);
     
              inc(TagEnd, length('</' + TagName + '>'));
            finally 
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

Остается только код, который загрузит найденные данные в заданной
свойство. Процедуре SetPropertyValue() передаются данные о
соответствующем свойстве (PropInfo), которое на следует
проинициализировать. Также процедура получает и текстовое значение,
содержащееся в найденном теге.

В случае, если тип данные не является классовым типом, то, очевидно,
текст Value следует просто загрузить в свойство. Это реализуется вызовом
процедуры TypInfo.SetPropValue(). Последняя самостоятельно разберется,
как корректно преобразовать тестовое значение в значение свойства в
завистимости от его типа.

Если свойство имеет классовый тип, то его значение Value должно
содержать XML код, описывающий свойства данного класса. В этом случае
воспользуемся рекурсией и передадим обработку вышеприведенной процедуре
DeSerializeInternal(). При этом передаем ей в качестве объекта ссылку на
найденное свойство PropObject и его имя PropInfo^.Name.

Нам также необходимо озаботиться отдельной обработкой данных для таких
классовых типов как списки TStrings и коллекции TCollection. Данные для
списков мы загружаем из значения Value как CommaText. Тут все понятно. В
сллучае же коллеций данные о элементах коллекции в XML документе
содержаться в виде последовательных контейнерных тегов с именем типа
элемента коллекции. Т.е., к примеру,

    <TMyCollection> ... </TMyCollection>
    <TMyCollection> ... </TMyCollection>
    <TMyCollection> ... </TMyCollection>
    и так далее.

Внутри каждой пары тегов \<TMyCollection\> содержатся свойства объекта TMyCollection.

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
            if Assigned(PropObject) then 
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


К приведенному коду следует добавить еще ряд возможностей для более
корректной реакции для обработки неверного XML кода. Также можно
достаточно просто реализовать автоматическую генерацию DTD для любого
класса Delphi. После этого можно собрать полноценный компонент,
объединяющий в себе всю необходимую функциональность для XML
сериализации.

## Создание DTD для объекта

За созданием кода для сериализации и десериализации объектов в Delphi
логично перейти к рассмотрению вопроса о возможности генерации
соответствующего DTD для сохраняемых в XML классов. DTD понадобится нам,
если мы захотим провести проверку XML документа на корректность и
допустимость с помощью одного из XML анализаторов. Работа с анализатором
MSXML рассмотрена в статье Загрузка и анализ документа XML..

Автоматическое создание DTD очень простая задача. У нас все для этого
есть. Необходимо рекурсивно пройтись по всем свойствам объекта и
сгенерировать модели содержания для каждого тега. При сериализации в XML
мы не использовали атрибутов, а значит мы не сможем в DTD установить
контроль над содержанием конкретных элементов. Остается только
определить модель содержания для XML, т.е. вложенность тегов в друг
друга.

Создадим процедуру GenerateDTD(), которая обеспечит запись формируемого
DTD для заданного объекта Component в заданный поток Stream. Она создает
список DTDList, в котором будут накапливаться атрибуты DTD, после чего
передает всю черновую работу процедуре GenerateDTDInternal().

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


Следующий код просматривает свойства объекта, составляет их список, а
затем формирует из этого модель содержания для элемента. Для свойств
классовых типов используется рекурсия. Поскольку при сериализации
объекта мы не использовали атрибутов, то определений для них создавать
нет необходимости.

Для всех неклассовых типов модель содержания это - (#PCDATA). К
примеру, свойство объекта Tag: integer превращается в .

Отдельно подходим к коллекциям. Для них необходимо указать на
множественность дочернего тега элемента коллекции. Например, для
свойства TMyCollection модель содержания может выглядеть так: .

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
        if DTDList.IndexOf(ElementName) <> -1 then exit; 
        DTDList.Add(ElementName); 
        s := '<!ELEMENT ' + ElementName + ' '; 
        if Data = '' then Data := PCDATA; 
        s := s + '(' + Data + ')>'#13#10; 
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
            if TagContent <> '' then TagContent := TagContent + '|'; 
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
                  if s <> '' then s := s + '|'; 
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
          if TagContent <> '' then TagContent := TagContent + '|'; 
          TagContent := TagContent + 
               (Component as TCollection).ItemClass.ClassName + '*'; 
        end; 
     
        { Добавляем модель содержания для элемента } 
        addElement(ComponentTagName, TagContent); 
      finally 
        FreeMem(PropList, NumProps*sizeof(pointer)); 
      end; 
     
    end; 

Закоментированный код нам не нужен, но он не удален, т.к. он
демонстрирует получение списка возможных значений для перечисления
(Enumeration) и набора (Set). Это может понадобится, если появится
необходимость генерировать свойства в виде атрибутов XML тегов и,
соответственно, DTD для возможных значений этих атрибутов.

## Компонент для XML сериализации

Объединяя сказанное о сериализации, десериализации объектов и создании
DTD соберем
полноценный компонент для XML сериализации. Компонент конвертирует
компонент в XML и обратно в соответствии с published-интерфейсом класса
компонента. XML формируется в виде пар тегов с вложенными в них
значениями. Атрибуты у тегов отсутствуют. Тег верхнего уровня
соответствует классу объекта. Вложенные теги соответствуют именам
свойств. Для элементов коллекций контейнерный тег соответствует имени
класса. Вложенность тегов не ограничена и полностью повторяет published
интерфейс класса заданного объекта. Поддерживаются целые типы, типы с
плавающей точкой, перечисления, наборы, строки, символы. вариантные
типы, классовые типы, стоковые списки и коллекции.
Интерфейс:

procedure Serialize(Component: TObject; Stream: TStream);
: Сериализация объекта в XML procedure

DeSerialize(Component: TObject; Stream: TStream);
: Загрузка XML в объект property

GenerateFormattedXML
: создать форматированный XML код property

ExcludeEmptyValues

: пропускать пустые значения свойств property

ExcludeDefaultValues
: пропускать значения по умолчанию property

OnGetXMLHeader
: позволяет указать свой XML заголовок

> **Ограничения:**  
> В объекте допустимо использовать только одну коллекцию каждого типа. Для
> преодоления этого ограничения требуется некоторая доработка. Наследники
> класса TStrings не могут иметь published свойств. Процедурные типы не
> обрабатываются. Для генерации DTD у объекта все свойства классовых
> типов, одноименные со свойствами агрегированных объектов, должны быть
> одного класса.

> **Предусловия:**  
> Объект для (де)сериализации должен быть создан до вызова процедуры.

> **Дополнительно:**  
> При загрузке из XML содержимое коллекций в объекте не очищается, что
> позволяет дозагружать данные из множества источников в один объект.

```
unit glXMLSerializer; 
{ 
Globus Delphi VCL Extensions Library

glXMLSerializer Unit 08.2001	      
component TglXMLSerializer 1.2 
Chudin Andrey, avchudin@yandex.ru
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
    FStrongConformity: boolean; 
    procedure check(Expr: boolean; const Message: string); 
    procedure WriteOutStream(Value: string); 
    { Private declarations } 
  protected 
    procedure SerializeInternal(Component: TObject; Level: integer = 1); 
    procedure DeSerializeInternal(Component: TObject; const ComponentTagName: string; ParentBlockEnd: PChar = nil); 
    procedure GenerateDTDInternal(Component: TObject; DTDList: TStrings; Stream: TStream; const ComponentTagName: string); 
    procedure SetPropertyValue(Component: TObject; PropInfo: PPropInfo; Value, ValueEnd: PChar; ParentBlockEnd: PChar); 
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
    property StrongConformity: boolean 
     read FStrongConformity write FStrongConformity default true; 
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
  FStrongConformity := true; 
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
 
  WriteOutStream( PChar(CR + '<' + Component.ClassName + '>') ); 
  SerializeInternal(Component); 
  WriteOutStream( PChar(CR + '') ); 
end; 
 
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
    WriteOutStream(CR + DupStr(TAB, Level) + '<' + Value + '>'); 
    inc(Level); 
  end; 
 
  { Добавляет закрывающий тег с заданным именем } 
  procedure addCloseTag(const Value: string; addBreak: boolean = false); 
  begin 
    dec(Level); 
    if addBreak then 
      WriteOutStream(CR + DupStr(TAB, Level)); 
    WriteOutStream(''); 
  end; 
 
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
            sPropValue := StringReplace(sPropValue, '<', '%lt;', [rfReplaceAll]); 
            sPropValue := StringReplace(sPropValue, '>', '%gt;', [rfReplaceAll]); 
            sPropValue := StringReplace(sPropValue, '&', '%', [rfReplaceAll]); 
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
            { Здесь можно добавить обработку остальных классов: TTreeNodes, TListItems } 
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
procedure TglXMLSerializer.DeSerializeInternal(Component: TObject; const ComponentTagName: string; ParentBlockEnd: PChar = nil); 
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
    while TagEnd[0] <= #33 do inc(TagEnd); 
  end; 
 
{ 
  StrPosExt - ищет позицию одной строки в другой с заданной длиной. 
  На длинных строках превосходит StrPos. 
} 
function StrPosExt(const Str1, Str2: PChar; Str2Len: DWORD): PChar; assembler; 
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
        JNE     @@1             // если строки различны - ищем следующее совпадение первого символа 
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
  BlockStart := StrPosExt(TokenPtr, PChar('<' + ComponentTagName + '>'), BufferLength); 
 
  { Если тег не найден и его наличие необязательно, то не обрабатываем его } 
  if (BlockStart = nil)and not StrongConformity then exit; 
 
  { иначе проверяем его присутствие } 
  check(BlockStart <> nil, 'Открывающий тег не найден: ' + '<' + ComponentTagName + '>'); 
  inc(BlockStart, length(ComponentTagName) + 2); 
 
  { ищем закрывающий тег } 
  BlockEnd := StrPosExt(BlockStart, PChar(''), BufferLength); 
  check(BlockEnd <> nil, 'Закрывающий тег не найден: ' + '<' + ComponentTagName + '>'); 
 
  { проверка на вхождение закр. тега в родительский тег } 
  check((ParentBlockEnd = nil)or(BlockEnd < ParentBlockEnd), 'Закрывающий тег не найден: ' + '<' + ComponentTagName + '>'); 
 
  TagEnd := BlockStart; 
  SkipSpaces(TagEnd); 
 
  { XML парсер } 
  while TagEnd < BlockEnd do 
  begin 
    { быстрый поиск угловых скобок } 
    asm 
      mov CL, '<' 
      mov EDX, Pointer(TagEnd) 
      dec EDX 
@@1:  inc EDX 
      mov AL, byte[EDX] 
      cmp AL, CL 
      jne @@1 
      mov TagStart, EDX 
 
      mov CL, '>' 
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
      TagEnd := StrPosExt(TagEnd, PChar(''), BufferLength); 
 
      TokenPtr := TagStart; 
      inc(TagStart, length('')-1); 
 
      TagValue := TagStart; 
      TagValueEnd := TagEnd; 
 
      { поиск свойства, соответствующего тегу } 
      PropIndex := FindProperty(TagName); 
 
      check(PropIndex <> -1, 'TglXMLSerializer.DeSerializeInternal: Uncknown property: ' + TagName); 
 
      SetPropertyValue(Component, PropList^[PropIndex], TagValue, TagValueEnd, BlockEnd); 
 
      inc(TagEnd, length('')); 
      SkipSpaces(TagEnd); 
 
    finally 
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
procedure TglXMLSerializer.SetPropertyValue(Component: TObject; PropInfo: PPropInfo; Value, ValueEnd: PChar; ParentBlockEnd: PChar); 
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
           sValue := StringReplace(sValue, '%lt;', '<', [rfReplaceAll]); 
           sValue := StringReplace(sValue, '%gt;', '>', [rfReplaceAll]); 
           sValue := StringReplace(sValue, '%', '&', [rfReplaceAll]); 
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
procedure TglXMLSerializer.GenerateDTDInternal(Component: TObject; DTDList: TStrings; Stream: TStream; const ComponentTagName: string); 
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
    if DTDList.IndexOf(ElementName) <> -1 then exit; 
    DTDList.Add(ElementName); 
    s := '';
    if Data = '' then Data := PCDATA; 
    s := s + '(' + Data + ')>'#13#10; 
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
      if not (PropTypeInf^.Kind in [tkDynArray, tkArray, tkRecord, tkInterface, tkMethod]) then 
      begin 
        if TagContent <> '' then TagContent := TagContent + '|'; 
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
            if s <> '' then s := s + '|'; 
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
      if TagContent <> '' then TagContent := TagContent + '|'; 
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
  if not Expr then raise XMLSerializerException.Create('XMLSerializerException'#13#10#13#10 + Message); 
end; 
 
end. 
```


## XML сериализация объектов. Заключение.

После последовательного рассмотрения возможностей прямой загрузки/сохранения XML документов
в объекты Delphi/С++Builder стоит подвести некоторые итоги и ответить на вопросы
о применимости данного подхода. 

### Применимость
								 
1. Метод подходит для создания собственных типов XML документов. Когда есть необходимость оперативно разработать свой формат для обмена данными, то проблем возникать не должно. В такой ситуации это может быть оптимальным подходом. Поскольку формат разрабатывается заново, то мы можем учесть все ограничения предложенной реализации и не использовать атрибуты. При этом достаточно спроектировать необходимые нам классы, а вся остальная работа будет проделана автоматически. 
2. Метод подходит для обработки XML документов, в которых не используются атрибуты. Подобных типов документов не много, но если они подходят, то такой путь их обработки достаточно удобен. Так автором статьи в рабочем проекте описанным методом обрабатываются документы стандарта ONIX XML. В этом формате присутствует атрибут только у одного элемента, а подобное ограничение можно обойти предварительной обработкой загружаемого документа. 

Применимость может стать почти универсальной, если доработать код для обработки атрибутов элементов. 

### Производительность
											   
Код загрузки XML документа в объект дает вполне приемлемую производительность.
Тестирование дало следующие результаты. 

**Документ:** формат ONIX XML размером 10 мб.  
**Системная конфигурация:** Celeron 450 / 256 / Windows 2000prof

|парсер|приблизительное время загрузки|
|--------|--------|
|MS XML Parser 2.6 синхронная загрузка без проверки состоятельности |~6 сек |
|MS XML Parser 2.6 синхронная загрузка с проверкой состоятельности  |~11 сек |
|Компонент TglXMLSerializer 					   |8,5 сек|

Компонент TglXMLSerializer загружает данные в синхронном режиме.
Он не использует DTD или схемы.
При загрузке проводится проверка правильности (well-formed) и частично - состоятельности (valid).
При нарушении правильности документа парсер выдаст соответствующее исключение и прекратит загрузку. 

Проверка состоятельности определяется тем, что при загрузке данные загружаются в свойства объекта.
Если одноименное элементу XML документа свойство не найдено, то генерируется исключение.
Так как свойства объекта типизированы и при загрузке происходит преобразование текстовых значений,
то ошибки, здесь возникающие, говорят о нарушении состоятельности документа.
Таким образом, интерфейс нашего объекта играет роль XML схемы, что очень удобно.
Более того, эти проверки могут быть расширены дополнительным кодом в обработчиках свойств объекта. 

### Расширяемость

Приведенная реализация имеет ряд ограничений.
Первое и основное - это отказ от использования элементов в атрибутах XML документов.
Это ограничение может быть снято переработкой кода парсера и процедур сохранения XML.
Для отличия элементов от атрибутов в интерфейсе объектов можно придти к следующему соглашению: 

- Все классовые типы являются элементами 
- Все простые типы являются атрибутами соответствующих объектов 

**Пример.**

```
TPerson = class;
 TMyXMLMessage = class(TPersistent)
 published
    property LanguageOfText: WideString;
    property ToPerson: TPerson;
 end;

 TPerson = class(TPersistent)
  published
     property FirstName: WideString;
     property LastName: WideString;
 end;
```
 		   
Таким образом, в первом случае объект приведенного выше класса TMyXMLMessage
при сериализации даст следующий XML код: 

```
<TMyXMLMessage>
<LanguageOfText>english</LanguageOfText>
	<ToPerson>
		<FirstName>Osama</FirstName>
		<LastName>Unknoun</LastName>
	</ToPerson>
</TMyXMLMessage>

```
 
При обработке простых типов как атрибутов получим следующий более компактный код: 

```
<TMyXMLMessage LanguageOfText="english">
	<ToPerson FirstName="Osama" LastName="Unknoun"/>
</TMyXMLMessage>

```

Второй вариант позволяет работать с любыми документами,
однако надо решить, каким образом описывать данные #CDDATA.
Возможно, для этого придется зарезервировать какой-либо тип. 

Второе ограничение, которое следует упомянуть, это способ описания коллекций.
В приведенной реализации коллекции сохраняются в виде тега свойства,
в который вложены описания элементов коллекции.
Довольно часто в XML документах повторяющаяся группа тегов не заключается специально в теги,
отделяющие эту группу.
Это является препятствием для написания классов для обработки уже существующих документов.
Поэтому необходимо предусмотреть и такую возможность. 

Приведенная реализация будет постоянно обновляться,
в том числе и на основании Ваших, уважаемый читатель, предложений.


**Чудин Андрей**, октябрь 2001г.

Специально для [**Королевства Delphi**](http://www.delphikingdom.com)

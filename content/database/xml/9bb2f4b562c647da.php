<h1>Создание DTD для объекта</h1>
<div class="date">01.01.2007</div>


<p>За созданием кода для сериализации и десериализации объектов в Delphi логично перейти к рассмотрению вопроса о возможности генерации соответствующего DTD для сохраняемых в XML классов. DTD понадобится нам, если мы захотим провести проверку XML документа на корректность и допустимость с помощью одного из XML анализаторов. Работа с анализатором MSXML рассмотрена в статье Загрузка и анализ документа XML..</p>

<p>Автоматическое создание DTD очень простая задача. У нас все для этого есть. Необходимо рекурсивно пройтись по всем свойствам объекта и сгенерировать модели содержания для каждого тега. При сериализации в XML мы не использовали атрибутов, а значит мы не сможем в DTD установить контроль над содержанием конкретных элементов. Остается только определить модель содержания для XML, т.е. вложенность тегов в друг друга.</p>

<p>Создадим процедуру GenerateDTD(), которая обеспечит запись формируемого DTD для заданного объекта Component в заданный поток Stream. Она создает список DTDList, в котором будут накапливаться атрибуты DTD, после чего передает всю черновую работу процедуре GenerateDTDInternal().</p>

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




<p>Следующий код просматривает свойства объекта, составляет их список, а затем формирует из этого модель содержания для элемента. Для свойств классовых типов используется рекурсия. Поскольку при сериализации объекта мы не использовали атрибутов, то определений для них создавать нет необходимости.</p>

<p>Для всех неклассовых типов модель содержания это - (#PCDATA). К примеру, свойство объекта Tag: integer превращается в .</p>

<p>Отдельно подходим к коллекциям. Для них необходимо указать на множественность дочернего тега элемента коллекции. Например, для свойства TMyCollection модель содержания может выглядеть так: .</p>

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
  var
    s: string;
  begin
    if DTDList.IndexOf(ElementName) &lt;&gt; -1 then
      exit;
    DTDList.Add(ElementName);
    s := 'then'
      Data := PCDATA;
    s := s + '(' + Data + ')&gt;'#13#10;
    Stream.write(PChar(s)[0], length(s));
  end;
 
begin
  { Playing with RTTI }
  TypeInf := Component.ClassInfo;
  AName := TypeInf^.name;
  TypeData := GetTypeData(TypeInf);
  NumProps := TypeData^.PropCount;
 
 
  GetMem(PropList, NumProps*sizeof(pointer));
  try
    { Получаем список свойств }
    GetPropInfos(TypeInf, PropList);
    TagContent := '';
 
    for i := 0 to NumProps-1 do
    begin
      PropName := PropList^[i]^.name;
 
      PropTypeInf := PropList^[i]^.PropType^;
      PropInfo := PropList^[i];
 
      { Пропустить не поддерживаемые типы }
      if not (PropTypeInf^.Kind in [tkDynArray, tkArray,
      tkRecord, tkInterface, tkMethod]) then
      begin
        if TagContent &lt;&gt; '' then
          TagContent := TagContent + '|';
        TagContent := TagContent + PropName;
      end;
 
      case PropTypeInf^.Kind of
        tkInteger, tkChar, tkFloat, tkString,
        tkWChar, tkLString, tkWString, tkVariant,
        tkEnumeration, tkSet:
        begin
          { Перевод в DTD. Для данных типов модель содержания - #PCDATA }
          addElement(PropName, PCDATA);
        end;
 
        {
        Kод был бы полезен при использовании атрибутов
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
      if TagContent &lt;&gt; '' then
        TagContent := TagContent + '|';
      TagContent := TagContent + (Component as TCollection).ItemClass.ClassName + '*';
    end;
 
    { Добавляем модель содержания для элемента }
    addElement(ComponentTagName, TagContent);
  finally
    FreeMem(PropList, NumProps*sizeof(pointer));
  end;
end;
</pre>

<p>Закоментированный код нам не нужен, но он не удален, т.к. он демонстрирует получение списка возможных значений для перечисления (Enumeration) и набора (Set). Это может понадобится, если появится необходимость генерировать свойства в виде атрибутов XML тегов и, соответственно, DTD для возможных значений этих атрибутов.</p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

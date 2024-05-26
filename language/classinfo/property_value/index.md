---
Title: Как прочитать значение свойства компонента по имени?
Date: 01.01.2007
Source: <https://www.lmc-mediaagentur.de/dpool>
---


Как прочитать значение свойства компонента по имени?
====================================================

Во время выполнения вам может потребоваться узнать, какие свойства доступны для конкретного компонента во время выполнения.
Список можно получить вызовом GetPropList.
Типы, функции и процедуры, включая GetPropList, которые обеспечивают доступ к этой информации о свойствах, находятся в исходном файле VCL TYPINFO.PAS.

**Параметры GetPropList**

    function GetPropList(TypeInfo: PTypeInfo; TypeKinds: TTypeKinds; PropList: PPropList): Integer;

Первый параметр GetPropList имеет тип PTypeInfo и является частью RTTI (информации о типе времени выполнения), доступной для любого объекта.
Определена структура записи:

    PPTypeInfo = ^PTypeInfo;
    PTypeInfo = ^TTypeInfo;
    TTypeInfo = record
      Kind: TTypeKind;
      Name: ShortString;
      {TypeData: TTypeData}
    end;

Доступ к записи TTypeInfo можно получить через свойство ClassInfo объекта.
Например, если вы получаете список свойств TButton, вызов может выглядеть так:

    GetPropList(Button1.ClassInfo, ....

Второй параметр типа TTypeKinds — это заданный тип, который действует как фильтр для типов свойств, включаемых в список.
Существует ряд допустимых записей, которые можно включить в набор (см. TYPEINFO.PAS), но tkProperties охватывает большинство.
Теперь наш вызов GetPropList будет выглядеть так:

    GetPropList(Button1.ClassInfo, tkProperties ....

Последний параметр, PPropList, представляет собой массив PPropInfo и определен в TYPEINFO.PAS:

    PPropList = ^TPropList;
    TPropList = array[0..16379] of PPropInfo;

Теперь вызов может звучать так:

    procedure TForm1.FormCreate(Sender: TObject);
    var
      PropList: PPropList;
    begin
      PropList := AllocMem(SizeOf(PropList^));
      GetPropList(TButton.ClassInfo, tkProperties + [tkMethod], PropList);
    {...}

**Получение дополнительной информации из записи TTypeInfo:**

В примере в конце этого документа указано не только имя свойства, но и его тип.
Имя типа свойства находится в дополнительном наборе структур.
Давайте еще раз взглянем на запись TPropInfo.
Обратите внимание, что она содержит PPTypeInfo, который в конечном итоге указывает на запись TTypeInfo.
TTypeInfo содержит имя класса свойства.

    PPropInfo = ^TPropInfo;
    TPropInfo = packed record
      PropType: PPTypeInfo;
      GetProc: Pointer;
      SetProc: Pointer;
      StoredProc: Pointer;
      Index: Integer;
      Default: Longint;
      NameIndex: SmallInt;
      Name: ShortString;
    end;
     
     
    PPTypeInfo = ^PTypeInfo;
    PTypeInfo = ^TTypeInfo;
    TTypeInfo = record
      Kind: TTypeKind;
      Name: ShortString;
      {TypeData: TTypeData}
    end;

В примере ниже показано, как настроить вызов GetPropList и как получить доступ к элементам массива.
В этом примере вместо TButton будет использоваться ссылка на TForm, но вы можете заменить другие значения в вызове GetPropList.
Видимым результатом будет заполнение списка именем свойства и типом свойств TForm.

Для этого проекта требуется TListBox.
Введите приведенный ниже код в обработчик событий OnCreate формы.

    uses
      TypInfo;
     
     
    procedure TForm1.FormCreate(Sender: TObject);
    var
      PropList: PPropList;
      i: integer;
    begin
      PropList := AllocMem(SizeOf(PropList^));
      i := 0;
      try
        GetPropList(TForm.ClassInfo, tkProperties + [tkMethod], PropList);
        while (PropList^[i] <> Nil) and (i < High(PropList^)) do
        begin
          ListBox1.Items.Add(PropList^[i].Name + ': ' + PropList^[i].PropType^.Name);
          Inc(i);
        end;
      finally
        FreeMem(PropList);
      end;
    end;


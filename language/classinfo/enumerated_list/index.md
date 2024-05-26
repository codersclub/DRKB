---
Title: Как сделать текстовый список всех доступных свойств перечисляемого типа?
Date: 01.01.2007
Author: Sen
Source: <https://www.lmc-mediaagentur.de/dpool>
---


Как сделать текстовый список всех доступных свойств перечисляемого типа?
========================================================================

> Мне нужно получить список строк (типа как в StringList) с возможными значениями свойства TBrushStyle
> (например, bsSolid, bsClear, bsHorizontal).
> Я хочу создать ComboBox с этими параметрами.
> Как я могу установить свойство Items моего ComboBox напрямую со всеми значениями
> перечислимого типа TBrushStyle?
> Мой ComboBox будет похож на редактор свойств этого типа.

Для этого вы можете использовать информацию времени выполнения (runtime type information, RTTI).

Ниже приведен пример:

    uses 
      {...}, TypInfo
     
    procedure BrushStylesAsStrings(AList: TStrings);
    var
      a: integer;
      pInfo: PTypeInfo;
      pEnum: PTypeData;
    begin
      AList.Clear;
      pInfo := PTypeInfo(TypeInfo(TBrushStyle));
      pEnum := GetTypeData(pInfo);
      with pEnum^ do
      begin
        for a := MinValue to MaxValue do
          AList.Add(GetEnumName(pInfo, a));
      end;
    end; 

---
Title: Как присвоить все значения полей одного класса другому такому же классу?
Date: 01.01.2007
---


Как присвоить все значения полей одного класса другому такому же классу?
========================================================================

::: {.date}
01.01.2007
:::

How can I assign all property values (or if it\'s not possible only
published property values, or some of them) of one class (TComponent) to
another instance of the same class? What I want to do is:

    MyComponent1.{property1} := MyComponent2.{property1};
    {...}
    MyComponent2.{propertyN} := MyComponent2.{propertyN};

Is there a better and shorter way to do this? I tried this: MyComponent1
:= MyComponent2; But it doesn\'t work. Why not? Can I point to the
second component ?

Answer 1:

MyComponent2 and MyComponent1 are pointers to your components, and this
kind of assigment leads to MyComponent1 pointing to MyComponent2. But it
will not copy its property values.

A better way is to override the assign method of your control, do all
property assignment there and call it when you need to copy component
attributes. Here\'s example:

    procedure TMyComponent.Assign(Source: TPersistent);
    begin
      if Source is TMyComponent then
      begin
        property1 := TMyComponent(Source).property1;
        { ... }
      end
      else
        inherited Assign(Source);
    end;

To assign properties you\'ll need to set this line in the code:

MyComponent1.Assign(MyComponent2);

Tip by Serge Gubenko

------------------------------------------------------------------------

    procedure EqualClassProperties(AClass1, AClass2: TObject);
    var
      PropList: PPropList;
      ClassTypeInfo: PTypeInfo;
      ClassTypeData: PTypeData;
      i: integer;
      NumProps: Integer;
      APersistent : TPersistent;
    begin
      if AClass1.ClassInfo <> AClass2.ClassInfo then
        exit;
      ClassTypeInfo := AClass1.ClassInfo;
      ClassTypeData := GetTypeData(ClassTypeInfo);
      if ClassTypeData.PropCount <> 0 then
      begin
        GetMem(PropList, SizeOf(PPropInfo) * ClassTypeData.PropCount);
        try
          GetPropInfos(AClass1.ClassInfo, PropList);
          for i := 0 to ClassTypeData.PropCount - 1 do
            if not (PropList[i]^.PropType^.Kind = tkMethod) then
              {if Class1,2 is TControl/TWinControl on same form, its names must be unique}
              if PropList[i]^.Name <> 'Name' then
                if (PropList[i]^.PropType^.Kind = tkClass) then
                begin
                  APersistent := TPersistent(GetObjectProp(AClass1, PropList[i]^.Name, TPersistent));
                if APersistent <> nil then
                  APersistent.Assign(TPersistent(GetObjectProp(AClass2, PropList[i]^.Name, TPersistent)))
                end
                else
                  SetPropValue(AClass1, PropList[i]^.Name, GetPropValue(AClass2, PropList[i]^.Name));
        finally
          FreeMem(PropList, SizeOf(PPropInfo) * ClassTypeData.PropCount);
        end;
      end;
    end;

Note that this code skips object properties inherited other than
TPersistent.

Tip by Gokhan Ersumer

Взято из <https://www.lmc-mediaagentur.de/dpool>

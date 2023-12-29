---
Title: Как изменить значение свойства компонента по имени?
Date: 01.01.2007
---


Как изменить значение свойства компонента по имени?
===================================================

::: {.date}
01.01.2007
:::

    function GetProperty(AControl: TPersistent; AProperty: String): PPropInfo;
    var
      i: Integer;
      props: PPropList;
      typeData: PTypeData;
    begin
      Result := nil;
      if (AControl = nil) or (AControl.ClassInfo = nil) then
        Exit;
      typeData := GetTypeData(AControl.ClassInfo);
      if (typeData = nil) or (typeData^.PropCount = 0) then
        Exit;
      GetMem(props, typeData^.PropCount * SizeOf(Pointer));
      try
        GetPropInfos(AControl.ClassInfo, props);
        for i := 0 to typeData^.PropCount - 1 do
        begin
          with Props^[i]^ do
            if (Name = AProperty) then
              result := Props^[i];
        end;
      finally
        FreeMem(props);
      end;
    end;
     
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      propInfo: PPropInfo;
    begin
      PropInfo := GetProperty(Button1.Font, 'Name');
      if PropInfo <> nil then
        SetStrProp(Button1.Font, PropInfo, 'Arial');
    end;

Взято из <https://www.lmc-mediaagentur.de/dpool>

------------------------------------------------------------------------

You can use RTTI to do this. Here is how to change a particular
component:

    procedure TForm1.BtnClick(Sender: TObject);
    var
      p: PPropInfo;
      f: TFont;
    begin
      f := TFont.Create;
      {Setup the font properties}
      f.Name := 'Arial';
      p := GetPropInfo(Sender.ClassInfo, 'Font');
      if Assigned(p) then
        SetOrdProp(Sender, p, Integer(f));
      f.Free;
    end;

To get at all the forms loop through the Screen global variable. For
each form loop through its Components list calling the above procedure
(or something close). If you only create your components at design time
that is it. If you create some at runtime and the owner is not the form,
then for each component loop through its Components list recursively to
get at all the owned components.

Tip by Jeff Overcash

Взято из <https://www.lmc-mediaagentur.de/dpool>

------------------------------------------------------------------------

I am building a routine that checks our forms for validity before
deploying them. I would like to use some kind of structure that tests if
a component type has access to a certain property, something like: \" if
(self.Controls\[b\] has Tag) then ...\". Can anyone offer suggestions?

Here\'s an example of setting a string property for a component if it
exists and another for an integer property:

    {
    Copyright © 1999 by Delphi 5 Developer's Guide - Xavier Pacheco and Steve Teixeira
    }
    procedure SetStringPropertyIfExists(AComp: TComponent; APropName: String;
    AValue: String);
    var
      PropInfo: PPropInfo;
      TK: TTypeKind;
    begin
      PropInfo := GetPropInfo(AComp.ClassInfo, APropName);
      if PropInfo <> nil then
      begin
        TK := PropInfo^.PropType^.Kind;
        if (TK = tkString) or (TK = tkLString) or (TK = tkWString) then
          SetStrProp(AComp, PropInfo, AValue);
      end;
    end;
     
     
    procedure SetIntegerPropertyIfExists(AComp: TComponent; APropName: String;
    AValue: Integer);
    var
      PropInfo: PPropInfo;
    begin
      PropInfo := GetPropInfo(AComp.ClassInfo, APropName);
      if PropInfo <> nil then
      begin
        if PropInfo^.PropType^.Kind = tkInteger then
          SetOrdProp(AComp, PropInfo, AValue);
      end;
    end;

Tip by Xavier Pacheco

Взято из <https://www.lmc-mediaagentur.de/dpool>

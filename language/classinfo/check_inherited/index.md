---
Title: Как определить, насдледовано ли свойство от определенного класса?
Date: 01.01.2007
Author: Peter Below
Source: <https://www.lmc-mediaagentur.de/dpool>
---


Как определить, насдледовано ли свойство от определенного класса?
=================================================================

    function GetFontProp(anObj: TObject): TFont;
    var
      PInfo: PPropInfo;
    begin
      {Try to get a pointer to the property information for a property with the name 'Font'.
      TObject.ClassInfo returns a pointer to the RTTI table, which we need to pass to GetPropInfo}
      PInfo := GetPropInfo(anObj.ClassInfo, 'font');
      Result := nil;
      if PInfo <> nil then
        {found a property with this name, check if it has the correct type}
        if (PInfo^.Proptype^.Kind = tkClass) and
          GetTypeData(PInfo^.Proptype^)^.ClassType.InheritsFrom(TFont)
          then
          Result := TFont(GetOrdProp(anObj, PInfo));
    end;


---
Title: Как прочитать весь список Published методов?
Date: 01.01.2007
---


Как прочитать весь список Published методов?
============================================

::: {.date}
01.01.2007
:::

    procedure EnumMethods( aClass: TClass; lines: TStrings );
     
      type
        TMethodtableEntry = packed Record
          len: Word;
          adr: Pointer;
          name: ShortString;
      end;
      {Note: name occupies only the size required, so it is not a true shortstring! The actual
      entry size is variable, so the method table is not an array of TMethodTableEntry!}
     
    var
      pp: ^Pointer;
      pMethodTable: Pointer;
      pMethodEntry: ^TMethodTableEntry;
      i, numEntries: Word;
    begin
      if aClass = nil then
        Exit;
      pp := Pointer(Integer( aClass ) + vmtMethodtable);
      pMethodTable := pp^;
      lines.Add(format('Class %s: method table at %p', [aClass.Classname, pMethodTable ] ));
      if pMethodtable <> nil then
      begin
        {first word of the method table contains the number of entries}
        numEntries := PWord( pMethodTable )^;
        lines.Add(format('  %d published methods', [numEntries] ));
        {make pointer to first method entry, it starts at the second word of the table}
        pMethodEntry := Pointer(Integer( pMethodTable ) + 2);
        for i := 1 to numEntries do
        begin
          with pMethodEntry^ do
            lines.Add(format( '  %d: len: %d, adr: %p, name: %s', [i, len, adr, name] ));
          {make pointer to next method entry}
          pMethodEntry := Pointer(Integer( pMethodEntry ) + pMethodEntry^.len);
        end;
      end;
        EnumMethods( aClass.ClassParent, lines );
    end;
     
     
    procedure TForm2.Button1Click(Sender: TObject);
    begin
      memo1.clear;
      EnumMethods( Classtype, memo1.lines );
    end;

Взято из <https://www.lmc-mediaagentur.de/dpool>

------------------------------------------------------------------------

    function GetComponentProperties(Instance: TPersistent; AList: TStrings): Integer;
    var
      I, Count: Integer;
      PropInfo: PPropInfo;
      PropList: PPropList;
    begin
      Result := 0;
      Count := GetTypeData(Instance.ClassInfo)^.PropCount;
      if Count > 0 then
      begin
        GetMem(PropList, Count * SizeOf(Pointer));
        try
          GetPropInfos(Instance.ClassInfo, PropList);
          for I := 0 to Count - 1 do
          begin
            PropInfo := PropList^[I];
            if PropInfo = nil then
              Break;
            if IsStoredProp(Instance, PropInfo) then
            begin
              {
              case PropInfo^.PropType^.Kind of
                tkInteger:
                tkMethod:
                tkClass:
                ...
              end;
              }
            end;
            Result := AList.Add(PropInfo^.Name);
          end;
        finally
          FreeMem(PropList, Count * SizeOf(Pointer));
        end;
      end;
    end;

Tip by Grega Loboda

------------------------------------------------------------------------

    uses
      TypInfo
     
    procedure ListProperties(AInstance: TPersistent; AList: TStrings);
    var
      i: integer;
      pInfo: PTypeInfo;
      pType: PTypeData;
      propList: PPropList;
      propCnt: integer;
      tmpStr: string;
    begin
      pInfo := AInstance.ClassInfo;
      if (pInfo = nil) or (pInfo^.Kind <> tkClass) then
        raise Exception.Create('Invalid type information');
      pType := GetTypeData(pInfo);  {Pointer to TTypeData}
      AList.Add('Class name: ' + pInfo^.Name);
      {If any properties, add them to the list}
      propCnt := pType^.PropCount;
      if propCnt > 0 then
      begin
        AList.Add(EmptyStr);
        tmpStr := IntToStr(propCnt) + ' Propert';
        if propCnt > 1 then
          tmpStr := tmpStr + 'ies'
        else
          tmpStr := tmpStr + 'y';
        AList.Add(tmpStr);
        FillChar(tmpStr[1], Length(tmpStr), '-');
        AList.Add(tmpStr);
        {Get memory for the property list}
        GetMem(propList, sizeOf(PPropInfo) * propCnt);
        try
          {Fill in the property list}
          GetPropInfos(pInfo, propList);
          {Fill in info for each property}
          for i := 0 to propCnt - 1 do
            AList.Add(propList[i].Name+': '+propList[i].PropType^.Name);
        finally
          FreeMem(propList, sizeOf(PPropInfo) * propCnt);
        end;
      end;
    end;
     
     
    function GetPropertyList(AControl: TPersistent; AProperty: string): PPropInfo;
    var
      i: integer;
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

And calling this code by:

    ListProperties(TProject(treeview1.items[0].data), memo3.lines);

My tProject is defined as

    type
       TProject = class(tComponent)
       private
         FNaam: string;
         procedure SetNaam(const Value: string);
       public
         constructor Create(AOwner: tComponent);
         destructor Destroy;
       published
         property Naam: string read FNaam write SetNaam;
       end;

Also note the output, there seem to be 2 standard properties (Name and
Tag) !

Memo3

Class name: TProject

3 Properties

-------------------

Name: TComponentName

Tag: Integer

Naam: String

Tip by Ronan van Riet

Взято из <https://www.lmc-mediaagentur.de/dpool>

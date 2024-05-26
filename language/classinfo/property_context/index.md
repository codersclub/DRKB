---
Title: Как получить контекст свойства по его целочисленному значению?
Date: 01.01.2007
Author: Ralph Friedman
Source: <https://www.lmc-mediaagentur.de/dpool>
---


Как получить контекст свойства по его целочисленному значению?
==============================================================

    unit PropertyList;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs, StdCtrls, Buttons;
     
    type
      TMyStream = class(TFileStream)
      private
      FFred: integer;
      published
      property Fred: integer read FFred write FFred;
      end;
    type
      TFrmPropertyList = class(TForm)
      SpeedButton1: TSpeedButton;
      ListBox1: TListBox;
      procedure SpeedButton1Click(Sender: TObject);
    private
      { Private declarations }
    public
      { Public declarations }
    end;
     
    var
      FrmPropertyList: TFrmPropertyList;
     
    implementation
     
    {$R *.DFM}
     
    uses
      TypInfo;
     
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
        AList.Add (EmptyStr);
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
            AList.Add(propList[i].Name + ': ' + propList[i].PropType^.Name);
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
     
     
    procedure TFrmPropertyList.SpeedButton1Click(Sender: TObject);
    var
      c: integer;
    begin
      ListProperties(self, ListBox1.Items);
      for c := 0 to ComponentCount - 1 do
      begin
        ListBox1.Items.Add(EmptyStr);
        ListProperties(Components[c], ListBox1.Items);
      end;
    end;
     
    end.


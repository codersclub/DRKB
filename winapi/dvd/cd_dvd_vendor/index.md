---
Title: Как узнать производителя CD / DVD?
Author: eralex
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как узнать производителя CD / DVD?
==================================

> Как это сделать через WMI я вроде разобрался.
> Только не нравится мне, что приходится перебирать в цикле все свойства
> Win32\_CDROMDrive. Может кто знает как сразу к конкретному свойству
> обратиться, т.е. избавиться от строки
> `while PropEnum.Next(1, TempObj, Value) = S_OK do`

Вот рабочий пример для D7.

    unit Unit1;
    interface
    uses
      Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
      Dialogs, WbemScripting_TLB, OleServer, ActiveX, StdCtrls, ExtCtrls,
      ComCtrls;
    type
      TForm1 = class(TForm)
        ListBox1: TListBox;
        SWbemLocator1: TSWbemLocator;
        Button1: TButton;
        procedure Button1Click(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
      end;
    var
      Form1: TForm1;
    implementation
     
    {$R *.dfm}
    procedure TForm1.Button1Click(Sender: TObject);
    var
      Service: ISWbemServices;
      ObjectSet: ISWbemObjectSet;
      SObject: ISWbemObject;
      PropSet: ISWbemPropertySet;
      SProp: ISWbemProperty;
      PropEnum, Enum: IEnumVariant;
      TempObj: OleVariant;
      Value: Cardinal;
      dr:string;
    begin
      ListBox1.Clear;
      Service:= SWbemLocator1.ConnectServer('.', 'root\CIMV2', '', '', '','', 0, nil);
      SObject:= Service.Get('Win32_CDROMDrive', wbemFlagUseAmendedQualifiers, nil);
      ObjectSet:= SObject.Instances_(0, nil);
      Enum:= (ObjectSet._NewEnum) as IEnumVariant;
      dr:='';
      while (Enum.Next(1, TempObj, Value) = S_OK) do
      begin
        SObject:= IUnknown(TempObj) as SWBemObject;
        PropSet:= SObject.Properties_;
        PropEnum:= (PropSet._NewEnum) as IEnumVariant;
        while PropEnum.Next(1, TempObj, Value) = S_OK do
        begin
          SProp:= IUnknown(TempObj) as SWBemProperty;
          if SProp.Name='Drive' then dr:=SProp.Get_Value;
          if SProp.Name='Name' then ListBox1.AddItem(dr+'  '+SProp.Get_Value, nil);
        end;
      end;
    end;
    end.


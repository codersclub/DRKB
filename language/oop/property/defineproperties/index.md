---
Title: Демонстрация DefineProperties
Author: Mike Scott
Date: 01.01.2007
---


Демонстрация DefineProperties
=============================

::: {.date}
01.01.2007
:::

Хорошо, создайте на основе опубликованного ниже кода модуль PropDemo.pas
и добавьте новый компонент в палитру компонентов. Расположите его на
форме и сохраните ее. Затем посмотрите файл DFM каким-либо
шестнадцатиричным редактором и проверьте наличие определенных свойств по
их именованным тэгам. Вы можете также попробовать закрыть форму и
модуль, а затем открыть его с помощью пункта меню File \| Open file...,
изменив тип файла в выпадающем списке на \*.DFM.

Mike Scott

Mobius Ltd.

    unit PropDemo;
     
    { Демонстрация DefineProperties.Mike Scott, CIS 100140,2420. }
     
    interface
     
    uses
      SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics, Controls,
      Forms, Dialogs;
     
    type
      TDemoProps = class(TComponent)
      private
    { Private declarations }
        FStringThing: string;
        FThing: record
          i, j, k: integer;
          x, y: real;
          ch: char;
        end;
        procedure ReadStringThing(Reader: TReader);
        procedure WriteStringThing(Writer: TWriter);
        procedure ReadThing(Stream: TStream);
        procedure WriteThing(Stream: TStream);
      protected
    { Protected declarations }
        procedure DefineProperties(Filer: TFiler); override;
      public
    { Public declarations }
        constructor Create(AOwner: TComponent); override;
      published
    { Published declarations }
      end;
     
    procedure Register;
     
    implementation
     
    constructor TDemoProps.Create(AOwner: TComponent);
     
    begin
      inherited Create(AOwner);
    { создайте любые данные, чтобы было что передать в поток}
      FStringThing := 'Всем привет!';
      with FThing do
        begin
          i := 1;
          j := 2;
          k := 3;
          x := PI;
          y := 180 / PI;
          ch := '?';
        end;
    end;
     
    procedure TDemoProps.ReadStringThing(Reader: TReader);
    begin
      FStringThing := Reader.ReadString;
    end;
     
    procedure TDemoProps.WriteStringThing(Writer: TWriter);
    begin
      Writer.WriteString(FStringThing);
    end;
     
    procedure TDemoProps.ReadThing(Stream: TStream);
    begin
      Stream.ReadBuffer(FThing, sizeof(FThing));
    end;
     
    procedure TDemoProps.WriteThing(Stream: TStream);
    begin
      Stream.WriteBuffer(FThing, sizeof(FThing));
    end;
     
    procedure TDemoProps.DefineProperties(Filer: TFiler);
     
    begin
      inherited DefineProperties(Filer);
      Filer.DefineProperty('StringThing', ReadStringThing, WriteStringThing,
        FStringThing <> '');
      Filer.DefineBinaryProperty('Thing', ReadThing, WriteThing, true);
    end;
     
    procedure Register;
    begin
      RegisterComponents('Samples', [TDemoProps]);
    end;
     
    end.

Взято из Советов по Delphi от [Валентина Озерова](mailto:mailto:webmaster@webinspector.com)

Сборник Kuliba

---
Title: Код определения свойств
Date: 01.01.2007
Author: Mike Scott, Mobius Ltd.
Source: Советы по Delphi от [Валентина Озерова](mailto:webmaster@webinspector.com)
---


Код определения свойств
=======================

Итак вам опять нужно "немного" кода. Вот небольшой примерчик
компонента лично для вас и остальных моих читателей. Установите этот
компонент в палитру Delphi, бросьте экземпляр на форму, закройте ее и
модуль и откройте форму как файл формы, используя в диалоге открытия тип
\*.dfm.

Вы увидите дополнительные свойства \'StringThing\' и \'Thing\'.
Первое - свойство строки, второе - бинарное свойство, фактически запись.
Если вы имеете HexEdit (шестнадцатиричный редактор) или что-то
аналогичное, взгляните на ваш dfm-файл и вы увидите тэги ваших новых
свойств вместе с их именами.

Если TReader/TWriter имеет специфические методы для чтения/записи
свойств и вы хотите добавить, например, строку, целое, символ или что-то
еще (проверьте описание соответствующих методов TReader в файлах
помощи), то в этом случае используйте DefineProperty. В случае сложного
объекта используйте DefineBinaryProperty и ваши методы чтения и записи
получат TStream вместо TReader/TWriter.

    unit PropDemo;
     
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



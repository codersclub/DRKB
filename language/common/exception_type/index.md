---
Title: Функция, возвращающая тип исключения
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Функция, возвращающая тип исключения
=========================

    // функция Chameleon, возвращающая тип сгенерированного исключения
     
    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls,
      Forms, Dialogs, StdCtrls;
     
    type
      MyBoolean = class
      public
        Value: boolean;
      end;
     
      MyInteger = class
      public
        Value: integer;
      end;
     
      MyClass = class
      public
        Value: TStrings;
      end;
     
      TForm1 = class(TForm)
        Button1: TButton;
        procedure Button1Click(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
        procedure MyProc;
        function Chameleon: boolean;
      end;
     
    var
     
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    function TForm1.Chameleon: boolean;
    var
      b: MyBoolean;
      i: MyInteger;
      c: MyClass;
      r: integer;
    begin
      r := Random(3);
      case r of
        0:
          begin
            b := MyBoolean.Create;
            raise b;
          end;
        1:
          begin
            i := MyInteger.Create;
            raise i;
          end;
        2:
          begin
            c := MyClass.Create;
            raise c;
          end;
      end;
    end;
     
    procedure TForm1.MyProc;
    begin
      try
        Chameleon;
      except
        on MyBoolean do
          ShowMessage('Функция возвратила класс MyBoolean');
        on MyInteger do
          ShowMessage('Функция возвратила класс MyInteger');
        on MyClass do
          ShowMessage('Функция возвратила класс MyClass');
      end;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      Chameleon;
    end;
     
    end.

Взгляните на тип данных Variant в D2: следующий код

    function AnyType(const TypeParm: integer): Variant;
    begin
      case TypeParm of
        1: Result := 1;
        2: Result := 2.0;
        3: Result := 'Три';
        4: Result := StrToDate('4/4/1944');
      end;
    end;

абсолютно бестолковый, но полностью корректный!

Следующий код содержит объявление трех функций, принимающих на входе
один и тот же параметр, но выдающих результаты различных типов
(результат физичиски один и тот же, и занимает он 4 байта). Я не думаю,
что можно одурачить delphi, чтобы с помощью этого метода возвратить
строку. Это может привести к разрушению менеджера кучи. Вместо этого
вызывайте необходимую вам функцию. Каждый вызов передается
MyFuncRetAnything, а P1 определяет возвращаемый тип. Если хотите, можете
написать другую обертку, делающую для вас еще и приведение типов.

**3 вызова, 1 код.**

Я понимаю, что это в действительности не то, что нужно, по я просто
хотел продемонстрировать другой способ. (вы можете возвращать строки как
тип PChar, который также занимает 4 байта). Вы должны использовать
некоторую память, распределяемую вызовом процедуры (может быть
передавать результаты как P2?).

    {моя форма имеет 3 метки, одну кнопку и этот код}
     
    var
      MyFuncRetInt: function(P1, P2: Integer): Integer;
      MyFuncRetBool: function(P1, P2: Integer): LongBool;
      MyFuncRetPointer: function(P1, P2: Integer): Pointer;
     
    function MyFuncRetAnything(P1, P2: Integer): Integer;
    var
      RetPointer: Pointer;
      RetBool: LongBool;
      RetInteger: Integer;
    begin
      RetPointer := nil;
      RetBool := False;
      RetInteger := 4711;
      case P1 of
        1: Result := Integer(RetPointer);
        2: Result := Integer(RetBool);
        3: Result := RetInteger;
      end;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      if MyFuncRetBool(2, 1900) then
        Label1.Caption := 'True'
      else
        Label1.Caption := 'False';
      Label2.Caption := IntToStr(MyFuncRetInt(3, 1900));
      Label3.Caption := IntToHex(Integer(MyFuncRetPointer(1, 1900)), 16);
    end;
     
    initialization
      MyFuncRetInt := @MyFuncRetAnything;
      MyFuncRetBool := @MyFuncRetAnything;
      MyFuncRetPointer := @MyFuncRetAnything;
     
    end.


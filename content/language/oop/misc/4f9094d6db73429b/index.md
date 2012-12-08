---
Title: Как забыть о необходимости разрушать объекты?
Date: 01.01.2007
---


Как забыть о необходимости разрушать объекты?
=============================================

::: {.date}
01.01.2007
:::

    type
      ISelfDestroy = interface;
      //forget about GUID, if you are not using COM
     
      TSelfDestroy = class(TInterfacedObject, ISelfDestroy)
      private
        FObject: TObject;
      public
        constructor Create(AObject: TObject);
        destructor Destroy; override;
      end;
     
    implementation
     
    constructor TSelfDestroy.Create(AObject: TObject);
    begin
      FObject := AObject;
    end;
     
    destructor TSelfDestroy.Destroy;
    begin
      FreeAndNil(FObject);
      inherited;
    end;
     
     
    // So when you use, just do like this...
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      MyObject: TMyObject;
      SelfDestroy: TSelfDestroy;
      begin
      MyObject    := TMyObject.Create;
      SelfDestroy := TSelfDestroy.Create(MyObject);
      // The MyObject will free automatically as soon as TSelfDestroy
      // goes out of scope.
      // Carry on your code here...
    end;

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>

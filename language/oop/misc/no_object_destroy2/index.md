---
Title: Как можно работать с объектами не заботясь об их разрушении?
Date: 01.01.2007
---


Как можно работать с объектами не заботясь об их разрушении?
============================================================

::: {.date}
01.01.2007
:::

Вначале сделаем интерфейс для нашего объекта:

    type
      IAutoClean = interface
        ['{61D9CBA6-B1CE-4297-9319-66CC86CE6922}']
      end;
     
      TAutoClean = class(TInterfacedObject, IAutoClean)
      private
        FObj: TObject;
      public
        constructor Create(AObj: TObject);
        destructor Destroy; override;
      end;
     
    implementation
     
    constructor TAutoClean.Create(AObj: TObject);
    begin
      FObj := AObj;
    end;
     
    destructor TAutoClean.Destroy;
    begin
      FreeAndNil(FObj);
      inherited;
    end;

А теперь будем использовать его вместо объекта:

    procedure TForm1.Button1Click(Sender: TObject);
    var
      a: IAutoClean;
        //must declare as local variable, so when this procedure finished, it's out of scope
      o: TOpenDialog; //any component
    begin
      o := TOpenDialog.Create(self);
      a := TAutoClean.Create(o);
      if o.Execute then
        ShowMessage(o.FileName);
    end;

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>

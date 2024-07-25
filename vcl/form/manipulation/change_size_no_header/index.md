---
Title: Форма, изменяющая размеры без заголовка
Author: feriman
Source: <https://forum.sources.ru>
Date: 01.01.2007
---


Форма, изменяющая размеры без заголовка
=======================================

Форма, изменяющая размеры без заголовка.

Нужно выставить свойство формы `BorderStyle := bsNone;`

    type
      TForm1 = class(TForm)
     
      ...
     
      protected
        procedure CreateParams(var Params: TCreateParams); override;
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.dfm}
     
    procedure TForm1.CreateParams(var Params: TCreateParams);
    begin
      inherited;
      Params.Style := (Params.Style or WS_THICKFRAME);
    end;


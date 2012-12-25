---
Title: Форма, изменяющая размеры без заголовка
Date: 01.01.2007
---


Форма, изменяющая размеры без заголовка
=======================================

::: {.date}
01.01.2007
:::

Форма изменяющая размеры без заголовка.

Нужно выставить свойство формы BorderStyle := bsNone;

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

Автор feriman

Взято из <https://forum.sources.ru>

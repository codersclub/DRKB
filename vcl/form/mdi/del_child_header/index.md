---
Title: Как убрать заголовок в дочерней форме MDI?
Date: 01.01.2007
---


Как убрать заголовок в дочерней форме MDI?
==========================================

Вариант 1:

Source: <https://forum.sources.ru>

Если в дочерней форме MDI установить BorderStyle в bsNone, то заголовок
формы не исчезнет. (Об этом сказано в хелпе). А вот следующий пример
решает эту проблему:

    type
      ... = class(TForm)
    { other stuff above }
        procedure CreateParams(var Params: TCreateParams); override;
    { other stuff below }
      end;
     
      ...
     
    procedure tMdiChildForm.CreateParams(var Params: tCreateParams);
    begin
      inherited CreateParams(Params);
      Params.Style := Params.Style and (not WS_CAPTION);
    end;


------------------------------------------------------------------------

Вариант 2:

Source: <https://delphiworld.narod.ru>

    type
      TForm2 = class(TForm)
        { другой код выше }
        procedure CreateParams(var Params: TCreateParams); override;
        { другой код ниже }
      end;
     
    procedure TForm2.CreateParams(var Params: TCreateParams);
    begin
      inherited CreateParams(Params);
      Params.Style := Params.Style and not WS_OVERLAPPEDWINDOW or WS_BORDER
    end;


---
Title: Необходимо, чтобы дочерняя форма не активизировала родительское окно
Date: 01.01.2007
---


Необходимо, чтобы дочерняя форма не активизировала родительское окно
====================================================================

::: {.date}
01.01.2007
:::

Сделайте родительским окном рабочий стол.

    procedure TForm2.CreateParams(VAR Params: TCreateParams); 
    begin 
      Inherited CreateParams(Params); 
      Params.WndParent := GetDesktopWindow; 
    end; 

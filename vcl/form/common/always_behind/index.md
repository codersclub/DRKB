---
Title: Как сделать форму всегда позади всех окон?
Date: 01.01.2007
---


Как сделать форму всегда позади всех окон?
==========================================

::: {.date}
01.01.2007
:::

    protected
      procedure CreateParams(var Params: TCreateParams); override;
     
    //...
     
    procedure TForm.CreateParams(var Params: TCreateParams);
    begin
      inherited CreateParams(Params);
      if Assigned(Application.MainForm) then
      begin
        Params.WndParent := GetDesktopWindow;
        Params.Style := WS_CHILD;
      end;
    end;

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>

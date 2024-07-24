---
Title: Как сделать форму всегда позади всех окон?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как сделать форму всегда позади всех окон?
==========================================

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


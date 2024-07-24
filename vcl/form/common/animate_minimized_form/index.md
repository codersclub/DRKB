---
Title: Как сделать анимацию минимизации формы?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как сделать анимацию минимизации формы?
=======================================

In FormShow:

    var
      RecS, RecL: TRect;
    begin
      RecS := Rect(Screen.Width, Screen.Height, Screen.Width, Screen.Height);
      RecL := ThisForm.BoundsRect;
      DrawAnimatedRects(GetDesktopWindow, IDANI_CAPTION, RecS, RecL);
      { ... }
    end;

In FormHide:

    var
      RecS, RecL: TRect;
    begin
      HideTimer.Enabled := False;
      RecS := Rect(Screen.Width, Screen.Height, Screen.Width, Screen.Height);
      RecL := ThisForm.BoundsRect;
      DrawAnimatedRects(GetDesktopWindow, IDANI_CAPTION, RecL, RecS);
    end;


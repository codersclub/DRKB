---
Title: Как сделать анимацию минимизации формы?
Date: 01.01.2007
---


Как сделать анимацию минимизации формы?
=======================================

::: {.date}
01.01.2007
:::

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

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>

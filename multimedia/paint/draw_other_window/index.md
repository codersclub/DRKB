---
Title: Как рисовать в чужом окне или по всему экрану?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как рисовать в чужом окне или по всему экрану?
==============================================

    procedure DrawOnScreen;
    var
      ScreenDC: hDC;
    begin
      ScreenDC := GetDC(0); {получить контекст экрана}
      Ellipse(ScreenDC, 0, 0, 200, 200); {нарисовать}
      ReleaseDC(0, ScreenDC); {освободить контекст}
    end;


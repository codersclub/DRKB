---
Title: Как узнать, какое окно закрывает форму?
Date: 01.01.2007
---


Как узнать, какое окно закрывает форму?
=======================================

    //Find windows that may cover another window.
    Var
      hW: HWnd;
      r: TRect;
    begin
      hw := Handle;
      While IsWindow(hw) Do Begin
        hw := GetWindow( hw, GW_HWNDPREV );
        If IsWindowVisible(hw) and not IsIconic( hw ) Then Begin
          ... use GetWindowRect( hw, r ) to get candidate windows
          rect and check if it intersects the forms BoundsRects via
          IntersectRect
        End;
      End;
    end;

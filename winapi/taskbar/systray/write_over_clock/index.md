---
Title: Надпись на часах в трее
Author: Krid
Date: 01.01.2007
Source: <https://forum.sources.ru>
---

Надпись на часах в трее
=======================

    var
      hTrayClock  : HWND;
      DC:HDC;
      r:TRect;
    
    begin
      hTrayClock := FindWindowEx(FindWindowEx(FindWindow('Shell_TrayWnd',nil),0,'TrayNotifyWnd',nil),0,'TrayClockWClass',nil);
      GetWindowRect(hTrayClock,r);
      DC := GetDC(0);
      //  SetBkMode(DC, TRANSPARENT);   // можно сделать прозрачный фон
      SetTextColor(DC, RGB($0FF,0,0));
      SetBkColor(DC,RGB($0FF,$0FF,0));
      TextOut(DC, r.Left+((r.Right-r.Left) div 4), r.Top+((r.Bottom-r.Top) div 4), '>:-(', 4);
      ReleaseDC(hTrayClock, DC);
    end.

При следующем обновлении часов надпись исчезнет. Так что можно делать
это по таймеру.


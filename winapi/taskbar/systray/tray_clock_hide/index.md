---
Title: Как скрыть часики в панели задач?
Date: 01.01.2007
---

Как скрыть часики в панели задач?
=================================

Вариант 1:

Source: <https://forum.sources.ru>

Убираем часики:

    procedure TForm1.Button1Click(Sender: TObject);
    var hn: HWnd;
    begin
      hn := FindWindowEx(FindWindowEx(FindWindow('Shell_TrayWnd', nil), 0, 'TrayNotifyWnd', nil), 0, 'TrayClockWClass', nil); 
      if hn <> 0 then
        ShowWindow(hn, SW_HIDE); //Bye,bye,Baby
    end;

Снова показываем:

    procedure TForm1.Button2Click(Sender: TObject);
    var hn: HWnd;
    begin
      hn := FindWindowEx(FindWindowEx(FindWindow('Shell_TrayWnd', nil), 0, 'TrayNotifyWnd', nil), 0, 'TrayClockWClass', nil);
      if hn <> 0 then
        ShowWindow(hn, SW_SHOW); //Hello, again
    end;


------------------------------------------------------------------------

Вариант 2:

Source: <https://delphiworld.narod.ru>

    function ShowTrayClock(bValue: Boolean) : Boolean; 
    var 
      TrayWnd, TrayNWnd, ClockWnd: HWND; 
    begin 
      TrayWnd  := FindWindow('Shell_TrayWnd', nil); 
      TrayNWnd := FindWindowEx(TrayWnd, 0, 'TrayNotifyWnd', nil); 
      ClockWnd := FindWindowEx(TrayNWnd, 0, 'TrayClockWClass', nil); 
      Result := IsWindow(ClockWnd); 
      if Result then 
      begin 
        ShowWindow(ClockWnd, Ord(bValue)); 
        PostMessage(ClockWnd, WM_PAINT, 0, 0); 
      end; 
    end; 
     
    // Example to hide they clock: 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
       ShowTrayClock(Boolean(0)); 
    end;


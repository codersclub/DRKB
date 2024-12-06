---
Title: Мигание кнопки приложения
Date: 01.01.2007
---

Мигание кнопки приложения
=========================

Вариант 1:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    procedure TForm1.Timer1Timer(Sender: TObject);
    begin
      FlashWindow(Application.Handle, True);
    end;


------------------------------------------------------------------------

Вариант 2:

Source: <https://www.swissdelphicenter.ch>

    Timer1.Interval = n  (Tip for n = 1000  "1 second")
     
     procedure TForm1.Timer1Timer(Sender: TObject);
     begin
          FlashWindow(Handle, true);
          FlashWindow(Application.Handle, true);
     end;

------------------------------------------------------------------------

Вариант 3:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    // Define FLASHWINFO structure as record type 
    type 
      FLASHWINFO = record 
        cbSize: UINT; 
        hWnd: HWND; 
        dwFlags: DWORD; 
        uCount: UINT; 
        dwTimeOut: DWORD; 
      end; 
      TFlashWInfo = FLASHWINFO; 
     
      // Define dwFlags constants 
    const 
      FLASHW_STOP = 0; 
      FLASHW_CAPTION = 1; 
      FLASHW_TRAY = 2; 
      FLASHW_ALL = FLASHW_CAPTION or FLASHW_TRAY; 
      FLASHW_TIMER = 4; 
      FLASHW_TIMERNOFG = 12; 
     
    var 
      Form1: TForm1; 
      FWInfo: TFlashWInfo; 
     
      // Function declaration for WinAPI call 
    function FlashWindowEx(var pfwi: FLASHWINFO): BOOL; stdcall; 
     
      {...} 
     
    implementation 
     
    {...} 
     
    // Import external function from 'USER32.DLL' with the same name 
    function FlashWindowEx; external user32 Name 'FlashWindowEx'; 
     
    procedure TForm1.FormCreate(Sender: TObject); 
    begin 
      // Check for API function's availability 
      if not Assigned(@FlashWindowEx) then 
      begin 
        ShowMessage('API Function FlashWindowEx is not present... Exit program!'); 
        Application.Terminate; 
      end 
      else 
        // Set default parameters 
        with FWInfo do 
        begin 
          cbSize    := SizeOf(FWInfo); // Size of structure in bytes 
          hWnd      := Form1.Handle;   // Main's form handle 
          dwFlags   := FLASHW_ALL;     // Flash both caption & task bar 
          uCount    := 10;             // Flash 10 times 
          dwTimeOut := 100;            // Timeout is 1/10 second apart 
        end; 
    end; 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      // Flash on normal state 
      FlashWindowEx(FWInfo); 
    end; 
     
    procedure TForm1.Button2Click(Sender: TObject); 
    begin 
      // Flash on minimized state 
      WindowState := wsMinimized;  // Application.Minimize; 
      FlashWindowEx(FWInfo); 
    end;


---
Title: Получить все возможные разрешения экрана
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Получить все возможные разрешения экрана
========================================

    procedure TForm1.Button1Click(Sender: TObject);
    var 
      DC: THandle;      // display context
      Bits: integer;    // bits per pixel
      HRes: integer;    // horizontal resolution
      VRes: integer;    // vertical resolution
      DM: TDevMode;     // to Save EnumDisplaySettings
      ModeNum: longint; // video mode number
      Ok: Bool;
      fre: integer;     // refresh rate 
    begin 
      DC   := GetDC(Handle); 
      Bits := GetDeviceCaps(DC, BITSPIXEL); 
      HRes := GetDeviceCaps(DC, HORZRES); 
      VRes := GetDeviceCaps(DC, VERTRES); 
      fre  := GetDeviceCaps(DC, VREFRESH); 
      // Show Current Resolution 
      Edit1.Text := Format('%d bit, %d x %d', [Bits, HRes, VRes]); 
      ReleaseDC(Handle, DC); // Show all modes available ModeNum := 0;  // The 1st one 
      EnumDisplaySettings(nil, ModeNum, DM); 
      ListBox1.Items.Add(Format('%d bit, %d x %d bei %d Hz', [DM.dmBitsPerPel, 
        DM.dmPelsWidth, DM.dmPelsHeight, Dm.dmDisplayFrequency])); 
      Ok := True; 
      while Ok do 
      begin 
        Inc(ModeNum); // Get next one 
        Ok := EnumDisplaySettings(nil, ModeNum, DM); 
        ListBox1.Items.Add(Format('%d bit, %d x %d bei %d Hz', [DM.dmBitsPerPel, 
          DM.dmPelsWidth, DM.dmPelsHeight, Dm.dmDisplayFrequency])); 
      end; 
    end;



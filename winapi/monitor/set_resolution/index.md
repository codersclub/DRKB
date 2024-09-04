---
Title: Как установить разрешение экрана?
Author: cpu
Date: 01.01.2007
---


Как установить разрешение экрана?
=================================

Вариант 1:

Author: cpu

Source: Vingrad.ru <https://forum.vingrad.ru>

    ChangeDisplaySettings

------------------------------------------------------------------------

Вариант 2:

Author: Зайцев О.В., Владимиров А.М.

Source: <https://forum.sources.ru>

    function SetFullscreenMode:Boolean;
    var DeviceMode : TDevMode;
    begin
      with DeviceMode do begin
        dmSize:=SizeOf(DeviceMode);
        dmBitsPerPel:=16;
        dmPelsWidth:=640;
        dmPelsHeight:=480;
        dmFields:=DM_BITSPERPEL or DM_PELSWIDTH or DM_PELSHEIGHT;
        result:=False;
        if ChangeDisplaySettings(DeviceMode,CDS_TEST or CDS_FULLSCREEN) <> DISP_CHANGE_SUCCESSFUL 
          then Exit;
        Result:=ChangeDisplaySettings(DeviceMode,CDS_FULLSCREEN) = DISP_CHANGE_SUCCESSFUL;
      end;
    end;
     
    procedure RestoreDefaultMode;
    var T : TDevMode absolute 0;
    begin
      ChangeDisplaySettings(T,CDS_FULLSCREEN);
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      if setFullScreenMode then begin
        sleep(7000);
        RestoreDefaultMode;
      end;
    end;

------------------------------------------------------------------------

Вариант 3:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    procedure ChangeDisplayResolution(x, y: word);
    var
      dm: TDEVMODE;
    begin
      ZeroMemory(@dm, sizeof(TDEVMODE));
      dm.dmSize := sizeof(TDEVMODE);
      dm.dmPelsWidth := x;
      dm.dmPelsHeight := y;
      dm.dmFields := DM_PELSWIDTH or DM_PELSHEIGHT;
      ChangeDisplaySettings(dm, 0);
    end;


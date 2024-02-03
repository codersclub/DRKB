---
Title: Как определить видеокарту?
Date: 01.01.2007
---


Как определить видеокарту?
==========================

::: {.date}
01.01.2007
:::


    procedure TForm1.button1click(Sender: TObject); 
    var 
      lpDisplayDevice: TDisplayDevice; 
      dwFlags: DWORD; 
      cc: DWORD; 
    begin 
    form2.memo1.Clear; 
    lpDisplayDevice.cb := sizeof(lpDisplayDevice); 
    dwFlags := 0; 
    cc:= 0; 
    while EnumDisplayDevices(nil, cc, lpDisplayDevice, dwFlags) do 
      begin 
        Inc(cc); 
        form2.memo1.lines.add(lpDisplayDevice.DeviceString);
            {Так же мы увидим дополнительную информацию в lpDisplayDevice} 
        form2.show; 
      end; 
    end;


Взято из <https://forum.sources.ru>

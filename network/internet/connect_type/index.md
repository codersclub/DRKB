---
Title: Как узнать тип соединения с интернетом?
Date: 01.01.2007
---


Как узнать тип соединения с интернетом?
=======================================

::: {.date}
01.01.2007
:::

    uses 
      WinInet; 
     
    const 
      MODEM = 1; 
      LAN = 2; 
      PROXY = 4; 
      BUSY = 8; 
     
    function GetConnectionKind(var strKind: string): Boolean; 
    var 
      flags: DWORD; 
    begin 
      strKind := ''; 
      Result := InternetGetConnectedState(@flags, 0); 
      if Result then 
      begin 
        if (flags and MODEM) = MODEM then strKind := 'Modem'; 
        if (flags and LAN) = LAN then strKind := 'LAN'; 
        if (flags and PROXY) = PROXY then strKind := 'Proxy'; 
        if (flags and BUSY) = BUSY then strKind := 'Modem Busy'; 
      end; 
    end; 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    var 
      strKind: string; 
    begin 
      if GetConnectionKind(strKind) then 
        ShowMessage(strKind); 
    end;

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>

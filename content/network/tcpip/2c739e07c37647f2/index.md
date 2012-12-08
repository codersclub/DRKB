---
Title: Как преобразовать длинный IP-адрес в короткий адрес / порт?
Date: 01.01.2007
---


Как преобразовать длинный IP-адрес в короткий адрес / порт?
===========================================================

::: {.date}
01.01.2007
:::

Некоторые старые internet протоколы ( такие как FTP ) посылают IP адреса
и номера портов в шестизначном формате XXX.XXX.XXX.XXX.XX.XXX  Следующий
код позволяет преобразовать такой адрес к нормальному четырёхзначному IP
адресу.

    procedure LongIPToShort(aLongIPAddress: string; out ShortIPAddress: string; out PortNumber: Integer);
    var I, DotPos, tempPort: Integer;
    var tempAddy, temp: string;
    var TempStr: string;
    begin
      tempAddy := '';
      tempStr := '';
    // Определяем, какой символ использует отправитель в качестве разделителя длинного IP: , или .
     
      if (POS(',', aLongIPAddress) <> 0) then
        TempStr := ','
      else
        TempStr := '.';
     
      for I := 1 to 4 do
        begin
          DotPOS := POS(TempStr, aLongIPAddress);
          tempAddy := tempAddy + (Copy(aLongIPAddress, 1, (DotPos - 1)));
          if I <> 4 then TempADdy := TempAddy + '.';
          Delete(aLongIpAddress, 1, DotPos);
        end;
      DotPos := Pos(TempStr, aLongIpAddress);
      temp := Copy(aLongIpAddress, 1, (DotPos - 1));
      tempPort := (StrToInt(temp) * 256);
      Delete(aLongIpAddress, 1, DotPos);
      TempPort := tempPort + StrToInt(ALongIpAddress);
      ShortIPAddress := TempADdy;
      PortNumber := tempPort;
    end;

Взято из <https://forum.sources.ru>

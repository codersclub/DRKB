---
Title: Записать в реестр данные бинарного вида
Date: 01.01.2007
---

Записать в реестр данные бинарного вида
=======================================

::: {.date}
01.01.2007
:::

    var
      Reg: TRegistry;
      buf : array [0..4] of byte;
      i: Integer;
    begin
      Reg := TRegistry.Create;
      try
        Reg.RootKey := HKEY_CURRENT_USER;
        if Reg.OpenKey('\Software', True) then begin
          for i:=1 to 4 do buf[i]:=0;
          buf[0]:=1;
          Reg.WriteBinnaryData('Value', buf, sizeof(buf));
          Reg.CloseKey;
        end;
      finally
        Reg.Free;
        inherited;
      end;
      {...}
    end;
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

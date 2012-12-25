---
Title: Как получить информацию о BIOS в Windows NT/2000/XP?
Date: 01.01.2007
---


Как получить информацию о BIOS в Windows NT/2000/XP?
====================================================

::: {.date}
01.01.2007
:::

В NT/2000/XP не получится прочитать значения прямо из BIOS, однако,
ничего не мешает нам считать нужные значения из реестра.

    procedure TBIOSInfo.GetRegInfoWinNT; 
    var 
      Registryv       : TRegistry; 
      RegPath         : string; 
      sl              : TStrings; 
    begin 
      Params.Clear; 
     
      RegPath := '\HARDWARE\DESCRIPTION\System'; 
      registryv:=tregistry.Create; 
      registryv.rootkey:=HKEY_LOCAL_MACHINE; 
      sl := nil; 
      try 
        registryv.Openkey(RegPath,false); 
        ShowMessage('BIOS Date: '+RegistryV.ReadString('SystemBiosDate')); 
        sl := ReadMultirowKey(RegistryV,'SystemBiosVersion'); 
        ShowMessage('BIOS Version: '+sl.Text); 
      except 
      end; 
      Registryv.Free; 
      if Assigned(sl) then sl.Free; 
    end;

------------------------------------------------------------------------

    /следующий метод получает многострочные значения из реестра
    //и преобразует их в TStringlist
    function ReadMultirowKey(reg: TRegistry; Key: string): TStrings; 
    const bufsize = 100; 
    var 
      i: integer; 
      s1: string; 
      sl: TStringList; 
      bin: array[1..bufsize] of char; 
    begin 
      try 
        result := nil; 
        sl := nil; 
        sl := TStringList.Create; 
        if not Assigned(reg) then 
          raise Exception.Create('TRegistry object not assigned.'); 
        FillChar(bin,bufsize,#0); 
        reg.ReadBinaryData(Key,bin,bufsize); 
        i := 1; 
        s1 := ''; 
        while i < bufsize do 
        begin 
          if ord(bin[i]) >= 32 then 
            s1 := s1 + bin[i] 
          else 
          begin 
            if Length(s1) > 0 then 
            begin 
              sl.Add(s1); 
              s1 := ''; 
            end; 
          end; 
          inc(i); 
        end; 
        result := sl; 
      except 
        sl.Free; 
        raise; 
      end; 
    end;

Взято из <https://forum.sources.ru>

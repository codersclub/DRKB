---
Title: Проверка наличия .NET Framework и определение его версии
Author: Dimka Maslov, mainbox@endimus.com
Date: 19.01.2004
---


Проверка наличия .NET Framework и определение его версии
========================================================

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Проверка наличия .NET Framework и определение его версии
     
    Функция возвращает номер последней установленной версии .NET Framework на компьютере,
    или пустую строку, если платформа .NET не установлена, либо установлена криво.
     
    Зависимости: Registry, SysUtils
    Автор:       Dimka Maslov, mainbox@endimus.com, ICQ:148442121, Санкт-Петербург
    Copyright:   Dimka Maslov
    Дата:        19 января 2004 г.
    ********************************************** }
     
    function DotNetVersion: String;
    var
     R: TRegistry;
     L: TStringList;
     S: string;
     i, MaxIndex, N, Code: Integer;
     V, MaxVersion: Double;
    const
     RegKey = 'Software\Microsoft.NETFramework\Policy';
    begin
     Result := '';
     R := TRegistry.Create;
     try
      R.RootKey := HKEY_LOCAL_MACHINE;
      if R.KeyExists(RegKey) then begin
       R.OpenKeyReadOnly(RegKey);
       L := TStringList.Create;
       try
        R.GetKeyNames(L);
        MaxVersion := -1.0;
        MaxIndex := -1;
        for i := 0 to L.Count - 1 do begin
         S := L[i];
         if UpCase(S[1]) = 'V' then begin
          Delete(S, 1, 1);
          Val(S, V, Code);
          if (Code = 0) and (V > MaxVersion) then begin
           MaxVersion := V;
           MaxIndex := i;
          end;
         end;
        end;
        if MaxIndex <> - 1 then begin
         S := L[MaxIndex];
         R.CloseKey;
         R.OpenKeyReadOnly(RegKey+'\'+S);
         R.GetValueNames(L);
         MaxIndex := -1;
         for i := 0 to L.Count - 1 do begin
          Val(L[i], N, Code);
          if (Code = 0) and (N > MaxIndex) then MaxIndex := N;
         end;
         Result := S;
         Delete(Result, 1, 1);
         if MaxIndex <> -1 then Result := Result + '.' + IntToStr(MaxIndex);
        end;
       finally
        L.Free;
       end;
      end;
     finally
      R.Free;
     end;
    end;

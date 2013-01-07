---
Title: Как узнать версию программы?
Author: Vit
Date: 01.01.2007
---


Как узнать версию программы?
============================

::: {.date}
01.01.2007
:::

    function FileVersion(AFileName:string): string;
    var
      szName: array[0..255] of Char;
      P: Pointer;
      Value: Pointer;
      Len: UINT;
      GetTranslationString:string;
      FFileName: PChar;
      FValid:boolean;
      FSize: DWORD;
      FHandle: DWORD;
      FBuffer: PChar;
    begin
      try
        FFileName := StrPCopy(StrAlloc(Length(AFileName) + 1), AFileName);
        FValid := False;
        FSize := GetFileVersionInfoSize(FFileName, FHandle);
        if FSize > 0 then
          try
            GetMem(FBuffer, FSize);
            FValid := GetFileVersionInfo(FFileName, FHandle, FSize, FBuffer);
          except
            FValid := False;
            raise;
          end;
        Result := '';
        if FValid then
          VerQueryValue(FBuffer, '\VarFileInfo\Translation', p, Len)
        else p := nil;
        if P <> nil then
          GetTranslationString := IntToHex(MakeLong(HiWord(Longint(P^)), LoWord(Longint(P^))), 8);
        if FValid then
          begin
            StrPCopy(szName, '\StringFileInfo\' + GetTranslationString + '\FileVersion');
            if VerQueryValue(FBuffer, szName, Value, Len) then
              Result := StrPas(PChar(Value));
          end;
      finally
        try
          if FBuffer <> nil then FreeMem(FBuffer, FSize);
        except
        end;
        try
          StrDispose(FFileName);
        except
        end;
      end;
    end;

В качестве параметра задать имя программы, если своей программы:

    FileVersion(Paramstr(0));

Автор: Vit

Взято с Vingrad.ru <https://forum.vingrad.ru>

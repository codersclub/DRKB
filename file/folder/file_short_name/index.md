---
Title: Как получить короткий путь файла, если есть длинный, и на оборот?
Author: Alex&Co
Date: 01.01.2007
---


Как получить короткий путь файла, если есть длинный, и на оборот?
=================================================================

::: {.date}
01.01.2007
:::

Получить короткий путь по значению длинного:

    GetShortPathName(LongPath) 
     
Получить длинный путь по значению короткого:

    GetFullPathName(ShortPath)


    function sfn(const LongName: String): String;
    // Возвращает LongFileName преобразованное в соответствующее короткое имя

    var i :Integer;
    begin
      SetLength(Result,Length(LongName));
      i := GetShortPathName(pChar(LongName),pChar(Result),Length(Result));
      if  i > Length(Result)  then begin
        SetLength(Result,i);
        i := GetShortPathName(pChar(LongName),pChar(Result),Length(Result));
      end;
      SetLength(Result,i);
    end;
     
    function ShortToLongFileName(FileName: string): string;
    // Возвращает FileName преобразованное в соответствующее длинное имя

    var
      KernelHandle: THandle;
      FindData: TWin32FindData;
      Search: THandle;
      GetLongPathName: function(lpszShortPath: PChar; lpszLongPath: PChar;
                                cchBuffer: DWORD): DWORD; stdcall;
    begin
      KernelHandle := GetModuleHandle('KERNEL32');
      if KernelHandle <> 0 then
        @GetLongPathName := GetProcAddress(KernelHandle, 'GetLongPathNameA');
     
      // Использю GetLongPathName доступную в windows 98 и выше чтобы
      // избежать проблем доступа к путям UNC в системах NT/2K/XP
      if Assigned(GetLongPathName) then begin
        SetLength(Result, MAX_PATH + 1);
        SetLength(Result, GetLongPathName(PChar(FileName), @Result[1], MAX_PATH));
      end
      else begin
        Result := '';
     
        // Поднимаюсь на одну дирректорию выше от пути к файлу и запоминаю
        // в result.  FindFirstFile возвратит длинное имя файла полученное
        // из короткого.
        while (True) do begin
          Search := Windows.FindFirstFile(PChar(FileName), FindData);
     
          if Search = INVALID_HANDLE_VALUE then Break;
     
          Result := String('\') + FindData.cFileName + Result;
          FileName := ExtractFileDir(FileName);
          Windows.FindClose(Search);
     
          // Нахожу имя диска с двоеточием.
          if Length(FileName) <= 2 then Break;
        end;
     
        Result := ExtractFileDrive(FileName) + Result;
      end;
    end;
     

Автор: Alex&Co

Сайт: [https://alex-co.com.ru](https://alex-co.com.ru%20)

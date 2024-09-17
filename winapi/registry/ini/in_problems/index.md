---
Title: Проблемы INI-файла
Date: 01.01.2007
---

Проблемы INI-файла
==================

Вариант 1:

Author: Tony Chang

Кто-нибудь имел какие-нибудь проблемы при использовании модуля TIniFile?
Я думаю здесь какая-то детская проблема с кэшированием!!!

Вот что я делал:

    (* c:\test.ini уже существует *)
    myIni := TIniFile.Create('c:\test.ini');
    With myIni do
    begin
      // .... (добавляем новую секцию в test.ini
    end;
    myIni.Free;
    RenameFile('c:\test.ini', 'c:\test1.ini');

Что я получил:

- test1.ini НЕ ИМЕЕТ добавленной мною секции;

- всякий раз при создании или открытии нового файла в том же самом
каталоге с помощью File Manager, \'c:\\test.ini\' появляется вновь, и у
него СУЩЕСТВУЕТ секция, которую я добавлял.

Я решил эту проблему добавлением следующей строки перед IniFile.Free:

    WritePrivateProfileString(nil, nil, nil, PChar(IniFileName));

Для получения дополнительной информации обратитесь к электронной справке
к разделу \'WritePrivateProfileString\'

------------------------------------------------------------------------

Вариант 2:

Source: <https://delphiworld.narod.ru>

Как указать системе на необходимость сбросить буфер INI-файла на диск

    procedure FlushIni(FileName: string);
    var
      {$IFDEF WIN32}
      CFileName: array[0..MAX_PATH] of WideChar;
      {$ELSE}
      CFileName: array[0..127] of Char;
      {$ENDIF}
    begin
      {$IFDEF WIN32}
      if (Win32Platform = VER_PLATFORM_WIN32_NT) then
        WritePrivateProfileStringW(nil, nil, nil, StringToWideChar(FileName,
        CFileName, MAX_PATH))
      else
        WritePrivateProfileString(nil, nil, nil, PChar(FileName));
      {$ELSE}
      WritePrivateProfileString(nil, nil, nil, StrPLCopy(CFileName,
      FileName, SizeOf(CFileName) - 1));
      {$ENDIF}
    end;


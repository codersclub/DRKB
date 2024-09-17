---
Title: INI-файлы (чтение / запись)
Date: 01.01.2007
---

INI-файлы (чтение / запись)
===========================

    function ReadIni(ASection, AString: string): string;
    var
      sIniFile: TIniFile;
      sPath: string[60];
    const
      S = 'xyz'; { стандартная строка для выдачи ошибок чтения }
    begin
      GetDir(0, sPath); { текущий каталог }
      sIniFile := TIniFile.Create(sPath + '\Name.INI');
      Result := sIniFile.ReadString(ASection, AString, S); { [Section] String=Value}
      sIniFile.Free;
    end;
     
    procedure WriteIni(ASection, AString, AValue: string);
    var
      sIniFile: TIniFile;
      sPath: string[60];
    begin
      GetDir(0, sPath); { текущий каталог }
      sIniFile := TIniFile.Create(sPath + '\Name.INI');
      sIniFile.WriteString(ASection, AString, AValue); { [Section] String=Value }
      sIniFile.Free;
    end;
     
    {ReadSection считывает все пункты указанной секции - т.е. ключи перед знаком "="
    ReadSectionValues полностью считывает все строки указанной секции, т.е. Punkt=xyz }

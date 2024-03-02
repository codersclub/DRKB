---
Title: Пример вызова TUtility DLL из Delphi?
Date: 01.01.2007
Source: Советы по Delphi от [Валентина Озерова](mailto:webmaster@webinspector.com)
---


Пример вызова TUtility DLL из Delphi?
=====================================

    var
      Session: hTUses;
      i: integer;
      ErrorCode: word;
      ResultCode: word;
     
    procedure BdeError(ResultCode: Word);
    begin
      if ResultCode <> 0 then
        raise Exception.CreateFmt('BDE ошибка %x', [ResultCode]);
    end;
     
    begin
      try
        BdeError(DbiInit(nil));
        BdeError(TUInit(@Session));
     
        for i := 1 to High(TableNames) do
          begin
            WriteLn('Проверка ' + TableNames[i]);
     
            ResultCode := TUVerifyTable(Session, @TableNames[i, 1], szPARADOX, 'TABLERRS.DB', nil, TU_Append_Errors, ErrorCode);
            BdeError(ResultCode);
     
            if ErrorCode = 0 then
              WriteLn('Успешно')
            else
              WriteLn('ОШИБКА! -- Для информации смотри TABLERRS.DB!');
     
            WriteLn('');
          end;
      finally
        BdeError(TUExit(Session));
        BdeError(DbiExit);
      end;
    end.

Взято из Советов по Delphi от [Валентина Озерова](mailto:webmaster@webinspector.com)

Сборник Kuliba

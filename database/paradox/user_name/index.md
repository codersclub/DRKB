---
Title: Имя пользователя Paradox
Date: 01.01.2007
Source: Советы по Delphi от [Валентина Озерова](mailto:webmaster@webinspector.com)
---


Имя пользователя Paradox
========================

Вы можете выполнить эту задачу, непосредственно обращаясь к BDE.

Включите следующие модули в секцию Uses вашего модуля: DBIPROCS, DBIERRS,
DBITYPES.

Ниже приведена функция с именем ID, возвращающая сетевое имя входа:

    function ID: string;
    var
      rslt: DBIResult;
      szErrMsg: DBIMSG;
      pszUserName: PChar;
    begin
     
      try
        Result := '';
        pszUserName := nil;
        GetMem(pszUserName, SizeOf(Char) * DBIMAXXBUSERNAMELEN);
        rslt := DbiGetNetUserName(pszUserName);
        if rslt = DBIERR_NONE then
          Result := StrPas(pszUserName)
        else
          begin
            DbiGetErrorString(rslt, szErrMsg);
            raise Exception.Create(StrPas(szErrMsg));
          end;
        FreeMem(pszUserName, SizeOf(Char) * DBIMAXXBUSERNAMELEN);
        pszUserName := nil;
      except
        on E: EOutOfMemory do ShowMessage('Ошибка. ' + E.Message);
        on E: Exception do ShowMessage(E.Message);
      end;
      if pszUserName <> nil then FreeMem(pszUserName, SizeOf(Char) * DBIMAXXBUSERNAMELEN);
    end;


Сборник Kuliba

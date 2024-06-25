---
Title: Получение имени пользователя и домена
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Получение имени пользователя и домена
=====================================

    // Пример получения имени пользователя и домена под которым работает 
    // текущий поток или процесс 
    type
     PTOKEN_USER = ^TOKEN_USER;
     _TOKEN_USER = record
       User : TSidAndAttributes;
     end;
     TOKEN_USER = _TOKEN_USER;
     
    function GetCurrentUserAndDomain (
          szUser : PChar; var chUser: DWORD; szDomain :PChar; var chDomain : DWORD
     ):Boolean;
    var
     hToken : THandle;
     cbBuf  : Cardinal;
     ptiUser : PTOKEN_USER;
     snu    : SID_NAME_USE;
    begin
     Result:=false;
     // Получаем маркер доступа текущего потока нашего процесса
     if not OpenThreadToken(GetCurrentThread(),TOKEN_QUERY,true,hToken)
      then begin
       if GetLastError()< > ERROR_NO_TOKEN then exit;
       // В случее ошибки - получаем маркер доступа нашего процесса.
       if not OpenProcessToken(GetCurrentProcess(),TOKEN_QUERY,hToken)
        then exit;
      end;
     
     // Вывываем GetTokenInformation для получения размера буфера 
     if not GetTokenInformation(hToken, TokenUser, nil, 0, cbBuf)
      then if GetLastError()< > ERROR_INSUFFICIENT_BUFFER
       then begin
        CloseHandle(hToken); 
        exit;
       end;
     
     if cbBuf = 0 then exit;
     
     // Выделяем память под буфер 
     GetMem(ptiUser,cbBuf);
     
     // В случае удачного вызова получим указатель на TOKEN_USER
     if GetTokenInformation(hToken,TokenUser,ptiUser,cbBuf,cbBuf)
      then begin
       // Ищем имя пользователя и его домен по его SID
       if LookupAccountSid(nil,ptiUser.User.Sid,szUser,chUser,szDomain,chDomain,snu)
        then Result:=true;
      end;
     
     // Освобождаем ресурсы 
     CloseHandle(hToken);
     FreeMem(ptiUser);
    end;
     
    // Использовать функцию можно так :
    var
     Domain, User : array [0..50] of Char;
     chDomain,chUser : Cardinal;
    begin
     chDomain:=50;
     chUser :=50;
     if GetCurrentUserAndDomain(User,chuser,Domain,chDomain)
      then ...
    end; 
     
    // Если вам необходимо получить только имя пользователя - используйте GetUserName
    // Данный пример можно использовать и для определения - запущен ли процесс
    // системой или пользователем.  Учетной записи Localsystem соответствует 
    // имя пользователя - SYSTEM и домен NT AUTORITY (лучше проверить на практике)


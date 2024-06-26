---
Title: Добавление и удаление общих сетевых ресурсов
Author: Rouse\_, Smike
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Добавление и удаление общих сетевых ресурсов
============================================

    {*******************************************************}
    {                                                       }
    {       Добавление и удаление общих сетевых ресурсов    }
    {                                                       }
    { Copyright (c)                                         }
    {    1998-2002 Rouse_                                   }
    {              (базовый код, взят из примера NetMon)    }
    {    2006 Smike                                         }
    {              (- доработка для возможности создания    }
    {                 ресурсов, открытых только для чтения  }
    {                 под NT/2000/XP/2003,                  }
    {               - небольшой рефакторинг ;) )            }
    {                                                       }
    {*******************************************************}
     
    unit Shares;
     
    interface
     
    uses
      Windows, SysUtils, AclApi;
     
    function ShareDirectory(const Directory: string): DWORD;
    function UnShareDirectory(const Directory: string): DWORD;
     
    implementation
     
    const
      STYPE_DISKTREE = 0;
     
    function ShareDirectoryNT(const Directory, ShareName: string): DWORD;
    type
      TShareInfo502 = packed record
        shi502_netname : PWChar;
        shi502_type: DWORD;
        shi502_remark :PWChar;
        shi502_permissions: DWORD;
        shi502_max_uses : DWORD;
        shi502_current_uses : DWORD;
        shi502_path : PWChar;
        shi502_passwd : PWChar;
        shi502_reserved: DWORD;
        shi502_security_descriptor: PSECURITY_DESCRIPTOR;
      end;
    const
      ACL_REVISION = 2;
      SECURITY_WORLD_SID_AUTHORITY: TSidIdentifierAuthority = (Value: (0, 0, 0, 0, 0, 1));
      SECURITY_WORLD_RID = ($00000000);
      SECURITY_NT_AUTHORITY: TSidIdentifierAuthority = (Value: (0, 0, 0, 0, 0, 5));
      SECURITY_BUILTIN_DOMAIN_RID = ($00000020);
      DOMAIN_ALIAS_RID_ADMINS = ($00000220);          
    var
      NetShareAddNT: function(servername: PWideChar;
                              level: DWORD;
                              buf: Pointer;
                              parm_err: LPDWORD): DWORD; stdcall;
      ShareNT : TShareInfo502;
      FLibHandle: THandle;
      TmpDirNT, TmpNameNT: PWChar;
      TmpLength: Integer;
      pSd: PSECURITY_DESCRIPTOR;
      pDacl: PACL;
      EveryoneSid, AdminSid: Pointer;  
    begin
      Result := DWORD(-1);
      FLibHandle := LoadLibrary('NETAPI32.DLL');
      if FLibHandle = 0 then Exit;
      try
        NetShareAddNT := GetProcAddress(FLibHandle,'NetShareAdd');
        if not Assigned(NetShareAddNT) then Exit;
     
        TmpLength := SizeOf(WideChar) * 256; //Определяем необходимый размер
     
        GetMem(TmpNameNT, TmpLength); //Конвертируем в PWChar
        StringToWideChar(ShareName, TmpNameNT, TmpLength);
        ShareNT.shi502_netname := TmpNameNT; //Имя
     
        ShareNT.shi502_type := STYPE_DISKTREE; //Тип ресурса
        ShareNT.shi502_remark := ''; //Комментарий
        // В NT, 2000, XP, 2003 разрешения на уровне расшаренной папки не поддерживается
        // Для этого задаем ниже атрибуты доступа на уровне групп
        ShareNT.shi502_permissions := 0;
        ShareNT.shi502_max_uses := DWORD(-1); //Кол-во максим. подключ.
        ShareNT.shi502_current_uses := 0; //Кол-во тек подкл.
     
        GetMem(TmpDirNT, TmpLength);
        StringToWideChar(Directory, TmpDirNT, TmpLength);
        ShareNT.shi502_path := TmpDirNT; //Путь к ресурсу
     
        ShareNT.shi502_passwd := ''; //Пароль
     
        ShareNT.shi502_reserved := 0;
     
        // Здесь начинается самое интересное - задаем разрешения :)
        GetMem(pDacl, 256);
        InitializeAcl(pDacl^, 256, ACL_REVISION);
        EveryoneSid := nil;
        AdminSid := nil;
        AllocateAndInitializeSid(SECURITY_WORLD_SID_AUTHORITY, 1, SECURITY_WORLD_RID, 0, 0, 0, 0, 0, 0, 0, EveryoneSid);
        AllocateAndInitializeSid(SECURITY_NT_AUTHORITY, 2, SECURITY_BUILTIN_DOMAIN_RID, DOMAIN_ALIAS_RID_ADMINS, 0, 0, 0, 0, 0, 0, AdminSid);
        AddAccessAllowedAce(pDacl^, ACL_REVISION, GENERIC_ALL, AdminSid);
        AddAccessAllowedAce(pDacl^, ACL_REVISION, (GENERIC_READ or GENERIC_EXECUTE or READ_CONTROL or STANDARD_RIGHTS_READ), EveryoneSid);
        GetMem(pSd, SECURITY_DESCRIPTOR_MIN_LENGTH);
        InitializeSecurityDescriptor(pSd, SECURITY_DESCRIPTOR_REVISION);
        SetSecurityDescriptorDacl(pSd, TRUE, pDacl, FALSE);
        ShareNT.shi502_security_descriptor := pSd;
     
        Result := NetShareAddNT(nil, 502, @ShareNT, nil); //Добавляем ресурс
     
        if Assigned(EveryoneSid) then
          FreeSid(EveryoneSid);
     
        if Assigned(AdminSid) then
          FreeSid(AdminSid);
     
        //освобождаем память
        FreeMem(pDacl);
        FreeMem(pSd);
        FreeMem(TmpNameNT);
        FreeMem(TmpDirNT);
      finally
        FreeLibrary(FLibHandle);
      end;
    end;
     
    function ShareDirectory9x(const Directory, ShareName: string): DWORD;
    type
      TShareInfo50 = packed record
        shi50_netname : array [0..12] of Char;
        shi50_type : Byte;
        shi50_flags : Word;
        shi50_remark : PChar;
        shi50_path : PChar;
        shi50_rw_password : array [0..8] of Char;
        shi50_ro_password : array [0..8] of Char;
      end;
    const
      SHI50F_RDONLY  = $1;
    var
      NetShareAdd: function(pszServer: PAnsiChar;
                            sLevel: Cardinal;
                            pbBuffer: PAnsiChar;
                            cbBuffer: Word):DWORD; stdcall;
      Share9x : TShareInfo50;
      FLibHandle : THandle;  
    begin
      Result := DWORD(-1);
      FLibHandle := LoadLibrary('SVRAPI.DLL');
      if FLibHandle = 0 then Exit;
      try
        NetShareAdd := GetProcAddress(FLibHandle,'NetShareAdd');
        if not Assigned(NetShareAdd) then Exit;
     
        FillChar(Share9x.shi50_netname, SizeOf(Share9x.shi50_netname), #0);
        Move(ShareName[1], Share9x.shi50_netname[0], Length(ShareName)); //Имя
        Share9x.shi50_type := STYPE_DISKTREE; //Тип ресурса
        Share9x.shi50_flags := SHI50F_RDONLY; //Доступ
        FillChar(Share9x.shi50_remark,
          SizeOf(Share9x.shi50_remark), #0); //Комментарий
        FillChar(Share9x.shi50_path,
          SizeOf(Share9x.shi50_path), #0);
        Share9x.shi50_path := PAnsiChar(Directory); //Путь к ресурсу
        FillChar(Share9x.shi50_rw_password,
          SizeOf(Share9x.shi50_rw_password), #0); //Пароль полного доступа
        FillChar(Share9x.shi50_ro_password,
          SizeOf(Share9x.shi50_ro_password), #0); //Пароль для чтения
        Result := NetShareAdd(nil, 50, @Share9x, SizeOf(Share9x));
      finally
        FreeLibrary(FLibHandle);
      end;
    end;
     
    function ShareDirectory(const Directory: string): DWORD;
    var
      ShareDir, ShareName: string;
    begin
      ShareDir := ExcludeTrailingPathDelimiter(Directory);
      ShareName := ExtractFileName(ShareDir);
     
      if Win32Platform = VER_PLATFORM_WIN32_NT then
        Result := ShareDirectoryNT(ShareDir, ShareName)
      else
        Result := ShareDirectory9x(ShareDir, ShareName);
    end;
     
    function UnShareDirectoryNT(const ShareName: string): DWORD;
    var
      FLibHandle : THandle;
      NameNT: PWChar;
      NetShareDelNT: function(servername: PWideChar;
                              netname: PWideChar;
                              reserved: DWORD): LongInt; stdcall;
      Size: Integer;
    begin
      Result := DWORD(-1);
      FLibHandle := LoadLibrary('NETAPI32.DLL');
      if FLibHandle = 0 then Exit;
      try
        NetShareDelNT := GetProcAddress(FLibHandle, 'NetShareDel');
        if not Assigned(NetShareDelNT) then //Проверка
        begin
          FreeLibrary(FLibHandle);
          Exit;
        end;
        Size := SizeOf(WideChar) * 256;
        GetMem(NameNT, Size);  //Выделяем память под переменную
        StringToWideChar(ShareName, NameNT, Size); //Преобразуем в PWideChar
        NetShareDelNT(nil, NameNT, 0);   //Удаляем ресурс
        FreeMem(NameNT);  //Освобождаем память
      finally
        FreeLibrary(FLibHandle);
      end;
    end;
     
    function UnShareDirectory9x(const ShareName: string): DWORD;
    var
      FLibHandle: THandle;
      Name9x: array [0..12] of Char;
      NetShareDel: function(pszServer,
                            pszNetName: PChar;
                            usReserved: Word): DWORD; stdcall;
    begin
      Result := DWORD(-1);
      FLibHandle := LoadLibrary('SVRAPI.DLL');
      if FLibHandle = 0 then Exit;
      try
        NetShareDel := GetProcAddress(FLibHandle,'NetShareDel');
        if not Assigned(NetShareDel) then Exit;
        FillChar(Name9x, SizeOf(Name9x), #0); //Очищаем массив
        Move(ShareName[1], Name9x[0], Length(ShareName)); //Заполняем массив
        Result := NetShareDel(nil, @Name9x, 0); //Удаляем ресурс
      finally
        FreeLibrary(FLibHandle);
      end;
    end;
     
    function UnShareDirectory(const Directory: string): DWORD;
    var
      ShareName: string;
    begin
      ShareName := ExtractFileName(ExcludeTrailingPathDelimiter(Directory));
     
      if Win32Platform = VER_PLATFORM_WIN32_NT then       //Код для NT
        Result := UnShareDirectoryNT(ShareName)
      else                                                //Код для 9х-Ме
        Result := UnShareDirectory9x(ShareName);
    end;
     
    end.


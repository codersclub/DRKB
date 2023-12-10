---
Title: Права доступа NTFS
Author: Александр (Rouse\_) Багель
Date: 01.01.2007
---


Права доступа NTFS
==================

::: {.date}
01.01.2007
:::

    uses ..., Aclapi, AccCtrl;
     
     
    function SetFileAccessRights(AFile, AUser: String; AMask: DWORD): Boolean;
    var
      psd             : PSECURITY_DESCRIPTOR;
      dwSize, dwError : DWord;
      bDaclPresent    : Bool;
      bDaclDefaulted  : Bool;
      OldAcl          : PACL;
      NewAcl          : PACL;
      sd              : SECURITY_DESCRIPTOR;
      ea              : EXPLICIT_ACCESS;
    begin
      Result := False;
      if WIN32Platform <> VER_PLATFORM_WIN32_NT then Exit;
      psd := nil;
      NewAcl := nil;
      bDaclDefaulted := True;
      if not GetFileSecurity(PChar(AFile), DACL_SECURITY_INFORMATION, Pointer(1),
               0, dwSize) and (GetLastError = ERROR_INSUFFICIENT_BUFFER) 
      then 
      try
        psd := HeapAlloc(GetProcessHeap, 8, dwSize);
        if psd <> nil then 
        begin
          BuildExplicitAccessWithName(@ea, PChar(AUser), AMask,
            SET_ACCESS, SUB_CONTAINERS_AND_OBJECTS_INHERIT{NO_INHERITANCE});
          Result := GetFileSecurity(PChar(AFile), DACL_SECURITY_INFORMATION, psd, dwSize, dwSize) and
            GetSecurityDescriptorDacl(psd, bDaclPresent, OldAcl, bDaclDefaulted) and
            (SetEntriesInAcl(1, @ea, OldAcl, NewAcl) = ERROR_SUCCESS) and
            InitializeSecurityDescriptor(@sd, SECURITY_DESCRIPTOR_REVISION) and
            SetSecurityDescriptorDacl(@sd, True, NewAcl, False) and
            SetFileSecurity(PChar(AFile), DACL_SECURITY_INFORMATION, @sd);
        end;
      finally  
        if NewAcl <> nil then LocalFree(HLocal(NewAcl));
        if psd <> nil then HeapFree(GetProcessHeap, 0, psd);    
      end;
    end;




Параметры: путь к объекту, имя пользователя, маска доступа, ее
расчитываешь вот так:
http://msdn.microsoft.com/library/default\....access\_mask.asp


 

Автор: Александр (Rouse\_) Багель

Взято из <https://forum.sources.ru>

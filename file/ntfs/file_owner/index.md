---
Title: Как прочитать владельца файла?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как прочитать владельца файла?
==============================

Когда вы создаете файл или каталог, вы становитесь его владельцем.
С помощью GetFileOwner вы получаете владельца файла.

    // When you create a file or directory, you become the owner of it. 
    // With GetFileOwner you get the owner of a file. 
     
    function GetFileOwner(FileName: string; 
      var Domain, Username: string): Boolean; 
    var 
      SecDescr: PSecurityDescriptor; 
      SizeNeeded, SizeNeeded2: DWORD; 
      OwnerSID: PSID; 
      OwnerDefault: BOOL; 
      OwnerName, DomainName: PChar; 
      OwnerType: SID_NAME_USE; 
    begin 
      GetFileOwner := False; 
      GetMem(SecDescr, 1024); 
      GetMem(OwnerSID, SizeOf(PSID)); 
      GetMem(OwnerName, 1024); 
      GetMem(DomainName, 1024); 
      try 
        if not GetFileSecurity(PChar(FileName), 
          OWNER_SECURITY_INFORMATION, 
          SecDescr, 1024, SizeNeeded) then 
          Exit; 
        if not GetSecurityDescriptorOwner(SecDescr, 
          OwnerSID, OwnerDefault) then 
          Exit; 
        SizeNeeded  := 1024; 
        SizeNeeded2 := 1024; 
        if not LookupAccountSID(nil, OwnerSID, OwnerName, 
          SizeNeeded, DomainName, SizeNeeded2, OwnerType) then 
          Exit; 
        Domain   := DomainName; 
        Username := OwnerName; 
      finally 
        FreeMem(SecDescr); 
        FreeMem(OwnerName); 
        FreeMem(DomainName); 
      end; 
      GetFileOwner := True; 
    end; 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    var 
      Domain, Username: string; 
    begin 
      GetFileOwner('YourFile.xyz', domain, username); 
      ShowMessage(username + '@' + domain); 
    end; 
     
    // Note: Only works unter NT.


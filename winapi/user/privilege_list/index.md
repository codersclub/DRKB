---
Title: Как вывести список привилегий?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---

Как вывести список привилегий?
==============================

    procedure TForm1.Button1Click(Sender: TObject);
    const
      TokenSize = 800; //  (SizeOf(Pointer)=4 *200)
    var
      hToken: THandle;
      pTokenInfo: PTOKENPRIVILEGES;
      ReturnLen: Cardinal;
      i: Integer;
      PrivName: PChar;
      DisplayName: PChar;
      NameSize: Cardinal;
      DisplSize: Cardinal;
      LangId: Cardinal;
    begin
      GetMem(pTokenInfo, TokenSize);
      if not OpenProcessToken(GetCurrentProcess(),
                              TOKEN_ADJUST_PRIVILEGES or TOKEN_QUERY,
                              hToken) then
        ShowMessage('OpenProcessToken error');
      if not GetTokenInformation(hToken, TokenPrivileges, pTokenInfo,
                                 TokenSize, ReturnLen) then
        ShowMessage('GetTokenInformation error');
      GetMem(PrivName, 255);
      GetMem(DisplayName, 255);
      for i := 0 to pTokenInfo.PrivilegeCount - 1 do
      begin
        DisplSize := 255;
        NameSize  := 255;
        LookupPrivilegeName(nil, pTokenInfo.Privileges[i].Luid, PrivName, Namesize);
        LookupPrivilegeDisplayName(nil, PrivName, DisplayName, DisplSize, LangId);
        ListBox1.Items.Add(PrivName +^I + DisplayName);
      end;
      FreeMem(PrivName);
      FreeMem(DisplayName);
      FreeMem(pTokenInfo);
    end;


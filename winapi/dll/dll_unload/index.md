---
Title: Как выгрузить DLL из памяти?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как выгрузить DLL из памяти?
============================

    function KillDll(aDllName: string): Boolean;
    var
      hDLL: THandle;
      aName: array[0..10] of char;
      FoundDLL: Boolean;
    begin
      StrPCopy(aName, aDllName);
      FoundDLL := False;
      repeat
        hDLL := GetModuleHandle(aName);
        if hDLL = 0 then
          Break;
        FoundDLL := True;
        FreeLibrary(hDLL);
      until False;
      if FoundDLL then
        MessageDlg('Success!', mtInformation, [mbOK], 0)
      else
        MessageDlg('DLL not found!', mtInformation, [mbOK], 0);
    end;


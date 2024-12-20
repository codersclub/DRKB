---
Title: Hook-функции в собственном приложении
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Hook-функции в собственном приложении
=====================================

    type
      TSaveRedir = packed record
        Addr: Pointer;
        Bytes: array[0..4] of Byte;
      end;
      PSaveRedir = ^TSaveRedir;
     
    procedure RedirectCall(FromAddr, ToAddr: Pointer; SaveRedir: PSaveRedir);
    var
      OldProtect: Cardinal;
      NewCode: packed record
        JMP: Byte;
        Distance: Integer;
      end;
    begin
      if not VirtualProtect(FromAddr, 5, PAGE_EXECUTE_READWRITE, OldProtect) then
        RaiseLastWin32Error;
      if Assigned(SaveRedir) then
      begin
        SaveRedir^.Addr := FromAddr;
        Move(FromAddr^, SaveRedir^.Bytes, 5);
      end;
      NewCode.JMP := $E9;
      NewCode.Distance := PChar(ToAddr) - PChar(FromAddr) - 5;
      Move(NewCode, FromAddr^, 5);
      if not VirtualProtect(FromAddr, 5, OldProtect, OldProtect) then
        RaiseLastWin32Error;
    end;
     
    procedure UndoRedirectCall(const SaveRedir: TSaveRedir);
    var
      OldProtect: Cardinal;
    begin
      if not VirtualProtect(SaveRedir.Addr, 5, PAGE_EXECUTE_READWRITE, OldProtect) then
        RaiseLastWin32Error;
      Move(SaveRedir.Bytes, SaveRedir.Addr^, 5);
      if not VirtualProtect(SaveRedir.Addr, 5, OldProtect, OldProtect) then
        RaiseLastWin32Error;
    end;
     
     
    // Example: Replace Application.MessageBox with your own.
     
    function MyNewMessageBox(Self: TApplication; const Text, Caption: PChar;
      Flags: Longint): Integer;
    begin
      ShowMessage('New Messagebox');
      //....
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      Application.MessageBox('You`ll never see this Text '
        + 'Diesen Text wirst du nie sehen', '...', MB_OK);
    end;
     
    var
      S: TSaveRedir;
     
    initialization
      RedirectCall(@TApplication.MessageBox, @MyNewMessageBox, @S);
     
    finalization
      UndoRedirectCall(S);


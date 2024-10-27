---
Title: Как получить закэшированные пароли в Win9x?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---

Как получить закэшированные пароли в Win9x?
===========================================

    program getpass; 
    ........ 
    type 
    ... 
    ListBox: TListBox; 
    procedure getpasswords; 
    ....... 
    end; 
     
    const Count: Integer = 0; 
     
    function WNetEnumCachedPasswords(lp: lpStr; w: Word; b: Byte; PC: PChar; dw: DWord): Word; stdcall; 
     
    implementation 
     
    {$R *.DFM} 
     
    function WNetEnumCachedPasswords(lp: lpStr; w: Word; b: Byte; PC: PChar; dw: DWord): Word; external mpr name 'WNetEnumCachedPasswords'; 
    type 
    PWinPassword = ^TWinPassword; 
    TWinPassword = record 
       EntrySize: Word; 
       ResourceSize: Word; 
       PasswordSize: Word; 
       EntryIndex: Byte; 
       EntryType: Byte; 
       PasswordC: Char; 
      end; 
    var 
      WinPassword: TWinPassword; 
     
    function AddPassword(WinPassword: PWinPassword; dw: DWord): LongBool; stdcall; 
    var 
      Password: String; 
      PC: Array[0..$FF] of Char; 
    begin 
      inc(Count); 
     
      Move(WinPassword.PasswordC, PC, WinPassword.ResourceSize); 
      PC[WinPassword.ResourceSize] := #0; 
      CharToOem(PC, PC); 
      Password := StrPas(PC); 
     
      Move(WinPassword.PasswordC, PC, WinPassword.PasswordSize + WinPassword.ResourceSize); 
      Move(PC[WinPassword.ResourceSize], PC, WinPassword.PasswordSize); 
      PC[WinPassword.PasswordSize] := #0; 
      CharToOem(PC, PC); 
      Password := Password + ': ' + StrPas(PC); 
     
      Form1.ListBox.Items.Add(Password); 
      Result := True; 
    end; 
     
    procedure tform1.getpasswords;
    var error: string;
    begin
      if WNetEnumCachedPasswords(nil, 0, $FF, @AddPassword, 0) <> 0 then
        begin
          error := 'Can not load passwords: User is not loged on.';
        end
      else if Count = 0 then
        error := 'No passwords found...'
    end;


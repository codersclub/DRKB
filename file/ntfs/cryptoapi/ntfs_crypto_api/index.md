---
Title: Как шифровать файлы при помощи Windows NTFS API?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Как шифровать файлы при помощи Windows NTFS API?
================================================

Этот совет работает с Windows 2000 (NTFS 5) и более поздних версий.
     
Эти две функции определены в windows.pas, но они определены неправильно.
В этом случае понадобится наше собственное определение.


    {
    This tip works with Windows 2000 (NTFS 5) and later
     
    These 2 functions are defined in windows.pas, but they're defined wrong. In this
    case our own definition.
    }
     
    function EncryptFile(lpFilename: PChar): BOOL; stdcall;
      external advapi32 name 'EncryptFileA';
     
    function DecryptFile(lpFilename: PChar; dwReserved: DWORD): BOOL; stdcall;
      external advapi32 name 'DecryptFileA';
     
    {....}
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      if not EncryptFile('c:\temp') then
        ShowMessage('Cannot encrypt directory.');
    end;
     
    procedure TForm1.Button2Click(Sender: TObject);
    begin
      if not DecryptFile('c:\temp', 0) then
        ShowMessage('Cannot decrypt directory.');
    end;


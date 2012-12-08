---
Title: Функция набора номера модемом
Date: 01.01.2007
---


Функция набора номера модемом
=============================

::: {.date}
01.01.2007
:::

    var
    hCommFile : THandle;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
    PhoneNumber : string;
    CommPort : string;
    NumberWritten : LongInt;
    begin
    PhoneNumber := 'ATDT 1-555-555-1212' + #13 + #10;
    CommPort := 'COM2';
    {Open the comm port}
    hCommFile := CreateFile(PChar(CommPort),
    GENERIC_WRITE,
    0,
    nil,
    OPEN_EXISTING,
    FILE_ATTRIBUTE_NORMAL,
    0);
    if hCommFile=INVALID_HANDLE_VALUE then
    begin
    ShowMessage('Unable to open '+ CommPort);
    exit;
    end;
    NumberWritten:=0;
    if WriteFile(hCommFile,
    PChar(PhoneNumber)^,
    Length(PhoneNumber),
    NumberWritten,
    nil) = false then 
    begin
         ShowMessage('Unable to write to ' + CommPort);
        end;
    end;
     
    procedure TForm1.Button2Click(Sender: TObject);
    begin
    {Close the port}
    CloseHandle(hCommFile);
    end;

Взято с сайта <https://blackman.wp-club.net/>

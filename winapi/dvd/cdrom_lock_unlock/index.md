---
Title: Блокировка / Разблокировка CD-ROM
Date: 01.01.2007
---


Блокировка / Разблокировка CD-ROM
=================================

Author: Baa

Source: Vingrad.ru <https://forum.vingrad.ru>

Вы уж простите, что на сях... сподручней было:

Исходный код 

    // ©Drkb v.3(2007): www.drkb.ru
     
    //заблокировать
    void CMFcDlg::OnBnClickedButton1()
    {
    HANDLE hDevice = CreateFile ("\\\\.\\E:", 
     GENERIC_READ,
     FILE_SHARE_READ | FILE_SHARE_WRITE,
     NULL,
     OPEN_EXISTING,
     NULL,
     NULL);
    DWORD dwBytesReturned = 0;
    PREVENT_MEDIA_REMOVAL pmr = {TRUE};
    if(!DeviceIoControl (hDevice, IOCTL_STORAGE_MEDIA_REMOVAL, &pmr, sizeof(pmr), NULL, 0, &dwBytesReturned, NULL)) AfxMessageBox ("Door can\'t be locked");
    CloseHandle (hDevice);
    }
     
    //разблокировать
    void CMFcDlg::OnBnClickedButton2()
    {
    HANDLE hDevice = CreateFile ("\\\\.\\E:", 
     GENERIC_READ,
     FILE_SHARE_READ | FILE_SHARE_WRITE,
     NULL,
     OPEN_EXISTING,
     NULL,
     NULL);
    DWORD dwBytesReturned = 0;
    PREVENT_MEDIA_REMOVAL pmr = {FALSE};
    if(!DeviceIoControl (hDevice, IOCTL_STORAGE_MEDIA_REMOVAL, &pmr, sizeof(pmr), NULL, 0, &dwBytesReturned, NULL)) AfxMessageBox ("Door can\'t be unlocked");
    CloseHandle (hDevice);
     
    }

------------------------------------------------------------------------

Вариант 2:

Author: Krid

Source: <https://forum.sources.ru>

    const
     
     IOCTL_STORAGE_MEDIA_REMOVAL = $02D4804;
     
    type
     PREVENT_MEDIA_REMOVAL=record
       PreventMediaRemoval:BOOL;
     end;
     
    //  fLock=true  - блокировать
    //  fLock=false - разблокировать
    function LockCD(cdLetter:char; fLock:boolean):boolean;
    var
     hDevice : THandle;
     dwBytesReturned : DWORD;
     pmr : PREVENT_MEDIA_REMOVAL;
    begin
     result:=false;
     hDevice := CreateFile(pchar('\\.\'+cdLetter+':'),GENERIC_READ, 
                             FILE_SHARE_READ or FILE_SHARE_WRITE,
                             nil,OPEN_EXISTING, 0,0);
     if (hDevice=DWORD(-1)) then exit;
     
     try
      pmr.PreventMediaRemoval:=fLock;
      if (not DeviceIoControl(hDevice, IOCTL_STORAGE_MEDIA_REMOVAL, @pmr, 
                              sizeof(pmr),nil, 0,
                              dwBytesReturned, nil)) then exit else result:=true;
     finally
       CloseHandle (hDevice);
     end;
    end;
     
    // блокируем
    procedure TForm1.Button1Click(Sender: TObject);
    begin
     if not LockCD('E',true) then 
       MessageBox(Handle,'Can not lock CD','Error',MB_ICONERROR) 
     else
       MessageBox(Handle,'CD is locked','Info',MB_ICONINFORMATION);
    end;
     
    // разблокируем
    procedure TForm1.Button2Click(Sender: TObject);
    begin
     if not LockCD('E',false) then 
       MessageBox(Handle,'Can not unlock CD','Error',MB_ICONERROR) 
     else
       MessageBox(Handle,'CD is unlocked','Info',MB_ICONINFORMATION)
    end;


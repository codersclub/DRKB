---
Title: Как заблокировать доступ к дисководу?
Author: p0s0l
Date: 01.01.2007
---


Как заблокировать доступ к дисководу?
=====================================

::: {.date}
01.01.2007
:::

    const

     
     FILE_DEVICE_FILE_SYSTEM: Integer = $00000009;
     METHOD_BUFFERED: Integer = $00000000;
     FILE_ANY_ACCESS: Integer = $00000000;
     
    function CTL_CODE(DeviceType, FunctionNo, Method, Access: Integer): Integer;
    begin
     Result := (DeviceType shl 16) or (Access shl 14) or (FunctionNo shl 2) or (Method);
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
     LHandle: THandle;
     BytesReturned: Cardinal;
     MsgBuf: PChar;
     FSCTL_LOCK_VOLUME: Integer;
    begin
     FSCTL_LOCK_VOLUME := CTL_CODE(FILE_DEVICE_FILE_SYSTEM, 6,
                                                      METHOD_BUFFERED, FILE_ANY_ACCESS);
     LHandle := CreateFile('\\.\A:', GENERIC_READ or GENERIC_WRITE, FILE_SHARE_READ
                          or FILE_SHARE_WRITE, nil, OPEN_EXISTING, FILE_ATTRIBUTE_NORMAL or
                          FILE_FLAG_DELETE_ON_CLOSE, 0);
     if LHandle <> 0 then
     begin
       if DeviceIOControl(LHandle, FSCTL_LOCK_VOLUME, nil, 0, nil, 0, BytesReturned, nil) then
         ShowMessage('Дисковод заблокирован. Нажмите ОК для разблокирования.')
       else
       begin
         if FormatMessage(FORMAT_MESSAGE_ALLOCATE_BUFFER or
              FORMAT_MESSAGE_FROM_SYSTEM, nil, GetLastError(), 0, @MsgBuf, 0, nil) > 0 then
         begin
           ShowMessage('Ошибка DeviceIOControl: ' + MsgBuf);
           LocalFree(Cardinal(MsgBuf));
         end
         else
           ShowMessage('Ошибка при вызове DeviceIOControl!');
       end;
       CloseHandle(LHandle);
     end
     else
       ShowMessage('Ошибка при вызове CreateFile!');
    end;

Автор: p0s0l

Взято с Vingrad.ru <https://forum.vingrad.ru>

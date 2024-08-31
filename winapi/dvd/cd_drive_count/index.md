---
Title: Как узнать количество CD в системе?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Как узнать количество CD в системе?
===================================

    function GetNumberOfCDDrives: Byte;
     var
       drivemap, mask: DWORD;
       i: integer;
       root: string;
     begin
       Result := 0;
       root := 'A:';
       drivemap := GetLogicalDrives;
       mask := 1;
       for i := 1 to 32 do
       begin
         if (mask and drivemap) <> 0 then
           if GetDriveType(PChar(root)) = DRIVE_CDROM then
           begin
             Inc(Result);
           end;
         mask := mask shl 1;
         Inc(root[1]);
       end;
     end;
     
     procedure TForm1.Button1Click(Sender: TObject);
     begin
       Label1.Caption := IntToStr(GetNumCDDrives);
     end;


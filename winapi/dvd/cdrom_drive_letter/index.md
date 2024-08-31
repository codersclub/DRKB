---
Title: Как узнать букву CD-ROM?
Date: 01.01.2007
---


Как узнать букву CD-ROM?
========================

Вариант 1:

Source: <https://blackman.wp-club.net/>

    var DriveType: UInt;
     
    DriveType := GetDriveType(PChar('F:\'));
    if DriveType = DRIVE_CDROM then ShowMessage('Сидюк');


------------------------------------------------------------------------

Вариант 2:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    function GetFirstCDROM: string;
    {возвращает букву 1-го привода CD-ROM или пустую строку}
    var
      w: dword;
      Root: string;
      i: integer;
    begin
      w := GetLogicalDrives;
      Root := '#:\';
      for i := 0 to 25 do
      begin
        Root[1] := Char(Ord('A') + i);
        if (W and (1 shl i)) > 0 then
          if GetDriveType(Pchar(Root)) = DRIVE_CDROM then
          begin
            Result := Root[1];
            exit;
          end;
      end;
      Result := '';
    end;



------------------------------------------------------------------------

Вариант 3:

Source: <https://www.swissdelphicenter.ch>

    function GetFirstCDROMDrive: char;
     var
       drivemap, mask: DWORD;
       i: integer;
       root: string;
     begin
       Result := #0;
       root := 'A:\';
       drivemap := GetLogicalDrives;
       mask := 1;
       for i := 1 to 32 do
       begin
         if (mask and drivemap) <> 0 then
           if GetDriveType(PChar(root)) = DRIVE_CDROM then
           begin
             Result := root[1];
             Break;
           end;
         mask := mask shl 1;
         Inc(root[1]);
       end;
     end;
     
     procedure TForm1.Button2Click(Sender: TObject);
     begin
       ShowMessage(GetFirstCDROMDrive);
     end;


------------------------------------------------------------------------

Вариант 4:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    procedure TForm1.Button1Click(Sender: TObject);
    var
      w: dword;
      Root: string;
      i: integer;
    begin
      w := GetLogicalDrives;
      Root := '#:\';
      for i := 0 to 25 do
      begin
        Root[1] := Char(Ord('A') + i);
        if (W and (1 shl i)) > 0 then
          if GetDriveType(Pchar(Root)) = DRIVE_CDROM then
            Form1.Label1.Caption := Root;
      end;
    end;



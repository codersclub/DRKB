---
Title: Определение типов логических дисков
Author: Александр (Rouse\_) Багель
Date: 01.01.2007
---


Определение типов логических дисков
===================================

::: {.date}
01.01.2007
:::

    unit Unit1;

     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms,
      Dialogs, StdCtrls;
     
    type
      TForm1 = class(TForm)
        Memo1: TMemo;
        Button1: TButton;
        procedure Button1Click(Sender: TObject);
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.dfm}
     
    procedure TForm1.Button1Click(Sender: TObject);
    const
      NameSize = 4;
      VolumeCount = 26;
      TotalSize = NameSize * VolumeCount;
      Report = 'Volume: %s %s';
    var
      Buff, Volume: String;
      lpQuery: array [0..MAXCHAR - 1] of Char;
      I, Count: Integer;
    begin
      SetLength(Buff, TotalSize);
      Count := GetLogicalDriveStrings(TotalSize, @Buff[1]) div NameSize;
      if Count = 0 then
        Memo1.Lines.Add(SysErrorMessage(GetLastError))
      else
        for I := 0 to Count - 1 do
        begin
          Volume := PChar(@Buff[(I * NameSize) + 1]);
          case GetDriveType(PChar(Volume)) of
            DRIVE_UNKNOWN: Memo1.Lines.Add(Format(Report, [Volume,
              'The drive type cannot be determined.']));
            DRIVE_NO_ROOT_DIR: Memo1.Lines.Add(Format(Report, [Volume,
              'The root path is invalid. For example, no volume is mounted at the path.']));
            DRIVE_REMOVABLE:
            begin
              Volume[3] := #0;
              QueryDosDevice(PChar(Volume), @lpQuery[0], MAXCHAR);
              Volume[3] := '\';
              if String(lpQuery) = '\Device\Floppy0' then
                Memo1.Lines.Add(Format(Report, [Volume, 'The drive is a Floppy disk A:.']))
              else
                if String(lpQuery) = '\Device\Floppy1' then
                  Memo1.Lines.Add(Format(Report, [Volume, 'The drive is a Floppy disk B:.']))
                else
                  Memo1.Lines.Add(Format(Report, [Volume, 'The drive is a Flash Drive.']));
            end;
            DRIVE_FIXED:
            begin
              Volume[3] := #0;
              QueryDosDevice(PChar(Volume), @lpQuery[0], MAXCHAR);
              Volume[3] := '\';
              if Copy(String(lpQuery), 1, 22)  = '\Device\HarddiskVolume' then
                Memo1.Lines.Add(Format(Report, [Volume,
                  'The disk cannot be removed from the drive.']))
              else
                Memo1.Lines.Add(Format(Report, [Volume,
                  'The drive is a SUBST disk on path: "' +
                    Copy(String(lpQuery), 5, Length(String(lpQuery))) + '"']));
            end;
            DRIVE_REMOTE: Memo1.Lines.Add(Format(Report, [Volume,
              'The drive is a remote (network) drive.']));
            DRIVE_CDROM: Memo1.Lines.Add(Format(Report, [Volume,
              'The drive is a CD-ROM drive.']));
            DRIVE_RAMDISK: Memo1.Lines.Add(Format(Report, [Volume,
              'The drive is a RAM disk.']));
          else
            Memo1.Lines.Add(Format(Report, [Volume, 'Xpen znaet chto :)']));
          end;
        end;
    end;
     
    end.

Автор: Александр (Rouse\_) Багель

Взято из <https://forum.sources.ru>

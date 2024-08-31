---
Title: Как различать звуковые CD
Author: Даниил Карапетян (delphi4all@narod.ru)
Date: 01.01.2007
---


Как различать звуковые CD
=========================

Лазерный диск имеет свой идентификатор. Если сохранить, какому диску
соответствует какой идентификатор, то можно реализовать определение
диска.

В этой программе при нажатии на кнопку происходит проверка, есть ли
название этого диска в файле. Если есть, то в заголовок окна выводится
его название, если нет, то введенное пользователем название диска
сохраняется в файл.

    uses MMSystem, IniFiles;
     
    function GetCDid: string;
    var
      InfoParams: TMCI_Info_Parms;
      s: array [0..63] of char;
      OpenParams: TMCI_Open_Parms;
      CloseParams: TMCI_Generic_Parms;
    begin
      result := '';
      FillChar(InfoParams, sizeof(InfoParams), #0);
      InfoParams.lpstrReturn := @s[0];
      InfoParams.dwRetSize := 10;
      OpenParams.dwCallback := 0;
      OpenParams.lpstrDeviceType := 'CDAudio';
      if mciSendCommand(0, mci_Open, mci_Open_Type,
     
        Longint(addr(OpenParams))) <> 0 then Exit;
      if mciSendCommand(OpenParams.wDeviceID, MCI_INFO,
        MCI_INFO_MEDIA_IDENTITY, longint(@InfoParams)) = 0
      then result := s;
      mciSendCommand(OpenParams.wDeviceID, mci_Close, 0,
        Longint(addr(CloseParams)));
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      id: string;
      ini: TIniFile;
      name: string;
    begin
      id := GetCDid;
      if id = '' then begin
     
        Form1.Caption := 'No disk';
        Exit;
      end;
      ini := TIniFile.Create(ExtractFilePath(Application.ExeName) +
        'cd.ini');
      name := ini.ReadString('CD', id, '');
      if name = '' then begin
        name := 'CD name';
        if not InputQuery('CD name', 'Enter CD name:', name)
          then Exit;
        ini.WriteString('CD', id, name);
      end;
      Form1.Caption := name;
      ini.Destroy;
    end;

Автор справки: Алексей Денисов (aleksey@sch103.krasnoyarsk.su)

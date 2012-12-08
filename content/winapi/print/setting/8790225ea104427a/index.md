---
Title: Как прочитать / установить принтер по умолчанию?
Date: 01.01.2007
---

Как прочитать / установить принтер по умолчанию?
================================================

::: {.date}
01.01.2007
:::

    uses 
      Printers, Messages; 
     
    function GetDefaultPrinter: string; 
    var 
      ResStr: array[0..255] of Char; 
    begin 
      GetProfileString('Windows', 'device', '', ResStr, 255); 
      Result := StrPas(ResStr); 
    end; 
     
    procedure SetDefaultPrinter1(NewDefPrinter: string); 
    var 
      ResStr: array[0..255] of Char; 
    begin 
      StrPCopy(ResStr, NewdefPrinter); 
      WriteProfileString('windows', 'device', ResStr); 
      StrCopy(ResStr, 'windows'); 
      SendMessage(HWND_BROADCAST, WM_WININICHANGE, 0, Longint(@ResStr)); 
    end; 
     
    procedure SetDefaultPrinter2(PrinterName: string); 
    var 
      I: Integer; 
      Device: PChar; 
      Driver: PChar; 
      Port: PChar; 
      HdeviceMode: THandle; 
      aPrinter: TPrinter; 
    begin 
      Printer.PrinterIndex := -1; 
      GetMem(Device, 255); 
      GetMem(Driver, 255); 
      GetMem(Port, 255); 
      aPrinter := TPrinter.Create; 
      try 
        for I := 0 to Printer.Printers.Count - 1 do 
        begin 
          if Printer.Printers = PrinterName then 
          begin 
            aprinter.PrinterIndex := i; 
            aPrinter.getprinter(device, driver, port, HdeviceMode); 
            StrCat(Device, ','); 
            StrCat(Device, Driver); 
            StrCat(Device, Port); 
            WriteProfileString('windows', 'device', Device); 
            StrCopy(Device, 'windows'); 
            SendMessage(HWND_BROADCAST, WM_WININICHANGE, 
              0, Longint(@Device)); 
          end; 
        end; 
      finally 
        aPrinter.Free; 
      end; 
      FreeMem(Device, 255); 
      FreeMem(Driver, 255); 
      FreeMem(Port, 255); 
    end; 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      label1.Caption := GetDefaultPrinter2; 
    end; 
     
    //Fill the combobox with all available printers 
    procedure TForm1.FormCreate(Sender: TObject); 
    begin 
      Combobox1.Items.Clear; 
      Combobox1.Items.AddStrings(Printer.Printers); 
    end; 
     
    //Set the selected printer in the combobox as default printer 
    procedure TForm1.Button2Click(Sender: TObject); 
    begin 
      SetDefaultPrinter(Combobox1.Text); 
    end;

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>

------------------------------------------------------------------------

    uses
      IniFiles;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      WinIni: TIniFile;
      WinIniFileName: array [0..MAX_PATH] of char;
      s: array [0..64] of char;
    begin
      GetWindowsDirectory(WinIniFileName, sizeof(WinIniFileName));
      StrCat(WinIniFileName, '\win.ini');
      WinIni := TIniFile.Create(WinIniFileName);
      try
        WinIni.WriteString('windows','device', 'HP LaserJet Series II,HPPCL,LPT1:');
      finally
        WinIni.Free;
      end;
      StrCopy(S, 'windows');
      SendMessage(HWND_BROADCAST, WM_WININICHANGE, 0, LongInt(@S));
    end;

Взято с <https://delphiworld.narod.ru>

------------------------------------------------------------------------

Примечание от Vit

Поместил предыдущие ответы на сей вопрос и даже не знаю, а надо ли было?
Изобретение велосипеда! В Дельфи есть предопределённый системный объект
Printer типа TPrinter, в нём уже есть готовые свойства и методы как для
чтения текущего принтера (и всех остальных принтеров тоже), так и для
изменнеия текущего принтера на другой. Хочу добавить что реализация
через API может несколько различаеться для разных версий Windows и
простой код по изменнеию текущего принтера вовсе не факт будет работать
стабильно на всех системах. Используйте объект Printer - это более
надёжно и просто.

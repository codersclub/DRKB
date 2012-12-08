---
Title: Как найти все форматы бумаги, поддерживаемые принтером?
Date: 01.01.2007
---

Как найти все форматы бумаги, поддерживаемые принтером?
=======================================================

::: {.date}
01.01.2007
:::

    uses 
      Printers, WinSpool; 
     
    procedure GetPapernames(sl: TStrings); 
    type 
      TPaperName      = array [0..63] of Char; 
      TPaperNameArray = array [1..High(Word) div SizeOf(TPaperName)] of TPaperName; 
      PPapernameArray = ^TPaperNameArray; 
    var 
      Device, Driver, Port: array [0..255] of Char; 
      hDevMode: THandle; 
      i, numPaperformats: Integer; 
      pPaperFormats: PPapernameArray; 
    begin 
      Printer.PrinterIndex := -1; // Standard printer 
      Printer.GetPrinter(Device, Driver, Port, hDevmode); 
      numPaperformats := WinSpool.DeviceCapabilities(Device, Port, DC_PAPERNAMES, nil, nil); 
      if numPaperformats  0 then  
      begin 
        GetMem(pPaperformats, numPaperformats * SizeOf(TPapername)); 
        try 
          WinSpool.DeviceCapabilities(Device, Port, DC_PAPERNAMES, 
            PChar(pPaperFormats), nil); 
          sl.Clear; 
          for i := 1 to numPaperformats do sl.Add(pPaperformats^[i]); 
        finally 
          FreeMem(pPaperformats); 
        end; 
      end; 
    end; 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      GetPapernames(memo1.Lines); 
    end; 

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>

------------------------------------------------------------------------

Вот пример, выводящий список форматов бумаги для принтера,
установленного по умолчанию:

    procedure TForm1.Button2Click(Sender: TObject);
    type
     
      TPaperName = array[0..63] of Char;
      TPaperNameArray = array[1..High(Cardinal) div Sizeof(TPaperName)] of
        TPaperName;
      PPapernameArray = ^TPaperNameArray;
    var
     
      Device, Driver, Port: array[0..255] of Char;
      hDevMode: THandle;
      i, numPaperformats: Integer;
      pPaperFormats: PPapernameArray;
    begin
     
      Printer.PrinterIndex := -1;
      Printer.GetPrinter(Device, Driver, Port, hDevmode);
      numPaperformats :=
        WinSpool.DeviceCapabilities(Device, Port, DC_PAPERNAMES, nil, nil);
      if numPaperformats > 0 then
        begin
          GetMem(pPaperformats, numPaperformats * Sizeof(TPapername));
          try
            WinSpool.DeviceCapabilities(Device, Port, DC_PAPERNAMES,
              Pchar(pPaperFormats), nil);
            memo1.clear;
            for i := 1 to numPaperformats do
              memo1.lines.add(pPaperformats^[i]);
          finally
            FreeMem(pPaperformats);
          end;
        end;
    end;

Взято из Советов по Delphi от [Валентина
Озерова](mailto:mailto:webmaster@webinspector.com)

Сборник Kuliba

---
Title: Установить размеры бумаги
Date: 01.01.2007
---

Установить размеры бумаги
=========================

::: {.date}
01.01.2007
:::

      var
         Device, Driver, Port: array[0..80] of Char;
         DevMode: THandle;
         pDevmode: PDeviceMode;
       begin
         // Get printer device name etc.
         Printer.GetPrinter(Device, Driver, Port, DevMode);
         // force reload of DEVMODE
         Printer.SetPrinter(Device, Driver, Port, 0) ;
         // get DEVMODE handle
         Printer.GetPrinter(Device, Driver, Port, DevMode);
         If Devmode <> 0 Then Begin
           // lock it to get pointer to DEVMODE record
           pDevMode := GlobalLock( Devmode );
           If pDevmode <> Nil Then
           try
             With pDevmode^ Do Begin
               // modify paper size
               dmPapersize := DMPAPER_B5;
               // tell printer driver that dmPapersize field contains
               // data it needs to inspect.
               dmFields := dmFields or DM_PAPERSIZE;
             End;
          finally
            // unlock devmode handle.
            GlobalUnlock( Devmode );
          end;
         End; { If }
       end;

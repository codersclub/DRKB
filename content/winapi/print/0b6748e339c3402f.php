<h1>Установить размеры бумаги</h1>
<div class="date">01.01.2007</div>


<pre>
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
     If Devmode &lt;&gt; 0 Then Begin
       // lock it to get pointer to DEVMODE record
       pDevMode := GlobalLock( Devmode );
       If pDevmode &lt;&gt; Nil Then
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
</pre>


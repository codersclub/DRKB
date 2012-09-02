<h1>Как программно добавить принтер?</h1>
<div class="date">01.01.2007</div>


<p>Чтобы программно добавить принтер, необходимо воспользоваться API функцией AddPrinter, которая имеет три параметра: </p>

<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>Имя принтера </td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>Уровень печати </td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>Описание принтера </td></tr></table>
<p>Следующий пример является надстройкой для этой функции. Для этого необходимо знать Имя принтера, которое будет отображаться в Проводнике, имя порта, к которому подключён принтер (т.е. LPT1:), имя драйвера (прийдётся посмотреть вручную) и имя процессора печати (который обычно "winprint"). </p>

<pre>
unit unit_AddPrinter;
 
interface
 
function AddAPrinter(PrinterName, PortName,
DriverName, PrintProcessor: string): boolean;
 
implementation
 
uses
  SysUtils,
  WinSpool,
  Windows;
 
function AddAPrinter(PrinterName, PortName,
DriverName, PrintProcessor: string):     boolean;
var 
  pName: PChar; 
  Level: DWORD; 
  pPrinter: PPrinterInfo2; 
begin 
 
  pName := nil; 
  Level := 2; 
  New(pPrinter); 
  pPrinter^.pServerName := nil; 
  pPrinter^.pShareName := nil; 
  pPrinter^.pComment := nil; 
  pPrinter^.pLocation := nil; 
  pPrinter^.pDevMode := nil;
  pPrinter^.pSepFile := nil; 
  pPrinter^.pDatatype := nil; 
  pPrinter^.pParameters := nil; 
  pPrinter^.pSecurityDescriptor := nil; 
  pPrinter^.Attributes := 0;
  pPrinter^.Priority := 0;
  pPrinter^.DefaultPriority := 0;
  pPrinter^.StartTime := 0;
  pPrinter^.UntilTime := 0;
  pPrinter^.Status := 0;
  pPrinter^.cJobs := 0;
  pPrinter^.AveragePPM :=0;
 
  pPrinter^.pPrinterName := PCHAR(PrinterName);
  pPrinter^.pPortName := PCHAR(PortName);
  pPrinter^.pDriverName := PCHAR(DriverName);
  pPrinter^.pPrintProcessor := PCHAR(PrintProcessor);
 
  if AddPrinter(pName, Level, pPrinter) &lt;&gt; 0 then
    Result := true
  else
  begin
    // ShowMessage(inttostr(GetlastError));
    Result := false;
  end;
end;
 
end.
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>


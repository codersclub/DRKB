<h1>Как распечатать Excel файл?</h1>
<div class="date">01.01.2007</div>


<pre class="delphi">
{ 
  This is a simple example how to print an Excel file using OLE. 
} 
uses 
  ComObj; 
 
procedure TForm1.Button1Click(Sender: TObject); 
var 
  ExcelApp: OLEVariant; 
begin 
  // Create an Excel instance 
  // Excel Instanz erzeugen 
  ExcelApp := CreateOleObject('Excel.Application'); 
  try 
    ExcelApp.Workbooks.Open('C:\test\xyz.xls'); 
    // you can also modify some settings from PageSetup 
    // Man kann auch noch einige Einstellungen von "Seite Einrichten" anpassen 
    ExcelApp.ActiveSheet.PageSetup.Orientation := xlLandscape; 
    // Print it out 
    // Ausdrucken 
    ExcelApp.Worksheets.PrintOut; 
  finally 
    // Close Excel 
    // Excel wieder schliessen 
    if not VarIsEmpty(ExcelApp) then 
    begin 
      ExcelApp.Quit; 
      ExcelApp := Unassigned; 
    end; 
  end; 
end; 
</pre>
<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>

---
Title: Как распечатать Excel файл?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как распечатать Excel файл?
===========================


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


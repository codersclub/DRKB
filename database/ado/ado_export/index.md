---
Title: Экспорт ADO таблиц в разные форматы
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
Author: Carlo Pasolini, ccpasolini@libero.it 
---


Экспорт ADO таблиц в разные форматы
===================================

    { 
    Exporting ADO tables into various formats 
     
    In this article I want to present a component I built in order to 
    supply exporting features to the ADOTable component. ADO supplies 
    an extended SQL syntax that allows exporting of data into various  
    formats. I took into consideration the following formats: 
     
    1)Excel 
    2)Html 
    3)Paradox 
    4)Dbase 
    5)Text 
     
    You can see all supported output formats in the registry: 
    "HKEY_LOCAL_MACHINE\Software\Microsoft\Jet\4.0\ISAM formats" 
     
    This is the complete source of my component } 
     
    unit ExportADOTable; 
     
    interface 
     
    uses 
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs, 
      Db, ADODB; 
     
    type 
      TExportADOTable = class(TADOTable) 
      private 
        { Private declarations } 
        //TADOCommand component used to execute the SQL exporting commands 
        FADOCommand: TADOCommand; 
      protected 
        { Protected declarations } 
      public 
        { Public declarations } 
        constructor Create(AOwner: TComponent); override; 
     
        //Export procedures 
        //"FiledNames" is a comma separated list of the names of the fields you want to export 
        //"FileName" is the name of the output file (including the complete path) 
        //if the dataset is filtered (Filtered = true and Filter <> ''), then I append  
        //the filter string to the sql command in the "where" directive 
        //if the dataset is sorted (Sort <> '') then I append the sort string to the sql command in the  
        //"order by" directive 
     
        procedure ExportToExcel(FieldNames: string; FileName: string; 
          SheetName: string; IsamFormat: string); 
        procedure ExportToHtml(FieldNames: string; FileName: string); 
        procedure ExportToParadox(FieldNames: string; FileName: string; IsamFormat: string); 
        procedure ExportToDbase(FieldNames: string; FileName: string; IsamFormat: string); 
        procedure ExportToTxt(FieldNames: string; FileName: string); 
      published 
        { Published declarations } 
      end; 
     
    procedure Register; 
     
    implementation 
     
    procedure Register; 
    begin 
      RegisterComponents('Carlo Pasolini', [TExportADOTable]); 
    end; 
     
    constructor TExportADOTable.Create(AOwner: TComponent); 
    begin 
      inherited; 
     
      FADOCommand := TADOCommand.Create(Self); 
    end; 
     
     
    procedure TExportADOTable.ExportToExcel(FieldNames: string; FileName: string; 
      SheetName: string; IsamFormat: string); 
    begin 
      {IsamFormat values 
       Excel 3.0 
       Excel 4.0 
       Excel 5.0 
       Excel 8.0 
      } 
     
      if not Active then 
        Exit; 
      FADOCommand.Connection  := Connection;   
      FADOCommand.CommandText := 'Select ' + FieldNames + ' INTO ' + '[' + 
        SheetName + ']' + ' IN ' + '"' + FileName + '"' + '[' + IsamFormat + 
        ';]' + ' From ' + TableName; 
      if Filtered and (Filter <> '') then 
        FADOCommand.CommandText := FADOCommand.CommandText + ' where ' + Filter; 
      if (Sort <> '') then 
        FADOCommand.CommandText := FADOCommand.CommandText + ' order by ' + Sort; 
      FADOCommand.Execute; 
    end; 
     
    procedure TExportADOTable.ExportToHtml(FieldNames: string; FileName: string); 
    var 
      IsamFormat: string; 
    begin 
      if not Active then 
        Exit; 
     
      IsamFormat := 'HTML Export'; 
     
      FADOCommand.Connection  := Connection; 
      FADOCommand.CommandText := 'Select ' + FieldNames + ' INTO ' + '[' + 
        ExtractFileName(FileName) + ']' +  
        ' IN ' + '"' + ExtractFilePath(FileName) + '"' + '[' + IsamFormat + 
        ';]' + ' From ' + TableName; 
      if Filtered and (Filter <> '') then 
        FADOCommand.CommandText := FADOCommand.CommandText + ' where ' + Filter; 
      if (Sort <> '') then 
        FADOCommand.CommandText := FADOCommand.CommandText + ' order by ' + Sort; 
      FADOCommand.Execute; 
    end; 
     
     
    procedure TExportADOTable.ExportToParadox(FieldNames: string; 
      FileName: string; IsamFormat: string); 
    begin 
      {IsamFormat values 
      Paradox 3.X 
      Paradox 4.X 
      Paradox 5.X 
      Paradox 7.X 
      } 
      if not Active then 
        Exit; 
     
      FADOCommand.Connection  := Connection; 
      FADOCommand.CommandText := 'Select ' + FieldNames + ' INTO ' + '[' + 
        ExtractFileName(FileName) + ']' +  
        ' IN ' + '"' + ExtractFilePath(FileName) + '"' + '[' + IsamFormat + 
        ';]' + ' From ' + TableName; 
      if Filtered and (Filter <> '') then 
        FADOCommand.CommandText := FADOCommand.CommandText + ' where ' + Filter; 
      if (Sort <> '') then 
        FADOCommand.CommandText := FADOCommand.CommandText + ' order by ' + Sort; 
      FADOCommand.Execute; 
    end; 
     
    procedure TExportADOTable.ExportToDbase(FieldNames: string; FileName: string; 
      IsamFormat: string); 
    begin 
      {IsamFormat values 
      dBase III 
      dBase IV 
      dBase 5.0 
      } 
      if not Active then 
        Exit; 
     
      FADOCommand.Connection  := Connection; 
      FADOCommand.CommandText := 'Select ' + FieldNames + ' INTO ' + '[' + 
        ExtractFileName(FileName) + ']' +  
        ' IN ' + '"' + ExtractFilePath(FileName) + '"' + '[' + IsamFormat + 
        ';]' + ' From ' + TableName; 
      if Filtered and (Filter <> '') then 
        FADOCommand.CommandText := FADOCommand.CommandText + ' where ' + Filter; 
      if (Sort <> '') then 
        FADOCommand.CommandText := FADOCommand.CommandText + ' order by ' + Sort; 
      FADOCommand.Execute; 
    end; 
     
    procedure TExportADOTable.ExportToTxt(FieldNames: string; FileName: string); 
    var 
      IsamFormat: string; 
    begin 
      if not Active then 
        Exit; 
     
      IsamFormat := 'Text'; 
     
      FADOCommand.Connection  := Connection; 
      FADOCommand.CommandText := 'Select ' + FieldNames + ' INTO ' + '[' + 
        ExtractFileName(FileName) + ']' +  
        ' IN ' + '"' + ExtractFilePath(FileName) + '"' + '[' + IsamFormat + 
        ';]' + ' From ' + TableName; 
      if Filtered and (Filter <> '') then 
        FADOCommand.CommandText := FADOCommand.CommandText + ' where ' + Filter; 
      if (Sort <> '') then 
        FADOCommand.CommandText := FADOCommand.CommandText + ' order by ' + Sort; 
      FADOCommand.Execute; 
    end; 
     
    end. 
     
    { 
    Note that you can use an already existing database as destination but not an already existing 
    table in the database itself: if you specify an already exixting table you will receive 
    an error message. You might insert a verification code inside every exporting procedure of my 
    component, before the execution of the sql exporting command, in order to send a request of   
    deleting the already present table or aborting the exporting process. 
     
    carlo Pasolini, Riccione(italy), e-mail: ccpasolini@libero.it 
    } 


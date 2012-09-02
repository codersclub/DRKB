<h1>Экспорт из TDBGrid в Excel без OLE</h1>
<div class="date">01.01.2007</div>


<pre>
{ 
  Exporting a DBGrid to excel without OLE 
 
  I develop software and about 95% of my work deals with databases. 
  I enjoied the advantages of using Microsoft Excel in my projects 
  in order to make reports but recently I decided to convert myself 
  to the free OpenOffice suite. 
  I faced with the problem of exporting data to Excel without having 
  Office installed on my computer. 
  The first solution was to create directly an Excel format compatible file: 
  this solution is about 50 times faster than the OLE solution but there 
  is a problem: the output file is not compatible with OpenOffice. 
  I wanted a solution which was compatible with each "DataSet"; 
  at the same time I wanted to export only the dataset data present in 
  a DBGrid and not all the "DataSet". 
  Finally I obtained this solution which satisfied my requirements. 
  I hope that it will be usefull for you too. 
 
  First of all you must import the ADOX type library 
  which will be used to create the Excel file and its 
  internal structure: in the Delphi IDE: 
 
  1)Project-&gt;Import Type Library: 
  2)Select "Microsoft ADO Ext. for DDL and Security" 
  3)Uncheck "Generate component wrapper" at the bottom 
  4)Rename the class names (TTable, TColumn, TIndex, TKey, TGroup, TUser, TCatalog) in 
    (TXTable, TXColumn, TXIndex, TXKey, TXGroup, TXUser, TXCatalog) 
    in order to avoid conflicts with the already present TTable component. 
  5)Select the Unit dir name and press "Create Unit". 
    It will be created a file named AOX_TLB. 
    Include ADOX_TLB in the "uses" directive inside the file in which you want 
    to use ADOX functionality. 
 
  That is all. Let's go now with the implementation: 
} 
 
unit DBGridExportToExcel; 
 
interface 
 
uses 
  Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs, 
  ExtCtrls, StdCtrls, ComCtrls, DB, IniFiles, Buttons, dbgrids, ADOX_TLB, ADODB; 
 
 
type TScrollEvents = class 
       BeforeScroll_Event: TDataSetNotifyEvent; 
       AfterScroll_Event: TDataSetNotifyEvent; 
       AutoCalcFields_Property: Boolean; 
  end; 
 
procedure DisableDependencies(DataSet: TDataSet; var ScrollEvents: TScrollEvents); 
procedure EnableDependencies(DataSet: TDataSet; ScrollEvents: TScrollEvents); 
procedure DBGridToExcelADO(DBGrid: TDBGrid; FileName: string; SheetName: string); 
 
 
implementation 
 
//Support procedures: I made that in order to increase speed in 
//the process of scanning large amounts 
//of records in a dataset 
 
//we make a call to the "DisableControls" procedure and then disable the "BeforeScroll" and 
//"AfterScroll" events and the "AutoCalcFields" property. 
procedure DisableDependencies(DataSet: TDataSet; var ScrollEvents: TScrollEvents);
begin
  with DataSet do
    begin
      DisableControls;
      ScrollEvents := TScrollEvents.Create();
      with ScrollEvents do
        begin
          BeforeScroll_Event := BeforeScroll;
          AfterScroll_Event := AfterScroll;
          AutoCalcFields_Property := AutoCalcFields;
          BeforeScroll := nil;
          AfterScroll := nil;
          AutoCalcFields := False;
        end;
    end;
end;
 
//we make a call to the "EnableControls" procedure and then restore
// the "BeforeScroll" and "AfterScroll" events and the "AutoCalcFields" property.
 
procedure EnableDependencies(DataSet: TDataSet; ScrollEvents: TScrollEvents);
begin
  with DataSet do
    begin
      EnableControls;
      with ScrollEvents do
        begin
          BeforeScroll := BeforeScroll_Event;
          AfterScroll := AfterScroll_Event;
          AutoCalcFields := AutoCalcFields_Property;
        end;
    end;
end;
 
//This is the procedure which make the work: 
 
procedure DBGridToExcelADO(DBGrid: TDBGrid; FileName: string; SheetName: string); 
var 
  cat: _Catalog; 
  tbl: _Table; 
  col: _Column; 
  i: integer; 
  ADOConnection: TADOConnection; 
  ADOQuery: TADOQuery; 
  ScrollEvents: TScrollEvents; 
  SavePlace: TBookmark; 
begin 
  // 
  //WorkBook creation (database) 
  cat := CoCatalog.Create; 
  cat._Set_ActiveConnection('Provider=Microsoft.Jet.OLEDB.4.0; Data Source=' + FileName + ';Extended Properties=Excel 8.0'); 
  //WorkSheet creation (table) 
  tbl := CoTable.Create; 
  tbl.Set_Name(SheetName); 
  //Columns creation (fields) 
  DBGrid.DataSource.DataSet.First; 
  with DBGrid.Columns do 
    begin 
      for i := 0 to Count - 1 do 
        if Items[i].Visible then 
        begin 
          col := nil; 
          col := CoColumn.Create; 
          with col do 
            begin 
              Set_Name(Items[i].Title.Caption); 
              Set_Type_(adVarWChar); 
            end; 
          //add column to table 
          tbl.Columns.Append(col, adVarWChar, 20); 
        end; 
    end; 
  //add table to database 
  cat.Tables.Append(tbl); 
 
  col := nil; 
  tbl := nil; 
  cat := nil; 
 
  //exporting 
  ADOConnection := TADOConnection.Create(nil); 
  ADOConnection.LoginPrompt := False; 
  ADOConnection.ConnectionString := 'Provider=Microsoft.Jet.OLEDB.4.0; Data Source=' + FileName + ';Extended Properties=Excel 8.0'; 
  ADOQuery := TADOQuery.Create(nil); 
  ADOQuery.Connection := ADOConnection; 
  ADOQuery.SQL.Text := 'Select * from [' + SheetName + '$]'; 
  ADOQuery.Open; 
 
 
  DisableDependencies(DBGrid.DataSource.DataSet, ScrollEvents); 
  SavePlace := DBGrid.DataSource.DataSet.GetBookmark; 
  try 
  with DBGrid.DataSource.DataSet do 
    begin 
      First; 
      while not Eof do 
        begin 
          ADOQuery.Append; 
          with DBGrid.Columns do 
            begin 
              ADOQuery.Edit; 
              for i := 0 to Count - 1 do 
                if Items[i].Visible then 
                  begin 
                    ADOQuery.FieldByName(Items[i].Title.Caption).AsString := FieldByName(Items[i].FieldName).AsString; 
                  end; 
              ADOQuery.Post; 
            end; 
          Next; 
        end; 
    end; 
 
  finally 
  DBGrid.DataSource.DataSet.GotoBookmark(SavePlace); 
  DBGrid.DataSource.DataSet.FreeBookmark(SavePlace); 
  EnableDependencies(DBGrid.DataSource.DataSet, ScrollEvents); 
 
  ADOQuery.Close; 
  ADOConnection.Close; 
 
  ADOQuery.Free; 
  ADOConnection.Free; 
 
  end; 
 
end; 
 
end. 
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>

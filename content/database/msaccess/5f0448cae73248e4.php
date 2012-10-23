<h1>Как паковать базу данных?</h1>
<div class="date">01.01.2007</div>



<p>Using D6 Pro, Access XP and Jet 4.0 Sp6 - how can I compact Access files?</p>

<p>Answer:</p>

<p>This does it:</p>
<pre>
procedure TMainForm.ActionCompactAccessDBExecute(Sender: TObject);
var
  JetEngine: Variant;
  TempName: string;
  aAccess: string;
  stAccessDB: string;
  SaveCursor: TCursor;
begin
  stAccessDB := 'Provider = Microsoft.Jet.OLEDB.4.0;' +
    'Data Source = %s;Jet OLEDB: Engine type = ';
  stAccessDB := stAccessDB + '5'; {5 for Access 2000 and 4 for Access 97}
  OpenDialog1.InitialDir := oSoftConfig.ApplicationPath + 'Data\';
  OpenDialog1.Filter := 'MS Access (r) (*.mdb)|*.mdb';
  if OpenDialog1.execute and (uppercase(ExtractFileExt
    (OpenDialog1.FileName)) = '.MDB') then
  begin
    if MessageDlg('This process can take several minutes. Please wait till the end ' +
      #13 + #10 + 'of it. Do you want to proceed? Press No to exit.', mtInformation,
      [mbYes, mbNo], 0) = mrNo then
      exit;
    SaveCursor := screen.cursor;
    screen.cursor := crHourGlass;
    aAccess := OpenDialog1.FileName;
    TempName := ChangeFileExt(aAccess, '.$$$');
    DeleteFile(PChar(TempName));
    JetEngine := CreateOleObject('JRO.JetEngine');
    try
      JetEngine.CompactDatabase(Format(stAccessDB, [aAccess]),
        Format(stAccessDB, [TempName]));
      DeleteFile(PChar(aAccess));
      RenameFile(TempName, aAccess);
    finally
      JetEngine := Unassigned;
      screen.cursor := SaveCursor;
    end;
  end;
end;
</pre>


<p>Important Notes:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">1.</td><td>1. &nbsp; &nbsp; &nbsp; &nbsp;Include the JRO_TLB unit in your uses clause.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">2.</td><td>2. &nbsp; &nbsp; &nbsp; &nbsp;Nobody should use or open the database during compacting.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">3.</td><td>3. &nbsp; &nbsp; &nbsp; &nbsp;If the compiler gives you an error on the JRO_TLB unit follow these steps:</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 72px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Using the Delphi IDE go to Project &#8211; Import Type Library.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 72px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Scroll down until you reach "Microsoft Jet and Replication Objects 2.1 Library".</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 72px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Click on Install button.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 72px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Recompile a gain.</td></tr></table></div>

<hr />How to compact and repair MS Access 2000 (Jet Engine 4) during run time using Delphi 5?</p>

<p>Answer:</p>

<p>Usually the size of MS Access keep growing fast by time because of it's internal caching and temporary buffering, which in over whole effect the performance, space required for storing, and backing-up (if needed).&nbsp; The solution is to compact it from Access menus (Tools &#8211; Database Utilities &#8211; Compact and Repair Database) or to do that from inside your Delphi application.</p>
<pre>
function CompactAndRepair(sOldMDB: string; sNewMDB: string): Boolean;
const
  sProvider = 'Provider=Microsoft.Jet.OLEDB.4.0;';
var
  oJetEng: JetEngine;
begin
  sOldMDB := sProvider + 'Data Source=' + sOldMDB;
  sNewMDB := sProvider + 'Data Source=' + sNewMDB;
 
  try
    oJetEng := CoJetEngine.Create;
    oJetEng.CompactDatabase(sOldMDB, sNewMDB);
    oJetEng := nil;
    Result := True;
  except
    oJetEng := nil;
    Result := False;
  end;
end;
</pre>


<p>Example :</p>
<pre>
if CompactAndRepair('e:\Old.mdb', 'e:\New.mdb') then
  ShowMessage('Successfully')
else
  ShowMessage('Error…');
</pre>


<p>Important Notes:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">1.</td><td>1. &nbsp; &nbsp; &nbsp; &nbsp;Include the JRO_TLB unit in your uses clause.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">2.</td><td>2. &nbsp; &nbsp; &nbsp; &nbsp;Nobody should use or open the database during compacting.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">3.</td><td>3. &nbsp; &nbsp; &nbsp; &nbsp;If the compiler gives you an error on the JRO_TLB unit follow these steps:</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 72px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Using the Delphi IDE go to Project &#8211; Import Type Library.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 72px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Scroll down until you reach "Microsoft Jet and Replication Objects 2.1 Library".</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 72px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Click on Install button.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 72px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Recompile a gain.</td></tr></table></div>
<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>


<hr />
<pre>
procedure CompactDatabase_JRO(DatabaseName:string;DestDatabaseName:string='';Password:string='');
const
   Provider = 'Provider=Microsoft.Jet.OLEDB.4.0;';
var
  TempName : array[0..MAX_PATH] of Char; // имя временного файла
  TempPath : string; // путь до него
  Name : string;
  Src,Dest : WideString;
  V : Variant;
begin
   try
       Src := Provider + 'Data Source=' + DatabaseName;
       if DestDatabaseName&lt;&gt;'' then
           Name:=DestDatabaseName
       else begin
           // выходная база не указана - используем временный файл
           // получаем путь для временного файла
           TempPath:=ExtractFilePath(DatabaseName);
           if TempPath='' Then TempPath:=GetCurrentDir;
           //получаем имя временного файла
           GetTempFileName(PChar(TempPath),'mdb',0,TempName);
           Name:=StrPas(TempName);
       end;
       DeleteFile(PChar(Name));// этого файла не должно существовать :))
       Dest := Provider + 'Data Source=' + Name;
       if Password&lt;&gt;'' then begin
           Src := Src + ';Jet OLEDB:Database Password=' + Password;
           Dest := Dest + ';Jet OLEDB:Database Password=' + Password;
       end;
 
       V:=CreateOleObject('jro.JetEngine');
       try
           V.CompactDatabase(Src,Dest);// сжимаем
       finally
           V:=0;
       end;
       if DestDatabaseName='' then begin // т.к. выходная база не указана 
           DeleteFile(PChar(DatabaseName)); //то удаляем не упакованную базу
           RenameFile(Name,DatabaseName); // и переименовываем упакованную базу
       end;
   except
    // выдаем сообщение об исключительной ситуации
    on E: Exception do ShowMessage(e.message);
   end;
end;
</pre>


<p>Использование:</p>
<pre>
CompactDatabase_JRO('C:\MyDataBase\base.mdb','','123');
</pre>

<div class="author">Автор: ZEE</div>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>


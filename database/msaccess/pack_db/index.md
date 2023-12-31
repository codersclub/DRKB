---
Title: Как паковать базу данных?
Author: ZEE
Date: 01.01.2007
---


Как паковать базу данных?
=========================

::: {.date}
01.01.2007
:::

Using D6 Pro, Access XP and Jet 4.0 Sp6 - how can I compact Access
files?

Answer:

This does it:

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

Important Notes:

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"}
  ---- -----------------------------------------------------------
  1.   1\.        Include the JRO\_TLB unit in your uses clause.
  ---- -----------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"}
  ---- ----------------------------------------------------------------------
  2.   2\.        Nobody should use or open the database during compacting.
  ---- ----------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"}
  ---- ---------------------------------------------------------------------------
  3.   3\.        If the compiler gives you an error on the JRO\_TLB unit follow
       these steps:
  ---- ---------------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 72px;"}
  --- ------------------------------------------------------------
  ·   Using the Delphi IDE go to Project - Import Type Library.
  --- ------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 72px;"}
  --- ------------------------------------------------------------------------------------
  ·   Scroll down until you reach "Microsoft Jet and Replication Objects 2.1 Library".
  --- ------------------------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 72px;"}
  --- --------------------------
  ·   Click on Install button.
  --- --------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 72px;"}
  --- -------------------
  ·   Recompile a gain.
  --- -------------------
:::

------------------------------------------------------------------------

How to compact and repair MS Access 2000 (Jet Engine 4) during run time
using Delphi 5?

Answer:

Usually the size of MS Access keep growing fast by time because of it\'s
internal caching and temporary buffering, which in over whole effect the
performance, space required for storing, and backing-up (if needed). 
The solution is to compact it from Access menus (Tools - Database
Utilities - Compact and Repair Database) or to do that from inside your
Delphi application.

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

Example :

    if CompactAndRepair('e:\Old.mdb', 'e:\New.mdb') then
      ShowMessage('Successfully')
    else
      ShowMessage('Error…');

Important Notes:

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"}
  ---- -----------------------------------------------------------
  1.   1\.        Include the JRO\_TLB unit in your uses clause.
  ---- -----------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"}
  ---- ----------------------------------------------------------------------
  2.   2\.        Nobody should use or open the database during compacting.
  ---- ----------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"}
  ---- ---------------------------------------------------------------------------
  3.   3\.        If the compiler gives you an error on the JRO\_TLB unit follow
       these steps:
  ---- ---------------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 72px;"}
  --- ------------------------------------------------------------
  ·   Using the Delphi IDE go to Project - Import Type Library.
  --- ------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 72px;"}
  --- ------------------------------------------------------------------------------------
  ·   Scroll down until you reach "Microsoft Jet and Replication Objects 2.1 Library".
  --- ------------------------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 72px;"}
  --- --------------------------
  ·   Click on Install button.
  --- --------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 72px;"}
  --- -------------------
  ·   Recompile a gain.
  --- -------------------
:::

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>

------------------------------------------------------------------------

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
           if DestDatabaseName<>'' then
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
           if Password<>'' then begin
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

Использование:

    CompactDatabase_JRO('C:\MyDataBase\base.mdb','','123');

Автор: ZEE

Взято из <https://forum.sources.ru>

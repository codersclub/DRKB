---
Title: Создание таблицы Foxpro
Date: 01.01.2007
---


Создание таблицы Foxpro
=======================

::: {.date}
01.01.2007
:::

    if savedialog1.execute then
    begin
    if FileExists(savedialog1.filename) then
       DeleteFile(savedialog1.filename);
      //QUERY.DataSource НЕ ЗАПОЛНЕНО иначе взрыв гарантирован
    with Session do
    begin
        ConfigMode := cmSession;
      try
       AddStandardAlias('TEMPDB', extractfilepath(savedialog1.filename),
        'FOXPRO'); //FOXPRO
      finally
          ConfigMode := cmAll;
      end;
    end;
     with database1 do
     begin
       databasename:='tst';
       LoginPrompt := False;
       Params.Values['PATH'] :=extractfilepath(savedialog1.filename);
       DriverName:='Microsoft FoxPro Driver (*.dbf)';
       AliasName:='TEMPDB';
     end;
     query1.paramcheck := false;
     Query1.DatabaseName := 'tst';
     Query1.SQL.Clear;
     vrem:=Trim(ChangeFileExt(extractfilename(SaveDialog1.fileName),' '));
     query1.sql.Add('CREATE TABLE '''+vrem+''' (');
     query1.sql.Add('last_name CHAR(20),');
     query1.sql.Add('first_name CHAR(15),');
     query1.sql.Add('salary DECIMAL(10,2));');  //NUMERIC
     query1.ExecSQL;
     query1.close;
    end; // от savedialog

Взято с <https://delphiworld.narod.ru>

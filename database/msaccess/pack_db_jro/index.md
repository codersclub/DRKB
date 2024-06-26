---
Title: Программное сжатие базы данных Access, используя JRO
Author: Алексей Сапронов (Savva), savva@nm.ru, ICQ:126578975
Date: 09.09.2002
---


Программное сжатие базы данных Access, используя JRO
====================================================

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Программное сжатие базы данных Access используя JRO (Jet Replication Objects)
     
    Процедура позволяет сжать базу данных в формате Access, используя JRO (Jet Replication Objects). Действие аналогичное пункту меню в Access "Сервис -> Служебные программы -> Сжать и восстановить базу данных".
    Параметры:
    * DatabaseName - путь к исходной (не сжатой) базе данных
    * DestDatabaseName - путь к сжатой базе данных (по умолчанию пустой - в этом случае исходная база заменяется сжатой)
    * Password - пароль базы данных (по умолчанию пустой)
     
    PS. этот код был написан в связи с тем что аналогичная процедура через DAO у многих не работала (по пока неизвестным для меня причинам)
     
    Зависимости: windows,SysUtils,ComObj,Dialogs (Dialogs можно исключить используя MessageBox для вывода сообщения исключительной ситуации)
    Автор:       savva, savva@nm.ru, ICQ:126578975, Орел
    Copyright:   Сапронов Алексей (Savva)
    Дата:        9 сентября 2002 г.
    ********************************************** }
     
    Procedure CompactDatabase_JRO(DatabaseName:String;DestDatabaseName:String='';Password:String='');
    Const
       Provider = 'Provider=Microsoft.Jet.OLEDB.4.0;';
    Var
      TempName : Array[0..MAX_PATH] of Char; // имя временного файла
      TempPath : String; // путь до него
      Name : String;
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

Пример использования:

    ...
    db.Close;
    CompactDatabase_JRO('c:\database.mdb','c:\Archiv\database_pack.mdb','password');
    db.open;
    ... 

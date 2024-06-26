---
Title: Не получается вставить в таблицу записи со строками на русском языке
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Не получается вставить в таблицу записи со строками на русском языке
====================================================================

В Database Desktop поставьте правильный Language Driver у таблицы,
например, Pdox ANSI Cyrr.

Это простой вопрос в том случае, если база уже создана на диске. Если мы
создаем базу динамически из программы, то как потом поставить русский
язык без Database Desktop\'а?

Оказывается это не так просто. Я перерыл весь инет и так и не нашел. В
итоге пришлось потрудится и получилась следующая функция:

    { Устанавливает русский LANGDRIVER для таблицы BDE (Paradox или dBASE)}
    { Таблица должна уже существовать на диске 
      Если вы создаете таблицу динамически,
      не забудьте вызвать Table.CreateTable }
     
     procedure SetTableRussianLanguage(Table: TTable);
     var
       Props: CURProps;
       hDb: hDBIDb;
       TableDesc: CRTblDesc;
       OptDesc: FLDDesc;
       OptData: array [0..250] of Char;
       S: string;
     const   // Define propertly table type & codepage from list below
       LDName = 'ancyrr';   // Paradox ANSI Cyrillic 
       // LDName = 'cyrr';  // Paradox Cyrr 866
       // LDName = 'DB866ru0'; // dBASE RUS cp866 
     
     begin
     // Get handle (if table still not opened)
       Table.Open;
       // Get the table properties to determine table type...
       Check(DbiGetCursorProps(Table.Handle, Props));
     
       // Blank out the structure...
       FillChar(TableDesc, sizeof(TableDesc), 0);
       FillChar(OptDesc, SizeOf(OptDesc), #0);
       // Get the database handle from the table's cursor handle...
     
       Check( DbiGetObjFromObj(hDBIObj(Table.Handle), objDATABASE,
              hDBIObj(hDb)));
     
       { If table name contain cyrillic or other native character,
          convert name to OEM }
     
       SetLength(S, Length(Table.TableName));
       CharToOEM(PChar(Table.TableName), @S[1]);
     
       // Put the table name in the table descriptor...
       StrPCopy(TableDesc.szTblName, S{Table.TableName});
       // Put the table type in the table descriptor...
       StrPCopy(TableDesc.szTblType, Props.szTableType);
       // Set the Pack option in the table descriptor to TRUE...
     
       StrCopy(OptDesc.szName, 'LANGDRIVER');
       OptDesc.iLen:=Length(LDName)+1;
       TableDesc.iOptParams:=1;
       TableDesc.pfldOptParams:=@OptDesc;
       TableDesc.pOptData:=@OptData;
       StrPCopy(OptData, LDName);
     
       // Close the table so the restructure can complete...
       Table.Close;
       // Call DbiDoRestructure...
       Check(DbiDoRestructure(hDb, 1, @TableDesc, nil, nil, nil, False));
     end;


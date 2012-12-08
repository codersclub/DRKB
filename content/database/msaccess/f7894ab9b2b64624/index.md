---
Title: Как создать таблицу в MS Access при помощи DAO?
Date: 01.01.2007
---


Как создать таблицу в MS Access при помощи DAO?
===============================================

::: {.date}
01.01.2007
:::

1\. Объявляем переменные:

    var
      access, db, td, recordset: Variant;

2\. объявляем массив констант соответствия типов данных

(между полями в Delphi и типами полей DAO)

      arrMDBTypes: array[TFieldType] of Integer =
        ({dbText} 10 {ftUnknown},
         {dbText} 10 {ftString},
         {dbInteger} 3 {ftSmallint},
         {dbLong} 4 {ftInteger},
         {dbInteger} 3 {ftWord},
         {dbBoolean} 1 {ftBoolean},
         {dbDouble} 7 {ftFloat},
         {dbCurrency} 5 {ftCurrency},
         {dbDouble} 7 {ftBCD},
         {dbDate} 8 {ftDate},
         {dbTime} 22 {ftTime},
         {dbDate} 8 {ftDateTime},
         {dbLongBinary} 11 {ftBytes},
         {dbLongBinary} 11 {ftVarBytes},
         {dbInteger} 3 {ftAutoInc},
         {dbLongBinary} 11 {ftBlob},
         {dbMemo} 12 {ftMemo},
         {dbLongBinary} 11 {ftGraphic},
         {dbMemo} 12 {ftFmtMemo},
         {dbLongBinary} 11 {ftParadoxOle},
         {dbLongBinary} 11 {ftDBaseOle},
         {dbBinary} 9 {ftTypedBinary},
         {dbText} 10 {ftCursor}
     
        {$IFDEF VER120}
         ,
         {dbText} 10 {ftFixedChar},
         {dbText} 10 {ftWideString},
         {dbBigInt} 16 {ftLargeint},
         {dbText} 10 {ftADT},
         {dbText} 10 {ftArray},
         {dbText} 10 {ftReference},
         {dbText} 10 {ftDataSet}
        {$ELSE}
     
        {$IFDEF VER125}
         ,
         {dbText} 10 {ftFixedChar},
         {dbText} 10 {ftWideString},
         {dbBigInt} 16 {ftLargeint},
         {dbText} 10 {ftADT},
         {dbText} 10 {ftArray},
         {dbText} 10 {ftReference},
         {dbText} 10 {ftDataSet}
     
        {$ELSE}
     
        {$IFDEF VER130}
         ,
         {dbText} 10 {ftFixedChar},
         {dbText} 10 {ftWideString},
         {dbBigInt} 16 {ftLargeint},
         {dbText} 10 {ftADT},
         {dbText} 10 {ftArray},
         {dbText} 10 {ftReference},
         {dbText} 10 {ftDataSet},
         {dbLongBinary} 11 {ftOraBlob},
         {dbLongBinary} 11 {ftOraClob},
         {dbText} 10 {ftVariant},
         {dbText} 10 {ftInterface},
         {dbText} 10 {ftIDispatch},
         {dbGUID} 15 {ftGuid}
        {$ENDIF}
        {$ENDIF}
        {$ENDIF}
     
        );

3\. загружаем DAO:

        try
          access := GetActiveOleObject('DAO.DBEngine.35');
        except
          access := CreateOleObject('DAO.DBEngine.35');
        end;

4\. открываем базу данных

        try
          db := access.OpenDatabase(yourDatabaseName);
        except
          exit
        end;

5\. создаём новую таблицу в открытой базе данных

        td := db.CreateTableDef(yourTableName, 0, '', '');

6\. добавляем в таблицу поле с описаниями

        td.Fields.Append(td.CreateField(strFieldName, arrMDBTypes[intDataType], Size));

например,

        td.Fields.Append(td.CreateField('ID', arrMDBTypes[intDataType], Size));
        td.Fields.Append(td.CreateField('NAME', arrMDBTypes[intDataType], Size));

7\. добавляем таблицу в список таблиц

        db.TableDefs.Append(td);

8\. открываем созданную таблицу

        recordset := db.OpenTable(yourTableName, 0);

9\. добавляем новую запись в открытую таблицу

        recordset.AddNew;

10\. изменяем значения поля

     
        curField := recordset.Fields[0].Value := 1;
        curField := recordset.Fields[1].Value := 'First record';

11\. помещаем новую запись в базу

         recordset.Update(dbUpdateRegular, False);

где

    const
      dbUpdateRegular = 1;

12\. закрываем recordset

         recordset.Close;

13\. закрываем базу данных

         db.Close;

14\. освобождаем экземпляр DAO

         access := UnAssigned;

Взято из <https://forum.sources.ru>

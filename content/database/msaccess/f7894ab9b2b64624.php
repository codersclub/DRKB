<h1>Как создать таблицу в MS Access при помощи DAO?</h1>
<div class="date">01.01.2007</div>


<p>1. Объявляем переменные:</p>
<pre>
var
  access, db, td, recordset: Variant;
</pre>

<p>2. объявляем массив констант соответствия типов данных</p>
<p>(между полями в Delphi и типами полей DAO)</p>
<pre>
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
</pre>


<p>3. загружаем DAO:</p>
<pre>
    try
      access := GetActiveOleObject('DAO.DBEngine.35');
    except
      access := CreateOleObject('DAO.DBEngine.35');
    end;
</pre>

<p>4. открываем базу данных</p>
<pre>
    try
      db := access.OpenDatabase(yourDatabaseName);
    except
      exit
    end;
</pre>


<p>5. создаём новую таблицу в открытой базе данных</p>
<pre>
    td := db.CreateTableDef(yourTableName, 0, '', '');
</pre>

<p>6. добавляем в таблицу поле с описаниями</p>
<pre>
    td.Fields.Append(td.CreateField(strFieldName, arrMDBTypes[intDataType], Size));
</pre>

<p>например,</p>
<pre>
    td.Fields.Append(td.CreateField('ID', arrMDBTypes[intDataType], Size));
    td.Fields.Append(td.CreateField('NAME', arrMDBTypes[intDataType], Size));
</pre>

<p>7. добавляем таблицу в список таблиц</p>
<pre>
    db.TableDefs.Append(td);
</pre>

<p>8. открываем созданную таблицу</p>
<pre>
    recordset := db.OpenTable(yourTableName, 0);
</pre>

<p>9. добавляем новую запись в открытую таблицу</p>
<pre>
    recordset.AddNew;
</pre>


<p>10. изменяем значения поля</p>

<pre>
 
    curField := recordset.Fields[0].Value := 1;
    curField := recordset.Fields[1].Value := 'First record';
</pre>

<p>11. помещаем новую запись в базу</p>
<pre>
     recordset.Update(dbUpdateRegular, False);
</pre>

<p>где</p>
<pre>
const
  dbUpdateRegular = 1;
</pre>

<p>12. закрываем recordset</p>
<pre>
     recordset.Close;
</pre>

<p>13. закрываем базу данных</p>
<pre>
     db.Close;
</pre>

<p>14. освобождаем экземпляр DAO</p>
<pre>
     access := UnAssigned;
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>


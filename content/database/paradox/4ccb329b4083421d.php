<h1>Как упаковать таблицу?</h1>
<div class="date">01.01.2007</div>

<div class="author">Автор: Pavel Kulchenko</div>

<pre>
uses BDE; // for D3, для D2 не помню (что-то типа DbiProcs и еще что-то)
 
// для пpимеpа
tLog: TTable; // таблица, юзающая d:\db\log.db
 
var
  TblDesc: CRTblDesc;
  rslt: DBIResult;
  Dir: string; //имеется в виду huge string т.е. {$H+}
  hDb: hDbiDb;
 
begin
  tLog.Active := False; //деактивиpуем TTable
 
  SetLength(Dir, dbiMaxNameLen + 1);
  DbiGetDirectory(tLog.DBHandle, False, PChar(Dir));
  SetLength(Dir, StrLen(PChar(Dir)));
 
  DbiOpenDatabase(nil, nil, dbiReadWrite, dbiOpenExcl, nil, 0, nil, nil, hDb);
 
  DbiSetDirectory(hDb, PChar(Dir));
 
  FillChar(TblDesc, sizeof(CRTblDesc), 0);
  StrPCopy(TblDesc.szTblName, 'd:\db\log.db');
  // здесь должно быть полное имя файла
  //котоpое можно: а) ввести pуками;
  //б) вытащить из пpопеpтей таблицы;
  //в) вытащить из алиаса;
  //г) см. FAQ
  StrCopy(TblDesc.szTblType, szParadox);
  //BTW тут может и szDBase стоять
 
  TblDesc.bPack := TRUE;
 
  DbiDoRestructure(hDb, 1, @TblDesc, nil, nil, nil, False);
  DbiCloseDatabase(hDb);
 
end;
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

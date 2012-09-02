<h1>Как сменить пароль (master password) для таблицы Paradox</h1>
<div class="date">01.01.2007</div>


<pre>
var
  db: TDatabase;
  Desc: CRTblDesc;
begin
  db := PriceTable.OpenDatabase;
  FillChar( Desc, SizeOf( Desc ), #0 );
  StrCopy( Desc.szTblName, PChar( PriceTable.TableName ) );
  StrCopy( Desc.szTblType, szParadox );
  StrCopy( Desc.szPassword, 'password' );
  Desc.bProtected := TRUE;
  Check( DbiDoRestructure( db.Handle, 1, @Desc, nil, nil, nil, FALSE ) );
end;
</pre>

<p class="author">Автор: Nomadic</p><p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

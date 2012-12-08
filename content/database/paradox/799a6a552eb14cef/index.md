---
Title: Как сменить пароль (master password) для таблицы Paradox
Author: Nomadic
Date: 01.01.2007
---


Как сменить пароль (master password) для таблицы Paradox
========================================================

::: {.date}
01.01.2007
:::

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

Автор: Nomadic

Взято с <https://delphiworld.narod.ru>

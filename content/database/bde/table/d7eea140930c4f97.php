<h1>Копирование таблицы с помощью DBE</h1>
<div class="date">01.01.2007</div>


<pre>
function CopyTable(tbl: TTable; dest: string): boolean;
var
  psrc, pdest: array[0..DBIMAXTBLNAMELEN] of char;
  rslt: DBIResult;
begin
  Result := False;
  StrPCopy(pdest, dest);
  with tbl do
  begin
    try
      DisableControls;
      StrPCopy(psrc, TableName);
      rslt := DbiCopyTable(DBHandle, True, psrc, nil, pdest);
      Result := (rslt = 0);
    finally
      Refresh;
      EnableControls;
    end;
  end;
end;
</pre>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

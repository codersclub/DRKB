<h1>Как по Alias узнать физический путь к базе данных?</h1>
<div class="date">01.01.2007</div>


<pre class="delphi">
function GetAliasDir(alias: PChar): PChar;
var
  s: TStringList;
  i: integer;
  t: string;
  res: array[0..255] of char;
begin
  res := '';
  if Session.IsAlias(alias) then
  begin {Check if alias exists}
    s := TStringList.Create;
    try
      Session.GetAliasParams(Alias, s);
      t := '';
      if s.count &gt; 0 then
      begin
        i := 0;
        while (i &lt; s.count) and (Copy(s.Strings[i], 1, 5) &lt;&gt; 'PATH=') do
          inc(i);
        if (i &lt; s.count) and (Copy(s.Strings[i], 1, 5) = 'PATH =') then
        begin
          t := Copy(s.Strings[i], 6, Length(s.Strings[i]) - 4);
          if t[length(t)] &lt;&gt; '\' then
            t := t + '\';
        end;
      end;
      StrPCopy(res, t);
    except
      StrPCopy(res, '');
    end;
    s.Free;
  end;
  result := res;
end;
</pre>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>

<hr />

Если ссылка на таблицу получена через псевдоним, получить физический путь к ней не так просто.
Для получения этого пути необходимо использовать функцию BDE DbiGetDatabaseDesc.
Данной функции в качестве параметров передаются имя псевдонима и указатель на структуру DBDesc.
Структура DBDesc будет заполнена информацией, относящейся к этому псевдониму.
Определение структуры:</p>

<pre class="delphi">
pDBDesc = ^DBDesc;
DBDesc = packed record        { Описание данной базы данных }
  szName          : DBINAME;  { Логическое имя (или псевдоним) }
  szText          : DBINAME;  { Описательный текст }
  szPhyName       : DBIPATH;  { Физическое имя/путь }
  szDbType        : DBINAME;  { Тип базы данных }
end;
</pre>

<p>Физическое имя/путь будет содержаться в поле szPhyName структуры DBDesc.</p>

<p>Возможные значения, возвращаемые функцией DBIGetDatbaseDesc:</p>

<p>DBIERR_NONE - Описание базы данных для pszName было успешно извлечено.</p>
<p>DBIERR_OBJNOTFOUND - База данных, указанная в pszName, не была обнаружена.</p>

<p>Приведенный ниже пример кода показывает как можно получить физический путь для компонента TTable, использующего псевдоним DBDemos:</p>

<pre class="delphi">
var
  vDBDesc: DBDesc;
  DirTable: String;
begin
  Check(DbiGetDatabaseDesc(PChar(Table1.DatabaseName), @vDBDesc));
  DirTable := Format('%s\%s', [vDBDesc.szPhyName, Table1.TableName]);
  ShowMessage(DirTable);
end;
</pre>


<div class="author">Автор: Xavier Pacheco</div>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

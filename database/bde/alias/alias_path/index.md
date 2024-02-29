---
Title: Как по Alias узнать физический путь к базе данных?
Author: Xavier Pacheco
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Как по Alias узнать физический путь к базе данных?
==================================================

Вариант 1.


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
          if s.count > 0 then
          begin
            i := 0;
            while (i < s.count) and (Copy(s.Strings[i], 1, 5) <> 'PATH=') do
              inc(i);
            if (i < s.count) and (Copy(s.Strings[i], 1, 5) = 'PATH =') then
            begin
              t := Copy(s.Strings[i], 6, Length(s.Strings[i]) - 4);
              if t[length(t)] <> '\' then
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

Source: Delphi Knowledge Base: <https://www.baltsoft.com/>

------------------------------------------------------------------------

Вариант 2.

Author: Xavier Pacheco
Source: <https://delphiworld.narod.ru>

Если ссылка на таблицу получена через псевдоним, получить физический
путь к ней не так просто. Для получения этого пути необходимо
использовать функцию BDE DbiGetDatabaseDesc. Данной функции в качестве
параметров передаются имя псевдонима и указатель на структуру DBDesc.
Структура DBDesc будет заполнена информацией, относящейся к этому
псевдониму. Определение структуры:

```
pDBDesc = ^DBDesc;
DBDesc = packed record        { Описание данной базы данных }
  szName          : DBINAME;    { Логическое имя (или псевдоним) }
  szText          : DBINAME;    { Описательный текст }
  szPhyName       : DBIPATH;    { Физическое имя/путь }
  szDbType        : DBINAME;    { Тип базы данных }
end;
```
Физическое имя/путь будет содержаться в поле szPhyName структуры DBDesc.

Возможные значения, возвращаемые функцией DBIGetDatbaseDesc:

- DBIERR\_NONE - Описание базы данных для pszName было успешно
извлечено.

- DBIERR\_OBJNOTFOUND - База данных, указанная в pszName, не была
обнаружена.

Приведенный ниже пример кода показывает как можно получить физический
путь для компонента TTable, использующего псевдоним DBDemos:

    var
      vDBDesc: DBDesc;
      DirTable: String;
    begin
      Check(DbiGetDatabaseDesc(PChar(Table1.DatabaseName), @vDBDesc));
      DirTable := Format('%s\%s', [vDBDesc.szPhyName, Table1.TableName]);
      ShowMessage(DirTable);
    end;


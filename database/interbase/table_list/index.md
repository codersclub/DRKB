---
Title: Как получить список таблиц?
Date: 01.01.2007
---


Как получить список таблиц?
===========================

::: {.date}
01.01.2007
:::

A list of user tables can be retrieved by querying system table
rdb$relations.

The example below shows how to do this - it inserts the table names
sorted alphabetically into a ListBox (lbSourceTables).

    begin
      ibcSourceList.SQL.Clear;
      ibcSourceList.SQL.Add('select rdb$relation_name from rdb$relations');
      ibcSourceList.SQL.Add('where rdb$system_flag = 0');
      ibcSourceList.SQL.Add('order by rdb$relation_name');
      ibcSourceList.Open;
      while not ibcSourceList.Eof do
      begin
        lbSourceTables.Items.Add(ibcSourceList.Fields[0].AsString);
        ibcSourceList.Next;
      end;
      ibcSourceList.Close;
    end;

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>

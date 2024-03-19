---
Title: Как получить список таблиц?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как получить список таблиц?
===========================

Список пользовательских таблиц можно получить,
запросив системную таблицу rdb$relations.

В примере ниже показано, как это сделать:
имена таблиц, отсортированные по алфавиту, вставляются в ListBox(lbSourceTables).


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


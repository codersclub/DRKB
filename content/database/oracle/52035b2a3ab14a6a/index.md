---
Title: Доступ к объекту Oracle
Date: 01.01.2007
---


Доступ к объекту Oracle
=======================

::: {.date}
01.01.2007
:::

Для этого можно воспользоваться компонентами от AllRoundAutomations
Direct Oracle Access. Если кому надо могу поделиться. При помощи этих
компонент можно не только производить простые запросы/вставки, но и
выполнять DDL-скрипты, и иметь доступ к объектам Oracle 8, примет смотри
ниже\...

    var
      Address: TOracleObject;
    begin
      Query.SQL.Text := 'select Name, Address from Persons';
      Query.Execute;
      while not Query.Eof do
      begin
        Address := Query.ObjField('Address');
        if not Address.IsNull then
          ShowMessage(Query.Field('Name') + ' lives in ' + Address.GetAttr('City'));
        Query.Next;
      end;
    end;

Взято с <https://delphiworld.narod.ru>

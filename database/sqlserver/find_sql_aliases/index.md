---
Title: Как найти все Alias, указывающие на MS SQL Server?
Date: 01.01.2007
---


Как найти все Alias, указывающие на MS SQL Server?
===================================================

::: {.date}
01.01.2007
:::

    GetAliases(ComboBox1.Items)
     
    procedure GetAliases(const AList: TStrings);
    var
      i: Integer;
      Desc: DBDesc;
      Buff: array[0..254] of char;
    begin
      // list all BDE aliases
      Session.GetAliasNames(AList);
      for i := AList.Count - 1 downto 0 do
      begin
        StrPCopy(Buff, AList[i]);
        Check(DbiGetDatabaseDesc(Buff, @Desc));
        // no Paradox, please
        if StrPas(Desc.szDBType) = 'STANDARD' then
          AList.Delete(i)
      end
    end;

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>

---
Title: Как сделать список всех пользователей BDE?
Date: 01.01.2007
---


Как сделать список всех пользователей BDE?
==========================================

::: {.date}
01.01.2007
:::

With Paradox:

    procedure BDEGetPDXUserList(AList: TStrings);
    var
      hCur: hDBICur;
      UDesc: USERDesc;
    begin
      AList.Clear;
      Check(DBIOpenUserList(hCur));
      try
        while DBIGetNextRecord(hCur, dbiNOLOCK, @UDesc, nil) <> DBIERR_EOF do
        begin
          AList.Add(StrPas(UDesc.szUserName));
        end;
      finally
        DBICloseCursor(hCur);
      end;
    end;

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>

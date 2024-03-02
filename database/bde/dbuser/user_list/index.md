---
Title: Как сделать список всех пользователей BDE?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как сделать список всех пользователей BDE?
==========================================

Для Paradox:

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


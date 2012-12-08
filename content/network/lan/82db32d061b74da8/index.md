---
Title: Сканирование доменов локальной сети
Date: 01.01.2007
---


Сканирование доменов локальной сети
===================================

::: {.date}
01.01.2007
:::

Переменная List заполняется списком доменов. Функция возвращает код
ошибки обращения к сети.

    Function FillNetLevel(xxx: PNetResource; list: TStrings) : Word;
    Type
        PNRArr = ^TNRArr;
        TNRArr = array[0..59] of TNetResource;
    Var
       x: PNRArr;
       tnr: TNetResource;
       I : integer;
       EntrReq,
       SizeReq,
       twx: Integer;
       WSName: string;
    begin
         Result := WNetOpenEnum(RESOURCE_GLOBALNET, RESOURCETYPE_ANY,
                                    RESOURCEUSAGE_CONTAINER, xxx, twx);
         If Result = ERROR_NO_NETWORK Then Exit;
         if Result = NO_ERROR then
         begin
                New(x);
                EntrReq := 1;
                SizeReq := SizeOf(TNetResource)*59;
                while (twx <> 0) and 
                      (WNetEnumResource(twx, EntrReq, x, SizeReq) <> ERROR_NO_MORE_ITEMS) do
                begin
                      For i := 0 To EntrReq - 1 do
                      begin
                       Move(x^[i], tnr, SizeOf(tnr));
                       case tnr.dwDisplayType of
                        RESOURCEDISPLAYTYPE_DOMAIN:
                        begin
                           if tnr.lpRemoteName <> '' then
                               WSName:= tnr.lpRemoteName
                               else WSName:= tnr.lpComment;
                           list.Add(WSName);
                        end;
                        else FillNetLevel(@tnr, list);
                       end;
                      end;
                end;
                Dispose(x);
                WNetCloseEnum(twx);
         end;
    end;

Источник: <https://dmitry9.nm.ru/info/>

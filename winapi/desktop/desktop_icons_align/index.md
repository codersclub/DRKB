---
Title: Как выровнять иконки на рабочем столе к левому краю?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как выровнять иконки на рабочем столе к левому краю?
====================================================

Для начала необходимо получить дескриптор рабочего стола, который
представляет из себя обычный ListView.

Пример:

    function GetDesktopListViewHandle: THandle;
    var
      S: String;
    begin
      Result := FindWindow('ProgMan', nil);
      Result := GetWindow(Result, GW_CHILD);
      Result := GetWindow(Result, GW_CHILD);
      SetLength(S, 40);
      GetClassName(Result, PChar(S), 39);
      if PChar(S) <> 'SysListView32' then Result := 0;
    end;

Как только дескриптор рабочего стола получен, можно с ним работать при
помощи обычных API функций (через юнит CommCtrl). См. сообщения
LVM\_xxxx в хелпе по Win32.

Следующая строчка кода выравнивает иконки на рабочем столе к левому
краю:

    SendMessage(GetDesktopListViewHandle,LVM_ALIGN,LVA_ALIGNLEFT,0);


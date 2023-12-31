---
Title: Как получить Handle рабочего стола
Date: 01.01.2007
---


Как получить Handle рабочего стола
==================================

::: {.date}
01.01.2007
:::

Рабочий стол перекрыт сверху компонентом ListView. Вам просто необходимо
взять хэндл этого органа управления. Пример:

    function GetDesktopListViewHandle: THandle;
    var
      S: string;
    begin
      Result := FindWindow('ProgMan', nil);
      Result := GetWindow(Result, GW_CHILD);
      Result := GetWindow(Result, GW_CHILD);
      SetLength(S, 40);
      GetClassName(Result, PChar(S), 39);
      if PChar(S) <> 'SysListView32' then
        Result := 0;
    end;

После того, как Вы взяли тот хэндл, Вы можете использовать API этого
ListView, определенный в модуле CommCtrl, для того, чтобы манипулировать
рабочим столом. Смотрите тему "LVM\_xxxx messages" в оперативной
справке по Win32.

К примеру, следующая строка кода:

    SendMessage(GetDesktopListViewHandle, LVM_ALIGN, LVA_ALIGNLEFT, 0);

разместит иконки рабочего стола по левой стороне рабочего стола Windows.

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

---
Title: Как установить цвет фона иконок на рабочем столе, либо сделать у них прозрачный фон?
Date: 01.01.2007
---


Как установить цвет фона иконок на рабочем столе, либо сделать у них прозрачный фон?
====================================================================================

::: {.date}
01.01.2007
:::

Для этого нужно найти окно \"SysListView32\" (которое является списком,
который содержит иконки рабочего стола). Сперва будем искать главное
родительское окно \"Progman\", которое содержит дочернее окно
\"SHELLDLL\_DefView\", которое в свою очередь имеет дочернее окно
\"SysListView32\". Для этого можно воспользоваться API функцией
FindWindow to. Когда Мы получим дескриптор окна \"SysListView32\", то
можно будет воспользоваться макросами ListView\_SetTextBkColor и
ListView\_SetTextColor для установки желаемого цвета.

Ниже приведена процедура, которая делает всё вышеперечисленное. Если
параметр Trans равен true, то будет установлен прозрачный фон, иначе
цвет фона будет равен Background.

    unit DeskIcons;
     
    interface
    uses Graphics; // Будет использоваться TColor
     
    procedure SetDesktopIconColor(Forground, Background: TColor; Trans: Boolean);
    procedure SetDefaultIconColors;
     
    implementation
    uses Windows, CommCtrl; // будут использоваться HWND и ListView_XXXXX
     
    procedure SetDesktopIconColor(Forground, Background: TColor; Trans: Boolean);
     
    var
      Window: HWND;
    begin
      // Находим нужное окно в три этапа
      Window := FindWindow('Progman', 'Program Manager');
      // Используем FindWindowEx для нахождения дочернего окна
      Window := FindWindowEx(Window, HWND(nil), 'SHELLDLL_DefView', '');
      // SysListView32, это список с иконками на рабочем столе
      Window := FindWindowEx(Window, HWND(nil), 'SysListView32', '');
      // Используем макрос для очистки цвета фона
      if Trans then
        ListView_SetTextBkColor(Window, $ffffffff) // фоновый цвет
      else
        ListView_SetTextBkColor(Window, Background); // фоновый цвет
      ListView_SetTextColor(Window, Forground); // передний цвет
      // теперь перерисовываем иконки
      ListView_RedrawItems(Window, 0, ListView_GetItemCount(Window) - 1);
      UpdateWindow(Window);   // даём команду "немедленно перерисовать"
    end;
     
    procedure SetDefaultIconColors;
    { Эта процедура устанавливает цвета, которые заданы в
      windows по умолчанию }
    var
      Kind: Integer;
      Color: TColor;
    begin
      Kind := COLOR_DESKTOP;
      Color := GetSysColor(COLOR_DESKTOP);
      SetSysColors(1, Kind, Color);
    end;
     
    end.

Взято из <https://forum.sources.ru>

---
Title: Проблема с установками принтера
Date: 01.01.2007
---


Проблема с установками принтера
===============================

::: {.date}
01.01.2007
:::

Обнаружил, что компонент QReport никак не реагирует на установки
принтера PrinterSetup диалога, вызываемого нажатием кнопочкисобственного
Preview!

В QuickReport есть собственный объект TQRPrinter, установки которого он
использует при печати, а стандартные установки принтеров на него не
влияют. В диалоге PrinterSetup, вызываемом из Preview можно лишь выбрать
принтер на который нужно печатать (если, конечно, установлено несколько
принтеров).

Советую поставить обновление QReport на 2.0J с www.qusoft.com.

Перед печатью (не только из QReport) программно установите требуемый
драйвер принтера текущим для Windows

    function SetDefPrn(const stDriver : string) : boolean;
    begin
      SetPrinter(nil).Free;
      Result := WriteProfileString('windows', device, PChar( stDriver));
    end;

После печати восстановите установки.

Источник: <https://dmitry9.nm.ru/info/>
---
Title: Как установить драйвер принтера?
Date: 01.01.2007
---

Как установить драйвер принтера?
================================

::: {.date}
01.01.2007
:::

Приведенный пример устанавливает драйвер принтера. Вам необходимо
скопировать файлы с драйвером принтера в каталог Windows\\System и
внести необходимые изменения в файл Win.Ini.

Примечание:

DriverName = Имя драйвера;

DRVFILE - имя файла с драйвером без расширения (".drv" - по
умолчанию).

    procedure TForm1.Button1Click(Sender: TObject);
    var
      s: array [0..64] of char;
    begin
      WriteProfileString('PrinterPorts', 'DriverName', 'DRVFILE,FILE:,15,45');
      WriteProfileString('Devices', 'DriverName', 'DRVFILE,FILE:');
      StrCopy(S, 'PrinterPorts');
      SendMessage(HWND_BROADCAST, WM_WININICHANGE, 0, LongInt(@S));
      StrCopy(S, 'Devices');
      SendMessage(HWND_BROADCAST, WM_WININICHANGE, 0, LongInt(@S));
    end;

Взято с <https://delphiworld.narod.ru>

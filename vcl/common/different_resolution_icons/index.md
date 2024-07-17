---
Title: Как заставить приложение показывать различные иконки при различных разрешениях дисплея?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как заставить приложение показывать различные иконки при различных разрешениях дисплея?
=======================================================================================

Для этого достаточно текущее разрешение экрана и в соответствии с ним
изменить дескриптор иконки приложения. Естевственно, что Вам прийдётся
создать в ресурсах новые иконки.

Поместите следующий код в файл проекта (.DPR) Вашего приложения:

    Application.Initialize;
    Application.CreateForm(TForm1, Form1);
    case GetDeviceCaps(GetDC(Form1.Handle), HORZRES) of
      640: Application.Icon.Handle := LoadIcon(hInstance, 'ICON640');
      800: Application.Icon.Handle := LoadIcon(hInstance, 'ICON800');
      1024: Application.Icon.Handle := LoadIcon(hInstance, 'ICON1024');
      1280: Application.Icon.Handle := LoadIcon(hInstance, 'ICON1280');
    end;
    Application.Run;


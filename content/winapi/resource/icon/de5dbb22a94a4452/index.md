---
Title: Изменение иконки приложения
Date: 01.01.2007
---

Изменение иконки приложения
===========================

::: {.date}
01.01.2007
:::

Присвойте свойству Application.Icon другую иконку и вызовите функцию

    InvalidateRect(Application.Handle, NIL, True); 

\... для немедленной перерисовки.

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

------------------------------------------------------------------------

Изменять иконку приложения или окна во время его работы

Изменять иконку приложения или окна достаточно просто - для этого у
TApplication и TForm предусмотрено свойство Icon. Смена иконки может
вестись обычным присвоением свойству Icon нового значения:

    Form1.Icon := Image1.Picture.Icon;

При этом происходит не присвоение указателя (как казалось бы), а
копирование данных посредством вызова Assign, который производится в
методе TForm.SetIcon

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

------------------------------------------------------------------------

Загрузка иконки из ресурса

Загрузка производится типовым вызовом API:

    Form1.Icon.Handle := LoadIcon(hInstance, 'имя иконки в ресурсе');

Причем имя в ресурсе желательно писать всегда в верхнем регистре

Все сказанное выше пригодно и для приложения, только в этом случае
вместо Form1 выступает Application. Для принудительной перерисовки
кнопки приложения в панеле задач можно применить вызов

    InvalidateRect(Application.Handle, nil, True);

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

------------------------------------------------------------------------

Пример организации простейшей анимации иконки приложения

    procedure TForm1.Timer1Timer(Sender: TObject);
    begin
      inc(IconIndex);
      case IconIndex of
        1 : Application.Icon.Assign(Image1.Picture.Icon);
        2 : Application.Icon.Assign(Image2.Picture.Icon);
        else IconIndex := 0;
      end;
      InvalidateRect(Application.Handle, nil, True);
    end;

При этом естественно предполагается, что в Image1 и Image2 загружены
иконки.

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

------------------------------------------------------------------------

Как заставить приложение показывать различные иконки при различных
разрешениях дисплея?

Для этого достаточно текущее разрешение экрана и в соответствии с ним
изменить дескриптор иконки приложения. Естественно, что Вам придется
создать в ресурсах новые иконки.

Поместите следующий код в файл проекта (.DPR) Вашего приложения:

    Application.Initialize;
    Application.CreateForm(TForm1, Form1);
    case GetDeviceCaps(GetDC(Form1.Handle), HORZRES) of
       640 : Application.Icon.Handle := LoadIcon (hInstance, 'ICON640');
       800 : Application.Icon.Handle := LoadIcon (hInstance, 'ICON800');
      1024 : Application.Icon.Handle := LoadIcon (hInstance, 'ICON1024');
      1280 : Application.Icon.Handle := LoadIcon (hInstance, 'ICON1280');
    end;
    Application.Run;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

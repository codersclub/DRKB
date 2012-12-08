---
Title: Растягивание иконки
Date: 01.01.2007
---

Растягивание иконки
===================

::: {.date}
01.01.2007
:::

StretchDraw не работает с иконками. В данной ситуации я бы поступил так:
рисовал бы иконку в Timage и затем назначал изображение другому,
большему Timage.

Пример кода:

    procedure TForm1.StringGrid1Click(Sender: TObject);
    begin
      Image1.Canvas.FillRect(Image1.Canvas.ClipRect);
      Image1.Canvas.Draw(0, 0,
      TIcon(StringGrid1.Objects
      [StringGrid1.Col, StringGrid1.Row]));
      Form2.Image1.Picture := Image1.Picture;
    end;
    {Примечание. Form2.Image1 имеет Stretch установленный
    в True и размер, бОльший размера иконки в 4 раза}

Дополнение

Андрей Бреслав пишет:

предложенный способ не работает, ибо компонента TImage использует тот же
метод StretchDraw, что и спрашивающий. Растянуть иконку можно так:

    procedure TForm1.Button1Click(Sender: TObject);
    var
      Bmp: TBitMap;
    begin
      Bmp:= TBitMap.Create;
      Bmp.Height:= GetSystemMetrics(SM_CYICON);
      Bmp.Width:= GetSystemMetrics(SM_CXICON);
      Bmp.Canvas.Draw(0,0, Image1.Picture.Icon);
      Image1.Picture.Bitmap:= Bmp;
      Bmp.Free;
    end;

Есть более человечный способ, чем просто рисовать в Image: функция
DrawIconEx Win32 API:

    procedure TForm1.Button1Click(Sender: TObject);
    begin
      DrawIconEx(Canvas.Handle, 5, 5, LoadIcon(0, IDI_APPLICATION),
        16, 32, 0, 0, DI_NORMAL);
    end;

Кстати, думаю, людям будет полезно знать по подробнее о DrawIconEx:
Рисует иконку или курсор в соответствии с заданными занчениями.

    function DrawIconEx(hdc: HDC; xLeft, yTop: Integer; hIcon: HICON;
      cxWidth, cyWidth: Integer; istepIfAniCur: UINT;
      hbrFlickerFreeDraw: HBRUSH; diFlags: UINT): BOOL; stdcall;

hdc - контекст устройства (TCanvas.Handle)

xLeft, yTop - координаты левого верхнего угла

hIcon - дескриптор объекта Windows - Icon

cxWidth, cyWidth - размеры

istepIfAniCur - (!) номер отображаемого кадра в анимированном курсоре

hbrFlickerFreeDraw - кисть

diFlags - сумма след. занчений:

DI\_COMPAT - буду благодарен, если объясните

DI\_DEFAULTSIZE - если cxWidth, cyWidth равны 0, рисует в default
размере

DI\_IMAGE - применяет одну часть кисти

DI\_MASK - применяет другую часть кисти

DI\_NORMAL = DI\_IMAGE and DI\_MASK - применяет обе части кисти

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

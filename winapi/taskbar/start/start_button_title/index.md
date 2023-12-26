---
Title: Как изменить заголовок кнопки «Пуск»
Date: 01.01.2007
---

Как изменить заголовок кнопки «Пуск»
====================================

::: {.date}
01.01.2007
:::

Для начала создайте какой-нибудь Bitmap, который вы будете натягивать на
кнопку \[т.к. такого понятия как \"заголовок кнопки ПУСК\" в
действительности не существует\], а та надпись, что находится на
стартовой кнопке, является рисунком. Создавая рисунок, учитывайте
размеры и то, что левая сторона должна быть \"плоской\", как у нас на
рисунке слева, это связано с особенностями наложения.

Далее займёмся проектом. Сначала объявляем глобальные переменные

    StartButton: hWnd;
    OldBitmap: THandle;
    NewImage: TPicture;

Затем описываем событие по создания окна \[OnCreate\]:

    procedure TForm1.FormCreate(Sender: TObject);
    begin
      NewImage := TPicture.create;
      NewImage.LoadFromFile('C:\Windows\delphi.BMP'); //здесь укажите путь к нужному файлу
      StartButton := FindWindowEx(FindWindow('Shell_TrayWnd', nil), 0, 'Button', nil);
      OldBitmap := SendMessage(StartButton, BM_SetImage, 0, NewImage.Bitmap.Handle);
    end;

Если вы делаете это на своей машине, то можете всё восстанавливать по
событию OnDestroy:

    procedure TForm1.FormDestroy(Sender: TObject);
    begin
      SendMessage(StartButton, BM_SetImage, 0, OldBitmap);
      NewImage.Free;
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

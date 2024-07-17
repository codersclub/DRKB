---
Title: Восстановление минимизированного приложения
Author: Song, Den
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Восстановление минимизированного приложения
===========================================

При минимизации формы я использую RxTrayIcon, чтобы при этом исчезла
кнопка из Панели задач вызываю ShowWindow(Application.Handle,SW\_HIDE).
Но вот незадача - не получается при восстановлении приложения (после
клика на TrayIcon) добиться, чтобы оно становилось поверх других окон и
обязательно было активным.

Дело оказалось в следующем : гасить Tray-иконку надо в последнюю
очередь, именно так все работает (ранее сначала гасил Tray-иконку, а уже потом
восттанавливал свое приложение).

Таким образом правильно работает следующий код:

    procedure TForm1.ApplicationMinimize(Sender : TObject);
    begin
     RxTrayIcon1.Show;
     ShowWindow(Application.Handle,SW_HIDE);
    end;
     
    procedure TForm1.RxTrayIcon1Click(Sender: TObject; Button: TMouseButton;
             Shift: TShiftState; X, Y: Integer);
    begin
     Application.Restore;
     SetForeGroundWindow(Application.MainForm.Handle);
     RxTrayIcon1.Hide;
    end;


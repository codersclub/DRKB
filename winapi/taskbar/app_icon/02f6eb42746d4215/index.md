---
Title: Рисование на минимизированной иконке
Author: Nick Hodges (Monterey, CA)
Date: 01.01.2007
---

Рисование на минимизированной иконке
====================================

::: {.date}
01.01.2007
:::

Автор: Nick Hodges (Monterey, CA)

Есть ли у кого пример рисования на иконке минимизированного приложения с
помощью Delphi?

Когда Delphi-приложение минимизировано, иконка, которая вы видите -
реальное главное окно, объект TApplication, поэтому вам необходимо
использовать переменную Application. Таким образом, чтобы удостовериться
что приложение минимизировано, вызовите IsIconic(Application.Handle).
Если функция возвратит True, значит так оно и есть. Для рисования на
иконке создайте обработчик события Application.OnMessage. Здесь вы
можете проверять наличие сообщения WM\_Paint и при его нахождении
отрисовывать иконку. Это должно выглядеть приблизительно так:

    ...
    { private declarations }
      procedure AppOnMessage(var Msg: TMsg; var Handled: Boolean);
    ...
     
    procedure TForm1.AppOnMessage(var Msg: TMsg; var Handled: Boolean);
    var
      DC: hDC;
      PS: TPaintStuff;
    begin
      if (Msg.Message = WM_PAINT) and IsIconic(Application.Handle) then
      begin
        DC := BeginPaint(Application.Handle, PS);
        ...осуществляем отрисовку с помощью вызовов Windows GDI...
     
        EndPaint(Application.Handle, PS);
        Handled := True;
      end;
    end;
     
    procedure TForm1.OnCreate(Sender: TObject);
    begin
      Application.OnMessage := AppOnMessage;
    end;

Код создан на основе алгоритма Neil Rubenking.

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

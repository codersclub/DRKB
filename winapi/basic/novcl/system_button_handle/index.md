---
Title: Перехват нажатия на системные кнопки формы (закрытие, минимизация окна и т.д.)
Date: 01.01.2007
---


Перехват нажатия на системные кнопки формы (закрытие, минимизация окна и т.д.)
==============================================================================

::: {.date}
01.01.2007
:::

Перехват нажатия на системные кнопки формы (закрытие , минимизация окна
и т.д.)

Сообщение WM\_SYSCOMMAND приходит перед выполнением соответствующей
команды,
что дает возможность переопределить код.

Описание :

WM\_SYSCOMMAND

    uCmdType = wParam;        // type of system command requested
    
    xPos = LOWORD(lParam);    // horizontal postion, in screen coordinates
    
    yPos = HIWORD(lParam);    // vertical postion, in screen coordinates

Например, перехват события минимизации окна приложения:

       Type TMain = class(TForm)
         ....
        protected
          Procedure WMGetSysCommand(var Message : TMessage); message WM_SYSCOMMAND;
        end;
       .....
       //----------------------------------------------------------------
       //   Обработка сообщения WM_SYSCOMMAND (перехват минимизации окна)
       //----------------------------------------------------------------
       Procedure TMain.WMGetSysCommand(var Message : TMessage) ;
       Begin
            IF (Message..wParam = SC_MINIMIZE)  
            Then Main.Visible:=False
            Else Inherited;
       End;

Взято с сайта <https://blackman.wp-club.net/>

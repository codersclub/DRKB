---
Title: Свернуть всё приложение при сворачивании неглавного окна
Author: Vemer, Vemer@mail.ru
Date: 17.03.2004
---


Свернуть всё приложение при сворачивании неглавного окна
===========================================================

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Сворачивает все приложение при сворачивании неглавного окна.
     
    Обработчик сообщении. При попытке свернуть окно - сворачивает все приложение.
    Предназначен для неглавных немодальных окон.
     
    Зависимости: Как у стандартной формы...
    Автор:       Vemer, Vemer@mail.ru, Петрозаводск
    Copyright:   создано на основе примеров на www.delphimaster.ru
    Дата:        17 марта 2004 г.
    ********************************************** }
     
    //Пишем в Private формы(неглавной);
    Procedure WMSysCommand(var message: TWMSysCommand); message WM_SysCommand;
     
    //Пишем в тексте программы:
    Procedure TF_Shop.WMSysCommand(var message: TWMSysCommand);
    begin
     If message.CmdType = SC_MINIMIZE then Application.Minimize
     Else Inherited;
    End;

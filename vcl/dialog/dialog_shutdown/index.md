---
Title: Как вызвать диалог Shutdown Windows?
Date: 01.01.2007
---


Как вызвать диалог Shutdown Windows?
====================================

Вариант 1:

Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>

    uses ComObj;
     
    {....}
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      shell: Variant;
    begin
      shell := CreateOleObject('Shell.Application');
      shell.ShutdownWindows;
    end;


------------------------------------------------------------------------

Вариант 2:

Author: Gua, gua@ukr.net

Date: 18.07.2002

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Открытие диалогового окна "Завершение работы Windows"
     
    Зависимости: Windows,Messages
    Автор:       Gua, gua@ukr.net, ICQ:141585495, Simferopol
    Copyright:   Gua
    Дата:        18 июля 2002 г.
    ********************************************** }
     
    procedure ShutDownWindow;
    begin
      SendMessage(FindWindow('Progman','Program Manager'),WM_CLOSE,0,0);
    end;

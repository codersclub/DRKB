---
Title: Как вызвать Shutdown Windows диалог?
Date: 01.01.2007
---


Как вызвать Shutdown Windows диалог?
====================================

::: {.date}
01.01.2007
:::

    uses ComObj;
     
    {....}
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      shell: Variant;
    begin
      shell := CreateOleObject('Shell.Application');
      shell.ShutdownWindows;
    end;

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>

------------------------------------------------------------------------

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

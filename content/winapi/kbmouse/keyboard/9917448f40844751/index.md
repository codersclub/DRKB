---
Title: Как узнать о нажатии NON-MENU клавиши в момент, когда меню показано?
Date: 01.01.2007
---


Как узнать о нажатии NON-MENU клавиши в момент, когда меню показано?
====================================================================

::: {.date}
01.01.2007
:::

Создайте обработчик сообщения WM\_MENUCHAR.

    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls,
      Forms, Dialogs, Menus;
     
    type
      TForm1 = class(TForm)
        MainMenu1: TMainMenu;
        One1: TMenuItem;
        Two1: TMenuItem;
        THree1: TMenuItem;
      private
        {Private declarations}
        procedure WmMenuChar(var m : TMessage); message WM_MENUCHAR;
      public
      {Public declarations}
    end;
     
    var
      Form1: TForm1;
     
    implementation
    {$R *.DFM}
     
    procedure TForm1.WmMenuChar(var m: TMessage);
    begin
      Form1.Caption := 'Non standard menu key pressed';
      m.Result := 1;
    end;
     
    end.
     
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

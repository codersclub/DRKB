---
Title: Как выделить кнопку в TDBNavigator программно?
Author: Vit
Date: 01.01.2007
---


Как выделить кнопку в TDBNavigator программно?
==============================================

::: {.date}
01.01.2007
:::

    type TFake=class(TDBNavigator);
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      TFake(DBNavigator1).buttons[nbNext].Perform(WM_RBUTTONDOWN,0,0);
      TFake(DBNavigator1).buttons[nbNext].Perform(WM_RBUTTONUP,0,0);
    end;

Автор: Vit

Взято с Vingrad.ru <https://forum.vingrad.ru>

---
Title: Как выделить кнопку в TDBNavigator программно?
Author: Vit
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Как выделить кнопку в TDBNavigator программно?
==============================================

    type TFake=class(TDBNavigator);
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      TFake(DBNavigator1).buttons[nbNext].Perform(WM_RBUTTONDOWN,0,0);
      TFake(DBNavigator1).buttons[nbNext].Perform(WM_RBUTTONUP,0,0);
    end;


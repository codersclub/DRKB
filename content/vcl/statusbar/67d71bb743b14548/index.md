---
Title: В строке состояния TStatusBar выводится только 127 символов
Author: Mikel
Date: 01.01.2007
---


В строке состояния TStatusBar выводится только 127 символов
===========================================================

::: {.date}
01.01.2007
:::

В строке состояния TStatusBar выводится только 127 символов.

Можно ли как-нибудь увеличить это число?

    procedure TForm1.Button1Click(Sender: TObject);
     
     var i:integer;
          s:string;
    begin
      s:='';
      for i:=1 to 150 do
        s:=s+inttostr(i mod 10);
      label1.Caption:=s;
      form1.Paint;
    end;
     
    procedure TForm1.FormPaint(Sender: TObject);
    begin
      label1.Repaint;
      application.processmessages;{yield;}
      statusbar1.Canvas.CopyRect(rect(2,round((statusbar1.height- label1.height)/2),label1.width,label1.height),
    label1.canvas,rect(0,0,label1.width,label1.height));
    end;

Автор: Mikel

Взято с Vingrad.ru <https://forum.vingrad.ru>

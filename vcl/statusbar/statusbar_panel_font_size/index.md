---
Title: Установить размер шрифта для панели TStatusBar
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Установить размер шрифта для панели TStatusBar
==============================================

    With StatusBar1.Panels[1] do
    begin
      Text := Edit1.Text;
      Canvas.Font.Size := StatusBar1.Font.Size;
      Width := Canvas.TextWidth(Text) + 10;
    end;



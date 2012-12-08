---
Title: Как сделать окошко подсказки в редакторе как Delphi по Ctrl-J
Author: Hog
Date: 01.01.2007
---


Как сделать окошко подсказки в редакторе как Delphi по Ctrl-J
=============================================================

::: {.date}
01.01.2007
:::

Автор: Hog

Допустим у тебя TMemo..

1\. Делаешь ListBox, заполняешь, visible := false, parent := Memo

2\. У Memo в обработчике Memo.onKeyDown что-нибудь типа:

    if (key = Ord('J')) and (ssCtrl in Shift) then
    begin
      lb.Left := Memo.CaretPos.x;
      lb.Top := Memo.CaretPos.y + lb.height;
      lb.Visible := True;
      lb.SetFocus;
    end;

он показывается.. а дальше работай с листбоксом, вставляй в мемо нужный
текст, пряч листбокс

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

---
Title: Чередование фона строк в TListView
Author: Subfire, subfire@mail.ru
Date: 19.02.2003
---


Чередование фона строк в TListView
==================================

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Чередование фона строк в TListView
     
    Да какое описание...
    Вообщем можно просто copy/past сделать...
    Хотя реализация не оптимальная, но общая идея - та что нужна =)))
     
    Зависимости: нету =)
    Автор:       Subfire, subfire@mail.ru, Питер
    Copyright:   =) не нужно
    Дата:        19 февраля 2003 г.
    ***************************************************** }
     
    procedure TForm1.ListView1CustomDrawItem(Sender: TCustomListView;
      Item: TListItem; State: TCustomDrawState; var DefaultDraw: Boolean);
    var
      i: word;
    begin
      if item = nil then
        EXIT;
      i := Item.Index;
      if trunc((i) / 2) < (i / 2) then
        sender.canvas.brush.Color := cl3DLight
      else
        sender.canvas.brush.Color := clwhite;
    end;

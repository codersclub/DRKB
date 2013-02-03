---
Title: Как переместить каретку TMemo в нужную строку?
Author: Vit
Date: 01.01.2007
---


Как переместить каретку TMemo в нужную строку?
==============================================

::: {.date}
01.01.2007
:::

    function SetCaretPosition(memo:TMemo; x,y:integer);
    var i:integer;
    begin
      i := SendMessage(memo.Handle, EM_LINEINDEX, y, 0) + x;
      SendMessage(memo1.Handle, EM_SETSEL, i, i);
    end;

или

    type TFake=class(TCustomMemo);
    ....
    TFake(MyMemo).SetCaretPos()

Автор: Vit

Взято с Vingrad.ru <https://forum.vingrad.ru>

---
Title: Как переместить каретку TMemo в нужную строку?
Author: Vit
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Как переместить каретку TMemo в нужную строку?
==============================================

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


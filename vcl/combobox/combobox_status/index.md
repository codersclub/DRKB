---
Title: Как определить состояние списка ComboBox, выпал / скрыт?
Date: 01.01.2007
---


Как определить состояние списка ComboBox, выпал / скрыт?
=======================================================

Пошлите ComboBox сообщение CB\_GETDROPPEDSTATE.

    if SendMessage(ComboBox1.Handle, CB_GETDROPPEDSTATE, 0, 0) = 1 then
    begin
      {список ComboBox выпал}
      ...
    end;

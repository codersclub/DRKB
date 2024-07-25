---
Title: Как ограничить подвижность формы
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как ограничить подвижность формы
============================

Странно, но по какой-то причине в messages.pas
нет объявления записи для этого сообщения.

    type
      TWmMoving = record
        Msg: Cardinal;
        fwSide: Cardinal;
        lpRect: PRect;
        Result: Integer;
      end;
     
    // Добавьте обработчик в приватный раздел вашей формы:
     
    procedure WMMoving(var msg: TWMMoving); message WM_MOVING;
     
    // Реализуйте это следующим образом:
     
      procedure TFormX.WMMoving(var msg: TWMMoving);
      var
        r: TRect;
      begin
        r := Screen.WorkareaRect;
        // при необходимости сравните новые границы формы
        // в msg.lpRect^ с r и измените их
        if msg.lprect^.left < r.left then
          OffsetRect(msg.lprect^, r.left - msg.lprect^.left, 0);
        if msg.lprect^.top < r.top then
          OffsetRect(msg.lprect^, 0, r.top - msg.lprect^.top);
        if msg.lprect^.right > r.right then
          OffsetRect(msg.lprect^, r.right - msg.lprect^.right, 0);
        if msg.lprect^.bottom > r.bottom then
          OffsetRect(msg.lprect^, 0, r.bottom - msg.lprect^.bottom);
        inherited;
      end;


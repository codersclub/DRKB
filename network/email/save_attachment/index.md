---
Title: При чтении почты POP3 отделять Attachment и сохранять в файл
Date: 01.01.2007
Source: http://articles.org.ru/
---


При чтении почты POP3 отделять Attachment и сохранять в файл
============================================================

Почту читаю, используя компонент tnmpop3 (стандартный в поставке d5),
еще пробовал использовать библитеку indy, но не помогло. А проблема
заключается в том, что после прочтения письма, невозможно отделить
аттачмент от тела. Но это происходит не со всеми письмами. Если я
отправлю письмо с аттачем, то я могу его нормально читать и разбирать, а
если отправляет Заказчик, то получается то, что я описал. Причем,
outlook и thebat, эти письма нормально читают и аттач МОЖНО сохранить.

    for intindex := 0 to pred(msg.messageparts.count) do
    begin
      if (msg.messageparts.items[intindex] is tidattachment) then
      begin //general attachment
        tidattachment(msg.messageparts.items[intindex]).savetofile(
        tidattachment(msg.messageparts.items[intindex]).filename);
        tidattachment.create(msg1.messageparts,
        tidattachment(msg.messageparts.items[intindex]).filename);
      end
      else
      begin //body text
        if msg.messageparts.items[intindex] is tidtext then
        begin
          memo1.lines.clear;
          memo1.lines.addstrings(tidtext(msg.messageparts.items[intindex]).body);
        end
      end;
    end;


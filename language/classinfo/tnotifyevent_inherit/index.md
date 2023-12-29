---
Title: Как определить, является ли метод потомком TNotifyEvent?
Date: 01.01.2007
---


Как определить, является ли метод потомком TNotifyEvent?
========================================================

::: {.date}
01.01.2007
:::

If I am given a TPersistent object, and a method name, is there a way to
determine if the name is an event of TNotifyEvent type? For example,
given a TPersistent lMyObj and an event name, "OnDataChanged", how can
I determine if OnDataChanged is a TNotifyEvent?

    function IsNotifyEvent(Sender: TObject; const Event: string): Boolean;
    var
      PropInfo: PPropInfo;
      Method: TNotifyEvent;
    begin
      Result := False;
      PropInfo := GetPropInfo(Sender.ClassInfo, Event);
      if not Assigned(PropInfo) then
        Exit;
      if PropInfo.PropType^.Kind <> tkMethod then
        Exit;
      Method := TNotifyEvent(GetMethodProp(Sender, PropInfo));
      Result := Assigned(Method);
    end;

Tip by Jack Sudarev

Взято из <https://www.lmc-mediaagentur.de/dpool>

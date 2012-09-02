<h1>Как определить, является ли метод потомком TNotifyEvent?</h1>
<div class="date">01.01.2007</div>


<p>If I am given a TPersistent object, and a method name, is there a way to determine if the name is an event of TNotifyEvent type? For example, given a TPersistent lMyObj and an event name, "OnDataChanged", how can I determine if OnDataChanged is a TNotifyEvent?</p>

<pre>
function IsNotifyEvent(Sender: TObject; const Event: string): Boolean;
var
  PropInfo: PPropInfo;
  Method: TNotifyEvent;
begin
  Result := False;
  PropInfo := GetPropInfo(Sender.ClassInfo, Event);
  if not Assigned(PropInfo) then
    Exit;
  if PropInfo.PropType^.Kind &lt;&gt; tkMethod then
    Exit;
  Method := TNotifyEvent(GetMethodProp(Sender, PropInfo));
  Result := Assigned(Method);
end;
</pre>



<p>Tip by Jack Sudarev</p>
<p>Взято из <a href="https://www.lmc-mediaagentur.de/dpool" target="_blank">https://www.lmc-mediaagentur.de/dpool</a></p>

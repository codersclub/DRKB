<h1>Как определить, нажата ли в данный момент клавиша Shift, Ctrl или Alt?</h1>
<div class="date">01.01.2007</div>


<p>Следующий пример демонстрирует проверку состояния клавиши Shift (нажата она или нет), в то время когда выделен пункт меню. А так же в примере содержатся функции, позволяющие определить состояние клавишь Alt, Ctrl, и shift:</p>
<pre>
function CtrlDown : Boolean;
var
  State : TKeyboardState;
begin
  GetKeyboardState(State);
  Result := ((State[vk_Control] And 128) &lt;&gt; 0);
end;
 
function ShiftDown : Boolean;
var
  State : TKeyboardState;
begin
  GetKeyboardState(State);
  Result := ((State[vk_Shift] and 128) &lt;&gt; 0);
end;
 
function AltDown : Boolean;
var
  State : TKeyboardState;
begin
  GetKeyboardState(State);
  Result := ((State[vk_Menu] and 128) &lt;&gt; 0);
end;
 
procedure TForm1.MenuItem12Click(Sender: TObject);
begin
  if ShiftDown then
    Form1.Caption := 'Shift' else
    Form1.Caption := '';
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>


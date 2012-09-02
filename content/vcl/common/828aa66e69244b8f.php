<h1>Можно ли как-то уменьшить мерцание при перерисовке компонента?</h1>
<div class="date">01.01.2007</div>


<p>Если добавить флаг csOpaque (непрозрачный) к свойству ControlStyle компонента</p>
<p>- то фон компонента перерисовываться не будет.</p>
<pre>
constructor TMyControl.Create;
begin
  inherited;
  ControlStyle := ControlStyle + [csOpaque];
end;
</pre>


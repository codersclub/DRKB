<h1>Кнопка со звуком</h1>
<div class="date">01.01.2007</div>


<p>Когда Вы нажимаете на кнопку, то видите трёхмерный эффект нажатия. А как же насчёт четвёртого измерения, например звука ? Ну тогда нам понадобится звук для нажатия и звук для отпускания кнопки. Если есть желание, то можно добавить даже речевую подсказку, однако не будем сильно углубляться.</p>

<p>Компонент звуковой кнопки имеет два новых свойства:</p>
<pre>
type
  TDdhSoundButton = class(TButton)
  private
    FSoundUp, FSoundDown: string;
  protected
    procedure MouseDown(Button: TMouseButton;
      Shift: TShiftState; X, Y: Integer); override;
    procedure MouseUp(Button: TMouseButton;
      Shift: TShiftState; X, Y: Integer); override;
  published
    property SoundUp: string
      read FSoundUp write FSoundUp;
    property SoundDown: string
      read FSoundDown write FSoundDown;
  end;
</pre>

<p>Звуки будут проигрываться при нажатии и отпускании кнопки:</p>
<pre>
procedure TDdhSoundButton.MouseDown(
  Button: TMouseButton;
  Shift: TShiftState; X, Y: Integer);
begin
  inherited;
  PlaySound (PChar (FSoundDown), 0, snd_Async);
end;
 
procedure TDdhSoundButton.MouseUp(Button: TMouseButton;
  Shift: TShiftState; X, Y: Integer);
begin
  inherited;
  PlaySound (PChar (FSoundUp), 0, snd_Async);
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>


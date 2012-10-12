<h1>TStatusBar с другими контролами</h1>
<div class="date">01.01.2007</div>


<p>Этот StatusBar позволит размещать на себе любые другие контролы.</p>
<p>Создаем новый компонент от StatusBar и првим код как внизу. Потом инсталлируем и все.</p>
<pre>
unit StatusBarExt;
 
interface
 
uses Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs, ComCtrls;
 
type
  TStatusBarExt = class(TStatusBar)
public
  constructor Create(AOwner: TComponent); override; // добавить конструктор
end;
 
procedure Register;
 
implementation
 
uses Consts; // не забыть
 
constructor TStatusBarExt.Create( AOwner : TComponent );
begin
  inherited Create(AOwner);
  ControlStyle := ControlStyle + [csAcceptsControls]; // собственно все!
end;
 
procedure Register;
begin
  RegisterComponents('Samples', [TStatusBarExt]);
end;
 
end.
</pre>

<p class="author">Автор: man2002ua </p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

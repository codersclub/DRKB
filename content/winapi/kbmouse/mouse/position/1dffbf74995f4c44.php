<h1>Как отследить выход мыши за пределы формы?</h1>
<div class="date">01.01.2007</div>


<p>Можно через события OnMouseEnter/OnMouseLeave:</p>

<pre>
TYourObject = class(TAnyControl)
...
private
FMouseInPos : Boolean;
procedure CMMouseEnter(var AMsg: TMessage); message CM_MOUSEENTER;
procedure CMMouseLeave(var AMsg: TMessage); message CM_MOUSELEAVE;
...
end;
 
implementation
 
 
procedure TYourObject.CMMouseEnter(var AMsg: TMessage);
begin
FMouseInPos := True;
Refresh;
end;
 
 
procedure TYourObject.CMMouseLeave(var AMsg: TMessage);
begin
FMouseInPos := False;
Refresh;
end;
</pre>

<p>Затем считывать параметр FMouseInPos.</p>

<p>Взято с сайта <a href="https://blackman.wp-club.net/" target="_blank">https://blackman.wp-club.net/</a></p>

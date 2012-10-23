<h1>Подсветка компонента во время перемещения над ним мыши</h1>
<div class="date">01.01.2007</div>

Вы должны обрабатывать сообщения CM_MOUSEENTER и CM_MOUSELEAVE примерно таким образом:</p>
<pre>
TYourObject = class(TAnyControl)
  ...
  private
  FMouseInPos: Boolean;
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
<p>...затем читать параметр FMouseInPos при прорисовке области компонента или использовать иное решение.</p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

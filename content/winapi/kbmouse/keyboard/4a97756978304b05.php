<h1>Как отличить нажат правый или левый CTRL?</h1>
<div class="date">01.01.2007</div>

Для того, чтобы отличить нажат левый или правый Ctrl, нужно перехватить событие WM_KEYDOWN. В зависимости от состояния 24-ого бита параметра LParam нажата правая или левая клавиша. </p>
<pre>
public
  procedure WMKEYDOWN(var msg: TMessage); message WM_KEYDOWN;
end;
 
var
  Form1: TForm1;
 
implementation
 
{$R *.DFM}
 
procedure TForm1.WMKEYDOWN(var msg: TMessage);
begin
  if (msg.LParam and (255 shl 16)) shr 16 &lt;&gt; 29 then
    Exit;
  if msg.LParam and (1 shl 24) &gt; 0 then
    Form1.Caption := 'Right'
  else
    Form1.Caption := 'Left';
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>


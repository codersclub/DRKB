<h1>Как отловить правый Enter (NumPad)</h1>
<div class="date">01.01.2007</div>

Для этого можно воспользоваться функцией GetHeapStatus:</p>
<pre>
procedure TForm1.WMKeyDown(var message: TWMKeyDown);
begin
  inherited;
  case message.CharCode of
    VK_RETURN:
    begin
      if (message.KeyData and $1000000 &lt;&gt; 0) then
      begin
        { ENTER on numeric keypad }
      end
      else
      begin
        { ENTER on the standard keyboard }
      end;
    end;
  end;
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>


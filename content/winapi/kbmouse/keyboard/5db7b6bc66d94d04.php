<h1>Как отловить правый Enter (NumPad)?</h1>
<div class="date">01.01.2007</div>


<p class="author">Автор: Full ( http://full.hotmail.ru/ )</p>
<p>Для этого можно воспользоваться функцией GetHeapStatus:</p>
<pre>
procedure TForm1.WMKeyDown(var Message: TWMKeyDown);
begin
  inherited;
  case Message.CharCode of
    VK_RETURN:
      begin // ENTER pressed
        if (Message.KeyData and $1000000 &lt;&gt; 0) then
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

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>


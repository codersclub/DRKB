<h1>Как узнать состояние клавиши CAPS LOCK?</h1>
<div class="date">01.01.2007</div>


<pre>
function IsCapsLockOn : Boolean; 
begin 
  Result := 0 &lt;&gt; (GetKeyState(VK_CAPITAL) and $01); 
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

<hr />
<pre>
procedure AppOnIdle(Sender: TObject; var Done: Boolean);
 
...
 
procedure TForm1.AppOnIdle(Sender: TObject; var Done: Boolean);
begin
  CheckBox1.Checked := Odd(GetKeyState(VK_CAPITAL));
  CheckBox2.Checked := Odd(GetKeyState(VK_SHIFT));
  CheckBox3.Checked := Odd(GetKeyState(VK_NUMLOCK));
  CheckBox4.Checked := Odd(GetKeyState(VK_SCROLL));
  Done := False;
end;
 
procedure TForm1.FormCreate(Sender: TObject);
begin
  Application.OnIdle := AppOnIdle;
end;
</pre>

<a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>


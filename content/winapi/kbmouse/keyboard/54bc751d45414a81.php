<h1>Как отключить комбинацию Alt+Tab</h1>
<div class="date">01.01.2007</div>

<p>Если вы хотите зло подшутить над глупым пользователем, а он оказывается не такой уж и глупый, и усиленно пытается переключиться на другую программу, вы можете круто его обломать: </p>
<pre>
procedure TurnSysKeysOff;
var
  OldVal: LongInt;
begin
  SystemParametersInfo (97, Word (True), @OldVal, 0);
end;
 
procedure TurnSysKeysBackOn;
var
  OldVal: LongInt;
begin
  SystemParametersInfo (97, Word (False), @OldVal, 0);
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>


<h1>Как вызвать диалог свойств файла?</h1>
<div class="date">01.01.2007</div>


<pre>
Procedure ShowFileProperties(Const filename: String);
Var
  sei: TShellExecuteinfo;
Begin
  FillChar(sei,sizeof(sei),0);
  sei.cbSize := sizeof(sei);
  sei.lpFile := Pchar(filename);
  sei.lpVerb := 'properties';
  sei.fMask  := SEE_MASK_INVOKEIDLIST;
  ShellExecuteEx(@sei);
End;
</pre>
</p>

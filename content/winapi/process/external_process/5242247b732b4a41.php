<h1>Функция передачи строк (а заодно и числа) между программами через SendMessage</h1>
<div class="date">01.01.2007</div>


<pre>
Function SendString(TargetWnd, SourceWnd: THandle; N: Integer; Const S: String): Integer;
Var
  CD: TCopyDataStruct;
Begin
  CD.dwData := N;
  CD.cbData := Length(S);
  If CD.cbData = 0  Then
    CD.lpData := NIL
  Else CD.lpData := @S[1];
  Result := SendMessage(TargetWnd, WM_COPYDATA, SourceWnd, Integer(@CD));
End;
...
Procedure WMCopyData(Var Msg: TWMCopyData); Message WM_COPYDATA;
...
Procedure TForm1.WMCopyData(var Msg: TWMCopyData);
Var
 { Строка }
  S: String;
 { Число }
  N: Integer;
Begin
  If (Msg.CopyDataStruct^).lpData = NIL Then S := ''; 
  SetLength(S,Msg.CopyDataStruct^.cbData);
  S := String((Msg.CopyDataStruct^).lpData);
  N := (Msg.CopyDataStruct^).dwData;
End;
</pre>
<div class="author">Автор: Rrader</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

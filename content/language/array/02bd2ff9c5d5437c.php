<h1>String &gt; Array</h1>
<div class="date">01.01.2007</div>


<pre>
Procedure AssignFixedString( Var FixedStr: Array of Char; Const S: String
);
Var
  maxlen: Integer;
Begin
  maxlen := Succ( High( FixedStr ) - Low( FixedStr ));
  FillChar( FixedStr, maxlen, ' ' ); { blank fixed string }
  If Length(S) &gt; maxlen Then
    Move( S[1], FixedStr, maxlen )
  Else
    Move( S[1], FixedStr, Length(S));
End;
</pre>
&nbsp;</p>
<hr />
<pre>
function StrToArrays(str, r: string; out Temp: TStrings): Boolean;
var
  j: integer;
begin
  if temp &lt;&gt; nil then
  begin
    temp.Clear;
    while str &lt;&gt; '' do
    begin
      j := Pos(r,str);
      if j=0 then
        j := Length(str) + 1;
      temp.Add(Copy(Str,1,j-1));
      Delete(Str,1,j+length(r)-1);
    end;
    Result:=True;
  end
  else
    Result:=False;
end;
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>


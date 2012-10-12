<h1>Как получить URL?</h1>
<div class="date">01.01.2007</div>


<p>TWebBrowser.После нажатия кнопки на web форме формируется ссылка на какуюто страницу с параметрами,а с этой страницы уже происходит перенаправление на результирующую страницу. Хотелось бы увидеть ссылку на страницу вместе с параметрами. </p>
<pre>
function GetPostParam(const PostData: OleVariant): string;
var
  V: Variant;
  P: PChar;
  lb, hb, i: Integer;
begin
V:=Variant(TVarData(PostData).VPointer^);
if VarIsArray(V) then begin
 P:=VarArrayLock(V);
  try
   lb := VarArrayLowBound(V, 1);
   hb := VarArrayHighBound(V, 1);
   SetString(Result, P, hb - lb + 1);
   for i := 1 to Length(Result) do if Result[i] = #0 then begin
   SetLength(Result, i - 1); Break; end; Exit;
  finally  VarArrayUnlock(V);   end;
 end;
Result:= '';
end;
</pre>

<p class="author">Автор: P.O.D.</p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

<h1>Обрезание строки по длине</h1>
<div class="date">01.01.2007</div>

<p class="author">Автор: ___Nikolay</p>
<pre>
// Обрезание строки по длине
function TfmDW6Main.BeautyStr(s: string; iLength: integer): string;
var
  bm: TBitmap;
  sResult: string;
  iStrLen: integer;
  bAdd: boolean;
begin
  Result := s;
  if Trim(s) = '' then
    exit;
 
  bAdd := false;
    sResult := s;
  bm := TBitmap.Create;
  bm.Width := 100;
  bm.Height := 100;
  iStrLen := bm.Canvas.TextWidth(sResult);
  while iStrLen &gt; iLength do
  begin
    if Length(sResult) &lt; 4 then
      break;
 
    Delete(sResult, Length(sResult) - 2, 3);
    bAdd := true;
    iStrLen := bm.Canvas.TextWidth(sResult);
  end;
 
  if (iStrLen &lt;= iLength) and bAdd then
    sResult := sResult + '...';
 
  bm.Free;
  Result := sResult;
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
&nbsp;</p>

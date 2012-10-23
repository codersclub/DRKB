<h1>Как преобразовать String в Binary и наоборот?</h1>
<div class="date">01.01.2007</div>


<div class="author">Автор: Rem </div>
<pre>
function BinStrToByte(a_sBinStr: string): byte;
var
 i: integer;
begin
 Result := 0;
 for i := 1 to length(a_sBinStr) do
   Result := (Result shl 1) or byte(a_sBinStr[i] = '1');
end;
 
function ByteToBinStr(a_bByte: byte): string;
var
 i: integer;
begin
 SetLength(Result, 8);
 for i := 8 downto 1 do
 begin
   Result[i] := chr($30 + (a_bByte and 1));
   a_bByte := a_bByte shr 1;
 end;
end;
 
// Примечание: вторая функция использует тот факт,
// что в таблице ANSI коды '0' = $30 и '1' = $31
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

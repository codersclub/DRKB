<h1>String &gt; PWideChar</h1>
<div class="date">01.01.2007</div>


<pre>
 
{ **** UBPFD *********** by kladovka.net.ru ****
&gt;&gt; Конвертация String в PWideChar
 
Зависимости: ???
Автор:       Gua, gua@ukr.net, ICQ:141585495, Simferopol
Copyright:   Andre .v.d. Merwe
Дата:        18 июля 2002 г.
********************************************** }
 
function StringToPWide( sStr: string; var iNewSize: integer ): PWideChar;
var
  pw : PWideChar;
  iSize : integer;
begin
  iSize := Length( sStr ) + 1;
  iNewSize := iSize * 2;
 
  pw := AllocMem( iNewSize );
 
  MultiByteToWideChar( CP_ACP, 0, PChar(sStr), iSize, pw, iNewSize );
 
  Result := pw;
end; 
</pre>
<p> Пример использования:</p>
<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
   iSize: integer;
begin
  ChangeWallpaper(StringToPWide('C:\1.jpg',iSize));
end; 
</pre>


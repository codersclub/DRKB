<h1>Функция наполнения строки</h1>
<div class="date">01.01.2007</div>


<pre>
function Spcs(num : byte) : string;
var
  tmp : string;
begin
  fillchar(tmp, num+1, ' ');  {инициализация всей строки пробелами}
  tmp[0] := chr(num);         {устанавливаем длину строки с пробелами}
  result := tmp;
end;
 
 
//Теперь достаточно написать 
 
 
Edit1.Text := SurName + spcs(10) + FirstName
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
</p>
<hr />
<p>Решением является создание функции, функционально похожей на функцию Clipper:</p>
<p>PadL(string, width, character)</p>
<pre>function TfrmFunc.PadL(cVal: string; nWide: integer; cChr: char): string;
var
  i1, nStart: integer;
begin
  if length(cVal) &lt; nWide then
  begin
    nStart:=length(cVal);
    for i1:=nStart to nWide-1 do
      cVal:=cChar+cVal;
  end;
  PadL:=cVal;
end;
 
</pre>

<p>Затем это может вызываться c любой строкой, которой вы хотите задать определенную длину. Пользуйтесь функцией также, как вы привыкли пользоваться прежней - PadL(A,length(B),'0'); Она имеет большую гибкость - возможно заполнение любым символом до необходимой длины (удобно для задания текстовых счетчиков с фиксированным количеством символов -- PadL(A,6,'0').</p>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
</p>
</p>
<hr />
<pre>
function LeftPad(S: string; Ch: Char; Len: Integer): string;
 var
   RestLen: Integer;
 begin
   Result  := S;
   RestLen := Len - Length(s);
   if RestLen &lt; 1 then Exit;
   Result := S + StringOfChar(Ch, RestLen);
 end;
 
 function RightPad(S: string; Ch: Char; Len: Integer): string;
 var
   RestLen: Integer;
 begin
   Result  := S;
   RestLen := Len - Length(s);
   if RestLen &lt; 1 then Exit;
   Result := StringOfChar(Ch, RestLen) + S;
 end;
 
 {Beispiel / Example}
 
 procedure TForm1.Button1Click(Sender: TObject);
 begin
   Edit1.Text := Rightpad(Edit2.Text, '-', 30);
 end;
</pre>

<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
</p>

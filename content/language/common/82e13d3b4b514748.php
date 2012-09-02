<h1>Использование PosEx взамен Pos</h1>
<div class="date">01.01.2007</div>


<p>В Delphi 7 в модуле StrUtils внесены некоторые изменения. </p>
<p>Есть новая функция: PosEx.</p>
<p>Обьявление этих функций:</p>
<pre>
function Pos(Substr: String; S: String): Integer;
function PosEx(Const SubStr, S: String; Offset: Cardinal = 1): Integer;
</pre>
<p>Новая функция PosEx, позволяет указать начальную позицию поиска внутри строки, что избавит вас от необходимости изменения исходной строки. Незабудьте указать модуль StrUtils.</p>
<p>Ниже приведена реализация функции в модуле StrUtils (если вы используете более старшую версию среди разработки вы сможете сами добавить этот код и использовать его вместо функции Pos):</p>
<pre>
function PosEx(Const SubStr, S: String; Offset: Cardinal = 1): Integer;
var
  I,X: Integer;
  Len, LenSubStr: Integer;
begin
  if Offset = 1 then
    Result := Pos(SubStr, S)
  else
  begin
    I := Offset;
    LenSubStr := Length(SubStr);
    Len := Length(S) - LenSubStr + 1;
    while I &lt;= Len do
    begin
      if S[I] = SubStr[1] then
      begin
        X := 1;
        while (X &lt; LenSubStr) and (S[I + X] = SubStr[X + 1]) do
          Inc(X);
        if (X = LenSubStr) then
        begin
          Result := I;
          Exit;
        end;
      end;
      Inc(I);
    end;
    Result := 0;
  end;
end;
</pre>
<p class="author">Автор RoboSol</p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

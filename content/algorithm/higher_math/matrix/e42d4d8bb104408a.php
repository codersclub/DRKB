<h1>Как заменить строку в матрице?</h1>
<div class="date">01.01.2007</div>


<pre>
program Matrices;
 
{$APPTYPE CONSOLE}
 
uses
  SysUtils;
 
type
  TMatrixRow = Array of Double;  {preferrable to Real}
  TMatrix = Array of TMatrixRow;
 
 
procedure MatrixExchangeRows(M: TMatrix; First, Second: Integer);
var
  Help: TMatrixRow;
begin
  if (First &lt; 0) or (First &gt; High(M)) or (Second &lt; 0) or (Second &gt; High(M)) then
    Exit;  {or whatever you like.}
  {Only pointers are exchanged!}
  Help := M[First];
  M[First] := M[Second];
  M[Second] := Help;
end;
 
 
procedure MatrixWrite(M: TMatrix);
var
  Row, Col: Integer;
begin
  for Row := 0 to High(M) do
  begin
    for Col := 0 to High(M[Row]) do
      Write(M[Row, Col]:10:2);
    Writeln;
  end;
  Writeln;
end;
 
var
  Matrix: TMatrix;
  Row, Column: Integer;
 
begin
  Randomize;
  SetLength(Matrix, 4, 4);
  for Row := 0 to High(Matrix) do
    for Column := 0 to High(Matrix[Row]) do
      Matrix[Row, Column] := Random * 1000.0;
  MatrixWrite(Matrix);
  MatrixExchangeRows(Matrix, 1, 2);
  MatrixWrite(Matrix);
  Readln;
end.
</pre>

<p>Взято из <a href="https://www.lmc-mediaagentur.de/dpool" target="_blank">https://www.lmc-mediaagentur.de/dpool</a></p>

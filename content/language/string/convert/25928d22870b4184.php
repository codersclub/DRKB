<h1>String &gt; TStringList</h1>
<div class="date">01.01.2007</div>


<pre>
{ **** UBPFD *********** by delphibase.endimus.com ****
&gt;&gt; Преобразование строки с разделителями в StringList.
 
Преобразование строки с разделителями в StringList или наследник TStrings.
Навеяно одноименной процедурой из InfoPower :-)
 
Зависимости: Classes
Автор:       Игорь Шевченко, whitefranz@hotmail.com, Москва
Copyright:   Игорь Шевченко, Woll2Woll software (original)
Дата:        30 апреля 2002 г.
***************************************************** }
 
procedure StrBreakApart(const S, Delimeter: string; Parts: TStrings);
var
  CurPos: integer;
  CurStr: string;
begin
  Parts.clear;
  Parts.BeginUpdate();
  try
    CurStr := S;
    repeat
      CurPos := Pos(Delimeter, CurStr);
      if (CurPos &gt; 0) then
      begin
        Parts.Add(Copy(CurStr, 1, Pred(CurPos)));
        CurStr := Copy(CurStr, CurPos + Length(Delimeter),
          Length(CurStr) - CurPos - Length(Delimeter) + 1);
      end
      else
        Parts.Add(CurStr);
    until CurPos = 0;
  finally
    Parts.EndUpdate();
  end;
end;
Пример использования: 
 
var
  Tmp: StringList;
begin
  Tmp := TStringList.Create();
  StrBreakApart('Text1&lt;BR&gt;Text2&lt;BR&gt;Text3&lt;BR&gt;Text4', '&lt;BR&gt;', Tmp);
  // После вызова Tmp содержит
  // Text1
  // Text2
  // Text3
  // Text4
  ...
  Tmp.Free();
end;
</pre>

<hr />
<p>Можно сделать значительно проще:</p>
<pre>procedure StrBreakApart(const S, Delimeter: string; Parts: TStrings);

begin
  Parts.text:=StringReplace(S, Delimeter, #13#10, [rfReplaceAll, rfIgnoreCase]);
end;
</pre>

<p class="author">Автор: Vit</p>
&nbsp;
<p>&nbsp;</p>

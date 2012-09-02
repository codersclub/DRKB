<h1>Перетасовка строк в списке</h1>
<div class="date">01.01.2007</div>


<pre>
{ **** UBPFD *********** by kladovka.net.ru ****
&gt;&gt; Перетасовка строк в списке
 
Процедура тасует строки в списке.
List - Список строк
MoveCount - необязательный параметр, задающий количество перестановок, 
если этот параметр опущен, либо меньше или равен нулю, его значение 
принимается равным C*C-C, где C - количество строк в списке.
 
Зависимости: SysUtils, Classes
Автор:       Dimka Maslov, mainbox@endimus.ru, ICQ:148442121, Санкт-Петербург
Copyright:   Dimka Maslov
Дата:        18 ноября 2002 г.
********************************************** }
 
procedure ShuffleStrings(List: TStrings; MoveCount: Integer = 0);
var
 i, N, C: Integer;
 Index1, Index2: Integer;
 Str: string;
 Obj: TObject;
begin
 List.BeginUpdate;
 try
  C:=List.Count;
  N:=MoveCount;
  if N &lt;= 0 then N:=C*C-C;
  for i:=0 to N do begin
   Index1:=Random(C);
   Index2:=Random(C);
   Str:=List.Strings[Index1];
   Obj:=List.Objects[Index1];
   List.Strings[Index1]:=List.Strings[Index2];
   List.Objects[Index1]:=List.Objects[Index2];
   List.Strings[Index2]:=Str;
   List.Objects[Index2]:=Obj;
  end;
 finally
  List.EndUpdate;
 end;
end; 
</pre>

<p> Пример использования:</p>
<pre>
ShuffleStrings(Memo1.Lines) 
</pre>


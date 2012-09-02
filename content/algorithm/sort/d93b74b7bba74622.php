<h1>Сортировка строк с украинскими символами</h1>
<div class="date">01.01.2007</div>


<pre>
{ **** UBPFD *********** by kladovka.net.ru ****
&gt;&gt; Сортировка строк с украинскими символами
 
Принцип работы функции такой же как и у стандартной функции CompareText из SysUtils. Поскольку для украинских символов строки сортируются этой функцией "как попало", то я решил написать свой CompareUkrText.
 
Зависимости: System
Автор:       Алексей Глеб, noodlesf@mail.ru, Чернигов
Copyright:   Собственное написание (Алексей Глеб)
Дата:        1 февраля 2003 г.
********************************************** }
 
Unit UkrSort;
 
Interface
 
Function CompareUkrText(S1, S2: String): integer;
 
  //массив, который заменит ASCI таблицу
Var
  Chars: Array[1..136] Of char=
  ('1','2','3','4','5','6','7','8','9','0','A','B','C','D','E','F','G',
   'H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X',
   'Y','Z','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o',
   'p','q','r','s','t','u','v','w','x','y','z','А','Б','В','Г','Ґ','Д',
   'Е','Ё','Є','Ж','З','И','І','Ї','Й','К','Л','М','Н','О','П','Р','С',
   'Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я','а','б','в',
   'г','ґ','д','е','ё','є','ж','з','и','і','ї','й','к','л','м','н','о',
   'п','р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я');
 
Implementation
 
  //сама функция
Function CompareUkrText(S1, S2: String): integer;
 
  Function GetNum(C: char): integer;
    //динам. функция получения номера символа из нашего массива
  Var
    i: integer;
  Begin
    Result:=0;
    For i:=1 To 136 Do
      If Chars[i]=C Then
      Begin
        Result:=i;
        exit;
      End;
  End;
 
  Function CompCh(C1, C2: integer): integer;
    //динам. функция определения "что больше???"
  Begin
    If C1=C2 Then Result:=0;
    If C1&gt;C2 Then Result:=1;
    If C1&lt;C2 Then Result:=-1;
  End;
Var
  i, xS1, xS2, CurrR: integer;
Begin //начало функции сортировки
  Result:=0;
  CurrR:=0; //временный результат
  If S1&lt;&gt;S2 Then
  Begin
      //сканирование сток посимвольно
    For i:=1 To Length(S1) Do
    Begin
      If Length(S2)&gt;=i Then
      Begin
        xS1:=GetNum(S1[i]);
        xS2:=GetNum(S2[i]);
        If (xS1&lt;&gt;0)And(xS2&lt;&gt;0)And(xS1&lt;&gt;xS2) Then
          CurrR:=CompCh(xS1, xS2)
        Else
        Begin
          If (xS1=0)Or(xS2=0) Then
          Begin
            If xS2=0 Then CurrR:=1;
            If xS1=0 Then CurrR:=-1;
          End;
        End;
        If CurrR&lt;&gt;0 Then
        Begin
          Result:=CurrR;
          Exit;
        End;
      End
      Else
      Begin
        Result:=CurrR;
        Exit;
      End;
    End;
  End;
End;
 
End. 
</pre>

<p> Пример использования:</p>
<pre>
Function CustomSortProc(Item1, Item2: TListItem; ParamSort: integer): integer; Stdcall;
Begin
  Result:=CompareUkrText(Item1.Caption, Item2.Caption);
End;
 
procedure TForm1.FormClick(Sender: TObject);
begin
  ListView1.CustomSort(@CustomSortProc, 0);
end; 
</pre>


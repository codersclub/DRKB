<h1>Получать слова нужной длины при перестановке букв в указанном слове</h1>
<div class="date">01.01.2007</div>


<pre>
{ 
  Definition: Permutation 
 
  A permutation is an arrangement of n objects, arranged in groups of size r 
  without repetition where order is important. 
 
  P(n,r) = n! / (n-r)! 
 
  Example: Find all two-letter permutations of the letters "ABC" 
 
  n = ABC 
  r = 2 
 
  Output: AB  AC  BA  BC  CA  CB 
}
 
 
 { 
  Definition: Permutation 
 
  Eine Permutation ist eine Anordnung von n Objekten ohne Wiederholung. 
  Dabei spielt die Reihenfolge der Elemente in den Mengen keine Rolle. 
 
  P(n,r) = n! / (n-r)! 
 
  Beispiel: Finde alle 2-Buchstaben Kombinationen von "ABC" 
 
  n = ABC 
  r = 2 
 
  Ergebnis: AB  AC  BA  BC  CA  CB 
}
 
 
 { 
  The following is a console Program: 
  Choose File, New, Console Application 
 
}
 
 
    program Permute;
 {$APPTYPE CONSOLE}
 
 uses SysUtils;
 
 var
    R, Slen: Integer;
 
 procedure P(var A: string; B: string);
 var
    J: Word;
   C, D: string;
 begin
   { P(N,N) &gt;&gt;  R=Slen  }
   if Length(B) = SLen - R then
    begin
     Write(' {' + A + '} '); {Per++}
   end
    else
     for J := 1 to Length(B) do
     begin
       C := B;
       D := A + C[J];
       Delete(C, J, 1);
       P(D, C);
     end;
 end;
 
 var
    Q, S, S2: string;
 begin
   S  := ' ';
   S2 := ' ';
   while (S &lt;&gt; '') and (S2 &lt;&gt; '') do
   begin
     Writeln('');
     Writeln('');
     Write('P(N,R)  N=? : ');
      ReadLn(S);
     SLen := Length(S);
     Write('P(N,R)  R=? : ');
      ReadLn(S2);
     if s2 &lt;&gt; '' then R := StrToInt(S2);
     Writeln('');
      Q := '';
      P(Q, S);
   end;
 end.
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>

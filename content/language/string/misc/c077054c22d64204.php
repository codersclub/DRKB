<h1>Получить количество ссылок AnsiString</h1>
<div class="date">01.01.2007</div>


<pre>
function GetAnsistringRefcount(const S: string): Cardinal;
 asm
   or eax, eax
   jz @done
   sub eax, 8
   mov eax, dword ptr [eax]
 @done:
 end;
 
 procedure TForm1.Button1Click(Sender: TObject);
 var
   S1, S2: string;
 begin
   memo1.lines.Add(Format('Refcount at start: %d',
     [GetAnsistringRefcount(S1)]));
   S1 := StringOfChar('A', 10);
   memo1.lines.Add(Format('Refcount after assignment: %d',
     [GetAnsistringRefcount(S1)]));
   S2 := S1;
   memo1.lines.Add(Format('Refcount after S2:=S1: %d',
     [GetAnsistringRefcount(S1)]));
   S2 := S1 + S2;
   memo1.lines.Add(Format('Refcount after S2:=S1+S2: %d',
     [GetAnsistringRefcount(S1)]));
 end;
</pre>

<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
&nbsp;</p>

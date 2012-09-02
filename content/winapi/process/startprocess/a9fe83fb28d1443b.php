<h1>Как запустить и подождать завершения 2-х процессов?</h1>
<div class="date">01.01.2007</div>


<pre>
procedure HzChe;
var
hProcess : array [0..1] of Cardinal;
struc1 : PSTARTUPINFO;
struc2 : PROCESS_INFORMATION;
begin
  if not CreateProcess ( PChar('c:\PSTOLD.EXE') ,
nil,
nil,
nil,
False,
NORMAL_PRIORITY_CLASS,
nil,
nil,
struc1^,
struc2 ) then ShowMessage ( 'Zhopa kakaya-to');
  hProcess[0] := struc2.hProcess;
if not CreateProcess ( PChar('c:\PSTOLD1.EXE') ,
nil,
nil,
nil,
False,
NORMAL_PRIORITY_CLASS,
nil,
nil,
struc1^,
struc2 ) then ShowMessage ( 'Zhopa kakaya-to');
hProcess[1] := struc2.hProcess;
  if WaitForMultipleObjects ( 2, @hProcess, True, INFINITE ) = 1 then 
    ShowMessage ('    vce, priehali' );
end;
</pre>

<p>P.S. </p>
<p>То, что я понаписал нельзя считать цивильным кодом...просто демонстрация работы функции WaitForMultipleObjects ( код позорный...просто жуть...) </p>
<p class="author">Автор ответа: Baa</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

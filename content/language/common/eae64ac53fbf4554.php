<h1>Директивы вызова процедур</h1>
<div class="date">01.01.2007</div>


<p>Может кто объяснит подробнее особенности применения директив вызовов процедур: register, pascal, cdecl, stdcall, safecall. В чём отличия, когда и какие надо применять, какие преимущества и недостатки? </p>
<p>Разница в способе передачи параметров в функцию и возврата параметров из функции.</p>
<p>stdcall - юзается (вроде) а винапях. Передача аргументов справа налево. Стек очищает вызываемая процедура. Возвращает разультат в EAX (помойму)</p>
<p>pascal - юзалось в вин16апи. Передача в аргументов слева направо. Стек очищает вызываемая. В паскале результат возвращался в al, ax или в dx:ax. Как в Дельфи - не помню, вероятно а EAX.</p>
<p>register - передача всего через регистры процессора. Как именно - зависит от компилятора.</p>
<p>cdecl - не помню. Вроде тоже, что и stdcall, только стек чистит вызывающая процедура</p>
<p class="author">Автор: FdX</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr />
<p>sdecl - вызовы в стиле С (для обращения к DLL использующим соглашения о вызовах в стиле С). Параметры в сет с права на лево. Очистка - вызывающей процедурой. Обеспечивают обслуживание переменного числа параметров. </p>
<p class="author">Автор: Dapo</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr />
<p>Эти директивы скорее относятся к способу(ам) реализации вызовов процедур и передачи (приему от) параметров на конкретном машинном языке при компиляции с языков высокого уровня.</p>
<p>Так, например в DOS СИ использовали свои виды реализаций(обычно называемые C-call), а Паскаль - свой. В win32 также различаются реализации для этих языков, но постепенно происходит заимствование фрагментов реализаций друг у друга и их симбиозы (stdcall).</p>
<p>Если ты пишешь только на одном языке и не подключаешь внешних библиотек, созданных другим компилятором (в другом формате), то тебе, в принципе, все равно, какая реализация используется - компилятор сам примет верное решение и согласует вызовы подпрограмм в своем стиле. Исключение, пожалуй, составляет лишь опция "registers" - по смыслу это означает приоритетное использование регистров процессора для передачи(получения) данных процедуре. Как правило, это ускоряет вызов процедуры и возврат из нее: может быть использования для повышения быстродействия. Однако это обычно делают установкой глобального флага проекта в момент создания Файнал Релиз, применяя это сразу ко всем подпрограммам.</p>
<p>Однако если тебе необходимо подключить внешнюю библиотеку (например, написанный на СИ dll, вызывающий в свою очередь апи sql-сервера), то будет необходимо учесть способ передачи параметров именно этой библиотеке.</p>
<p>Или при явном вызове win api из кода также нужно учесть способ их вызова (stdcall)... </p>
<p class="author">Автор: Chingachguk</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr />
<p>Calling conventions influence two things:</p>
<div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>how parameters are passed to a function/procedure (=routines)</td></tr></table></div><div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>how the call stack is cleaned up when the call returns</td></tr></table></div><p>Delphi routines can use the calling conventions pascal (the Delphi 1 default), register (the default for Delphi 2-5), cdecl (the default used by C/C++ compilers), stdcall (the default used by the Windows API). There is a fifth one: safecall, which is only used in the context of interface methods. A good explanation for what it entails can be found in issue 51 (Nov. 99) of The Delphi Magazine, i will not go into it further here. Lets go through the first four in detail, using a couple of test functions with the same parameter list but different calling conventions. For clearity we compile with stack frames on, so each routine will start with the prologue push ebp mov ebp, esp. The stack layouts given below are for the mov line. Each test function is called with the same parameter values so one can</p>
<p>use the CPU windows stack pane to study the resulting stack layout.</p>
<p>1. Pascal calling convention</p>
<pre>
function Test1( i: Integer; b: Boolean; d: Double ): Integer; Pascal;
</pre>
<p>Pascal calling convention passes parameters on the stack and pushes them from left to right in the parameter list. Each parameter occupies a multiple of 4 bytes. The resulting stack layout is</p>
<p>ebp + 20 value of i, 4 bytes</p>
<p>ebp + 16 value of b, 4 bytes, only lowbyte significant</p>
<p>ebp + 08 value of d, 8 bytes</p>
<p>ebp + 04 return address, 4 bytes</p>
<p>ebp + 00 old ebp value</p>
<p>The parameters are cleared off the stack by the called function using a ret $10 instruction ($10 = 16 is the total size of the parameters on stack).</p>
<p>2. Register calling convention</p>
<pre>
function Test2( i: Integer; b: Boolean; d: Double ): Integer; Register;
</pre>
<p>Register calling convention passes parameters in registers eax, edx, ecx and on the stack and processes them from left to right in the parameter list. There are rules to decide what goes into registers and what goes on the stack, as detailed in the Object Pascal Language guide. The resulting stack layout is</p>
<p>ebp + 08 value of d, 8 bytes</p>
<p>ebp + 04 return address, 4 bytes</p>
<p>ebp + 00 old ebp value</p>
<p>The value of i is passed in eax, the value of b in edx. The parameters are cleared off the stack by the called function using a ret $8 instruction ($8 = 8 is the total size of the parameters on stack).</p>
<p>3. cdecl calling convention</p>
<pre>
function Test3( i: Integer; b: Boolean; d: Double ): Integer; cdecl;
</pre>
<p>Cdecl calling convention passes parameters on the stack and pushes them from right to left in the parameter list. Each parameter occupies a multiple of 4 bytes. The resulting stack layout is</p>
<p>ebp + 16 value of d, 8 bytes</p>
<p>ebp + 12 value of b, 4 bytes, only lowbyte significant</p>
<p>ebp + 08 value of i, 4 bytes</p>
<p>ebp + 04 return address, 4 bytes</p>
<p>ebp + 00 old ebp value</p>
<p>The parameters are cleared off the stack by the calling function, so the function ends with a ret 0 and after the call instruction we find a add esp, $10 instruction ($10 = 16 is the total size of the parameters on stack).</p>
<p>4. Stdcall calling convention</p>
<pre>
function Test4( i: Integer; b: Boolean; d: Double ): Integer; stdcall;
</pre>
<p>Sdtcall calling convention passes parameters on the stack and pushes them from right to left in the parameter list. Each parameter occupies a multiple of 4 bytes. The resulting stack layout is</p>
<p>ebp + 16 value of d, 8 bytes</p>
<p>ebp + 12 value of b, 4 bytes, only lowbyte significant</p>
<p>ebp + 08 value of i, 4 bytes</p>
<p>ebp + 04 return address, 4 bytes</p>
<p>ebp + 00 old ebp value</p>
<p>The parameters are cleared off the stack by the called function using a ret $10 instruction ($10 = 16 is the total size of the parameters on stack).</p>
<p>When writing DLLs that are only be meant to be used from Delphi programs you will usually use the register calling convention, since it is the most efficient one. But this really ties the DLL to Delphi, no program compiled in another language (with the exception of BC++ Builder perhaps) will be able to use the DLL unless it uses assembler to call the functions, since the Register calling convention (like MS VC _fastcall) is</p>
<p>compiler-specific. When writing DLLs that should be usable by other programs regardless of language you use the stdcall calling convention for exported routines. Any language that can call Windows API routines will be able to call routines from such a DLL, as long as you stay away from Delphi-specific data types, like String, Boolean, objects, real48. Pascal calling convention is Win16 heritage, it was the default for the Win16 API but is no longer used on Win32. A topic loosely tied to calling conventions is name decoration for exported names in DLLs. Delphi (5 at least) does not decorate names, regardless of calling convention used. The name</p>
<p>appears in the exported names table exactly as you cite it in the exports clause of the DLL, case and all. Case is</p>
<p>significant for exported functions in Win32! Other compilers may decorate names. Unless told to do otherwise a C compiler will prefix all cdecl functions with an underbar and will decorate stdcall functions in the format _name@x, where x is the total parameter size, e.g. _Test3@16. C++ is even worse, unless functions are declared as extern "C" it will export names in a decorated format that encodes parameter size and type, in a compiler-specific fashion. For routines exported with Pascal calling convention the names may be all uppercase,</p>
<p>but as said above you will not usually encouter this convention on Win32. Due to these naming issues it is often appropriate to sic TDUMP on an unknown DLL you want to interface to, to figure out the actual names of the exported functions. These can then be given in a name clause for the external statement if they are decorated.</p>
<p>Demo DLL:</p>
<pre>
library DemoDLL;
uses Windows;
 
function Test1(i: Integer; b: Boolean; d: Double): Integer; pascal;
begin
  Result := Round(i * Ord(b) * d);
end;
 
function Test2(i: Integer; b: Boolean; d: Double): Integer; register;
begin
  Result := Round(i * Ord(b) * d);
end;
 
function Test3(i: Integer; b: Boolean; d: Double): Integer; cdecl;
begin
  Result := Round(i * Ord(b) * d);
end;
 
function Test4(i: Integer; b: Boolean; d: Double): Integer; stdcall;
begin
  Result := Round(i * Ord(b) * d);
end;
 
exports
  Test1 index 1,
  Test2 index 2,
  Test3 index 3,
  Test4 index 4;
 
begin
end.
</pre>

<pre>
// Example call from test project:
implementation
{$R *.DFM}
 
function Test1(i: Integer; b: Boolean; d: Double): Integer; pascal; external 'DEMODLL.DLL' Index 1;
 
function Test2(i: Integer; b: Boolean; d: Double): Integer; register; external 'DEMODLL.DLL' Index 2;
 
function Test3(i: Integer; b: Boolean; d: Double): Integer; cdecl; external 'DEMODLL.DLL' Index 3;
 
function Test4(i: Integer; b: Boolean; d: Double): Integer; stdcall; external 'DEMODLL.DLL' Index 4;
 
procedure TForm1.Button1Click(Sender: TObject);
var i: Integer;
begin
  i := Test1(16, True, 1.0);
  i := Test2(16, True, 1.0);
  i := Test3(16, True, 1.0);
  i := Test4(16, True, 1.0);
end;
</pre>
<p>Set breakpoints on the lines and step into the routines with the CPU window open to see the stack layout. </p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

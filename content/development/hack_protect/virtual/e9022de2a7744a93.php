<h1>Как определить, работает ли программа в виртуальной машине Connectrix?</h1>
<div class="date">01.01.2007</div>


<pre>
{ 
 This function can be used to determine whether your program is 
 running from within Connectrix's Virtual PC 
} 
 
function running_inside_vpc: boolean; assembler; 
asm 
 push ebp 
 
 mov  ecx, offset @@exception_handler 
 mov  ebp, esp 
 
 push ebx 
 push ecx 
 push dword ptr fs:[0] 
 mov  dword ptr fs:[0], esp 
 
 mov  ebx, 0 // flag 
 mov  eax, 1 // VPC function number 
 
 // call VPC 
 db 00Fh, 03Fh, 007h, 00Bh 
 
 mov eax, dword ptr ss:[esp] 
 mov dword ptr fs:[0], eax 
 add esp, 8 
 
 test ebx, ebx 
 setz al 
 lea esp, dword ptr ss:[ebp-4] 
 mov ebx, dword ptr ss:[esp] 
 mov ebp, dword ptr ss:[esp+4] 
 add esp, 8 
 jmp @@ret 
 @@exception_handler: 
 mov ecx, [esp+0Ch] 
 mov dword ptr [ecx+0A4h], -1 // EBX = -1 -&gt; not running, ebx = 0 -&gt; running 
 add dword ptr [ecx+0B8h], 4 // -&gt; skip past the detection code 
 xor eax, eax // exception is handled 
 ret 
 @@ret: 
end;
</pre>

<p class="author">Автор: p0s0l</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>


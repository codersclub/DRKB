<h1>Как определить, работает ли программа в виртуальной машине VMware?</h1>
<div class="date">01.01.2007</div>


<pre>
//////////////////////////////////////////////////////////////////////////////// 
// 
//  Simple VMware check on i386 
// 
//    Note: There are plenty ways to detect VMware. This short version bases 
//    on the fact that VMware intercepts IN instructions to port 0x5658 with 
//    an magic value of 0x564D5868 in EAX. However, this is *NOT* officially 
//    documented (used by VMware tools to communicate with the host via VM). 
// 
//    Because this might change in future versions - you should look out for 
//    additional checks (e.g. hardware device IDs, BIOS informations, etc.). 
//    Newer VMware BIOS has valid SMBIOS informations (you might use my BIOS 
//    Helper unit to dump the ROM-BIOS (http://www.bendlins.de/nico/delphi). 
// 
 
function IsVMwarePresent(): LongBool; stdcall;  // platform; 
begin 
 Result := False; 
{$IFDEF CPU386} 
 try 
   asm 
           mov     eax, 564D5868h 
           mov     ebx, 00000000h 
           mov     ecx, 0000000Ah 
           mov     edx, 00005658h 
           in      eax, dx 
           cmp     ebx, 564D5868h 
           jne     @@exit 
           mov     Result, True 
   @@exit: 
   end; 
 except 
   Result := False; 
 end; 
{$ENDIF} 
end;
</pre>

<div class="author">Автор: p0s0l</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

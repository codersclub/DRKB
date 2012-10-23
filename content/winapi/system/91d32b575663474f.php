<h1>Прочитать свойства системы</h1>
<div class="date">01.01.2007</div>


<pre>
{ 
  The SYSTEM_INFO structure contains information about the current computer 
  system. This includes the architecture and type of the processor, the number of 
  processors in the system, the page size, and other such information. 
}
 
 procedure TForm1.Button1Click(Sender: TObject);
 var
   SysInfo: TSystemInfo;
 begin
   GetSystemInfo(SysInfo);
   with ListBox1.Items, SysInfo do
   begin
     Add('ProcessorArchitecture:' + IntToStr(wProcessorArchitecture));
     Add(FloatToStr(dwPageSize) + ' Kb page size');
     Add(Format('Lowest memory address accessible to applications and DLL - %p',
       [lpMinimumApplicationAddress]));
     Add(Format('Highest memory address accessible to applications and DLL - %p',
       [lpMaximumApplicationAddress]));
     Add('OEMID:' + IntToStr(dwOemId));
     Add('ActiveProcessorMask:' + IntToStr(dwActiveProcessorMask));
     Add(IntToStr(dwNumberOfProcessors) + ' - number of processors');
     Add('ProcessorType:' + IntToStr(dwProcessorType));
     case wProcessorLevel of
       3: Add('Intel 80386 processor level');
       4: Add('Intel 80486 processor level');
       5: Add('Intel Pentium processor level');
     end;
     Add(FloatToStr(dwAllocationGranularity / 1024) +
       ' Kb - granularity with which virtual memory is allocated');
     Add('ProcessorRevision:' + IntToStr(wProcessorRevision));
   end;
 end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
<hr />
<p>Часто при создании систем привязки программ к компьютеру или окон типа System Info или About Box необходимо определить данные о пользователе и о системе. Это можно сделать следующим образом (из примеров по Delphi - программа COA):</p>
<pre>
...
 Buffer : Array[0..30] of Char;    // Буфер под ASCIIZ строку
begin
 // Открыли библиотеку User
 hInstUser := LoadLibrary('USER');      
 LoadString(hInstUser, 514, Buffer, 30);
 // Имя пользователя
 LabelUserName.Caption := StrPas(Buffer); 
 LoadString(hInstUser, 515, Buffer, 30);
 FreeLibrary(hInstUser);
 // Компания
 LabelCompName.Caption := StrPas(Buffer);
 WinVer := GetVersion;
 // Версия Windows
 LabelWinVer.Caption := Format('Windows %u.%.2u',
        [LoByte(LoWord(WinVer)), HiByte(LoWord(WinVer))]);
 // Версия DOS
 LabelDosVer.Caption := Format('DOS %u.%.2u',
        [HiByte(HiWord(WinVer)), LoByte(HiWord(WinVer))]);
 WinFlags := GetWinFlags;
 // Режим
 IF WinFlags AND WF_ENHANCED &gt; 0 THEN
   LabelWinMode.Caption := '386 Enhanced Mode' 
 ELSE IF WinFlags AND WF_PMODE &gt; 0 THEN
   LabelWinMode.Caption := 'Standard Mode'
 ELSE LabelWinMode.Caption := 'Real Mode';
 // Сопроцессор
 IF WinFlags AND WF_80x87 &gt; 0 THEN 
  ValueMathCo.Caption := 'Present'
 ELSE ValueMathCo.Caption := 'Absent';
 
 // Свободно ресурсов
 Fmt := GetFreeSystemResources(GFSR_SYSTEMRESOURCES);
 ValueFSRs.Caption := Format('%d%% Free', [Fmt1]); 
 // Свободно памяти
 ValueMemory.Caption := FormatFloat(',#######', MemAvail DIV 
1024) + ' KB Free';
end;
 
 
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>


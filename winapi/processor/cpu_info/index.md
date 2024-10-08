---
Title: Как получить информацию о процессоре?
Date: 01.01.2007
---

Как получить информацию о процессоре?
=====================================

Вариант 1:

Author: Chingachguk

О процессоре можно на любом уровне (приложении или драйвере) получить
информацию с помощью команды(машинной) CPUID(386+):

Например (Вставка на асм в языке Паскаль):

    {Получить тип процессора}
     
    asm
      mov eax,0 
      cpuid {Или db 0Fh, 0A2h}
      {Теперь регистры EBX:ECX:EDX содержат строку "Genu-inel-ntel" (например)}
    end;

Передать в Паскаль содержимое регистров можно, например, так:

    var
      EBXstr,ECXstr,EDXstr: string[5];
     
    begin
      asm
        mov eax,0
        cpuid
        mov dword ptr EBXstr+1,EBX
        mov byte ptr EBXstr,4
        mov dword ptr ECXstr+1,ECX
        mov byte ptr ECXstr,4
        mov dword ptr EDXstr+1,EDX
        mov byte ptr EDXstr,4
      end;
     
    writeln(EBSstr,ECXstr,EDXstr); 


------------------------------------------------------------------------

Вариант 2:

Source: <https://forum.sources.ru>

    unit CpuId; 
    interface 
    uses Windows, Mmsystem, Sysutils, Math, Dialogs; 
    type 
        TCpuRec=record 
           Name:string[128]; 
           Vendor:string[12]; 
           Frequency:word; 
           Family:integer; 
           Model:integer; 
           Stepping:integer; 
           L1DCache:word; 
           L1ICache:word; 
           L2Cache:word; 
         end; 
        TCpuType = (cpu8086, cpu286, cpu386, cpu486, cpuPentium); 
        TCpuData=object 
          function GetCPUIDSupport:Boolean; 
          function GetVendorString:string; 
          function GetCPUFrequency:word; 
          procedure GetFMS(var Family,Model,Stepping:byte); 
          function GetMaxCpuId:dword; 
          function CheckFPU:Boolean; 
          function CheckTSC:Boolean; 
          function CheckMSR:Boolean; 
          function CheckMPS:Boolean; 
          function GetNoCpus:cardinal; 
          function CheckPN:Boolean; 
          function CheckCMPXCHG8B:Boolean; 
          function CheckCMOVe:Boolean; 
          function CheckSelfSnoop:Boolean; 
          function CheckDebugTraceStore:Boolean; 
          function CheckFXSAVEFXRSTOR:Boolean; 
          function CheckMMX:Boolean; 
          function CheckMMXplus:Boolean; 
          function CheckSSE:Boolean; 
          function CheckSSE2:Boolean; 
          function CheckAMD3DNow:Boolean; 
          function CheckAMD3DNowPlus:Boolean; 
          function GetMaxExtendedFunctions:dword; 
          procedure GetExtendedFMS(var Family,Model,Stepping:byte); 
          function GetExtendedCpuName:string; 
          function GetExtendedL1DCache:word; 
          function GetExtendedL1ICache:word; 
          function GetExtendedL2Cache:word; 
     
          function CheckCeleron:Boolean; 
          function CheckPentiumIII:Boolean; 
          function CheckXeon:Boolean; 
          function CheckPentium4:Boolean; 
          function CheckIthanium:Boolean; 
     
    //****Aici am conrectat**** 
          function IntelP5N:string; 
          function IntelP6N:string; 
    //****Pana aici**** 
          function AMDK5N:string; 
          function Cyrix686N:string; 
          function GenericCpuN:string; 
          function P5CacheL1DI:word; 
          function P6CacheL1DI:word; 
          function P6CacheL2:word; 
     
          function AuthenticAMD:TCpuRec; 
     
          function GenuineIntel:TCpuRec; 
          function CyrixInstead:TCpuRec; 
          function GenericCPU:TCpuRec; 
         end; 
    const 
    Intel486:array[0..8] of string= (
      'Intel 486 DX', 
      'Intel 486 DX', 
      'Intel 486 SX', 
      'Intel 486 DX2', 
      'Intel 486 SL', 
      'Intel 486 SX2', 
      'Intel 486 DX2', 
      'Intel 486 DX4', 
      'Intel 486 DX4'
    ); 
    UMC486:array[0..1] of string= (
      'UMC U5D', 
      'UMC U5S'
    ); 
    AMD486:array[0..5] of string= (
      'AMD 486 DX2', 
      'AMD 486 DX2', 
      'AMD 486 DX4', 
      'AMD 486 DX4', 
      'AMD 5x86', 
      'AMD 5x86'
    ); 
    IntelP5:array[0..6] of string= (
      'Intel Pentium P5 A-Step', 
      'Intel Pentium P5', 
      'Intel Pentium P54C', 
      'Intel Pentium P24T Overdrive', 
      'Intel Pentium MMX P55C', 
      'Intel Pentium P54C', 
      'Intel Pentium MMX P55C'
    ); 
    NexGenNx586='NexGen Nx586'; 
    Cyrix4x86='VIA Cyrix 4x86'; 
    Cyrix5x86='VIA Cyrix 5x86'; 
    CyrixMediaGX='VIA Cyrix Media GX'; 
    CyrixM1='VIA Cyrix 6x86'; 
    CyrixM2='VIA Cyrix 6x86MX'; 
    CyrixIII='VIA Cyrix III'; 
    AMDK5:array[0..3] of string= (
      'AMD SSA5 (PR75/PR90/PR100)', 
      'AMD 5k86 (PR120/PR133)', 
      'AMD 5k86 (PR166)', 
      'AMD 5k86 (PR200)'
    ); 
    AMDK6:array[0..4] of string= (
       'AMD K6 (166~233)', 
       'AMD K6 (266~300)', 
       'AMD K6-2', 
       'AMD K6-III', 
       'AMD K6-2+ or K6-III+'
    ); 
    Centaur:array[0..2] of string= (
        'Centaur C6', 
        'Centaur C2', 
        'Centaur C3'
    ); 
    Rise:array[0..1] of string= (
        'Rise mP6', 
        'Rise mP6'
    ); 
    IntelP6:array[0..7] of string= (
        'Intel Pentium Pro A-Step', 
        'Intel Pentium Pro', 
        'Intel Pentium II', 
        'Intel Pentium II', 
        'Intel Pentium II', 
        'Intel Pentium III', 
        'Intel Pentium III', 
        'Intel Pentium III'
    ); 
    AMDK7:array[0..3] of string= (
         'AMD Athlon(tm) Processor', 
         'AMD Athlon(tm) Processor', 
         'AMD Duron(tm) Processor', 
         'AMD Thunderbird Processor'
    ); 
    IntelP4='Intel Pentium 4'; 
    
    var CpuData:TCpuData; 
    implementation 
    
    function TCpuData.GetCPUIDSupport:Boolean; 
    var TempDetect:dword; 
    begin 
      asm 
        pushf 
        pushfd 
        push eax 
        push ebx 
        push ecx 
        push edx 
       
        pushfd 
        pop eax 
        mov ebx,eax 
        xor eax,$00200000 
        push eax 
        popfd 
        pushfd 
        pop eax 
        push ebx 
        popfd 
        xor eax,ebx 
        mov TempDetect,eax 
       
        pop edx 
        pop ecx 
        pop ebx 
        pop eax 
        popfd 
        popf 
      end; 
      GetCPUIDSupport:=(TempDetect=$00200000); 
    end; 
    
    function TCpuData.GetVendorString:string; 
    var
      s1,s2,s3:array[0..3] of char; 
      TempVendor:string; 
      i:integer; 
    begin 
      asm 
        push eax 
        push ebx 
        push ecx 
        push edx 
        mov eax,0 
        db $0F,$A2                /// cpuid 
        mov s1,ebx 
        mov s2,edx 
        mov s3,ecx 
        pop edx 
        pop ecx 
        pop ebx 
        pop eax 
      end; 
      TempVendor:=''; 
      for i:=0 to 3 do 
        TempVendor:=TempVendor+s1[i]; 
      for i:=0 to 3 do 
        TempVendor:=TempVendor+s2[i]; 
      for i:=0 to 3 do 
        TempVendor:=TempVendor+s3[i]; 
      GetVendorString:=TempVendor; 
    end; 
    
    function TCpuData.GetCPUFrequency:word; 
    var
      TimeStart:integer; 
      TimeStop:integer; 
      StartTicks:dword; 
      EndTicks:dword; 
      TotalTicks:dword; 
      cpuSpeed:dword; 
      NeverExit:Boolean; 
    begin 
      TimeStart:=0; 
      TimeStop:=0; 
      StartTicks:=0; 
      EndTicks:=0; 
      TotalTicks:=0; 
      cpuSpeed:=0; 
      NeverExit:=True; 
      TimeStart:=timeGetTime; 
      while NeverExit do 
      begin 
        TimeStop:=timeGetTime; 
        if ((TimeStop-TimeStart)>1) then 
        begin 
          asm 
            xor eax,eax 
            xor ebx,ebx 
            xor ecx,ecx 
            xor edx,edx 
            db $0F,$A2                /// cpuid 
            db $0F,$31                /// rdtsc 
            mov StartTicks,eax 
          end; 
          Break; 
        end; 
      end; 
      TimeStart:=TimeStop; 
      while NeverExit do 
      begin 
        TimeStop:=timeGetTime; 
        if ((TimeStop-TimeStart)>1000) then 
        begin 
          asm 
            xor eax,eax 
            xor ebx,ebx 
            xor ecx,ecx 
            xor edx,edx 
            db $0F,$A2                /// cpuid 
            db $0F,$31                /// rdtsc 
            mov EndTicks,eax 
          end; 
          Break; 
        end; 
      end; 
      TotalTicks:=EndTicks-StartTicks; 
      cpuSpeed:=TotalTicks div 1000000; 
      GetCPUFrequency:=cpuSpeed; 
    end; 
    
    procedure TCpuData.GetFMS(var Family,Model,Stepping:byte); 
    var
      TempFlags:dword; 
      BinFlags:array[0..31] of byte; 
      i,pos:integer; 
    begin 
      asm 
        push eax 
        push ebx 
        push ecx 
        push edx 
        mov eax,1 
        db $0F,$A2                /// cpuid 
        mov TempFlags,eax 
        pop edx 
        pop ecx 
        pop ebx 
        pop eax 
      end; 
      for i:=0 to 31 do 
      begin 
        BinFlags[i]:=TempFlags mod 2; 
        TempFlags:=TempFlags div 2; 
      end; 
      family:=0; 
      model:=0; 
      stepping:=0; 
      pos:=0; 
      for i:=0 to 3 do 
      begin 
        stepping:=stepping+(BinFlags[pos]*StrToInt(FloatToStr(Power(2,i)))); 
        inc(pos); 
      end; 
      pos:=4; 
      for i:=0 to 3 do 
      begin 
        model:=model+(BinFlags[pos]*StrToInt(FloatToStr(Power(2,i)))); 
        inc(pos); 
      end; 
      pos:=8; 
      for i:=0 to 3 do 
      begin 
        family:=family+(BinFlags[pos]*StrToInt(FloatToStr(Power(2,i)))); 
        inc(pos); 
      end; 
    end; 
    
    function TCpuData.GetMaxCpuId:dword; 
    var TempMax:dword; 
    begin 
      asm 
        push eax 
        push ebx 
        push ecx 
        push edx 
        mov eax,0 
        db $0F,$A2                /// cpuid 
        mov TempMax,eax 
        pop edx 
        pop ecx 
        pop ebx 
        pop eax 
      end; 
      GetMaxCpuId:=TempMax; 
    end; 
    
    function TCpuData.CheckFPU:Boolean; 
    label NoFpu; 
    var TempCheck:dword; 
    begin 
      TempCheck:=1; 
      asm 
        push eax 
        push ebx 
        push ecx 
        push edx 
        mov eax,1 
        db $0F,$A2                /// cpuid 
        test edx,$1 
        jz NoFpu 
        mov edx,0 
        mov TempCheck,edx 
      NoFpu: 
        pop edx 
        pop ecx 
        pop ebx 
        pop eax 
      end; 
      CheckFpu:=(TempCheck=0); 
    end; 
    
    function TCpuData.CheckTSC:Boolean; 
    label NoTSC; 
    var TempCheck:dword; 
    begin 
      TempCheck:=1; 
      asm 
        push eax 
        push ebx 
        push ecx 
        push edx 
        mov eax,1 
        db $0F,$A2                /// cpuid 
        test edx,$10 
        jz NoTSC 
        mov edx,0 
        mov TempCheck,edx 
      NoTSC: 
        pop edx 
        pop ecx 
        pop ebx 
        pop eax 
      end; 
      CheckTSC:=(TempCheck=0); 
    end; 
    
    function TCpuData.CheckMSR:Boolean; 
    label NoMSR; 
    var TempCheck:dword; 
    begin 
      TempCheck:=1; 
      asm 
        push eax 
        push ebx 
        push ecx 
        push edx 
        mov eax,1 
        db $0F,$A2                /// cpuid 
        test edx,$20 
        jz NoMSR 
        mov edx,0 
        mov TempCheck,edx 
      NoMSR: 
        pop edx 
        pop ecx 
        pop ebx 
        pop eax 
      end; 
      CheckMSR:=(TempCheck=0); 
    end; 
    
    function TCpuData.CheckMPS:Boolean; 
    var SysInfo:TSystemInfo; 
    begin 
      GetSysTemInfo(SysInfo); 
      CheckMPS:=(SysInfo.dwNumberOfProcessors>1); 
    end; 
    
    function TCpuData.GetNoCpus:cardinal; 
    var SysInfo:TSystemInfo; 
    begin 
      GetSystemInfo(SysInfo); 
      GetNoCpus:=SysInfo.dwNumberOfProcessors; 
    end; 
    
    function TCpuData.CheckPN:Boolean; 
    label NoPN; 
    var TempCheck:dword; 
    begin 
      TempCheck:=1; 
      asm 
        push eax 
        push ebx 
        push ecx 
        push edx 
        mov eax,1 
        db $0F,$A2                /// cpuid 
        test edx,$40000 
        jz NoPN 
        mov edx,0 
        mov TempCheck,edx 
      NoPN: 
        pop edx 
        pop ecx 
        pop ebx 
        pop eax 
      end; 
      CheckPN:=(TempCheck=0); 
    end; 
    
    function TCpuData.CheckCMPXCHG8B:Boolean; 
    label NoCMPXCHG8B; 
    var TempCheck:dword; 
    begin 
      TempCheck:=1; 
      asm 
        push eax 
        push ebx 
        push ecx 
        push edx 
        mov eax,1 
        db $0F,$A2                /// cpuid 
        test edx,$100 
        jz NoCMPXCHG8B 
        mov edx,0 
        mov TempCheck,edx 
      NoCMPXCHG8B: 
        pop edx 
        pop ecx 
        pop ebx 
        pop eax 
      end; 
      CheckCMPXCHG8B:=(TempCheck=0); 
    end; 
    
    function TCpuData.CheckCMOVe:Boolean; 
    label NoCMOVe; 
    var TempCheck:dword; 
    begin 
      TempCheck:=1; 
      asm 
        push eax 
        push ebx 
        push ecx 
        push edx 
        mov eax,1 
        db $0F,$A2                /// cpuid 
        test edx,$8000 
        jz NoCMOVe 
        mov edx,0 
        mov TempCheck,edx 
      NoCMOVe: 
        pop edx 
        pop ecx 
        pop ebx 
        pop eax 
      end; 
      CheckCMOVe:=(TempCheck=0); 
    end; 
    
    function TCpuData.CheckSelfSnoop:Boolean; 
    label NoSelfSnoop; 
    var TempCheck:dword; 
    begin 
      TempCheck:=1; 
      asm 
        push eax 
        push ebx 
        push ecx 
        push edx 
        mov eax,1 
        db $0F,$A2                /// cpuid 
        test edx,$8000000 
        jz NoSelfSnoop 
        mov edx,0 
        mov TempCheck,edx 
      NoSelfSnoop: 
        pop edx 
        pop ecx 
        pop ebx 
        pop eax 
      end; 
      CheckSelfSnoop:=(TempCheck=0); 
    end; 
    
    function TCpuData.CheckDebugTraceStore:Boolean; 
    label NoDebugTraceStore; 
    var TempCheck:dword; 
    begin 
      TempCheck:=1; 
      asm 
        push eax 
        push ebx 
        push ecx 
        push edx 
        mov eax,1 
        db $0F,$A2                /// cpuid 
        test edx,$200000 
        jz NoDebugTraceStore 
        mov edx,0 
        mov TempCheck,edx 
      NoDebugTraceStore: 
        pop edx 
        pop ecx 
        pop ebx 
        pop eax 
      end; 
      CheckDebugTraceStore:=(TempCheck=0); 
    end; 
    
    function TCpuData.CheckFXSAVEFXRSTOR:Boolean; 
    label NoFXSAVEFXRSTOR; 
    var TempCheck:dword; 
    begin 
      TempCheck:=1; 
      asm 
        push eax 
        push ebx 
        push ecx 
        push edx 
        mov eax,1 
        db $0F,$A2                /// cpuid 
        test edx,$1000000 
        jz NoFXSAVEFXRSTOR 
        mov edx,0 
        mov TempCheck,edx 
      NoFXSAVEFXRSTOR: 
        pop edx 
        pop ecx 
        pop ebx 
        pop eax 
      end; 
      CheckFXSAVEFXRSTOR:=(TempCheck=0); 
    end; 
    
    function TCpuData.CheckMMX:Boolean; 
    label NoMMX; 
    var TempCheck:dword; 
    begin 
      TempCheck:=1; 
      asm 
        push eax 
        push ebx 
        push ecx 
        push edx 
        mov eax,1 
        db $0F,$A2                /// cpuid 
        test edx,$800000 
        jz NoMMX 
        mov edx,0 
        mov TempCheck,edx 
      NoMMX: 
        pop edx 
        pop ecx 
        pop ebx 
        pop eax 
      end; 
      CheckMMX:=(TempCheck=0); 
    end; 
    
    function TCpuData.CheckMMXplus:Boolean; 
    label NoMMXplus; 
    var TempCheck:dword; 
    begin 
      TempCheck:=1; 
      asm 
        push eax 
        push ebx 
        push ecx 
        push edx 
        mov eax,$80000001 
        mov ebx,0 
        mov ecx,0 
        mov edx,0 
        db $0F,$A2                /// cpuid 
        test edx,$400000 
        jz NoMMXplus 
        mov edx,0 
        mov TempCheck,edx 
      NoMMXplus: 
        pop edx 
        pop ecx 
        pop ebx 
        pop eax 
      end; 
      CheckMMXplus:=(TempCheck=0); 
    end; 
    
    function TCpuData.CheckSSE:Boolean; 
    label NoSSE; 
    var TempCheck:dword; 
    begin 
      TempCheck:=1; 
      asm 
        push eax 
        push ebx 
        push ecx 
        push edx 
        mov eax,1 
        db $0F,$A2                /// cpuid 
        test edx,$2000000 
        jz NoSSE 
        mov edx,0 
        mov TempCheck,edx 
      NoSSE: 
        pop edx 
        pop ecx 
        pop ebx 
        pop eax 
      end; 
      CheckSSE:=(TempCheck=0); 
    end; 
    
    function TCpuData.CheckSSE2:Boolean; 
    label NoSSE2; 
    var TempCheck:dword; 
    begin 
      TempCheck:=1; 
      asm 
        push eax 
        push ebx 
        push ecx 
        push edx 
        mov eax,1 
        db $0F,$A2                /// cpuid 
        test edx,$4000000 
        jz NoSSE2 
        mov edx,0 
        mov TempCheck,edx 
      NoSSE2: 
        pop edx 
        pop ecx 
        pop ebx 
        pop eax 
      end; 
      CheckSSE2:=(TempCheck=0); 
    end; 
    
    function TCpuData.CheckAMD3DNow:Boolean; 
    label NoAMD3DNow; 
    var TempCheck:dword; 
    begin 
      TempCheck:=1; 
      asm 
        push eax 
        push ebx 
        push ecx 
        push edx 
        mov eax,$80000001 
        mov ebx,0 
        mov ecx,0 
        mov edx,0 
        db $0F,$A2                /// cpuid 
        test edx,$80000000 
        jz NoAMD3DNow 
        mov edx,0 
        mov TempCheck,edx 
      NoAMD3DNow: 
        pop edx 
        pop ecx 
        pop ebx 
        pop eax 
      end; 
      CheckAMD3DNow:=(TempCheck=0); 
    end; 
    
    function TCpuData.CheckAMD3DNowPlus:Boolean; 
    label NoAMD3DNowPlus; 
    var TempCheck:dword; 
    begin 
      TempCheck:=1; 
      asm 
        push eax 
        push ebx 
        push ecx 
        push edx 
        mov eax,$80000001 
        mov ebx,0 
        mov ecx,0 
        mov edx,0 
        db $0F,$A2                /// cpuid 
        test edx,$40000000 
        jz NoAMD3DNowPlus 
        mov edx,0 
        mov TempCheck,edx 
      NoAMD3DNowPlus: 
        pop edx 
        pop ecx 
        pop ebx 
        pop eax 
      end; 
      CheckAMD3DNowPlus:=(TempCheck=0); 
    end; 
    
    function TCpuData.GetMaxExtendedFunctions:dword; 
    var TempExt:dword; 
    begin 
      asm 
        push eax 
        push ebx 
        push ecx 
        push edx 
        mov eax,$80000000 
        mov ebx,0 
        mov ecx,0 
        mov edx,0 
        db $0F,$A2                /// cpuid 
        shl eax,1 
        shr eax,1 
        mov TempExt,eax 
        pop edx 
        pop ecx 
        pop ebx 
        pop eax 
      end; 
      GetMaxExtendedFunctions:=TempExt; 
    end; 
     
    procedure TCpuData.GetExtendedFMS(var family,model,stepping:byte); 
    var TempFlags:dword; 
        BinFlags:array[0..31] of byte; 
        i,pos:integer; 
    begin 
      asm 
        push eax 
        push ebx 
        push ecx 
        push edx 
        mov eax,$80000001 
        mov ebx,0 
        mov ecx,0 
        mov edx,0 
        db $0F,$A2                /// cpuid 
        mov TempFlags,eax 
        pop edx 
        pop ecx 
        pop ebx 
        pop eax 
      end; 
      for i:=0 to 31 do 
      begin 
        BinFlags[i]:=TempFlags mod 2; 
        TempFlags:=TempFlags div 2; 
      end; 
      family:=0; 
      model:=0; 
      stepping:=0; 
      pos:=0; 
      for i:=0 to 3 do 
      begin 
        stepping:=stepping+(BinFlags[pos]*StrToInt(FloatToStr(Power(2,i)))); 
        inc(pos); 
      end; 
      pos:=4; 
      for i:=0 to 3 do 
      begin 
        model:=model+(BinFlags[pos]*StrToInt(FloatToStr(Power(2,i)))); 
        inc(pos); 
      end; 
      pos:=8; 
      for i:=0 to 3 do 
      begin 
        family:=family+(BinFlags[pos]*StrToInt(FloatToStr(Power(2,i)))); 
        inc(pos); 
      end; 
    end; 
     
    function TCpuData.GetExtendedCpuName:string; 
    var s1,s2,s3,s4,s5,s6,s7,s8,s9,s10,s11,s12:array[0..3] of char; 
        TempCpuName:string; 
        i:integer; 
    begin 
      asm 
        push eax 
        push ebx 
        push ecx 
        push edx 
        mov eax,$80000002 
        mov ebx,0 
        mov ecx,0 
        mov edx,0 
        db $0F,$A2                /// cpuid 
        mov s1,eax 
        mov s2,ebx 
        mov s3,ecx 
        mov s4,edx 
        mov eax,$80000003 
        mov ebx,0 
        mov ecx,0 
        mov edx,0 
        db $0F,$A2                /// cpuid 
        mov s5,eax 
        mov s6,ebx 
        mov s7,ecx 
        mov s8,edx 
        mov eax,$80000004 
        mov ebx,0 
        mov ecx,0 
        mov edx,0 
        db $0F,$A2                /// cpuid 
        mov s9,eax 
        mov s10,ebx 
        mov s11,ecx 
        mov s12,edx 
        pop edx 
        pop ecx 
        pop ebx 
        pop eax 
      end; 
      TempCpuName:=''; 
      for i:=0 to 3 do 
       TempCpuName:=TempCpuName+s1[i]; 
      for i:=0 to 3 do 
       TempCpuName:=TempCpuName+s2[i]; 
      for i:=0 to 3 do 
       TempCpuName:=TempCpuName+s3[i]; 
      for i:=0 to 3 do 
       TempCpuName:=TempCpuName+s4[i]; 
      for i:=0 to 3 do 
       TempCpuName:=TempCpuName+s5[i]; 
      for i:=0 to 3 do 
       TempCpuName:=TempCpuName+s6[i]; 
      for i:=0 to 3 do 
       TempCpuName:=TempCpuName+s7[i]; 
      for i:=0 to 3 do 
       TempCpuName:=TempCpuName+s8[i]; 
      for i:=0 to 3 do 
       TempCpuName:=TempCpuName+s9[i]; 
      for i:=0 to 3 do 
       TempCpuName:=TempCpuName+s10[i]; 
      for i:=0 to 3 do 
       TempCpuName:=TempCpuName+s11[i]; 
      for i:=0 to 3 do 
       TempCpuName:=TempCpuName+s12[i]; 
      GetExtendedCpuName:=TempCpuName; 
    end; 
    
    function TCpuData.GetExtendedL1DCache:word; 
    var L1D,TempL1D:dword; 
        BinArray:array[0..31] of byte; 
        i,p:integer; 
    begin 
      asm 
        push eax 
        push ebx 
        push ecx 
        push edx 
        mov eax,$80000005 
        mov ebx,0 
        mov ecx,0 
        mov edx,0 
        db $0F,$A2                /// cpuid 
        mov L1D,ecx 
        pop edx 
        pop ecx 
        pop ebx 
        pop eax 
      end; 
      for i:=0 to 31 do 
      begin 
        BinArray[i]:=L1D mod 2; 
        L1D:=L1D div 2; 
      end; 
      TempL1D:=0; 
      p:=0; 
      for i:=24 to 31 do 
      begin 
        TempL1D:=TempL1D+(BinArray[i]*StrToInt(FloatToStr(Power(2,p)))); 
        inc(p); 
      end; 
      GetExtendedL1DCache:=TempL1D; 
    end; 
    
    function TCpuData.GetExtendedL1ICache:word; 
    var L1I,TempL1I:dword; 
        BinArray:array[0..31] of byte; 
        i,p:integer; 
    begin 
      asm 
        push eax 
        push ebx 
        push ecx 
        push edx 
        mov eax,$80000005 
        mov ebx,0 
        mov ecx,0 
        mov edx,0 
        db $0F,$A2                /// cpuid 
        mov L1I,edx 
        pop edx 
        pop ecx 
        pop ebx 
        pop eax 
      end; 
      for i:=0 to 31 do 
      begin 
        BinArray[i]:=L1I mod 2; 
        L1I:=L1I div 2; 
      end; 
      TempL1I:=0; 
      p:=0; 
      for i:=24 to 31 do 
      begin 
        TempL1I:=TempL1I+(BinArray[i]*StrToInt(FloatToStr(Power(2,p)))); 
        inc(p); 
      end; 
      GetExtendedL1ICache:=TempL1I; 
    end; 
    
    function TCpuData.GetExtendedL2Cache:word; 
    var L2,TempL2:dword; 
        BinArray:array[0..31] of byte; 
        i,p:integer; 
    begin 
      asm 
        push eax 
        push ebx 
        push ecx 
        push edx 
        mov eax,$80000006 
        mov ebx,0 
        mov ecx,0 
        mov edx,0 
        db $0F,$A2                /// cpuid 
        mov L2,ecx 
        pop edx 
        pop ecx 
        pop ebx 
        pop eax 
      end; 
      for i:=0 to 31 do 
      begin 
        BinArray[i]:=L2 mod 2; 
        L2:=L2 div 2; 
      end; 
      TempL2:=0; 
      p:=0; 
      for i:=16 to 31 do 
      begin 
        TempL2:=TempL2+(BinArray[i]*StrToInt(FloatToStr(Power(2,p)))); 
        inc(p); 
      end; 
      GetExtendedL2Cache:=TempL2; 
    end; 
    
    function TCpuData.CheckCeleron:Boolean; 
    var BId:byte; 
    begin 
      asm 
        push eax 
        push ebx 
        push ecx 
        push edx 
        mov eax,1 
        db $0F,$A2                /// cpuid 
        mov BId,bl 
        pop edx 
        pop ecx 
        pop ebx 
        pop eax 
      end; 
      CheckCeleron:=(BId=$1); 
    end; 
    
    function TCpuData.CheckPentiumIII:Boolean; 
    var BId:byte; 
    begin 
      CheckPentiumIII:=(CheckMMX and CheckSSE); 
    end; 
    
    function TCpuData.CheckXeon:Boolean; 
    var BId:byte; 
    begin 
      asm 
        push eax 
        push ebx 
        push ecx 
        push edx 
        mov eax,1 
        db $0F,$A2                /// cpuid 
        mov BId,bl 
        pop edx 
        pop ecx 
        pop ebx 
        pop eax 
      end; 
      CheckXeon:=(BId=$3); 
    end; 
    
    function TCpuData.CheckPentium4:Boolean; 
    var BId:byte; 
    begin 
      asm 
        push eax 
        push ebx 
        push ecx 
        push edx 
        mov eax,1 
        db $0F,$A2                /// cpuid 
        mov BId,bl 
        pop edx 
        pop ecx 
        pop ebx 
        pop eax 
      end; 
      CheckPentium4:=(BId=$8); 
    end; 
    
    function TCpuData.CheckIthanium:Boolean; 
    var res:dword; 
        BinArray:array[0..31] of byte; 
        i:byte; 
    begin 
      asm 
        push eax 
        push ebx 
        push ecx 
        push edx 
        mov eax,1 
        db $0F,$A2                /// cpuid 
        mov res,edx 
        pop edx 
        pop ecx 
        pop ebx 
        pop eax 
      end; 
      for i:=0 to 31 do 
      begin 
        BinArray[i]:=res mod 2; 
        res:=res div 2; 
      end; 
      CheckIthanium:=(CheckPentium4 and (BinArray[30]=1)); 
    end; 
    
    function TCpuData.IntelP5N:string; 
    begin 
    If CheckMMX then
      IntelP5N:='Intel Pentium(r) MMX(tm)' 
    else
      IntelP5N:='Intel Pentium(r)'; 
    end; 
    
    function TCpuData.IntelP6N:string; 
    begin 
      if CheckCeleron then
        IntelP6N:='Intel Celeron(r)' 
      else 
      if CheckPentiumIII then
        IntelP6N:='Intel Pentium(r) III' 
      else 
      if CheckXeon then
        IntelP6N:='Intel Pentium(r) III Xeon(tm)' 
      else 
      if not CheckMMX then
        IntelP6N:='Intel Pentium(r) PRO' 
      else IntelP6N:='Intel Pentium(r) II';   
    end; 
    
    function TCpuData.AMDK5N:string; 
    var Family,Model,Stepping:byte; 
    begin 
      GetFMS(Family,Model,Stepping); 
      if Model=0 then
        AMDK5N:='AMD K5' 
      else
        AMDK5N:=GetExtendedCpuName; 
    end; 
    
    function TCpuData.Cyrix686N:string; 
    begin 
      if CpuData.GetMaxExtendedFunctions>0 then
        Cyrix686N:=GetExtendedCpuName 
    else 
    if CheckMMX then
      Cyrix686N:='VIA Cyrix 6x86MII' 
    else 
      Cyrix686N:='VIA Cyrix 6x86'; 
    end; 
    
    function TCpuData.GenericCpuN:string; 
    var SysInfo:TSystemInfo; 
    begin 
      GetSystemInfo(SysInfo); 
      if SysInfo.dwProcessorType=386 
        then GenericCpuN:='Generic 386 CPU' 
      else 
      if SysInfo.dwProcessorType=486 
        then GenericCpuN:='Generic 486 CPU' 
      else 
      if SysInfo.dwProcessorType=586 
        then GenericCpuN:='Pentium Class CPU' 
      else GenericCpuN:='Unknown CPU'; 
    end; 
    
    function TCpuData.P5CacheL1DI:word; 
    begin 
      if CheckMMX then P5CacheL1DI:=16 
      else P5CacheL1DI:=8; 
    end; 
    
    function TCpuData.P6CacheL1DI:word; 
    begin 
      if not CheckMMX then P6CacheL1DI:=8 
      else P6CacheL1DI:=16; 
    end; 
    
    function TCpuData.P6CacheL2:word; 
    var Family,Model,Stepping:byte; 
    begin 
      if CheckCeleron then P6CacheL2:=128 
      else 
      if CheckPentiumIII then
      begin 
        GetFMS(Family,Model,Stepping); 
        if Model=7 then P6CacheL2:=512 
        else if Model=8 then P6cacheL2:=256 
        else P6CacheL2:=512; 
      end 
      else
      if not CheckMMX then P6CacheL2:=512 
      else P6CacheL2:=512; 
    end; 
    
    function TCpuData.AuthenticAMD:TCpuRec; 
    var Family,Model,Stepping:byte; 
        EFamily,EModel,EStepping:byte; 
    begin 
      GetFMS(Family,Model,Stepping); 
      If Family=4 then
      begin 
        AuthenticAMD.Name:='AMD 486'; 
        AuthenticAMD.Vendor:=GetVendorString; 
        AuthenticAMD.Frequency:=0; 
        AuthenticAMD.Family:=Family; 
        AuthenticAMD.Model:=Model; 
        AuthenticAMD.Stepping:=Stepping; 
        AuthenticAMD.L1DCache:=8; 
        AuthenticAMD.L1ICache:=8; 
        AuthenticAMD.L2Cache:=0; 
      end 
      else 
      if Family=5 then
      begin 
        if GetMaxExtendedFunctions>4 then 
        begin 
          AuthenticAMD.Name:=GetExtendedCpuName; 
          AuthenticAMD.Vendor:=GetVendorString; 
          AuthenticAMD.Frequency:=GetCPUFrequency; 
          GetExtendedFMS(EFamily,EModel,EStepping); 
          AuthenticAMD.Family:=EFamily; 
          AuthenticAMD.Model:=EModel; 
          AuthenticAMD.Stepping:=EStepping; 
          AuthenticAMD.L1DCache:=GetExtendedL1DCache; 
          AuthenticAMD.L1ICache:=GetExtendedL1ICache; 
          AuthenticAMD.L2Cache:=0; 
        end 
        else 
        begin 
          AuthenticAMD.Name:=AMDK5N; 
          AuthenticAMD.Vendor:=GetVendorString; 
          AuthenticAMD.Frequency:=GetCPUFrequency; 
          AuthenticAMD.Family:=Family; 
          AuthenticAMD.Model:=Model; 
          AuthenticAMD.Stepping:=Stepping; 
          AuthenticAMD.L1DCache:=16; 
          AuthenticAMD.L1ICache:=16; 
          AuthenticAMD.L2Cache:=0; 
         end; 
       end 
       else if family>5 then 
       begin 
         AuthenticAMD.Name:=GetExtendedCpuName; 
         AuthenticAMD.Name:=GetExtendedCpuName; 
         AuthenticAMD.Vendor:=GetVendorString; 
         AuthenticAMD.Frequency:=GetCPUFrequency; 
         GetExtendedFMS(EFamily,EModel,EStepping); 
         AuthenticAMD.Family:=EFamily; 
         AuthenticAMD.Model:=EModel; 
         AuthenticAMD.Stepping:=EStepping; 
         AuthenticAMD.L1DCache:=GetExtendedL1DCache; 
         AuthenticAMD.L1ICache:=GetExtendedL1ICache; 
         AuthenticAMD.L2Cache:=GetExtendedL2Cache; 
       end; 
    end; 
    
    function TCpuData.GenuineIntel:TCpuRec; 
    var Family,Model,Stepping:byte; 
    begin 
      GetFMS(Family,Model,Stepping); 
      if Family=4 then
      begin 
        GenuineIntel.Name:='Intel 486'; 
        GenuineIntel.Vendor:=GetVendorString; 
        GenuineIntel.Frequency:=0; 
        GenuineIntel.Family:=Family; 
        GenuineIntel.Model:=Model; 
        GenuineIntel.Stepping:=Stepping; 
        GenuineIntel.L1DCache:=8; 
        GenuineIntel.L1ICache:=8; 
        GenuineIntel.L2Cache:=0; 
      end 
      else 
      if Family=5 then
      begin 
        GenuineIntel.Name:=IntelP5N; 
        GenuineIntel.Vendor:=GetVendorString; 
        GenuineIntel.Frequency:=GetCPUFrequency; 
        GenuineIntel.Family:=Family; 
        GenuineIntel.Model:=Model; 
        GenuineIntel.Stepping:=Stepping; 
        GenuineIntel.L1DCache:=P5CacheL1DI; 
        GenuineIntel.L1ICache:=P5CacheL1DI; 
        GenuineIntel.L2Cache:=0; 
      end 
      else 
      if Family=6 then
      begin 
        GenuineIntel.Name:=IntelP6N; 
        GenuineIntel.Vendor:=GetVendorString; 
        GenuineIntel.Frequency:=GetCPUFrequency; 
        GenuineIntel.Family:=Family; 
        GenuineIntel.Model:=Model; 
        GenuineIntel.Stepping:=Stepping; 
        GenuineIntel.L1DCache:=P6CacheL1DI; 
        GenuineIntel.L1ICache:=P6CacheL1DI; 
        GenuineIntel.L2Cache:=P6CacheL2; 
      end 
      else 
      if Family=$F then
      begin 
        if CheckPentium4 then 
        begin 
          GenuineIntel.Name:='Intel Pentium(r) 4'; 
            GenuineIntel.Vendor:=GetVendorString; 
            GenuineIntel.Frequency:=GetCPUFrequency; 
            GenuineIntel.Family:=32; 
            GenuineIntel.Model:=Model; 
            GenuineIntel.Stepping:=Stepping; 
            GenuineIntel.L1DCache:=8; 
            GenuineIntel.L1ICache:=12; 
            GenuineIntel.L2Cache:=256; 
          end 
          else if CheckIthanium then 
          begin 
            GenuineIntel.Name:='Intel Ithanium'; 
            GenuineIntel.Vendor:=GetVendorString; 
            GenuineIntel.Frequency:=GetCPUFrequency; 
            GenuineIntel.Family:=64; 
            GenuineIntel.Model:=Model; 
            GenuineIntel.Stepping:=Stepping; 
            GenuineIntel.L1DCache:=0; 
            GenuineIntel.L1ICache:=0; 
            GenuineIntel.L2Cache:=0; 
          end; 
        end; 
      end; 
    end; 
    
    function TCpuData.CyrixInstead:TCpuRec; 
    var Family,Model,Stepping:byte; 
        EFamily,EModel,EStepping:byte; 
    begin 
      GetFMS(Family,Model,Stepping); 
      if Family=4 then
      begin 
        CyrixInstead.Name:='VIA Cyrix 4x86'; 
        CyrixInstead.Vendor:=GetVendorString; 
        CyrixInstead.Frequency:=0; 
        CyrixInstead.Family:=Family; 
        CyrixInstead.Model:=Model; 
        CyrixInstead.Stepping:=Stepping; 
        CyrixInstead.L1DCache:=8; 
        CyrixInstead.L1ICache:=8; 
        CyrixInstead.L2Cache:=0; 
      end 
      else 
      if Family=5 then
      begin 
        CyrixInstead.Name:='VIA Cyrix 5x86'; 
        CyrixInstead.Vendor:=GetVendorString; 
        CyrixInstead.Frequency:=GetCPUFrequency; 
        CyrixInstead.Family:=Family; 
        CyrixInstead.Model:=Model; 
        CyrixInstead.Stepping:=Stepping; 
        CyrixInstead.L1DCache:=8; 
        CyrixInstead.L1ICache:=8; 
        CyrixInstead.L2Cache:=0; 
      end 
      else
      begin 
        if GetMaxExtendedFunctions>0 then 
        Begin 
          CyrixInstead.Name:=GetExtendedCpuName; 
          CyrixInstead.Vendor:=GetVendorString; 
          CyrixInstead.Frequency:=GetCPUFrequency; 
          GetExtendedFMS(EFamily,EModel,EStepping); 
          CyrixInstead.Family:=EFamily; 
          CyrixInstead.Model:=EModel; 
          CyrixInstead.Stepping:=EStepping; 
          CyrixInstead.L1DCache:=GetExtendedL1DCache; 
          CyrixInstead.L1ICache:=GetExtendedL1ICache; 
          CyrixInstead.L2Cache:=GetExtendedL2Cache; 
        end 
        else
        begin 
          CyrixInstead.Name:=Cyrix686N; 
          CyrixInstead.Vendor:=GetVendorString; 
          CyrixInstead.Frequency:=GetCPUFrequency; 
          CyrixInstead.Family:=Family; 
          CyrixInstead.Model:=Model; 
          CyrixInstead.Stepping:=Stepping; 
          CyrixInstead.L1DCache:=32; 
          CyrixInstead.L1ICache:=32; 
          CyrixInstead.L2Cache:=0; 
        end; 
      end; 
    end; 
     
    function TCpuData.GenericCPU:TCpuRec; 
    var Family,Model,Stepping:byte; 
        EFamily,EModel,EStepping:byte; 
    begin 
      if not GetCPUIDSupport then 
      begin 
        MessageDlg('This CPU does not support the CPUID instruction!!!',mtWarning, 
        [mbOk],0); 
        GenericCPU.Name:='Unidentified CPU'; 
        GenericCPU.Vendor:='Unidentified'; 
        GenericCPU.Frequency:=0; 
        GenericCPU.Family:=-1; 
        GenericCPU.Model:=-1; 
        GenericCPU.Stepping:=-1; 
        GenericCPU.L1DCache:=0; 
        GenericCPU.L1ICache:=0; 
        GenericCPU.L2Cache:=0; 
      end 
      else 
      begin 
        GetFMS(Family,Model,Stepping); 
        if GetMaxExtendedFunctions>0 then 
        begin 
          GenericCPU.Name:=GetExtendedCPUName; 
          GenericCPU.Vendor:=GetVendorString; 
          GenericCPU.Frequency:=GetCPUFrequency; 
          CpuData.GetExtendedFMS(EFamily,EModel,EStepping); 
          GenericCPU.Family:=EFamily; 
          GenericCPU.Model:=EFamily; 
          GenericCPU.Stepping:=EStepping; 
          GenericCPU.L1DCache:=GetExtendedL1DCache; 
          GenericCPU.L1ICache:=GetExtendedL1ICache; 
          GenericCPU.L2Cache:=GetExtendedL2Cache; 
        end 
        else begin 
          GenericCPU.Name:=GenericCpuN; 
          GenericCPU.Vendor:=GetVendorString; 
          if Family<=4 then
            GenericCPU.Frequency:=0 
          else GenericCPU.Frequency:=GetCPUFrequency; 
          GenericCPU.Family:=Family; 
          GenericCPU.Model:=Model; 
          GenericCPU.Stepping:=Stepping; 
          GenericCPU.L1DCache:=0; 
          GenericCPU.L1ICache:=0; 
          GenericCPU.L2Cache:=0; 
        end; 
      end; 
    end; 
    
    end.


------------------------------------------------------------------------

Вариант 3:

Source: <https://community.borland.com>

Author: p0sol

Как узнать тип процессора (через реестр)?

    function CPUType: string;
    var
      Reg: TRegistry;
    begin
      CPUType := '';
      Reg := TRegistry.Create;
      try
        Reg.RootKey := HKEY_LOCAL_MACHINE;
        if Reg.OpenKey('\Hardware\Description\System\CentralProcessor\0', False) then
          CPUType := Reg.ReadString('Identifier');
      finally
        Reg.Free;
      end;
    end;

------------------------------------------------------------------------

Вариант 4:

Source: <https://delphiworld.narod.ru>

    unit ExpandCPUInfo;
     
    interface
     
    type
     
    TCPUInfo = packed record
      IDString : array [0..11] of Char;
      Stepping : Integer;
      Model    : Integer;
      Family   : Integer;
      FPU,
      VirtualModeExtensions,
      DebuggingExtensions,
      PageSizeExtensions,
      TimeStampCounter,
      K86ModelSpecificRegisters,
      MachineCheckException,
      CMPXCHG8B,
      APIC,
      MemoryTypeRangeRegisters,
      GlobalPagingExtension,
      ConditionalMoveInstruction,
      MMX     : Boolean;
      SYSCALLandSYSRET,
      FPConditionalMoveInstruction,
      AMD3DNow : Boolean;
      CPUName : String;
    end;
    {информация об идентификации процессора}
    function ExistCPUID:Boolean;
    function CPUIDInfo(out info: TCPUInfo):Boolean;
    {инф-я о технологии процессора}
    function ExistMMX:Boolean;
    function Exist3DNow:Boolean;
    function ExistKNI:Boolean;
    {------------------------}
    procedure EMMS;
    procedure FEMMS;
    procedure PREFETCH(p: Pointer); register;
     
    implementation
     
    function ExistCPUID : Boolean;
    asm
      pushfd
      pop eax
      mov ebx, eax
      xor eax, 00200000h
      push eax
      popfd
      pushfd
      pop ecx
      mov eax,0
      cmp ecx, ebx
      jz @NO_CPUID
      inc eax
    @NO_CPUID:
    end;
     
    function CPUIDInfo(out info: TCPUIDInfo):Boolean;
     
    function ExistExtendedCPUIDFunctions:Boolean;
    asm
      mov eax,080000000h
      db $0F,$A2
    end;
    
    var
      name : array [0..47] of Char;
      p : Pointer;
    
    begin
      if ExistCPUID then
      asm
        jmp @Start
        @BitLoop:
        mov al,dl
        and al,1
        mov [edi],al
        shr edx,1
        inc edi
        loop @BitLoop
        ret
        @Start:
        mov edi,info
        mov eax,0
        db $0F,$A2
        mov [edi],ebx
        mov [edi+4],edx
        mov [edi+8],ecx
        mov eax,1
        db $0F,$A2
        mov ebx,eax
        and eax,0fh;
        mov [edi+12],eax;
        shr ebx,4
        mov eax,ebx
        and eax,0fh
        mov [edi+12+4],eax
        shr ebx,4
        mov eax,ebx
        and eax,0fh
        mov [edi+12+8],eax
        add edi,24
        mov ecx,6
        call @BitLoop
        shr edx,1
        mov ecx,3
        call @BitLoop
        shr edx,2
        mov ecx,2
        call @BitLoop
        shr edx,1
        mov ecx,1
        call @BitLoop
        shr edx,7
        mov ecx,1
        call @BitLoop
        mov p,edi
      end;
      
      if (info.IDString = 'AuthenticAMD') and ExistExtendedCPUIDFunctions then
      begin
        asm
          mov edi,p
          mov eax,080000001h
          db $0F,$A2
          mov eax,edx
          shr eax,11
          and al,1
          mov [edi],al
          mov eax,edx
          shr eax,16
          and al,1
          mov [edi+1],al
          mov eax,edx
          shr eax,31
          and al,1
          mov [edi+2],al
          lea edi,name
          mov eax,0
          mov [edi],eax
          mov eax,080000000h
          db $0F,$A2
          cmp eax,080000004h
          jl @NoString
          mov eax,080000002h
          db $0F,$A2
          mov [edi],eax
          mov [edi+4],ebx
          mov [edi+8],ecx
          mov [edi+12],edx
          add edi,16
          mov eax,080000003h
          db $0F,$A2
          mov [edi],eax
          mov [edi+4],ebx
          mov [edi+8],ecx
          mov [edi+12],edx
          add edi,16
          mov eax,080000004h
          db $0F,$A2
          mov [edi],eax
          mov [edi+4],ebx
          mov [edi+8],ecx
          mov [edi+12],edx
        @NoString:
        end;
        info.CPUName:=name;
      end
      else with info do
      begin
        SYSCALLandSYSRET:=False;
        FPConditionalMoveInstruction:=False;
        AMD3DNow:=False;
        CPUName:='';
      end;
      Result:=ExistCPUID;
    end;
     
    function ExistMMX:Boolean;
    var
      info : TCPUIDInfo;
    begin
      if CPUIDInfo(info) then
        Result:=info.MMX
      else
        Result:=False;
    end;
     
    function Exist3DNow:Boolean;
    var
      info : TCPUIDInfo;
    begin
      if CPUIDInfo(info) then
        Result:=info.AMD3DNow
      else
        Result:=False;
    end;
     
    function ExistKNI:Boolean;
    begin
      Result:=False;
    end;
     
    procedure EMMS;
    asm
      db $0F,$77
    end;
     
    procedure FEMMS;
    asm
      db $0F,$03
    end;
     
    procedure PREFETCH(p: Pointer); register;
    asm
    // PREFETCH byte ptr [eax]
    end;
     
    end.

------------------------------------------------------------------------

Вариант 5:

Author: -=LTi=-

Source: <https://www.swissdelphicenter.ch>

    //Sometimes u need to know some information about the CPU 
    //like: brand id, factory speed, wich instruction set supported etc. 
    //If so, than u can use this code. 
    //2002 by -=LTi=- 
     
    unit main;
     
     interface
     
     uses
       Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
       StdCtrls, ExtCtrls;
     
     type
       Tfrm_main = class(TForm)
         img_info: TImage;
         procedure FormShow(Sender: TObject);
       private
         { Private declarations }
       public
         { Public declarations }
         procedure info(s1, s2: string);
       end;
     
     var
       frm_main: Tfrm_main;
       gn_speed_y: Integer;
       gn_text_y: Integer;
     const
       gn_speed_x: Integer = 8;
       gn_text_x: Integer  = 15;
       gl_start: Boolean   = True;
     
     implementation
     
     {$R *.DFM}
     
     procedure Tfrm_main.FormShow(Sender: TObject);
     var
       _eax, _ebx, _ecx, _edx: Longword;
       i: Integer;
       b: Byte;
       b1: Word;
       s, s1, s2, s3, s_all: string;
     begin
       //Set the startup colour of the image 
       img_info.Canvas.Brush.Color := clblue;
       img_info.Canvas.FillRect(rect(0, 0, img_info.Width, img_info.Height));
     
     
       gn_text_y := 5; //position of the 1st text 
     
       asm                //asm call to the CPUID inst. 
         mov eax,0        //sub. func call 
         db $0F,$A2       //db $0F,$A2 = CPUID instruction 
         mov _ebx,ebx
         mov _ecx,ecx
         mov _edx,edx
       end;
     
       for i := 0 to 3 do   //extract vendor id 
       begin
         b := lo(_ebx);
         s := s + chr(b);
         b := lo(_ecx);
         s1:= s1 + chr(b);
         b := lo(_edx);
         s2:= s2 + chr(b);
         _ebx := _ebx shr 8;
         _ecx := _ecx shr 8;
         _edx := _edx shr 8;
       end;
       info('CPU', '');
       info('   - ' + 'Vendor ID: ', s + s2 + s1);
     
       asm
         mov eax,1
         db $0F,$A2
         mov _eax,eax
         mov _ebx,ebx
         mov _ecx,ecx
         mov _edx,edx
       end;
       //06B1 
       //|0000| |0000 0000| |0000| |00| |00| |0110| |1011| |0001| 
       b := lo(_eax) and 15;
       info('   - ' + 'Stepping ID: ', IntToStr(b));
       b := lo(_eax) shr 4;
       info('   - ' + 'Model Number: ', IntToHex(b, 1));
       b := hi(_eax) and 15;
       info('   - ' + 'Family Code: ', IntToStr(b));
       b := hi(_eax) shr 4;
       info('   - ' + 'Processor Type: ', IntToStr(b));
       //31.   28. 27.   24. 23.   20. 19.   16. 
       //  0 0 0 0   0 0 0 0   0 0 0 0   0 0 0 0 
       b := lo((_eax shr 16)) and 15;
       info('   - ' + 'Extended Model: ', IntToStr(b));
     
       b := lo((_eax shr 20));
       info('   - ' + 'Extended Family: ', IntToStr(b));
     
       b := lo(_ebx);
       info('   - ' + 'Brand ID: ', IntToStr(b));
       b := hi(_ebx);
       info('   - ' + 'Chunks: ', IntToStr(b));
       b := lo(_ebx shr 16);
       info('   - ' + 'Count: ', IntToStr(b));
       b := hi(_ebx shr 16);
       info('   - ' + 'APIC ID: ', IntToStr(b));
     
       //Bit 18 =? 1     //is serial number enabled? 
       if (_edx and $40000) = $40000 then
         info('   - ' + 'Serial Number ', 'Enabled')
       else
         info('   - ' + 'Serial Number ', 'Disabled');
     
       s := IntToHex(_eax, 8);
       asm                  //determine the serial number 
        mov eax,3
         db $0F,$A2
         mov _ecx,ecx
         mov _edx,edx
       end;
       s1 := IntToHex(_edx, 8);
       s2 := IntToHex(_ecx, 8);
       Insert('-', s, 5);
       Insert('-', s1, 5);
       Insert('-', s2, 5);
       info('   - ' + 'Serial Number: ', s + '-' + s1 + '-' + s2);
     
       asm
         mov eax,1
         db $0F,$A2
         mov _edx,edx
       end;
       info('', '');
       //Bit 23 =? 1 
       if (_edx and $800000) = $800000 then
         info('MMX ', 'Supported')
       else
         info('MMX ', 'Not Supported');
     
       //Bit 24 =? 1 
       if (_edx and $01000000) = $01000000 then
         info('FXSAVE & FXRSTOR Instructions ', 'Supported')
       else
         info('FXSAVE & FXRSTOR Instructions Not ', 'Supported');
     
       //Bit 25 =? 1 
       if (_edx and $02000000) = $02000000 then
         info('SSE ', 'Supported')
       else
         info('SSE ', 'Not Supported');
     
       //Bit 26 =? 1 
       if (_edx and $04000000) = $04000000 then
         info('SSE2 ', 'Supported')
       else
         info('SSE2 ', 'Not Supported');
     
       info('', '');
     
       asm     //execute the extended CPUID inst. 
         mov eax,$80000000   //sub. func call 
         db $0F,$A2
         mov _eax,eax
       end;
     
       if _eax > $80000000 then  //any other sub. funct avail. ? 
       begin
         info('Extended CPUID: ', 'Supported');
         info('   - Largest Function Supported: ', IntToStr(_eax - $80000000));
         asm     //get brand ID 
           mov eax,$80000002
           db $0F
           db $A2
           mov _eax,eax
           mov _ebx,ebx
           mov _ecx,ecx
           mov _edx,edx
         end;
         s  := '';
         s1 := '';
         s2 := '';
         s3 := '';
         for i := 0 to 3 do
         begin
           b := lo(_eax);
           s3:= s3 + chr(b);
           b := lo(_ebx);
           s := s + chr(b);
           b := lo(_ecx);
           s1 := s1 + chr(b);
           b := lo(_edx);
           s2 := s2 + chr(b);
           _eax := _eax shr 8;
           _ebx := _ebx shr 8;
           _ecx := _ecx shr 8;
           _edx := _edx shr 8;
         end;
     
         s_all := s3 + s + s1 + s2;
     
         asm
           mov eax,$80000003
           db $0F
           db $A2
           mov _eax,eax
           mov _ebx,ebx
           mov _ecx,ecx
           mov _edx,edx
         end;
         s  := '';
         s1 := '';
         s2 := '';
         s3 := '';
         for i := 0 to 3 do
         begin
           b := lo(_eax);
           s3 := s3 + chr(b);
           b := lo(_ebx);
           s := s + chr(b);
           b := lo(_ecx);
           s1 := s1 + chr(b);
           b := lo(_edx);
           s2 := s2 + chr(b);
           _eax := _eax shr 8;
           _ebx := _ebx shr 8;
           _ecx := _ecx shr 8;
           _edx := _edx shr 8;
         end;
         
         s_all := s_all + s3 + s + s1 + s2;
     
         asm
           mov eax,$80000004
           db $0F
           db $A2
           mov _eax,eax
           mov _ebx,ebx
           mov _ecx,ecx
           mov _edx,edx
         end;
         s  := '';
         s1 := '';
         s2 := '';
         s3 := '';
         for i := 0 to 3 do
         begin
           b  := lo(_eax);
           s3 := s3 + chr(b);
           b := lo(_ebx);
           s := s + chr(b);
           b := lo(_ecx);
           s1 := s1 + chr(b);
           b  := lo(_edx);
           s2 := s2 + chr(b);
           _eax := _eax shr 8;
           _ebx := _ebx shr 8;
           _ecx := _ecx shr 8;
           _edx := _edx shr 8;
         end;
         info('Brand String: ', '');
         if s2[Length(s2)] = #0 then
           setlength(s2, Length(s2) - 1);
         info('', '   - ' + s_all + s3 + s + s1 + s2);
       end
       else
         info('   - Extended CPUID ', 'Not Supported.');
     end;
     
     procedure Tfrm_main.info(s1, s2: string);
     begin
       if s1 <> '' then
       begin
         img_info.Canvas.Brush.Color := clblue;
         img_info.Canvas.Font.Color  := clyellow;
         img_info.Canvas.TextOut(gn_text_x, gn_text_y, s1);
       end;
       if s2 <> '' then
       begin
         img_info.Canvas.Brush.Color := clblue;
         img_info.Canvas.Font.Color  := clWhite;
         img_info.Canvas.TextOut(gn_text_x + img_info.Canvas.TextWidth(s1), gn_text_y, s2);
       end;
       Inc(gn_text_y, 13);
     end;
     
     end.


------------------------------------------------------------------------

Вариант 6:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    function GetProcessorType: integer;
    {Определение типа процессора.
    Функция возвращает следующие значения,
    определенные в модуле Windows:
    PROCESSOR_INTEL_386
    PROCESSOR_INTEL_486
    PROCESSOR_INTEL_PENTIUM
    PROCESSOR_MIPS_R4000 - Windows NT only
    PROCESSOR_ALPHA_21064 - Windows NT only}
    var
      sysInfo: TSystemInfo;
    begin
      GetSystemInfo(sysInfo);
      Result := sysInfo.dwProcessorType;
    end;


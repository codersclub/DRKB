---
Title: Как вычислить CRC (контрольную сумму) для файла?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как вычислить CRC (контрольную сумму) для файла?
================================================


    function GetCheckSum(FileName: string): DWORD; 
    var 
      F: file of DWORD; 
      P: Pointer; 
      Fsize: DWORD; 
      Buffer: array [0..500] of DWORD; 
    begin 
      FileMode := 0; 
      AssignFile(F, FileName); 
      Reset(F); 
      Seek(F, FileSize(F) div 2); 
      Fsize := FileSize(F) - 1 - FilePos(F); 
      if Fsize > 500 then Fsize := 500; 
      BlockRead(F, Buffer, Fsize); 
      Close(F); 
      P := @Buffer; 
      asm 
         xor eax, eax 
         xor ecx, ecx 
         mov edi, p 
         @again: 
           add eax, [edi + 4*ecx] 
           inc ecx 
           cmp ecx, fsize 
         jl @again 
         mov @result, eax 
       end; 
    end; 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      ShowMessage(IntToStr(GetCheckSum('c:\Autoexec.bat'))); 
    end; 


---
Title: Как читать / писать в I/O порты?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как читать / писать в I/O порты?
================================

В Delphi 1 записывать и считывать из портов можно через глобальный
массив 'ports'. Однако данная возможность отсутствует в '32-битном'
Delphi.

Следующие две функции можно использовать в любой версии delphi:

    function InPort(PortAddr:word): byte; 
    {$IFDEF WIN32} 
    assembler; stdcall; 
    asm 
            mov dx,PortAddr 
            in al,dx 
    end; 
    {$ELSE} 
    begin 
      Result := Port[PortAddr]; 
    end; 
    {$ENDIF} 
     
    procedure OutPort(PortAddr:   
              word; Databyte: byte); 
    {$IFDEF WIN32} 
    assembler; stdcall; 
    asm 
       mov al,Databyte 
       mov dx,PortAddr 
       out dx,al 
    end; 
    {$ELSE} 
    begin 
      Port[PortAddr] := DataByte; 
    end; 
    {$ENDIF} 


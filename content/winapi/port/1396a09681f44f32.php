<h1>Как читать / писать в I/O порты?</h1>
<div class="date">01.01.2007</div>


<p>В Delphi 1 записывать и считывать из портов можно через глобальный массив 'ports'. Однако данная возможность отсутствует в '32-битном' Delphi.</p>

<p>Следующие две функции можно использовать в любой версии delphi:</p>
<pre>
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
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>



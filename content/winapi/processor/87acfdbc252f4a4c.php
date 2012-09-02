<h1>Работа с портами микропроцессора</h1>
<div class="date">01.01.2007</div>


<p class="author">Автор: Pavlo Zolotarenki&nbsp; </p>

<p>Модуль для работы с портами микропроцессора с сохранением синтаксиса.</p>
<p>Работает под Win9x.</p>
<p>НЕ работает под WinNT.</p>
<pre>
//Copyright(c) 1998 Zolotarenko P.V pvz@mail.univ.kiev.ua
 
unit Ports;
interface
type
 
  TPort = class
  private
    procedure Set_(index_: word; value: byte); register;
    function Get_(index_: word): byte; register;
  public
    property Element[index_: word]: byte read Get_ write Set_; default;
  end;
 
  TPortW = class
  private
    procedure Set_(index_: word; value: Word); register;
    function Get_(index_: word): word; register;
  public
    property Element[index_: word]: word read Get_ write Set_; default;
  end;
 
var
  Port: TPort;
  PortW: TportW;
 
implementation
 
procedure TPort.Set_(index_: word; value: byte);
begin
  asm
    mov dx,index_
    mov al,value
    out dx,al
  end;
end;
 
function TPort.Get_(index_: word): byte;
begin
  asm
    mov dx,index_
    in al,dx
    mov @Result,al
  end;
end;
 
procedure TPortW.Set_(index_: word; value: word);
begin
  asm
    mov dx,index_
    mov ax,value
    out dx,ax
  end;
end;
 
function TPortW.Get_(index_: word): word;
begin
  asm
    mov dx,index_
    in ax,dx
    mov @Result,ax
  end;
end;
 
initialization
  Port := TPort.Create;
  PortW := TPortW.Create;
finalization
  Port.free;
  PortW.free;
end.
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

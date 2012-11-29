Работа с портами микропроцессора
================================

::: {.date}
01.01.2007
:::

Автор: Pavlo Zolotarenki 

Модуль для работы с портами микропроцессора с сохранением синтаксиса.

Работает под Win9x.

НЕ работает под WinNT.

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

Взято с <https://delphiworld.narod.ru>

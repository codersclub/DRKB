---
Title: URL кодирование строки
Author: Dimka Maslov, mainbox@endimus.ru
Date: 27.05.2002
---


URL кодирование строки
======================

    { **** UBPFD *********** by kladovka.net.ru ****
    >> URL кодирование строки
     
    Функция производит так назваемое URL кодирование строк для 
    использования в http запросах. Т.е. все алфавитно-цифровые 
    символы и знак подчёикивания '_' остаются неизменными, 
    пробел заменяется на '+', а все остальные символы на знак 
    процента '%' с двумя шестнадцатеричными цифрами.
     
    Зависимости: Windows
    Автор:       Dimka Maslov, mainbox@endimus.ru, ICQ:148442121, Санкт-Петербург
    Copyright:   Dimka Maslov
    Дата:        27 мая 2002 г.
    ********************************************** }
     
    function UrlEncode(Str: string): string;
     
    function CharToHex(Ch: Char): Integer;
     asm
        and eax, 0FFh
        mov ah, al
        shr al, 4
        and ah, 00fh
        cmp al, 00ah
        jl @@10
        sub al, 00ah
        add al, 041h
        jmp @@20
    @@10:
        add al, 030h
    @@20:
        cmp ah, 00ah
        jl @@30
        sub ah, 00ah
        add ah, 041h
        jmp @@40
    @@30:
        add ah, 030h
    @@40:
        shl eax, 8
        mov al, '%'
    end;
     
    var
     i, Len: Integer;
     Ch: Char;
     N: Integer; P: PChar;
    begin
     Result:='';
     Len:=Length(Str);
     P:=PChar(@N);
     for i:=1 to Len do begin
      Ch:=Str[i];
      if Ch in ['0'..'9', 'A'..'Z', 'a'..'z', '_'] then Result:=Result+Ch else begin
       if Ch = ' ' then Result:=Result+'+' else begin
        N:=CharToHex(Ch);
        Result:=Result+P;
       end;
      end;
     end;
    end; 

Пример использования:

    procedure TForm1.Button1Click(Sender: TObject);
    var
     S: string;
    begin
     S:=UrlEncode('Мастера Delphi');
     ShellExecute(Handle, 'open',
      PChar('http://www.yandex.ru/yandsearch?text='+S), '', '', SW_SHOWNORMAL);
    end; 

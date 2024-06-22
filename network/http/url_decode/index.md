---
Title: URL декодирование строки
Author: Dimka Maslov, mainbox@endimus.ru
Date: 27.05.2002
---


URL декодирование строки
========================

    { **** UBPFD *********** by kladovka.net.ru ****
    >> URL декодирование строки
     
    Функция выполняет URL декодирование строки, заменяя все 
    подстроки вида '%HH', где 'HH' - шестнадцатеричные 
    цифры, на соответствующие символы.
     
    Зависимости: Windows
    Автор:       Dimka Maslov, mainbox@endimus.ru, ICQ:148442121, Санкт-Петербург
    Copyright:   Dimka Maslov
    Дата:        27 мая 2002 г.
    ********************************************** }
     
    function UrlDecode(Str: string): string;
     
    function HexToChar(W: word): Char;
    asm
       cmp ah, 030h
       jl @@error
       cmp ah, 039h
       jg @@10
       sub ah, 30h
       jmp @@30
    @@10:
       cmp ah, 041h
       jl @@error
       cmp ah, 046h
       jg @@20
       sub ah, 041h
       add ah, 00Ah
       jmp @@30
    @@20:
       cmp ah, 061h
       jl @@error
       cmp al, 066h
       jg @@error
       sub ah, 061h
       add ah, 00Ah
    @@30:
       cmp al, 030h
       jl @@error
       cmp al, 039h
       jg @@40
       sub al, 030h
       jmp @@60
    @@40:
       cmp al, 041h
       jl @@error
       cmp al, 046h
       jg @@50
       sub al, 041h
       add al, 00Ah
       jmp @@60
    @@50:
       cmp al, 061h
       jl @@error
       cmp al, 066h
       jg @@error
       sub al, 061h
       add al, 00Ah
    @@60:
       shl al, 4
       or al, ah
       ret
    @@error:
       xor al, al
    end;
     
    function GetCh(P: PChar; var Ch: Char): Char;
    begin
     Ch:=P^;
     Result:=Ch;
    end;
     
    var
     P: PChar;
     Ch: Char;
    begin
     Result:='';
     P:=@Str[1];
     while GetCh(P, Ch) <> #0 do begin
      case Ch of
       '+': Result:=Result+' ';
       '%': begin
        Inc(P);
        Result:=Result+HexToChar(PWord(P)^);
        Inc(P);
       end;
       else Result:=Result+Ch;
      end;
      Inc(P);
     end;
    end;

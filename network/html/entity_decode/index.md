---
Title: Функция декодирования текста HTML, содержащего строки вида \&amp;\#123; в читабельный вид
Author: RAdmin
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Функция декодирования текста HTML, содержащего строки вида \&amp;\#123; в читабельный вид
==================================================================================

    Function PreDecode(s:string):string;
      function AddNumericChar(I: Integer):string;
      var
        W: WideChar;
        Buffer: array[0..10] of char;
      begin
        if I = 9 then result := ' '
           else if I < ord(' ') then  result := '?'  {control char}
               else if (I < 256)  then   result := Chr(I)
        else
        begin
        W := WideChar(I);
        SetString(result, Buffer, WideCharToMultiByte(CP_ACP, 0,
              @W, 1, @Buffer, SizeOf(Buffer), nil, nil))
        end;
      end;
     
    var val,i,ik:integer; sq:string;
    begin
      for i:=1 to Length(s) do
      begin
          if ( (s[i]='&') and (s[i+1] ='#') ) then
           begin
              sq := Copy(s,i+2,length(s));
              for ik:=1 to length(sq) do
              begin
                if not ( sq[ik] in ['0'..'9'] ) then
                break;
              end;
              if  Copy(sq,1,ik-1) <> '' then
              val := StrToInt( Copy(sq,1,ik-1) ) else val:=-1;
              if ( (val <> -1) and (sq[ik] = ';')  )
              then
               begin
                 Result:=Result+AddNumericChar(val);
                 Delete(s,i,ik+1);
                end;
           end else  result:=Result+s[i];
      end;
     
    end;


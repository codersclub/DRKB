---
Title: Проверка правильности E-mail адреса
Author: Udo Nesshoever
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Проверка правильности E-mail адреса
===================================

Если пользователю Вашего приложения необходимо вводить почтовый адрес,
то возникает потребность в проверке адреса на правильнось. Конечно
способов сделать это существует множество, но этот, на мой взгляд, самый
короткий и доступный для понимания.

Совместимость: Delphi 3.x (или выше)

    function IsValidEmail(const Value: string): boolean; 
      function CheckAllowed(const s: string): boolean; 
      var 
        i: integer; 
      begin 
        Result:= false; 
        for i:= 1 to Length(s) do 
        begin 
          { недопустимый символ в s - значит недопустимый адрес } 
          if not (s[i] in ['a'..'z', 'A'..'Z', '0'..'9', '_', '-', '.']) then 
            Exit; 
        end; 
        Result:= true; 
      end; 
    var 
      i: integer; 
      namePart, serverPart: string; 
    begin // начало выполнения IsValidEmail 
      Result:= false; 
      i:= Pos('@', Value); 
      if i = 0 then 
        Exit; 
      namePart:= Copy(Value, 1, i - 1); 
      serverPart:= Copy(Value, i + 1, Length(Value)); 
      // @ не указано имя         имя или сервер не указаны; минимально для сервера. "a.com" 
      if (Length(namePart) = 0) or ((Length(serverPart) < 1)) then 
        Exit; 
      i:= Pos('.', serverPart); 
      // должно иметь точку и как минимум два знака от конца 
      if (i = 0) or (i > (Length(serverPart) - 1)) then 
        Exit; 
      Result:= CheckAllowed(namePart) and CheckAllowed(serverPart); 
    end; 


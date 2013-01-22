---
Title: Преобразование строки в число
Date: 01.01.2007
---


Преобразование строки в число
=============================

::: {.date}
01.01.2007
:::

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Преобразование сроки в число
     
    Преобразует строку в число, при этом удаля из строки все лишние символы
     
    Зависимости: нет
    Автор:       Separator, vilgelm@mail.kz, ICQ:162770303, Алматы
    Copyright:   Separator
    Дата:        7 мая 2003 г.
    ***************************************************** }
     
    function StringToNumber(const Value: string): string;
    var
      ResStr: string;
      i, j, L: integer;
      Ch: char;
      E, DS: boolean;
     
    begin
      Result := '0';
      L := Length(Value);
      if L <> 0 then
      begin
        SetLength(ResStr, L);
        E := false;
        DS := false;
        j := 0;
        for i := 1 to L do
        begin
          Ch := Value[i];
          case Ch of
            '0'..'9':
              begin
                Inc(j);
                ResStr[j] := Ch
              end; //'0'..'9': begin
            '.', ',': if (not DS) and (not E) and (i <> L) then
              begin
                DS := true;
                Ch := DecimalSeparator;
                if j = 0 then
                begin
                  Inc(j);
                  ResStr[j] := '0';
                end; //if j = 0 then begin
                Inc(j);
                ResStr[j] := Ch
              end; //'.', ',': if (not DS) and (i <> L) then begin
            'e', 'E': if (not E) and (i <> L) then
              begin
                E := true;
                Ch := 'E';
                if j = 0 then
                begin
                  Inc(j);
                  ResStr[j] := '0';
                end; //if j = 0 then begin
                Inc(j);
                ResStr[j] := Ch
              end //'.', ',': if (not DS) and (i <> L) then begin
          end //case Ch of
        end; //for i:= 1 to L do begin
        if j <> 0 then
        begin
          if ResStr[j] = 'E' then
            Dec(j);
          if ResStr[j] = DecimalSeparator then
            Dec(j);
          SetLength(ResStr, j);
          Result := ResStr
        end //if j <> 0 then begin
      end //if L <> 0 then begin
    end;
    Пример использования: 
     
    Edit1.Text = ',...,fgftgtr656,.567erdf..5,,632'
    Edit2.Text := StringToNumber(Edit1.Text);
    Edit2.Text = 0, 656567E5632

------------------------------------------------------------------------

    type 
      TCharSet = set of Char; 
     
    function StripNonConforming(const S: string; 
      const ValidChars: TCharSet): string; 
    var 
      DestI: Integer; 
      SourceI: Integer; 
    begin 
      SetLength(Result, Length(S)); 
      DestI := 0; 
      for SourceI := 1 to Length(S) do 
        if S[SourceI] in ValidChars then 
        begin 
          Inc(DestI); 
          Result[DestI] := S[SourceI] 
        end; 
      SetLength(Result, DestI) 
    end; 
     
    function StripNonNumeric(const S: string): string; 
    begin 
      Result := StripNonConforming(S, ['0'..'9']) 
    end;
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

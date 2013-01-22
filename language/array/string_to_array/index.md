---
Title: String -> Array
Date: 01.01.2007
---


String -> Array
===============

::: {.date}
01.01.2007
:::

    Procedure AssignFixedString( Var FixedStr: Array of Char; Const S: String
    );
    Var
      maxlen: Integer;
    Begin
      maxlen := Succ( High( FixedStr ) - Low( FixedStr ));
      FillChar( FixedStr, maxlen, ' ' ); { blank fixed string }
      If Length(S) > maxlen Then
        Move( S[1], FixedStr, maxlen )
      Else
        Move( S[1], FixedStr, Length(S));
    End;

 

------------------------------------------------------------------------

    function StrToArrays(str, r: string; out Temp: TStrings): Boolean;
    var
      j: integer;
    begin
      if temp <> nil then
      begin
        temp.Clear;
        while str <> '' do
        begin
          j := Pos(r,str);
          if j=0 then
            j := Length(str) + 1;
          temp.Add(Copy(Str,1,j-1));
          Delete(Str,1,j+length(r)-1);
        end;
        Result:=True;
      end
      else
        Result:=False;
    end;
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

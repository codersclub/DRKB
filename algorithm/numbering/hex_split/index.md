---
Title: Разбиение шестнадцатиричной величины
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Разбиение шестнадцатиричной величины
====================================


    Function LoNibble ( X : Byte ) : Byte;
    Begin
      Result := X And $F;
    End;
     
    Function HiNibble ( X : Byte ) : Byte;
    Begin
      Result := X Shr 4;
    End;

Приведенные функции разделят ваше число на две половинки, нижнюю и
верхнюю. Если вам необходимо отображать их с ведущим нулем, то
используйте IntToHex подобным образом:

    Label1.Caption := 'Верхняя часть - ' + IntToHex ( HiNibble ( $2E ), 2 );
    Label2.Caption := 'Нижняя часть - ' + IntToHex ( LoNibble ( $2E ), 2 ); 




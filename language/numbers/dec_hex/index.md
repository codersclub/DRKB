---
Title: Dec -> Hex
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Dec -> Hex
==========

    function dec2hex(value: dword): string[8];
    const
      hexdigit = '0123456789ABCDEF';
    begin
      while value <> 0 do
      begin
        dec2hex := hexdigit[succ(value and $F)];
        value := value shr 4;
      end;
      if dec2hex = '' then dec2hex := '0';
    end;


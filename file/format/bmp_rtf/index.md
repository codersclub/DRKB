---
Title: Конвертирование BMP -> RTF
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Конвертирование BMP -> RTF
==========

    function BitmapToRTF(pict: TBitmap): string; 
    var 
      bi, bb, rtf: string; 
      bis, bbs: Cardinal; 
      achar: ShortString; 
      hexpict: string; 
      I: Integer; 
    begin 
      GetDIBSizes(pict.Handle, bis, bbs); 
      SetLength(bi, bis); 
      SetLength(bb, bbs); 
      GetDIB(pict.Handle, pict.Palette, PChar(bi)^, PChar(bb)^); 
      rtf := '{\rtf1 {\pict\dibitmap0 '; 
      SetLength(hexpict, (Length(bb) + Length(bi)) * 2); 
      I := 2; 
      for bis := 1 to Length(bi) do 
      begin 
        achar := IntToHex(Integer(bi[bis]), 2); 
        hexpict[I - 1] := achar[1]; 
        hexpict[I] := achar[2]; 
        Inc(I, 2); 
      end; 
      for bbs := 1 to Length(bb) do 
      begin 
        achar := IntToHex(Integer(bb[bbs]), 2); 
        hexpict[I - 1] := achar[1]; 
        hexpict[I] := achar[2]; 
        Inc(I, 2); 
      end; 
      rtf := rtf + hexpict + ' }}'; 
      Result := rtf; 
    end; 


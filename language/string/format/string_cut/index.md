---
Title: Обрезание строки по длине
Author: \_\_\_Nikolay
Date: 01.01.2007
---


Обрезание строки по длине
=========================

::: {.date}
01.01.2007
:::

Автор: \_\_\_Nikolay

    // Обрезание строки по длине
    function TfmDW6Main.BeautyStr(s: string; iLength: integer): string;
    var
      bm: TBitmap;
      sResult: string;
      iStrLen: integer;
      bAdd: boolean;
    begin
      Result := s;
      if Trim(s) = '' then
        exit;
     
      bAdd := false;
        sResult := s;
      bm := TBitmap.Create;
      bm.Width := 100;
      bm.Height := 100;
      iStrLen := bm.Canvas.TextWidth(sResult);
      while iStrLen > iLength do
      begin
        if Length(sResult) < 4 then
          break;
     
        Delete(sResult, Length(sResult) - 2, 3);
        bAdd := true;
        iStrLen := bm.Canvas.TextWidth(sResult);
      end;
     
      if (iStrLen <= iLength) and bAdd then
        sResult := sResult + '...';
     
      bm.Free;
      Result := sResult;
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

 

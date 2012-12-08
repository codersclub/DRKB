---
Title: Как вставить картинку в TRichEdit?
Author: Vit
Date: 01.01.2007
---


Как вставить картинку в TRichEdit?
==================================

::: {.date}
01.01.2007
:::

В стандартном RichEdit нельзя, для RichEdit с картинками используйте
RichEdit из RxLib или JVCL.

Автор: Vit

Взято с Vingrad.ru <https://forum.vingrad.ru>

------------------------------------------------------------------------

Ниже представлен пример, который можно применить к RxRichEdit,
RichEditEx, RichEdit98, и Microsoft RichTextBox (поставляемый с VB5+) не
прибегая к использованию буфера обмена или OLE:

    function BitmapToRTF(pict: TBitmap): string;
    var
      bi,bb,rtf: string;
      bis,bbs: Cardinal;
      achar: ShortString;
      hexpict: string;
      I: Integer;
    begin
      GetDIBSizes(pict.Handle,bis,bbs);
      SetLength(bi,bis);
      SetLength(bb,bbs);
      GetDIB(pict.Handle,pict.Palette,PChar(bi)^,PChar(bb)^);
      rtf := '{\rtf1 {\pict\dibitmap ';
      SetLength(hexpict,(Length(bb) + Length(bi)) * 2);
      I := 2;
      for bis := 1 to Length(bi) do
      begin
        achar := Format('%x',[Integer(bi[bis])]);
        if Length(achar) = 1 then
          achar := '0' + achar;
        hexpict[I-1] := achar[1];
        hexpict[I] := achar[2];
        Inc(I,2);
      end;
      for bbs := 1 to Length(bb) do
      begin
        achar := Format('%x',[Integer(bb[bbs])]);
        if Length(achar) = 1 then
          achar := '0' + achar;
        hexpict[I-1] := achar[1];
        hexpict[I] := achar[2];
        Inc(I,2);
      end;
      rtf := rtf + hexpict + ' }}';
      Result := rtf;
    end;

А вот пример использования этой функции:

    {SS это TStringStream, RE это TRxRichEdit, а BMP это TBitmap содержащий картинку.}
    SS := TStringStream.Create(BitmapToRTF(BMP));
    RE.PlainText := False;
    RE.StreamMode := [smSelection];
    RE.Lines.LoadFromStream(SS);
    SS.Free;

Взято из <https://forum.sources.ru>

---
Title: Встроенные форматы буфера обмена
Author: Peter Below
Date: 01.01.2007
---


Встроенные форматы буфера обмена
================================

::: {.date}
01.01.2007
:::

Автор: Peter Below

    procedure TForm1.BtnShowFormatsClick(Sender: TObject);
    var
      buf: array[0..60] of Char;
      n: Integer;
      fmt: Word;
      name: string[30];
    begin
      MemFormats.Clear;
      for n := 0 to Clipboard.FormatCount - 1 do
      begin
        fmt := Clipboard.Formats[n];
        if GetclipboardFormatName(fmt, buf, Pred(Sizeof(buf))) <> 0 then
          MemFormats.Lines.Add(StrPas(buf))
        else
        begin
          case fmt of
            1: name := 'CF_TEXT';
            2: name := 'CF_BITMAP';
            3: name := 'CF_METAFILEPICT';
            4: name := 'CF_SYLK';
            5: name := 'CF_DIF';
            6: name := 'CF_TIFF';
            7: name := 'CF_OEMTEXT';
            8: name := 'CF_DIB';
            9: name := 'CF_PALETTE';
            10: name := 'CF_PENDATA';
            11: name := 'CF_RIFF';
            12: name := 'CF_WAVE';
            13: name := 'CF_UNICODETEXT';
            14: name := 'CF_ENHMETAFILE';
            15: name := 'CF_HDROP (Win 95)';
            16: name := 'CF_LOCALE (Win 95)';
            17: name := 'CF_MAX (Win 95)';
            $0080: name := 'CF_OWNERDISPLAY';
            $0081: name := 'CF_DSPTEXT';
            $0082: name := 'CF_DSPBITMAP';
            $0083: name := 'CF_DSPMETAFILEPICT';
            $008E: name := 'CF_DSPENHMETAFILE';
            $0200..$02FF: name := 'частный формат';
            $0300..$03FF: name := 'Объект GDI';
          else
            name := 'неизвестный формат';
          end;
          MemFormats.Lines.Add(name);
        end;
      end;
    end;

Взято с <https://delphiworld.narod.ru>

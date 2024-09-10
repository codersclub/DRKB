---
Title: Получить список шрифтов и их размеров для текущего принтера
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---

Получить список шрифтов и их размеров для текущего принтера
===========================================================

Следующий пример помещает в компонент TMemo список шрифтов и их размеров
для текущего принтера.

    uses Printers;
     
    function EnumFontFamilyProc(var lf: TLogFont;
      var tm: TNewTextMetric;
      FontType: integer;
      var Memo: TMemo): integer
    {$IFDEF WIN32} stdcall;
    {$ELSE}; export;
    {$ENDIF}
    begin
      Memo.Lines.Add(StrPas(@lf.lfFaceName) +
        #32 + IntToStr(lf.lfHeight));
      result := 1;
    end;
     
    function EnumFontFamiliesProc(var lf: TLogFont;
      var tm: TNewTextMetric;
      FontType: integer;
      var Memo: TMemo): integer
    {$IFDEF WIN32} stdcall;
    {$ELSE}; export;
    {$ENDIF}
    begin
      if FontType = TRUETYPE_FONTTYPE then
      begin
        Memo.Lines.Add(StrPas(@lf.lfFaceName) + #32 + 'All Sizes');
      end
      else
        EnumFontFamilies(Printer.Handle,
          @lf.lfFaceName,
          @EnumFontFamilyProc,
          LongInt(@Memo));
      result := 1;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      tm: TTextMetric;
      i: integer;
    begin
      if PrintDialog1.Execute then
      begin
        EnumFontFamilies(Printer.Handle,
          nil,
          @EnumFontFamiliesProc,
          LongInt(@Memo1));
      end;
    end;


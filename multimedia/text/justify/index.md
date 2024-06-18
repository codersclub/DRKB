---
Title: Выравнивание текста по ширине
Author: Даниил Карапетян (delphi4all@narod.ru)
Date: 01.01.2007
---


Выравнивание текста по ширине
=============================
Текст выглядит лучше, если он выровнен по двух краям. Для этого пробелы
в каждой строке нужно удлинять или укорачивать так, чтобы все строки
имели одну длину.

Здесь создана процедура GetLine, которая возвращает одну строку, начиная
с заданного символа. Программа находит разницу между шириной текста и
реальной длинной строки и при выводе компенсирует эту разницу удлинением
пробелов.

Эта программа выводит на экран текст из файла C:\\text.txt, выравнивая
его по двум краям.

    type
      ...
      TLine = record
        s: string;
        wrap: boolean;
        length: integer;
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    const
      FileName = 'C:\text.txt';
     
    var
      s: string;
      bm: TBitMap;
      LineH: integer;
      MaxTextWidth: integer;
     
    procedure TForm1.FormCreate(Sender: TObject);
    var
      F: TFileStream;
      buf: array [0..127] of char;
     
      l: integer;
    begin
      ScrollBar1.Kind := sbVertical;
      bm := TBitMap.Create;
      with bm.Canvas.Font do begin
        Name := 'Serif';
        Size := 12;
      end;
      LineH := bm.Canvas.TextHeight('123');
     
      if not FileExists(FileName) then begin
        ShowMessage('Can not find file ' + FileName);
        Exit;
      end;
      F := TFileStream.Create(FileName, fmOpenRead);
      repeat
        l := F.Read(buf, 128);
     
        if l = 128
          then s := s + buf
          else s := s + copy(buf, 1, l);
      until l < 128;
      F.Destroy;
    end;
     
    procedure TForm1.FormResize(Sender: TObject);
    begin
      PaintBox1.Left := 0;
      PaintBox1.Top := 0;
      PaintBox1.Height := Form1.ClientHeight;
      PaintBox1.Width := Form1.ClientWidth - ScrollBar1.Width;
      ScrollBar1.Left := PaintBox1.Width;
      ScrollBar1.Top := 0;
      ScrollBar1.Height := PaintBox1.Height;
     
      bm.Width := PaintBox1.Width;
      bm.Height := PaintBox1.Height;
      ScrollBar1.Max := 1000;
      MaxTextWidth := PaintBox1.Width - 20;
    end;
     
    function RealTextWidth(s: string): integer;
    var
      i: integer;
    begin
      result := bm.Canvas.TextWidth(s);
      for i := 1 to Length(s) do
        if s[i] = #9 then
          inc(result, 40 - bm.Canvas.TextWidth(#9));
    end;
     
    function GetLine(index: integer): TLine;
     
    var
      i: integer;
      s1: string;
      first: integer;
    begin
      if (s[index] = #13) and (s[index + 1] = #10) then begin
        result.s := '';
        result.length := 2;
        result.wrap := true;
        Exit;
      end;
      first := index;
      while (first <= Length(s)) and (s[first] in [#32]) do inc(first);
      i := first;
      repeat
        while (i <= Length(s)) and (not (s[i] in [#9, #32])) and (s[i] <> #13) do
     
          inc(i);
        s1 := copy(s, first, i - index);
        inc(i);
      until (i >= Length(s)) or (s[i-1] = #13) or (RealTextWidth(s1) > MaxTextWidth);
      if RealTextWidth(s1) > MaxTextWidth then begin
        result.wrap := false;
        if i < Length(s) then begin
          dec(i, 2);
          while (i > 0) and (not (s[i] in [#9, #32])) do dec(i);
          result.Length := i - index;
     
          while (i > 0) and (s[i] in [#9, #32]) do dec(i);
        end;
        result.s := copy(s, first, i - index + 1);
        if result.s[length(result.s)] = #32 then
          delete(result.s, length(result.s), 1);
      end else begin
        result.length := i - index + 1;
        s1 := copy(s, first, i - index + 1);
        if length(s1) > 0 then begin
          if s1[Length(s1)] = #9
     
            then delete(s1, Length(s1), 1);
          if s1[length(s1) - 1] + s1[length(s1)] = #13#10
            then delete(s1, length(s1) - 1, 2);
        end;
        result.s := s1;
        result.wrap := true;
      end;
    end;
     
     
    procedure draw;
    var
      i, j: integer;
      line: TLine;
      OneWord: string;
      LineN: integer;
      SpaceCount: integer;
      TextLeft: integer;
      shift, allshift: integer;
      d: integer;
      LineCount: integer;
     
    begin
      with bm.Canvas do begin
        FillRect(ClipRect);
        i := 1;
        LineCount := 0;
        for j := 1 to Form1.ScrollBar1.Position do begin
          line := GetLine(i);
          inc(i, line.length);
          inc(LineCount);
        end;
        LineN := 0;
        repeat
          line := GetLine(i);
          SpaceCount := 0;
          TextLeft := 0;
          for j := 1 to Length(line.s) do
            if line.s[j] = #32 then inc(SpaceCount);
     
          if line.wrap = false
            then allshift := MaxTextWidth - RealTextWidth(line.s)
            else allshift := 0;
          if allshift > 40 * SpaceCount then allshift := 0;
          shift := 0;
          for j := 1 to Length(line.s) do begin
            if (not (line.s[j] in [#9, #32])) and (j < Length(line.s)) then begin
              OneWord := OneWord + line.s[j];
     
            end else begin
              OneWord := OneWord + line.s[j];
              if OneWord = #9 then begin
                inc(TextLeft, 40);
              end else begin
                if OneWord = #13#10 then begin
                  inc(LineN);
                end else begin
                  TextOut(10 + TextLeft, LineN * LineH, OneWord);
                  if SpaceCount = 0
     
                    then d := 0
                    else d := (allshift - shift) div (SpaceCount);
                  inc(shift, d);
                  inc(TextLeft, TextWidth(OneWord) + d);
                  dec(SpaceCount);
                end;
              end;  
              OneWord := '';
            end;
          end;
          inc(i, line.length);
          inc(LineN);
        until (LineN * LineH > Form1.PaintBox1.Height) or (i >= Length(s));
     
        repeat
          line := GetLine(i);
          inc(i, line.length);
          inc(LineCount);
        until i >= Length(s);
        inc(LineCount, LineN);
        Form1.ScrollBar1.Max := LineCount -
          Form1.PaintBox1.Height div LineH;
      end;
      Form1.PaintBox1.Canvas.Draw(0, 0, bm);
    end;
     
    procedure TForm1.PaintBox1Paint(Sender: TObject);
    begin
      draw;
    end;
     
    procedure TForm1.ScrollBar1Change(Sender: TObject);
     
    begin
      draw;
    end;

Автор справки: Алексей Денисов (aleksey@sch103.krasnoyarsk.su)

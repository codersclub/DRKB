---
Title: Конвертирование HTML -> RTF
Author: Falk Schulze
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Конвертирование HTML -> RTF
===========

    { HTML to RTF by Falk Schulze }
     
    procedure HTMLtoRTF(html: string; var rtf: TRichedit);
    var
      i, dummy, row: Integer;
      cfont: TFont; 
      Tag, tagparams: string;
      params: TStringList;
     
      function GetTag(s: string; var i: Integer; var Tag, tagparams: string): Boolean;
      var 
        a_tag: Boolean;
      begin
        GetTag  := False;
        Tag  := '';
        tagparams := '';
        a_tag  := False;
     
        while i <= Length(s) do 
        begin
          Inc(i);
          if s[i] = '<' then 
          begin
            GetTag := False;
            Exit;
          end;
     
          if s[i] = '>' then 
          begin
            GetTag := True;
            Exit;
          end;
     
          if not a_tag then 
          begin
            if s[i] = ' ' then 
            begin
              if Tag <> '' then a_tag := True;
            end 
            else 
              Tag := Tag + s[i];
          end 
          else
            tagparams := tagparams + s[i];
        end;
      end;
     
      procedure GetTagParams(tagparams: string; var params: TStringList);
      var 
        i: Integer;
        s: string;
        gleich: Boolean;
        function notGleich(s: string; i: Integer): Boolean;
        begin
          notGleich := True;
          while i <= Length(s) do 
          begin
            Inc(i);
            if s[i] = '=' then 
            begin
              notGleich := False;
              Exit;
            end 
            else if s[i] <> ' ' then Exit;
          end;
        end;
      begin
        Params.Clear;
        s := '';
        for i := 1 to Length(tagparams) do 
        begin
          if (tagparams[i] <> ' ') then 
          begin
            if tagparams[i] <> '=' then gleich := False;
            if (tagparams[i] <> '''') and (tagparams[i] <> '"') then s := s + tagparams[i]
          end 
          else 
          begin
            if (notGleich(tagparams, i)) and (not Gleich) then 
            begin
              params.Add(s);
              s := '';
            end 
            else 
              Gleich := True;
          end;
        end;
        params.Add(s);
      end;
     
      function HtmlToColor(Color: string): TColor;
      begin
        Result := StringToColor('$' + Copy(Color, 6, 2) + Copy(Color, 4,
          2) + Copy(Color, 2, 2));
      end;
     
      procedure TransformSpecialChars(var s: string; i: Integer);
      var 
        c: string;
        z, z2: Byte;
        i2: Integer;
      const 
        nchars = 9;
        chars: array[1..nchars, 1..2] of string =
          (('O', 'O'), ('o', 'o'), ('A', 'A'), ('a', 'a'),
          ('U', 'U'), ('u', 'u'), ('?', '?'), ('<', '<'),
          ('>', '>'));
      begin
        c  := '';
        i2 := i;
        for z := 1 to 7 do 
        begin
          c := c + s[i2];
          for z2 := 1 to nchars do 
          begin
            if chars[z2, 1] = c then 
            begin
              Delete(s, i, Length(c));
              Insert(chars[z2, 2], s, i);
              Exit;
            end;
          end;
          Inc(i2);
        end;
      end;
      function CalculateRTFSize(pt: Integer): Integer;
      begin
        case pt of
          1: Result := 6;
          2: Result := 9;
          3: Result := 12;
          4: Result := 15;
          5: Result := 18;
          6: Result := 22;
          else 
            Result := 30;
        end;
      end;
     
     
    type 
      fontstack = record
        Font: array[1..100] of tfont;
        Pos: Byte;
      end;
     
      procedure CreateFontStack(var s: fontstack);
      begin
        s.Pos := 0;
      end;
     
      procedure PushFontStack(var s: Fontstack; fnt: TFont);
      begin
        Inc(s.Pos);
        s.Font[s.Pos] := TFont.Create;
        s.Font[s.Pos].Assign(fnt);
      end;
     
      procedure PopFontStack(var s: Fontstack; var fnt: TFont);
      begin
        if (s.Font[s.Pos] <> nil) and (s.Pos > 0) then 
        begin
          fnt.Assign(s.Font[s.Pos]);
          s.Font[s.Pos].Free;
          Dec(s.Pos);
        end;
      end;
     
      procedure FreeFontStack(var s: Fontstack);
      begin
        while s.Pos > 0 do 
        begin
          s.Font[s.Pos].Free;
          Dec(s.Pos);
        end;
      end;
    var 
      fo_cnt: array[1..1000] of tfont;
      fo_liste: array[1..1000] of Boolean;
      fo_pos: TStringList;
      fo_stk: FontStack;
      wordwrap, liste: Boolean;
    begin
      CreateFontStack(fo_Stk);
     
      fo_Pos := TStringList.Create;
     
      rtf.Lines.BeginUpdate;
      rtf.Lines.Clear;
      wordwrap  := rtf.wordwrap;
      rtf.WordWrap := False;
     
      rtf.Lines.Add('');
      Params := TStringList.Create;
     
     
     
      cfont := TFont.Create;
      cfont.Assign(rtf.Font);
     
     
      i := 1;
      row := 0;
      Liste := False;
      rtf.selstart := 0;
      if Length(html) = 0 then Exit;
      repeat;
     
     
        if html[i] = '<' then 
        begin
          dummy := i;
          GetTag(html, i, Tag, tagparams);
          GetTagParams(tagparams, params);
     
          if Uppercase(Tag) = 'FONT' then 
          begin
            pushFontstack(fo_stk, cfont);
            if params.Values['size'] <> '' then
              cfont.Size := CalculateRTFSize(StrToInt(params.Values['size']));
     
            if params.Values['color'] <> '' then cfont.Color :=
                htmltocolor(params.Values['color']);
          end 
          else if Uppercase(Tag) = '/FONT' then  popFontstack(fo_stk, cfont) 
          else 
          if Uppercase(Tag) = 'H1' then 
          begin
            pushFontstack(fo_stk, cfont);
            cfont.Size := 6;
          end 
          else if Uppercase(Tag) = '/H1' then  popFontstack(fo_stk, cfont) 
          else 
          if Uppercase(Tag) = 'H2' then 
          begin
            pushFontstack(fo_stk, cfont);
            cfont.Size := 9;
          end 
          else if Uppercase(Tag) = '/H2' then  popFontstack(fo_stk, cfont) 
          else 
          if Uppercase(Tag) = 'H3' then 
          begin
            pushFontstack(fo_stk, cfont);
            cfont.Size := 12;
          end 
          else if Uppercase(Tag) = '/H3' then  popFontstack(fo_stk, cfont) 
          else 
          if Uppercase(Tag) = 'H4' then 
          begin
            pushFontstack(fo_stk, cfont);
            cfont.Size := 15;
          end 
          else if Uppercase(Tag) = '/H4' then  popFontstack(fo_stk, cfont) 
          else 
          if Uppercase(Tag) = 'H5' then 
          begin
            pushFontstack(fo_stk, cfont);
            cfont.Size := 18;
          end 
          else if Uppercase(Tag) = '/H5' then  popFontstack(fo_stk, cfont) 
          else 
          if Uppercase(Tag) = 'H6' then 
          begin
            pushFontstack(fo_stk, cfont);
            cfont.Size := 22;
          end 
          else if Uppercase(Tag) = '/H6' then  popFontstack(fo_stk, cfont) 
          else 
          if Uppercase(Tag) = 'H7' then 
          begin
            pushFontstack(fo_stk, cfont);
            cfont.Size := 27;
          end 
          else if Uppercase(Tag) = '/H7' then  popFontstack(fo_stk, cfont) 
          else 
     
          if Uppercase(Tag) = 'B' then cfont.Style := cfont.Style + [fsbold] 
          else if Uppercase(Tag) = '/B' then cfont.Style := cfont.Style - [fsbold] 
          else 
     
          if Uppercase(Tag) = 'I' then cfont.Style := cfont.Style + [fsitalic] 
          else if Uppercase(Tag) = '/I' then cfont.Style := cfont.Style - [fsitalic] 
          else 
     
          if Uppercase(Tag) = 'U' then cfont.Style := cfont.Style + [fsunderline] 
          else if Uppercase(Tag) = '/U' then cfont.Style := cfont.Style - [fsunderline] 
          else 
     
          if Uppercase(Tag) = 'UL' then liste := True 
          else if Uppercase(Tag) = '/UL' then 
          begin
            liste := False;
            rtf.Lines.Add('');
            Inc(row);
            rtf.Lines.Add('');
            Inc(row);
          end 
          else 
     
          if (Uppercase(Tag) = 'BR') or (Uppercase(Tag) = 'LI') then 
          begin
            rtf.Lines.Add('');
            Inc(row);
          end;
          // else rtf.Lines[row]:=RTF.lines[row]+'<'+tag+' '+tagparams+'>';
          fo_pos.Add(IntToStr(rtf.selstart));
          fo_cnt[fo_pos.Count] := TFont.Create;
          fo_cnt[fo_pos.Count].Assign(cfont);
          fo_liste[fo_pos.Count] := liste;
        end 
        else 
        begin
          if html[i] = '&' then Transformspecialchars(html, i);
     
          if (Ord(html[i]) <> 13) and (Ord(html[i]) <> 10) then
            rtf.Lines[row] := RTF.Lines[row] + html[i];
        end;
     
        Inc(i);
     
      until i >= Length(html);
      fo_pos.Add('999999');
     
      for i := 0 to fo_pos.Count - 2 do 
      begin
        rtf.SelStart := StrToInt(fo_pos[i]);
        rtf.SelLength := StrToInt(fo_pos[i + 1]) - rtf.SelStart;
        rtf.SelAttributes.Style := fo_cnt[i + 1].Style;
        rtf.SelAttributes.Size := fo_cnt[i + 1].Size;
        rtf.SelAttributes.Color := fo_cnt[i + 1].Color;
        fo_cnt[i + 1].Free;
      end;
     
      i := 0;
      while i <= fo_pos.Count - 2 do 
      begin
        if fo_liste[i + 1] then 
        begin
          rtf.SelStart := StrToInt(fo_pos[i + 1]);
          while fo_liste[i + 1] do Inc(i);
          rtf.SelLength := StrToInt(fo_pos[i - 1]) - rtf.SelStart;
          rtf.Paragraph.Numbering := nsBullet;
        end;
        Inc(i);
      end;
      rtf.Lines.EndUpdate;
      Params.Free;
      cfont.Free;
      rtf.WordWrap := wordwrap;
      FreeFontStack(fo_stk);
    end;


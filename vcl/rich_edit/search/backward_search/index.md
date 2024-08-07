---
Title: Обратный поиск строки в TRichEdit
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Обратный поиск строки в TRichEdit
=================================

    {+------------------------------------------------------------ 
     | Function FindTextBackwards 
     | 
     | Parameters : 
     |   findWhat: text to find 
     |   inString: string to find it in 
     |   startAt : character index to start at (1-based) 
     |   caseSensitive: determines whether search is case-sensitive 
     |   words   : if true the characters immediately surrounding 
     |             a found location must not be alphanumeric 
     | Returns    : 
     |   character index (1-based) of first character of a found 
     |   location, or 0, if the text was not found. 
     | Description: 
     |   Performs a simple sequential search for a string in a larger 
     |   string, starting at the specified position and working towards 
     |   the start of the string. 
     | Error Conditions: none 
     | Created: 27.02.99 by P. Below 
     +------------------------------------------------------------}
     
     function FindTextBackwards(findWhat, inString : string;
       startAt : integer;
       caseSensitive, words : boolean): integer;
     var
       i, patternlen, findpos : integer;
       lastchar, firstchar : char;
     begin
       Result := 0;  { assume failure }
       patternlen := Length(findWhat);
     
       { Do a few sanity checks on the parameters }
       if (patternlen = 0) or
         (startAt < patternlen) or
         (Length(inString) < patternlen) then
         Exit;
     
       if not caseSensitive then
        begin
         { convert both strings to lower case }
         findWhat := AnsiLowercase(findWhat);
         inString := AnsiLowercase(inString);
       end; { If }
     
       i := startAt;
       lastchar := findWhat[patternlen];
       firstchar := findWhat[1];
     
       while (Result = 0) and (i >= patternlen) do
        begin
         if inString[i] = lastchar then
          begin
           findPos := i - patternlen + 1;
           if inString[findPos] = firstchar then
            begin
             { We have a candidate. Compare the substring of length 
              patternlen starting at findPos with findWhat. With 
              AnsiStrLComp we can do that without having to copy 
              the substring to a temp string first. }
             if AnsiStrLComp(@findWhat[1], @inString[findPos],
               patternlen) = 0 then
              begin
               { We have a match! }
               Result := findPos;
     
               if words then
                begin
                 { Check the characters surrounding the hit. For the hit 
                  to constitute a word they must not be alphanumeric. }
                 if (findPos > 1) and
                   IsCharAlphanumeric(inString[findPos - 1]) then
                  begin
                   { Not a match after all, <sigh>. }
                   Result := 0;
                 end { If }
                 else
                  begin
                   if (i < Length(inString)) and
                     IsCharAlphanumeric(inString[i + 1]) then
                    begin
                     { Not a match after all, <sigh>. }
                     Result := 0;
                   end; { If }
                 end; { Else }
               end; { If }
             end; { If }
           end; { If }
         end; { If }
         Dec(i);
       end; { While }
     end; { FindTextBackwards }
     
     procedure TForm1.Button1Click(Sender : TObject);
     var
       findPos : integer;
     begin
       findPos := FindTextBackwards(findEdit.Text,
         richedit1.Text,
         richedit1.selstart + 1,
         caseCheckbox.Checked,
         wordsCheckbox.Checked);
       if findPos > 0 then
        begin
         with richedit1 do
          begin
           selstart := findPos - 1;
           sellength := findEdit.GetTextLen;
           Perform(em_scrollcaret, 0, 0);
           SetFocus;
         end;
       end
       else
         ShowMessage('Text not found');
     end;


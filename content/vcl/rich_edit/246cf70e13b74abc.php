<h1>Показывать значки элементов списка в TRichEdit</h1>
<div class="date">01.01.2007</div>


<pre>
uses
   RichEdit;
 
 procedure TForm1.Button1Click(Sender: TObject);
 var
   fmt: TParaformat2;
 begin
   FillChar(fmt, SizeOf(fmt), 0);
   fmt.cbSize := SizeOf(fmt);
   // The PARAFORMAT2 structure is used to set the numbering style. 
  // This is done through the following structure members: 
  fmt.dwMask := PFM_NUMBERING or PFM_NUMBERINGSTART or PFM_NUMBERINGSTYLE or
                 PFM_NUMBERINGTAB;
       // Set the following values (bitwise-or them together) to identify 
      // which of the remaining structure members are valid: 
      // PFM_NUMBERING, PFM_NUMBERINGSTART, PFM_NUMBERINGSTYLE, and PFM_NUMBERINGTAB 
  fmt.wNumbering := 2;
       //0 no numbering or bullets 
      //1 (PFN_BULLET) uses bullet character 
      //2 Uses Arabic numbers (1, 2, 3, ...). 
      //3 Uses lowercase letters (a, b, c, ...). 
      //4 Uses uppercase letters (A, B, C, ...). 
      //5 Uses lowercase Roman numerals (i, ii, iii, ...). 
      //6 Uses uppercase Roman numerals (I, II, III, ...). 
      //7 Uses a sequence of characters beginning with the Unicode 
      //  character specified by the wNumberingStart member. 
  fmt.wNumberingStart := 1;
       //  Starting value for numbering. 
  fmt.wNumberingStyle := $200;
       // Styles for numbering: 
      // 0 : Follows the number with a right parenthesis.  1) 
      // $100 : Encloses the number in parentheses.       (1) 
      // $200 : Follows the number with a period.          1. 
      // $300 : Displays only the number.                  1 
      // $400 : Continues a numbered list without applying the next number or bullet. 
      // $8000 : Starts a new number with wNumberingStart. 
  fmt.wNumberingTab := 1440 div 4;
   // Minimum space between a paragraph number and the paragraph text, in twips 
 
  RichEdit1.Perform(EM_SETPARAFORMAT, 0, lParam(@fmt));
 end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>

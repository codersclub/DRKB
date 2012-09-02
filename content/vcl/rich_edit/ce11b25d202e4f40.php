<h1>Задать расстояние между строк для TRichEdit</h1>
<div class="date">01.01.2007</div>


<pre>
uses
   RichEdit;
 
 procedure RE_SetLineSpacing(ARichEdit: TRichEdit; lineSpacing: Byte);
 var
   pf2: ParaFormat2;
 begin
   FillChar(pf2, SizeOf(pf2), 0);
   pf2.cbSize := SizeOf(PARAFORMAT2);
   pf2.dwMask := PFM_LINESPACING;
   pf2.bLineSpacingRule := lineSpacing;
   SendMessage(ARichEdit.Handle, EM_SETPARAFORMAT, 0, Longint(@pf2));
 end;
 
 //Example: Setlinespacing to 1: 
procedure TForm1.Button1Click(Sender: TObject);
 begin
   RE_SetLineSpacing(RichEdit1, 1);
 end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>

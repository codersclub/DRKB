<h1>Как использовать верхние и нижние индексы?</h1>
<div class="date">01.01.2007</div>


<p>RichEdit поддерживает верхние/нижние индексы;</p>
<p>Вот как это делается:</p>
<pre>
uses RichEdit;
 
procedure TForm1.Button1Click(Sender: TObject);
var
  CF: TCharFormat;
begin
  cf.cbSize := sizeof(cf);
  cf.dwMask := CFM_OFFSET;
  cf.yOffset := 70; // смещение по y; положительное/отрицательное для смещение верх/вниз
  RichEdit1.Perform(EM_SETCHARFORMAT, SCF_SELECTION, integer(@cf));
end;
</pre>


<p>SCF_ALL применить ко всему тексту</p>
<p>SCF_SELECTION применить к веделенному тексту</p>
<p>SCF_WORD | SCF_SELECTION применить к выделенным словам</p>

<p>Взято из MSDN. Проверено на Delphi7. Это работает. Попробый сделать сам, чтобы верхние/нижние индексы имели меньший размер.</p>

<p>Тем более это работает в rxRichEdit.</p>

<div class="author">Автор: Seti</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

<hr />
<pre>
// yOffset values 
type
   TCharacterFormat = (CFM_Superscript, CFM_Subscript, CFM_Normal);
 
 procedure RE_SetCharFormat(RichEdit: TRichEdit; CharacterFormat: TCharacterFormat);
 var
   // The CHARFORMAT structure contains information about 
  // character formatting in a rich edit control. 
  Format: TCharFormat;
 begin
   FillChar(Format, SizeOf(Format), 0);
   with Format do
   begin
     cbSize := SizeOf(Format);
     dwMask := CFM_OFFSET;
     // Character offset, in twips, from the baseline. 
    // If the value of this member is positive, 
    // the character is a superscript; 
    // if it is negative, the character is a subscript. 
    case CharacterFormat of
       CFM_Superscript: yOffset := 60;
       CFM_Subscript: yOffset := -60;
       CFM_Normal: yOffset := 0;
     end;
   end;
   // The EM_SETCHARFORMAT message sets character formatting in a rich edit control. 
  // SCF_SELECTION: Applies the formatting to the current selection 
  Richedit.Perform(EM_SETCHARFORMAT, SCF_SELECTION, Longint(@Format));
 end;
 
 // Examples: 
// Beispiele: 
 
// Apply Superscript to the current selection 
// Markierte Zeichen hoch stellen 
procedure TForm1.Button1Click(Sender: TObject);
 begin
   RE_SetCharFormat(RichEdit1, CFM_Superscript);
 end;
 
 // Apply Subscript to the current selection 
// Markierte Zeichen tief stellen 
procedure TForm1.Button2Click(Sender: TObject);
 begin
   RE_SetCharFormat(RichEdit1, CFM_Subscript);
 end;
</pre>

<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>

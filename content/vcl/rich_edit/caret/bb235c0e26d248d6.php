<h1>Перейти на строку в TRichEdit</h1>
<div class="date">01.01.2007</div>


<pre>
with Richedit1 do
begin
     selstart := perform( EM_LINEINDEX, linenumber, 0 );
     perform( EM_SCROLLCARET, 0, 0 );
end;
 
{
The EM_LINEINDEX message returns the character index of the first character
on a given line, assigning that to selstart moves the caret to that position.
The control will only automatically scroll the caret into view if it has
the focus, thus the EM_SCROLLCARET.
}
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
&nbsp;</p>

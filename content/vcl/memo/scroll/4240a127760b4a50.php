<h1>Как програмно прокрутить Memo?</h1>
<div class="date">01.01.2007</div>


<p>Этот пример прокручивает на одну строку вниз.</p>
<pre>
memo1.Perform(WM_VScroll, SB_LINEDOWN,0);
</pre>

<p>Возможны так же следующие опции:</p>
<p>SB_BOTTOM</p>
<p>SB_ENDSCROLL</p>
<p>SB_LINEDOWN </p>
<p>SB_LINEUP </p>
<p>SB_PAGEDOWN</p>
<p>SB_PAGEUP </p>
<p>SB_THUMBPOSITION</p>
<p>SB_THUMBTRACK </p>
<p>SB_TOP</p>
<p>TComboBox, TListBox, TRichEdit и т.п можно прокрутить подобным образом </p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr />
<p>В поле ввода вводите на какую строку нужно сойти, и по нажатию на кнопку эта строка будет попадать о зону видимости: </p>
<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
  line: integer;
begin
  line := StrToIntDef(Edit1.Text,1);
  Memo1.SelStart := Memo1.Perform(EM_LINEINDEX, line, 0);
  Memo1.Perform(EM_SCROLLCARET, 0, 0);
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
&nbsp;</p>
<hr />
<pre>
Var
  ScrollMessage:TWMVScroll;
begin
  ScrollMessage.Msg:=WM_VScroll;
  for i := Memo1.Lines.Count DownTo 0 do
  begin
    ScrollMessage.ScrollCode:=sb_LineUp;
    ScrollMessage.Pos:=0;
    Memo1.Dispatch(ScrollMessage);
  end;
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

<h1>Установка каретки в TRichEdit</h1>
<div class="date">01.01.2007</div>


<p>Узнать положение курсора в RichEdit не составляет труда (richedit.getcaret). А вот как установить каретку в нужное место?</p>
<pre>
Procedure setline(WhichEdit:TRichedit;Linepos,charpos:integer);
Begin
with WhichEdit do
begin
  selstart:=perform(EM_LineIndex,Linenum,0)+charpos;
  perform(EM_ScrollCaret,0,0);
end;
end;
</pre>

<p>Комментарии:</p>
<p>Если Вам не нужно, чтобы происходил скроллинг к позиции каретки, то EM_ScrollCaret можно убрать. Эта процедура так же может быть использована для TMemo, только надо будет заменить объявление witchedit на TMemo:</p>
<p>Procedure CustomMemoSetline(WhichEdit:TCustomMemo;Linepos,charpos:integer);</p>

<p>Так же эту процедуру можно использовать как ответ на вопрос "Как установить фокус на определённую строку в компоненте Memo ?". Для этого необходимо добавить следующий код после строки selstart:</p>
<p>sellength:=length(lines(line));</p>
<p>И установить charpos в 0.</p>

<p>RichEdit должен иметь фокус, иначе em_ScrollCaret не сработает.</p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

<hr />
<pre>
// You can move the caret in a TRichEdit component by using this code : 
 
procedure RichEdit_MoveTo(RichEdit: TRichEdit; LineNumber, CharNumber: Word);
 begin
   RichEdit.SelStart := RichEdit.Perform(EM_LINEINDEX, LineNumber, 0) + CharNumber);
 end;
 
 procedure TForm1.Button1Click(Sender: TObject);
 begin
   RichEdit_MoveTo(RichEdit1,2,5);
   Application.ProcessMessages;
   RichEdit1.SetFocus;
 end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>


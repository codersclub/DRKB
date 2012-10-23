<h1>Как заставить кнопку Enter работать наподобие Tab?</h1>
<div class="date">01.01.2007</div>


<div class="author">Автор: Khaled Shagrouni </div>

<p>Как-то бухгалтер, который пользовался моей программой, заявил, что ему не удобно перескакивать пустые поля в форме кнопкой Tab, и что намного удобнее это делать обычным Enter-ом. Предлагаю посмотреть, как я решил эту проблемму.</p>

<p>Совместимость: Все версии Delphi</p>

<p>  Пример обработчика события:</p>
<pre>
procedure Tform1.FormKeyDown(Sender: TObject; var Key: Word; 
  Shift: TShiftState); 
var 
  ACtrl: TWinControl; 
begin 
  if key = 13 then 
    begin 
      ACtrl := ActiveControl; 
      if ACtrl is TCustomMemo then exit; 
      repeat 
        ACtrl:= FindNextControl(ACtrl,true,true,false); 
      until (ACtrl is TCustomEdit) or 
      (ACtrl is TCustomComboBox) or 
      (ACtrl is TCustomListBox) or 
      (ACtrl is TCustomCheckBox) or 
      (ACtrl is TRadioButton); 
      ACtrl.SetFocus ; 
    end; 
end; 
</pre>

<p>Не забудьте установить свойство формы KeyPreview в true.</p>

<p>Как Вы можете видеть; этот код использует функцию FindNextControl, которая ищет следующий свободный контрол.</p>

<p>так как все формы в моём приложении наследуются от одной, то достаточно поместить этот код в главную форму и после этого все формы будут реагировать на нажатие Enter подобным образом.</p>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

<hr />
<p>Существует множество методов решения этой проблемы, но самый быстрый способ, это перехват нажатия клавиш, перед тем как их получит форма:</p>

<p>В секции формы PRIVATE добавьте:</p>
<pre>
Procedure CMDialogKey(Var Msg:TWMKey); message CM_DIALOGKEY; 
</pre>

<p>В секции IMPLEMENTATION добавьте:</p>

<pre>
Procedure TForm1.CMDialogKey(Var Msg: TWMKey); 
Begin 
If NOT (ActiveControl Is TButton) Then 
If Msg.Charcode = 13 Then 
Msg.Charcode := 9; 
inherited; 
End;
</pre>

<p>Тем самым мы исключаем срабатывания нашей подмены, если фокус находится на кнопке.</p>

<p>Чтобы ускорить работу приложения, не надо активизировать свойство формы KEYPREVIEW</p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>


<hr />
<pre>
procedure TForm1.FormCreate(Sender: TObject);
begin
  Form1.KeyPreview := true;
end;
 
procedure TForm1.FormKeyDown(Sender: TObject; var Key: Word;
  Shift: TShiftState);
var
  c: TControl;
begin
  if Key &lt;&gt; 13 then
    Exit;
  repeat
    c := Form1.FindNextControl(Form1.ActiveControl, true, true, true);
    (c as TWinControl).SetFocus;
  until
    c is TEdit;
end;
</pre>

<a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

<hr />
<pre>
procedure TForm1.Edit1KeyPress(Sender: TObject; var Key: Char);
begin
  if Key = Chr(VK_RETURN) then
  begin
    Perform(WM_NEXTDLGCTL,0,0);
    key:= #0;
  end;
end;
</pre>

<a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

<hr />
<pre>
procedure TForm1.FormKeyPress(Sender: TObject; var Key: Char);
begin
 if Key = #13 then
 begin
   SelectNext(Sender as TWinControl, True, True);
   Key := #0;
 end;
end;
</pre>

<a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

<hr />
<pre>
{ 
  This code gives the  key the same habbit as the key to 
  change focus between Controls. 
}
 
 // Form1.KeyPreview := True ! 
 
procedure TForm1.FormKeyPress(Sender: TObject; var Key: Char);
 begin
   if Key = #13 then
   begin
     Key := #0;
     { check if SHIFT - Key is pressed }
     if GetKeyState(VK_Shift) and $8000 &lt;&gt; 0 then
       PostMessage(Handle, WM_NEXTDLGCTL, 1, 0)
     else
       PostMessage(Handle, WM_NEXTDLGCTL, 0, 0);
   end;
 end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>


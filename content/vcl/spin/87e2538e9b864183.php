<h1>Проблема потери фокуса для TEdit</h1>
<div class="date">01.01.2007</div>

To Reproduce the Problem:</p>
<p>1. Drop two TEdits onto a form.</p>
<p>2. In the OnExit Event of Edit1 add the following code:</p>
<pre>
Application.MessageBox( 'Title','...', mb_ok );
</pre>
<p>3. Run the application.</p>
<p>4. First select Edit1 then Edit2</p>
<p>5. The Message box is shown.</p>
<p>Click the OK button, and the Caret has dissapeared!</p>
<p>6. How to handle this:</p>
<pre>
 procedure TForm1.Edit1Exit(Sender: TObject);
 begin
  Application.MessageBox('qq','qq',mb_ok);
  if Assigned(ActiveControl) then
    PostMessage(ActiveControl.Handle,WM_SETFOCUS,0,0);
 end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>

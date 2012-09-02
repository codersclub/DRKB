<h1>Можно ли динамически менять какая форма считается главной в приложении во время работы программы?</h1>
<div class="date">01.01.2007</div>


<p>Можно, но только во время загрузки приложения. Чтобы сделать это выберите "View-&gt;Project Source" и измените код инициализации приложения, так что порядок создания форм зависил от какого-то условия. </p>
<p class="note">Примечание</p>
<p>Вам придется редактировать этот код, если Вы добавите в приложение новые формы.</p>
<pre>
begin
  Application.Initialize;
  if &lt; какое - то условие &gt; then
    begin
      Application.CreateForm(TForm1, Form1);
      Application.CreateForm(TForm2, Form2);
    end
  else
    begin
      Application.CreateForm(TForm2, Form2);
      Application.CreateForm(TForm1, Form1);
    end;
end.
Application.Run;
</pre>



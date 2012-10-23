<h1>Как сделать клавишу-акселератор (keyboard shortcut) компонету, у которого нет заголовка?</h1>
<div class="date">01.01.2007</div>

<p>Возможный вариант - присвоить ссылку на этот компонент свойству FocusControl TLabel'а. В примере используется невидимый Label для создания "быстрой" клавиши (Alt+M) компонента Memo. Чтобы использовать пример, разместите на форме компонент TMemo, Label и несколько других компонентов, которые могут принимать фокус ввода. Запустите программу, переведите фокус ввода куда-нибудь вне Memo и нажмите Alt+M - фокус ввода вернется в Memo.</p>
<pre>
procedure TForm1.FormCreate(Sender: TObject);
begin 
  Label1.Visible := false;
  Label1.Caption := '&amp;M';
  Label1.FocusControl := Memo1;
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>



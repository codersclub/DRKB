<h1>Как отобразить подсказку в TLabel?</h1>
<div class="date">01.01.2007</div>


<p>На форме лежат TEdit, TCheckBox и TLabel. Я бы хотел, чтобы при наведении на TEdit или TCheckBox в TLabel отображалась "подсказка". Т.е. своего рода hint, но только отображаемый в TLabel. Как такое можно сотворить?</p>
<p>Такое поведение Hint в VCL предусмотренно:</p>
<pre>
procedure TForm1.DisplayHint(Sender: TObject);

 
begin
  Label1.caption := GetLongHint(Application.Hint);
end;
 
procedure TForm1.FormCreate(Sender: TObject);
begin
  Application.OnHint := DisplayHint;
end;
</pre>

<p>Теперь все хинты будут показываться на метке.</p>
<div class="author">Автор: Vit</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>


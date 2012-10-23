<h1>Как работать с TOpenFileDialog и TSaveFileDialоg?</h1>
<div class="date">01.01.2007</div>


<p>как именно с ними работать чтобы на с: открыть файл?</p>
<p>Похоже я понял что тебя смущает: OpenFileDialog и SaveFileDialog - ничего сами по себе не открывают и не сохраняют. Они нужны только для выбора имени файла. Ставишь их на форму. Там куча свойств и опций - типа исходны каталог, показыать скрытые файлы или нет и т.п. Впрочем по началу можно их вообще не указывать. Тебе надо знать только 1 метод - execute - открыть диалог:</p>
<pre>
OpenFileDialog1.execute 
</pre>
<p>ты можешь проверить действительно ли пользователь выбрал файл или нажал Cancel:</p>
<pre>
if OpenFileDialog1.execute then 
</pre>
<p>если файл выбран то свойство FileName возвращает тебе строку - имя файла </p>
<pre>
if OpenFileDialog1.execute then showmessage(OpenFileDialog1.FileName);
</pre>
<p>Сам файл не открывается и ничего с ним не делается, все это надо делать вручную:</p>
<pre>
if OpenFileDialog1.execute then
begin
  assignFile(f,OpenFileDialog1.Filename);
  reset(f);
  seek(f, $10000);
  write(f,b);
  CloseFile(f);
end;
</pre>

<div class="author">Автор: Vit</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>


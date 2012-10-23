<h1>Работа с ресурсами</h1>
<div class="date">01.01.2007</div>


<p>Сохранить файл в ресурсе программы на этапе компилляции можно выполнив следующие шаги:</p>
<p>1) Поставить себе RxLib</p>
<p>2) Появится в меню "Project" дополнительный пункт меню "Resources"</p>
<p>3) Открой его , создай новый ресурс "User Data", в него загрузи нужный файл, измени имя ресурса на что-нибудь типа 'MyResName'.</p>
<p>Теперь при компилляции проэкта в exe файл будет прикомпиллирован ваш файл в виде ресурса. Извлечь его на этапе выполнения можно следующим образом:</p>
<pre>
with TResourceStream.Create(hInstance, 'MyResName', RT_RCDATA) do 
  try 
    Seek(0, soFromBeginning); 
    SaveToFile('MyFileName.exe'); 
  finally 
    Free; 
  end;  
</pre>

<div class="author">Автор: Vit</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

<hr />

<p>А вот целый проект, сделанный LENIN INC показывающий различные приёмы работы с ресурсами:</p>
<p><a href="https://vingrad.ru/download/delphi/reswork.zip" target="_blank">reswork.zip</a></p>
<div class="author">Автор: LENIN INC</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

<p>Исходники программы для чтения и изменения ресурсов готовой программы</p>
<p>Большое спасибо Song нашедшему эту программу <a href="https://forum.vingrad.ru/index.php?s=2e1a44e8fd0d842dc2781c6bd964f18a&act=Attach&type=post&id=21633" target="_blank">ResEdit.zip</a></p>
<div class="author">Автор: Song</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>


<h1>Текстовые файлы</h1>
<div class="date">01.01.2007</div>


<p>Текстовый файл отличается тем что он разбит на разные по длине строки, отделенные символами #13#10. Есть 2 основных метода работы с текстовыми файлами - старый паскалевский способ и через файловые потоки. У обоих есть преимущества и недостатки. Через потоки способ проще поэтому начнем с него.</p>
<p>Итак у всех потомков класса TStrings (TStringList, memo.Lines и т.п. ) есть методы записи и чтения в файл - SaveToFile, LoadFromFile. Преимущество - простота использования и довольно высокая скорость, недостаток - читать и писать файл можно только целиком.</p>
<p>Примеры.</p>
<p>1) Загрузка текста из файла в Memo:</p>
<p> Memo1.lines.loadfromfile('c:\MyFile.txt');</p>
<p>2) Сохранение в файл:</p>
<p> Memo1.lines.savetoFile('c:\MyFile.txt');</p>
<p>3) А вот так можно прочитать весь файл в строку:</p>
<pre>
function ReadFromFile(FileName: string): string; 
begin 
  with TStringList.Create do 
  try 
    LoadFromFile(FileName); 
    Result := text; 
  finally 
    Free; 
  end; 
end;
</pre>
<p></p>


<h1>Как разделить строку на элементы? (аналог VB функции Split)</h1>
<div class="date">01.01.2007</div>


<p>Вариант 1. </p>
<p>В Дельфи есть специальный класс для хранения массивов строк - TStringList - очень рекомендую. Вот как вашу строку превратить в TStringList:</p>
<p>Объявление переменной</p>
<pre>
var t:TStringList;
 
begin
  t:=TStringList.create; //создаём класс
  t.text:=stringReplace('Ваша строка для разделения',' ',#13#10,[rfReplaceAll]);//мы заменяем все пробелы на символы конца строки
  //теперь можно убедится что у вас строка разбина на элементы:
  showmessage(t[0]);
  showmessage(t[1]);
  showmessage(t[2]);
  showmessage(t[3]);
  ...
  //после работы надо уничтожить класс
  t.free;
</pre>

<div class="author">Автор: Vit</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr /><p>Вариант 2. Используем стандартные массивы:</p>
<pre>
  var a:array of string;//наш массив
      s:string;//строка которую мы будем разбивать
begin
  s:='Windows Messages SysUtils Variants Classes Graphics Controls Forms';
  Repeat //мы постепенно заполняем массив на каждом шаге цикла по 1 элементу
    setlength(a,length(a)+1);//увеличиваем размер массива на 1
    if pos(' ',s)&gt;0 then //если есть пробел то надо взять слово до пробела
      begin
        a[length(a)-1]:=copy(s,1, pos(' ',s));//присвоение последнему элементу массива первого слова
        s:=copy(s,pos(' ',s)+1, length(s));//удаляем из строки первое слово
      end
    else//в строке осталось только одно слово
      begin
        a[length(a)-1]:=s;// присвоим последнее слово
        break;//выход из цикла
      end;
  Until False;//цикл бесконечный, выход изнутри
//теперь проверяем что получили
  showmessage(a[0]);
  showmessage(a[1]);
  showmessage(a[2]);
</pre>
<p>После использования массива не забудте освободить память a:=nil или setlength(a,0)</p>
<div class="author">Автор: Vit</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr />
<pre>
procedure SplitOnWords(const s:string; Delimiters:set of char; Strings:TStrings);
var
  p,sp:PChar;
  str:string;
 
begin
 include(Delimiters,#0); //чтоб уж наверняк
 p:=pointer(s); 
 while true do
 begin 
   //пропускаем все разделители в начале
   while p^ in Delimiters do 
    if p^=#0 then
      exit
    else
      inc(p);
    sp:=p;
    //пока не кончилось слово.
    while not (p^ in Delimiters) do inc(p);
 
    //запоминаем слово
    SetLength(str,cardinal(p)-cardinal(sp));
    Move(sp^,pointer(str)^,cardinal(p)-cardinal(sp));
    Strings.Add(str);
 end; 
end;
</pre>

<div class="author">Автор: Fantasist</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr /><p>См. также <a href="22008.htm">Парсинг строк</a></p>

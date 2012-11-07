<h1>Как определить, что два слова имеют схожее произношение?</h1>
<div class="date">01.01.2007</div>

<div class="author">Автор: Lloyd</div>
<p>Функция Soundex определяет схожесть звучания двух слов. Алгоритм Soundex опубликован в одной из статей журнала PC Magazine и предназначен для работы с английским языком (может кто-нибудь портирует для работы с нашим могучим? Пишите). Функции передается строка. Возвращаемое Soundex значение также имеет тип строки. Эта величина может сохраняться в базе данных или сравниваться с другим значением Soundex. Если два слова имеют одинаковое значение Soundex, можно предположить, что звучат они одинаково (более или менее).</p>
<p>Вы должны иметь в виду, что алгоритм Soundex игнорирует первую букву слова. Таким образом, "won" и "one" будут иметь различное значение Soundex, а "Won" и "Wunn" - одинаковое.</p>
<p>Soundex будет особенно полезен в базах данных, когда пользователь затрудняется с правописанием имен и фамилий.</p>
<pre>
function Soundex(OriginalWord: string): string;
var
  Tempstring1, Tempstring2: string;
  Count: integer;
begin
  Tempstring1 := '';
  Tempstring2 := '';
  OriginalWord := Uppercase(OriginalWord);
    {Переводим исходное слово в верхний регистр}
  Appendstr(Tempstring1, OriginalWord[1]); {Используем первую букву слова}
  for Count := 2 to length(OriginalWord) do
    {Назначаем числовое значение каждой букве, за исключением первой}
 
    case OriginalWord[Count] of
      'B', 'F', 'P', 'V': Appendstr(Tempstring1, '1');
      'C', 'G', 'J', 'K', 'Q', 'S', 'X', 'Z': Appendstr(Tempstring1, '2');
      'D', 'T': Appendstr(Tempstring1, '3');
      'L': Appendstr(Tempstring1, '4');
      'M', 'N': Appendstr(Tempstring1, '5');
      'R': Appendstr(Tempstring1, '6');
      {Все другие буквы, цифры и знаки пунктуации игнорируются}
    end;
  Appendstr(Tempstring2, OriginalWord[1]);
  {Удаляем из результата все последовательно повторяющиеся цифры.}
 
  for Count := 2 to length(Tempstring1) do
    if Tempstring1[Count - 1] &lt;&gt; Tempstring1[Count] then
      Appendstr(Tempstring2, Tempstring1[Count]);
  Soundex := Tempstring2; {Это - значение soundex}
end;
</pre>
<p>SoundAlike - функция, проверяющая схожесть звучания двух слов. При схожести звучания она возвратит значение True и значение False в противном случае. Она демонстрирует пример использования функции Soundex.</p>
<pre>
function SoundAlike(Word1, Word2: string): boolean;
begin
  if (Word1 = '') and (Word2 = '') then
    result := True
  else if (Word1 = '') or (Word2 = '') then
    result := False
  else if (Soundex(Word1) = Soundex(Word2)) then
    result := True
  else
    result := False;
end;
</pre>


<p>Дополнение</p>
<p>Существует алгоритм ("параметрической корреляции", если я вообще правильно называю его), основанный на оценке схожести слов по количеству совпадающих букв идущих друг за другом. Примечание: буквы не обязательно идут *непосредственно* друг за другом, т.е. без других букв.</p>
<p>Пример:</p>
<p>    Андрей vs. Андрей - 6</p>
<p>    ндрей vs. Андрей - 5</p>
<p>    Анрей vs. Андрей - 5</p>
<p>    Андрей vs. Александр - 4</p>
<p>    Андрей vs. Иннокентий - 2</p>
<p>    АнXрей vs. Андрей - 3, но в то же время с другими словами результат</p>
<p>будет на уровне 0..2</p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

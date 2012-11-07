<h1>Пример переменной записи</h1>
<div class="date">01.01.2007</div>

В Delphi 2.0 я пытаюсь прочесть текстовый файл и получаю проблему. Текстовый файл, который я хочу прочесть, имеет записи фиксированной длины, но в самих записях могут располагаться различные типы с различной длиной, и оканчиваться в различных позициях, в зависимости от типа.</p>
<p>Файл выглядит примерно так:</p>
<p>TFH.......&lt;First record type, первый тип записи&gt;</p>
<p>TBH.......&lt;Second record type, второй тип записи&gt;</p>
<p>TAB........&lt;Third record type, третий тип записи&gt;</p>
<p>TAA........&lt;Fourth record type, четвертый тип записи&gt;</p>
<p>Вы можете поймать больше одного зайца в случае объявления переменной записи, но если сделаете это правильно.</p>
<pre>
type
  TDataTag = array[1..3] of Char;
  TDataTags = array[0..NumOfTags - 1] of TDataTag;
  TDataRec = packed record
    tagfield: TDataTag;
    case integer of
      0: (поля для тэга TFH);
      1: (поля для тэга TBH);
      2: ..
      ....
  end;
  TMultiRec = packed record
    case Boolean of
      false: (строка: array[0..1024] of Char);
      { должно установать строку максимально возможной длины }
      true: (data: TDataRec);
  end;
 
const
  DataTags: TDataTags = ('TFH', 'TBH', ....);
var
  rec: TMultirec;
 
  ReadLn(datafile, rec.line);
  case IndexFromDataTag(rec.data.tagfield) of
    0: ...
      1: ...
  end;
</pre>
<p>IndexFromDataTag должен искать передаваемый тэг поля в массиве DataTags. Определите все поля в TDataRec как Array [1..someUpperBound] of Char.</p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
</p>

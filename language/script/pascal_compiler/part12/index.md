---
Title: 12. Разное
Date: 01.01.2007
---


12\. Разное
======

[Лекции по построению компилятора на Pascal](../)


**ВВЕДЕНИЕ**

Эта глава - второе из тех отклонений в сторону, которые не вписываются в
основное направление этой обучающей серии. Я упомянул в прошлый раз, что
я накопил некоторые изменения, которые должны быть внесены в структуру
компилятора. Поэтому я должен был отклониться чтобы разработать новую
структуру и показать ее вам.

Теперь, когда все это позади, я могу сказать что я намерен сделать
прежде всего. Это не должно занять много времени и затем мы сможем
вернуться в основное русло.

Некоторые люди спрашивали меня о вещах, которые предоставляют другие
языки, но к которым я пока что не обращался в этой серии. Две самых
больших из них - это точки с запятой и комментарии. Возможно вы тоже
задумывались о них и гадали как изменился бы компилятор если бы мы
работали с ними. Только для того, чтобы вы могли проследовать дальше без
тревожащего чувства, что что-то пропущено, мы рассмотрим здесь эти
вопросы.

**ТОЧКИ С ЗАПЯТОЙ**

Со времен появления Алгола точки с запятой были частью почти каждого
современного языка. Все мы использовали их считая это само собой
разумеющимся. Однако я полагаю, что больше ошибок компиляции происходило
из-за неправильно размещенной или отсутствующей точки с запятой, чем в
любом другом случае. И если бы мы получали один пенни за каждое
дополнительное нажатие клавиши, использованное программистами для набора
этих маленьких мошенников, мы смогли бы оплатить национальный долг.

Будучи воспитанным на Фортране, я потратил много времени чтобы
привыкнуть к использованию точек с запятой и сказать по правде я никогда
полностью не понимал почему они необходимы. Так как я программирую на
Паскале и так как использование точек с запятой в Паскале особенно
мудрено, этот один небольшой символ является моим наибольшим источником
ошибок.

Когда я начал разработку KISS, я решил критически относиться к каждой
конструкции в других языках и попытаться избежать наиболее общих
проблем, происходящих с ними. Это ставит  точку с  запятой  очень высоко
в моем хит-листе.

Чтобы понять роль точки с запятой, вы должны изучить краткую
предысторию.

Ранние языки программирования были строчно-ориентированными. В Фортране,
например, различные части утверждения занимали определенные столбцы и
поля, в которых они должны были располагаться. Так как некоторые
утверждения были слишком длинными для одной строки, существовал механизм
"карта продолжения" ("continuation card"), позволяющий компилятору
знать, что данная карта все еще является частью предыдущей строки.
Механизм дожил до наших дней, хотя перфокарты теперь - дела отдаленного
прошлого.

Когда появились другие языки, они также приняли различные механизмы для
работы с многострочными операторами. Хороший пример - BASIC. Важно
осознать, тем не менее, что механизм Фортрана был затребован не столько
строчной ориентацией языка, сколько ориентацией по столбцам. В тех
версиях Фортрана, где разрешен ввод в свободной форме, он больше не
нужен.

Когда отцы Алгола представили этот язык, они хотели уйти от
строчно-ориентированных программ подобных Фортрану или Бейсику и
разрешить ввод в свободной форме. Это дало возможность связывать
множество утверждений в одну строку как например:

    a=b; c=d; e=e+1;

В случаях подобных этому, точка с запятой почти обязательна. Та же самая
строка без точек с запятой выглядит просто "странной":

    a=b c= d e=e+1

Я полагаю, что это главная... возможно единственная... причина точек с
запятой: не давать программам выглядеть странно.

Но идея со связыванием множества утверждений вместе в одну строку в
лучшем случае сомнительная. Это не очень хороший стиль программирования
и возвращение назад к дням, когда считалось важным сэкономить карты. В
наши дни CRT и выровненного кода ясность программ гораздо лучше
обеспечивается сохранением раздельных утверждений. Все-таки хорошо иметь
возможность множественных утверждений, но это позор - оставлять
программистов в рабстве у точек с запятой только чтобы этот редкий
случай не "выглядел странно".

Когда я начинал KISS, я попытался держать глаза открытыми. Я решил, что
буду использовать точки с запятой когда это станет необходимо для
синтаксического анализатора, но только тогда. Я рассчитывал, что это
случится примерно в то время, когда я добавил возможность разложения
утверждений на несколько строк. Но как вы можете видеть это никогда не
случилось. Компилятор TINY совершенно счастлив анализировать наиболее
сложные утверждения, разложенные на любое число строк, без точек с
запятой.

Однако, есть люди, которые использовали точки с запятой так долго, что
они чувствуют себя без них голыми. Я один из них. Как только KISS стал
достаточно хорошо определен, я попробовал написать на этом языке
несколько программ-примеров. Я обнаружил, к своему ужасу, что пытаюсь в
любом случае расставлять точки с запятой. Так что теперь я стою перед
перспективой нового потока ошибок компилятора, вызванных нежелательными
точками с запятой. Тьфу!

Возможно более важно, что есть читатели, которые разрабатывают свои
собственные языки, которые могут включать точки с запятой или которые
хотят использовать методы из этого руководства для компиляции
стандартных языков типа C. В обоих случаях, нам необходима возможность
работать с точками с запятой.

**СИНТАКСИЧЕСКИЙ САХАР**

Вся эта дискуссия поднимает вопрос "синтаксического сахара"...
конструкций, которые добавлены к языку не потому, что они нужны, но
потому, что они заставляют программы выглядеть правильно для
программиста. В конце концов, хорошо иметь маленький простой компилятор,
но от него было бы мало пользы если бы полученный язык был
закодированным или сложным для программирования. На ум приходит язык
FORTH. Если мы можем добавить в язык возможности, которые делают
программы более легкими для чтения и понимания, и если эти возможности
предохраняют программиста от ошибок, тогда мы бы сделали это. Особенно
если эти конструкции не добавляют слишком много сложности в язык или его
компилятор.

Как пример можно было бы рассмотреть точку с запятой, но существуют
множество других, такие как "THEN" в операторе IF, "DO" в операторе
WHILE или даже утверждение "PROGRAM" которое я убрал из TINY. Ни один
из этих токенов не добавляет много к синтаксису языка... компилятор
может выяснить, что происходит и без них. Но некоторые люди чувствуют,
что они улучшают читаемость программ и это может быть очень важно.

Существуют две школы мысли на эту тему, которые хорошо представлены
двумя из наших наиболее популярных языков C и Pascal.

По мнению минималистов весь подобный сахар должен быть выброшен. Они
доказывают, что это загромождает язык и увеличивает число нажатий
клавиш, которое должен сделать программист. Возможно более важно, что
каждый дополнительный токен или ключевое слово представляет собой
ловушку, лежащую в ожидании невнимательного программиста. Если вы не
учтете токен, пропустите его или сделаете в нем орфографическую ошибку,
компилятор достанет вас. Поэтому эти люди утверждают,
что лучший подход - избегать таких вещей.
Этот народ предпочитает язык типа C, который
имеет минимум ненужных ключевых слов и пунктуации.

Те, кто относятся к другой школе, предпочитают язык Pascal. Они
доказывают, что необходимость набрать несколько дополнительных
символов - это малая цена за удобочитаемость.
В конце концов, люди тоже должны
читать программы. Их самый лучший аргумент в том, что каждая такая
конструкция является возможностью сообщить компилятору, что вы
действительно хотите того, что сказали. Сахарные токены служат в
качестве полезных ориентиров, помогающих вам не сбиться с пути..

Различия хорошо представлены этими двум языками. Наиболее часто слышимая
претензия к C - что он слишком прощающий. Когда вы делаете ошибку в C,
ошибочный код часто является другой допустимой конструкцией C. Так что
компилятор просто счастливо продолжает компиляцию и оставляет вам
нахождение ошибок в течение отладки. Я предполагаю именно поэтому
отладчики так популярны среди C программистов.

С другой стороны, если компилируется программа на Паскале, вы можете
быть вполне уверены, что программа будет делать то, что вы ей сказали.
Если имеется ошибка во время выполнения, возможно это ошибка разработки.

Самым лучшим примером полезного сахара является непосредственно точка с
запятой. Рассмотрите фрагмент кода:

     a=1+(2*b+c)   b...

Так как нет никакого оператора, соединяющего токен \'b\' с
остальной частью выражения, компилятор заключит, что выражение
заканчивается на \')\' а  \'b\' - это начало нового утверждения. Но
предположим, что я просто пропустил предполагаемый оператор и в
действительности хотел сказать:

     a=1+(2*b+c)*b...

В этом случае компилятор выдаст ошибку, хорошо, но она не будет очень
осмысленной, так как он будет ожидать знак \'=\' после \'b\', который в
действительности не должен быть там.

Если, наоборот, я вставлю точку с запятой после \'b\', тогда не может
остаться сомнений где, как я предполагаю, заканчивается утверждение.
Синтаксический сахар, т.о., может служить очень полезной цели,
предоставляя некоторую дополнительную подстраховку  что мы остаемся на
правильном пути.

Я нахожусь где-то посередине между этими подходами. Я склоняюсь к
преимуществам Паскалевской точки зрения... я был бы очень доволен
находить свои ошибки во время компиляции а не во время выполнения. Но я
также ненавижу просто бросаться словами без явной причины как в COBOL.
Пока что я последовательно выкинул большинство Паскалевского сахара из
KISS/TINY. Но я конечно не испытываю сильных чувств к любому способу и я
также могу видеть значение разбрасывания небольшого количества сахара
только для дополнительной подстраховки, которую он дает. Если вам
нравится этот последний подход, такие вещи легко добавить. Только
запомните, что как и точка с запятой каждая ложка сахара - это что-то,
что может потенциально привести к ошибке компиляции при ее пропуске.

**РАБОТА С ТОЧКАМИ С ЗАПЯТОЙ**

Есть два различных способа работы с точками с запятой используемые в
популярных языках. В Паскале точка с запятой расценивается как
разделитель операторов. Точка с запятой не требуется после последнего
утверждения в блоке. Синтаксис:

     <block> ::= <statement> ( ';' <statement>)
     <statement> ::= <assignment> | <if> | <while> ... | null

(пустое утверждение важно!)

Паскаль также определяет некоторые точки с запятой в других местах,
таких как после утверждения PROGRAM.

В C и Ada, с другой стороны, точка с запятой рассматривается как
терминатор операторов и следует после всех утверждений (с некоторыми
смущающими и путающими исключениями). Синтаксис для них простой:

     <block> ::= ( <statement> ';' )

Из двух синтаксисов, синтаксис Паскаля внешне выглядит более
рациональным, но опыт показал, что он ведет к некоторым странным
трудностям. Люди так привыкают ставить точку с запятой после каждого
утверждения, что они также предпочитают ставить ее и после последнего
утверждения в блоке. Это обычно не приносит какого-либо вреда... она
просто обрабатывается как пустое утверждение. Многие программисты на
Паскале, включая вашего покорного слугу,  делают точно также. Но есть
одно место, в котором вы абсолютно не можете поставить точку с запятой -
прямо перед ELSE. Это маленький подводный камень стоил мне множества
дополнительных компиляций, особенно когда ELSE добавляется к
существующему коду. Так что выбор C/Ada оказывается лучше. Очевидно,
Никлаус Вирт думает также: в Modula-2 он отказался от Паскалевского
подхода.

Имея эти два синтаксиса, легко (теперь, когда мы реорганизовали
синтаксический анализатор!) добавить эти возможности в наш анализатор.
Давайте сначала возьмем последний случай, так как он проще.

Для начала я упростил программу представив новую подпрограмму
распознавания:

    { Match a Semicolon } 
    procedure Semi; 
    begin 
       MatchString(';'); 
    end;


Эта процедура очень похожа на наш старый Match. Она требует чтобы
следующим токеном была точка с запятой. Найдя его, она переходит к
следующему.

Так как точка с запятой следует за утверждением, процедура Block почти
единственная, которую мы должны изменить:

    { Parse and Translate a Block of Statements } 
    procedure Block; 
    begin 
       Scan; 
       while not(Token in ['e', 'l']) do begin 
          case Token of 
           'i': DoIf; 
           'w': DoWhile; 
           'R': DoRead; 
           'W': DoWrite; 
           'x': Assignment; 
          end; 
          Semi; 
          Scan; 
       end; 
    end;  


Внимательно взгляните на тонкие изменения в операторе case. Вызов
Assigment теперь ограничивается проверкой Token. Это позволит избежать
вызова Assigment когда токен является точкой с запятой (что случается
когда утверждение пустое).

Так как объявления - тоже утверждения, мы также должны добавить вызов
Semi в процедуру TopDecl:

    { Parse and Translate Global Declarations } 
    procedure TopDecls; 
    begin 
       Scan; 
       while Token = 'v' do begin 
          Alloc; 
          while Token = ',' do 
             Alloc; 
          Semi; 
       end; 
    end;


Наконец нам нужен вызов для утверждения PROGRAM:

    { Main Program } 
    begin 
       Init; 
       MatchString('PROGRAM'); 
       Semi; 
       Header; 
       TopDecls; 
       MatchString('BEGIN'); 
       Prolog; 
       Block; 
       MatchString('END'); 
       Epilog; 
    end.


Проще некуда. Испробуйте это с копией TINY и скажите как вам это
нравится.

Версия Паскаля немного сложнее, но она все равно требует только
небольших изменений и то только в процедуре Block. Для максимальной
простоты давайте разобьем процедуру на две части. Следующая процедура
обрабатывает только одно утверждение:

    { Parse and Translate a Single Statement } 
    procedure Statement; 
    begin 
       Scan; 
       case Token of 
        'i': DoIf; 
        'w': DoWhile; 
        'R': DoRead; 
        'W': DoWrite; 
        'x': Assignment; 
       end; 
    end;


Используя эту процедуру мы можем переписать Block так:

    { Parse and Translate a Block of Statements } 
    procedure Block; 
    begin 
       Statement; 
       while Token = ';' do begin 
          Next; 
          Statement; 
       end; 
    end;


Это, уверен, не повредило, не так ли? Теперь мы можем анализировать
точки с запятой в Паскаль подобном стиле.

**КОМПРОМИСС**

Теперь, когда мы знаем как работать с точками с запятой, означает ли
это, что я собираюсь поместить их в KISS/TINY? И да и нет. Мне нравится
дополнительный сахар и защита, которые приходят с уверенным знанием, где
заканчиваются утверждения. Но я не изменил своей антипатии к ошибкам
компиляции, связанным с точками с запятой.

Так что я придумал хороший компромисс: сделаем их необязательными!

Рассмотрите следующую версию Semi:

    { Match a Semicolon }
    procedure Semi;
    begin
       if Token = ';' then Next;
    end;


Эта процедура будет принимать точку с запятой всякий раз, когда вызвана,
но не будет настаивать на ней. Это означает, что когда вы решите
использовать точки с запятой, компилятор будет использовать
дополнительную информацию чтобы удержаться на правильном пути. Но если
вы пропустите одну (или пропустите их всех) компилятор не будет
жаловаться. Лучший из обоих миров.

Поместите эту процедуру на место в первую версию вашей программы (с
синтаксисом для C/Ada)  и вы получите TINY Version 1.2.

**КОММЕНТАРИИ**

Вплоть до этого времени я тщательно избегал темы комментариев. Вы могли
бы подумать, что это будет простая тема... в конце концов компилятор
совсем не должен иметь дела с комментариями; он просто должен
игнорировать их. Что ж, иногда это так.

Насколько простыми или насколько трудными могут быть комментарии,
зависит от выбранного вами способа их реализации. В одном случае, мы
можем сделать так, чтобы эти комментарии перехватывались как только они
поступят в компилятор. В другом, мы можем обрабатывать их как
лексические элементы. Станет интереснее когда вы рассмотрите вещи, типа
разделителей комментариев, содержащихся в строках в кавычках.

**ОДНОСИМВОЛЬНЫЕ РАЗДЕЛИТЕЛИ**

Вот пример. Предположим, мы принимаем стандарт Turbo Pascal и используем
для комментариев фигурные скобки. В этом случае мы используем
одно-символьные разделители, так что наш анализ немного проще.

Один подход состоит в том, чтобы удалять комментарии как только мы
встретим их во входном потоке, т.е. прямо в процедуре GetChar. Чтобы
сделать это сначала измените имя GetChar на какое-нибудь другое, скажем
GetCharX. (На всякий случай запомните, это будет временное изменение,
так что лучше не делать этого с вашей единственной копией TINY. Я
полагаю вы понимаете, что вы всегда должны делать эти эксперименты с
рабочей копией).

Теперь нам нужна процедура для пропуска комментариев. Так что наберите
следующее:

    { Skip A Comment Field } 
    procedure SkipComment; 
    begin 
       while Look <> '}' do 
          GetCharX; 
       GetCharX; 
    end;


Ясно, что эта процедура будет просто считывать и отбрасывать символы из
входного потока, пока не найдет правую фигурную скобку. Затем она
считывает еще один символ и возвращает его в Look.

Теперь мы можем написать новую версию GetChar, которая вызывает
SkipComment для удаления комментариев:

    { Get Character from Input Stream } 
    { Skip Any Comments } 
    procedure GetChar; 
    begin 
       GetCharX; 
       if Look = '{' then SkipComment; 
    end;


Наберите этот код и испытайте его. Вы обнаружите, что вы действительно
можете вставлять комментарии везде, где захотите. Комментарии никогда
даже не попадут в синтаксический анализатор... каждый вызов GetChar
просто возвращает любой символ, не являющийся частью комментария.

Фактически, хотя этот метод делает свое дело и может даже совершенно
удовлетворять вас, он делает свою работу немного слишком хорошо. Прежде
всего, большинство языков программирования определяет, что комментарии
должны быть обработаны как пробелы, так как комментарии не могут быть
вложены, скажем, в имя переменной. Эта текущая версия не заботится о
том, где вы помещаете комментарии.

Во-вторых, так как остальная часть синтаксического анализатора не может
даже получить символ \'{\', вам не будет позволено поместить его в
строку в кавычках.

Однако, прежде чем вы отвернете свой нос от такого упрощенного решения,
я должен подчеркнуть, что столь уважаемый компилятор, как Turbo Pascal,
также не позволит использовать \'{\'  в строке в кавычках. Попробуйте.
Относительно комментариев, вложенных в идентификатор, я не могу
представить чтобы кто-то захотел сделать подобные вещи, так что вопрос
спорен.  Для 99% всех приложений то что я показал, будет работать просто
отлично.

Но, если вы хотите быть щепетильным в этом вопросе и придерживаться
стандартного обращения, тогда нам нужно переместить место перехвата
немного ниже.

Чтобы сделать это с начала верните GetChar на старое место и измените
имя, вызываемое в SkipComment Затем, давайте добавим левую фигурную
скобку как возможный символ незаполненного пространства:

    { Recognize White Space } 
    function IsWhite(c: char): boolean; 
    begin 
       IsWhite := c in [' ', TAB, CR, LF, '{']; 
    end; 


Теперь мы можем работать с комментариями в процедуре SkipWhite:

    { Skip Over Leading White Space } 
    procedure SkipWhite; 
    begin 
       while IsWhite(Look) do begin 
          if Look = '{' then 
             SkipComment 
          else 
             GetChar; 
       end; 
    end;


Обратите внимание, что SkipWhite написан так, что мы пропустим любую
комбинацию незаполненного пространства и комментариев в одном вызове.

Протестируйте компилятор. Вы обнаружите, что он позволит комментариям
служить разделителями токенов. Заслуживает внимания, что этот подход
также дает нам возможность обрабатывать фигурные скобки в строках в
кавычках, так как внутри этих строк мы не будем проверять или пропускать
пробелы.

Остался последний вопрос: вложенные комментарии. Некоторым программистам
нравится идея вложенных комментариев так как это позволяет
комментировать код во время отладки. Код, который я дал здесь не
позволит этого и, снова, не позволит и Turbo Pascal.

Но исправить это невероятно просто. Все, что нам нужно - сделать
SkipComment рекурсивной:

    { Skip A Comment Field } 
    procedure SkipComment; 
    begin 
       while Look <> '}' do begin 
          GetChar; 
          if Look = '{' then SkipComment; 
       end; 
       GetChar; 
    end;


Готово. Настолько утонченный обработчик комментариев, какой вам
когда-либо может понадобиться.

**МНОГОСИМВОЛЬНЫЕ РАЗДЕЛИТЕЛИ**

Все это хорошо для случаев, когда комментарии ограничены одиночными
символами, но как быть с такими случаями как C или стандартный Pascal,
где требуются два символа? Хорошо, принцип все еще тот же самый, но мы
должны совсем немного изменить наш подход. Я уверен, что вы не удивитесь
узнав, что это более сложный случай.

Для много символьной ситуации проще всего перехватывать левый
ограничитель в GetChar.  Мы можем "токенизировать" его прямо здесь,
заменяя его одиночным символом.

Давайте условимся, что мы используем ограничители C \'/*\' и \'*/\'.
Сначала мы должны возвратиться к методу \'GetCharX\'. В еще одной копии
вашего компилятора переименуйте GetChar в GetCharX и затем введите
следующую новую процедуру GetChar:

    { Read New Character.  Intercept '/*' } 
    procedure GetChar; 
    begin 
       if TempChar <> ' ' then begin 
          Look := TempChar; 
          TempChar := ' '; 
          end 
       else begin 
          GetCharX; 
          if Look = '/' then begin 
             Read(TempChar); 
             if TempChar = '*' then begin 
                Look := '{'; 
                TempChar := ' '; 
             end; 
          end; 
       end; 
    end;


Как вы можете видеть эта процедура перехватывает каждое появление \'/\'.
Затем она исследует следующий символ в потоке. Если это символ \'\*\',
то мы нашли начало комментария и GetChar возвратит его одно-символьный
заменитель. (Для простоты я использую тот же самый символ \'{\' как я
делал для Паскаля. Если бы вы писали компилятор C, вы без сомнения
захотели бы использовать какой-то другой символ, не используемый где-то
еще в C. Выберите что вам нравится... даже $FF, что-нибудь 
уникальное).

Если символ, следующий за \'/\' не \'\*\', тогда GetChar прячет его в
новой глобальной переменной TempChar и возвращает \'/\'.

Обратите внимание, что вы должны объявить эту новую переменную и
присвоить ей значение \' \'. Мне нравится делать подобные вещи с
использование конструкции "типизированная константа" в Turbo Pascal:

     const TempChar: char = ' ';

Теперь нам нужна новая версия SkipComment:

    { Skip A Comment Field } 
    procedure SkipComment; 
    begin 
       repeat 
          repeat 
             GetCharX; 
          until Look = '*'; 
          GetCharX; 
       until Look = '/'; 
       GetChar; 
    end;


Обратите внимание на несколько вещей: прежде всего нет необходимости
изменять функцию IsWhite и процедуру SkipWhite так как GetChar
возвращает токен \'{\'. Если вы измените этот символ токена, тогда
конечно вы также должны будете изменить символ в этих двух
подпрограммах.

Во-вторых, заметьте, что SkipComment вызывает в своем цикле не GetChar а
GetCharX. Это означает, что завершающий \'/\' не перехватывается и
обрабатывается SkipComment. В-третьих, хотя работу выполняет процедура
GetChar, мы все же можем работать с символами комментариев, вложенными в
строки в кавычках,  вызывая GetCharX  вместо GetChar  пока мы находимся
внутри строки. Наконец, заметьте, что мы можем снова обеспечить
вложенные комментарии добавив одиночное утверждение в SkipComment, точно
также как мы делали прежде.

**ОДНОСТОРОННИЕ КОММЕНТАРИИ**

Пока что я показал вам как работать с любыми видами комментариев,
ограниченных слева и справа. Остались только односторонние комментарии
подобные используемым в ассемблере или Ada, которые завершаются концом
строки. На практике этот способ проще. Единственная процедура, которая
должна быть изменена - SkipComment, которая должна теперь завершаться на
символе переноса строки:

    { Skip A Comment Field } 
    procedure SkipComment; 
    begin 
       repeat 
          GetCharX; 
       until Look = CR; 
       GetChar; 
    end; 


Если ведущий символ - одиночный, как  ";" в ассемблере, тогда мы по
существу все сделали. Если это двух символьный токен, как "--" из
Ada, нам необходимо только изменить проверки в GetChar. В любом случае
это более легкая проблема чем двухсторонние комментарии.

**ЗАКЛЮЧЕНИЕ**

К этому моменту у нас есть возможность работать и с комментариями и
точками с запятой, так же как и с другими видами синтаксического сахара.
Я показал вам несколько способов работы с каждым из них, в зависимости
от желаемых соглашений. Остался единственный вопрос - какие из этих
соглашений мы должны использовать в KISS/TINY?

- По причинам, которые я высказал по ходу дела, я выбираю следующее:  
Точки с запятой - терминаторы, а не разделители.

- Точки с запятой необязательны.

- Комментарии ограничены фигурными скобками.

- Комментарии могут быть вложенными.

Поместите код, соответствующий этим случаям в вашу копию TINY. Теперь у
вас есть TINY Version 1.2.

Теперь, когда мы разрешили эти побочные проблемы, мы можем наконец
возвратиться в основное русло. В следующей главе мы поговорим о
процедурах и передаче параметров и добавим эти важные возможности в
TINY.

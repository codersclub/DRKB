---
Title: 11. Пересмотр лексического анализа
Date: 01.01.2007
---


11\. Пересмотр лексического анализа
==============================

[Лекции по построению компилятора на Pascal](../)


**ВВЕДЕНИЕ**

У меня есть хорошие и плохие новости. Плохие новости - эта глава не та,
которую я вам обещал последний раз. Более того, и следующая глава также.

Хорошие новости в причине появления этой главы: я нашел способ упростить
и улучшить  лексический анализатор компилятора. Позвольте мне объяснить.

**ПРЕДПОСЫЛКА**

Если вы помните, мы подробно говорили на тему лексических анализаторов в
Главе 7 и я оставил вас с проектом распределенного сканера который, я
чувствовал, был почти настолько простым, насколько я смог сделать...
более чем большинство из того, что я где-либо видел. Мы использовали эту
идею в Главе 10. Полученная структура компилятора была простой и она
делала свою работу.

Однако недавно я начал испытывать проблемы такого рода, которые
подсказывают, что возможно вы делаете что-то неправильно.

Проблемы достигли критической стадии когда я попытался обратиться к
вопросу точек с запятой. Некоторые люди спрашивали меня, действительно
ли KISS будет использовать их для разделения операторов. Я не
намеревался использовать точки с запятой просто потому, что они мне не
нравятся и, как вы можете видеть, они не доказали своей необходимости.

Но я знаю, что многие из вас, как и я, привыкли к ним, так что я
намеревался написать короткую главу чтобы показать вам, как легко они
могут быть добавлены раз вы так склонны к ним.

Что ж, оказалось что их совсем непросто добавить. Фактически это было
чрезвычайно трудно.

Я полагаю, что должен был понять что что-то было неправильно из-за
проблемы переносов строк. В последних двух главах мы обращались к этому
вопросу и я показал вам, как работать с переносами с помощью процедуры,
названной достаточно соответствующе NewLine. В TINY Version 1.0 я 
расставил вызовы этой процедуры в стратегических местах кода.

Кажется, что всякий раз, когда я обращался к проблеме переносов, я,
однако, находил этот вопрос сложным и полученный синтаксически
анализатор оказывался очень ненадежным... одно удаление или добавление
здесь или там и все разваливалось. Оглядываясь назад, я понимаю, что это
было предупреждение, на которое я просто не обращал внимания.

Когда я попробовал добавить точку с запятой к переносам строк это стало
последней каплей. Я получил слишком сложное решение. Я начал понимать,
что необходимо что-то менять коренным образом.

Итак,  в некотором отношении эта глава заставить нас возвратиться
немного назад и пересмотреть заново вопрос лексического анализа. Сожалею
об этом. Это цена, которую вы платите за возможность следить за мной в
режиме реального времени. Но новая версия определенно усовершенствована
и хорошо послужит нам дальше.

Как я сказал, сканер, использованный нами в Главе 10, был почти
настолько простым, насколько возможно. Но все может быть улучшено. Новый
сканер более похож на классический сканер и не так прост как прежде. Но
общая структура компилятора даже проще чем раньше. Она также более
надежная и проще для добавления и/или модификации. Я думаю, что она
стоит времени, потраченного на это отклонение. Так что в этой главе я
покажу вам новую структуру. Без сомнения вы будете счастливы узнать, что
хотя изменения влияют на многие процедуры, они не очень глубоки и
поэтому мы теряем не очень многое из того что было сделано до этого.

Как ни странно, новый сканер намного более стандартен чем старый и он
очень похож на более общий сканер, показанный мной ранее в главе 7. Вы
должны помнить день, когда я сказал:  K-I-S-S!

**ПРОБЛЕМА**

Проблема начинает проявлять себя в процедуре Block, которую я
воспроизвел ниже:

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
          else Assignment; 
          end; 
          Scan; 
       end; 
    end;


Как вы можете видеть, Block ориентирован на индивидуальные утверждения
программы. При каждом проходе цикла мы знаем, что мы находимся в начале
утверждения. Мы выходим из блока когда обнаруживаем END или ELSE.

Но предположим, что вместо этого мы встретили точку с запятой.
Вышеуказанная процедура не может ее обработать, так как процедура Scan
ожидает и может принимать только токены, начинающиеся с буквы.

Я повозился с этим немного чтобы найти исправление. Я нашел множество
возможных подходов, но ни один из них меня не удовлетворял. В конце
концов я выяснил причину.

Вспомните, что когда мы начинали с наших одно-символьных синтаксических
анализаторов, мы приняли соглашение, по которому предсказывающий символ
должен быть всегда предварительно считан. То есть, мы имели бы символ,
соответствующий нашей текущей позиции во входном потоке, помещенный в
глобальной символьной переменной Look, так что мы могли проверять его
столько раз, сколько необходимо. По правилу, которое мы приняли, каждый
распознаватель, если он находил предназначенный ему символ, перемещал бы
Look на следующий символ во входном потоке.

Это простое и фиксированное соглашение служило нам очень хорошо когда мы
имели одно-символьные токены, и все еще служит. Был бы большой смысл
применить то же самое правило и к много символьным токенам.

Но когда мы залезли в лексический анализ, я начал нарушать это простое
правило. Сканер из Главы 10 действительно продвигался к следующему
токену если он находил идентификатор или ключевое слово, но он не делал
этого если находил возврат каретки, символ пробела или оператор.

Теперь, такой смешанный режим работы ввергает нас в глубокую проблему в
процедуре Block, потому что был или нет входной поток продвинут зависит
от вида встреченного нами токена. Если это ключевое слово или левая
часть операции присваивания, "курсор", как определено содержимым Look,
был продвинут к следующему символу или к началу незаполненного
пространства. Если, с другой стороны, токен является точкой с запятой,
или если мы нажали возврат каретки курсор не был продвинут.

Само собой разумеется, мы можем добавить достаточно логики чтобы
удержаться на правильном пути. Но это сложно и делает весь анализатор
очень ненадежным.

Существует гораздо лучший способ - просто принять то же самое правило,
которое так хорошо работало раньше, и относиться к токенам так же как
одиночным символам. Другими словами, мы будем заранее считывать токен
подобно тому, как мы всегда считывали символ. Это кажется таким
очевидным как только вы подумаете об этом способе.

Достаточно интересно, что если мы поступим таким образом, существующая
проблема с символами перевода строки исчезнет. Мы можем просто
рассматривать их как символы пробела, таким образом обработка переносов
становится тривиальной и значительно менее склонной к ошибкам чем
раньше.

**РЕШЕНИЕ**

Давайте начнем решение проблемы с пересмотра двух процедуры:

    { Get an Identifier } 
    procedure GetName; 
    begin 
       SkipWhite; 
       if Not IsAlpha(Look) then Expected('Identifier'); 
       Token := 'x'; 
       Value := ''; 
       repeat 
          Value := Value + UpCase(Look); 
          GetChar; 
       until not IsAlNum(Look); 
    end; 
     
    { Get a Number } 
    procedure GetNum; 
    begin 
       SkipWhite; 
       if not IsDigit(Look) then Expected('Number'); 
       Token := '#'; 
       Value := ''; 
       repeat 
          Value := Value + Look; 
          GetChar; 
       until not IsDigit(Look); 
    end;


Эти две процедуры функционально почти идентичны тем, которые я показал
вам в Главе 7. Каждая из них выбирает текущий токен, или идентификатор
или число, в глобальную строковую переменную Value. Они также
присваивают кодированной версии, Token, соответствующий код. Входной
поток останавливается на Look, содержащем первый символ, не являющийся
частью токена.

Мы можем сделать то же самое для операторов, даже много символьных, с
помощью процедуры типа:

    { Get an Operator } 
    procedure GetOp; 
    begin 
       Token := Look; 
       Value := ''; 
       repeat 
          Value := Value + Look; 
          GetChar; 
       until IsAlpha(Look) or IsDigit(Look) or IsWhite(Look); 
    end; 


Обратите внимание, что GetOps возвращает в качестве закодированного
токена первый символ оператора. Это важно, потому что это означает, что
теперь мы можем использовать этот одиночный символ для управления
синтаксическим анализатором вместо предсказывающего символа.

Нам нужно связать эти процедуры вместе в одну процедуру, которая может
обрабатывать все три случая. Следующая процедура будет считывать любой
из этих типов токенов и всегда оставлять входной поток за ним:

    { Get the Next Input Token } 
    procedure Next; 
    begin 
       SkipWhite; 
       if IsAlpha(Look) then GetName 
       else if IsDigit(Look) then GetNum 
       else GetOp; 
    end; 


Обратите внимание, что здесь я поместил SkipWhite перед вызовами а не
после. Это означает в основном, что переменная Look не будет содержать
значимого значения и, следовательно, мы не должны использовать ее как
тестируемое значение при синтаксическом анализе, как мы делали до этого.
Это большое отклонение от нашего нормального подхода.

Теперь, не забудьте, что раньше я избегал обработки символов возврата
каретки (CR) и перевода строки (LF) как незаполненного пространства.
Причина была в том, что так как SkipWhite вызывается последней в
сканере, встреча с LF инициировала бы чтение из входного потока. Если бы
мы были на последней строке программы, мы не могли бы выйти до тех пор,
пока мы не введем другую строку с отличным от пробела символом. Именно
поэтому мне требовалась вторая процедура NewLine для обработки CRLF.

Но сейчас, когда первым происходит вызов SkipWhite, это то поведение,
которое нам нужно. Компилятор должен знать, что появился другой токен
или он не должен вызывать Next. Другими словами, он еще не обнаружил
завершающий END. Поэтому мы будем настаивать на дополнительных данных до
тех пор, пока не найдем что-либо.

Все это означает, что мы можем значительно упростить и программу и
концепции, обрабатывая CR и LF как незаполненное пространство и убрав
NewLine. Вы можете сделать это просто изменив функцию IsWhite:

    { Recognize White Space } 
    function IsWhite(c: char): boolean; 
    begin 
       IsWhite := c in [' ', TAB, CR, LF]; 
    end;


Мы уже пробовали аналогичные подпрограммы в Главе 7, но вы могли бы
также попробовать и эти. Добавьте их к копии Cradle и вызовите Next в
основной программе:

    { Main Program } 
    begin 
       Init; 
       repeat 
          Next; 
          WriteLn(Token, ' ', Value); 
       until Token = '.'; 
    end.


Откомпилируйте и проверьте, что вы можете разделять программу на серии
токенов и  вы получаете правильные кода для каждого токена.

Почти работает, но не совсем. Существуют две потенциальные проблемы:
Во-первых, в KISS/TINY почти все наши операторы - одно-символьные.
Единственное исключение составляют операторы отношений \>=, \<= и \<\>.
Было бы позором обрабатывать все операторы как строки и выполнять
сравнение строк когда почти всегда удовлетворит сравнение одиночных
символов. Второе, и более важное, программа не работает, когда два
оператора появляются вместе как в (a+b)\*(c+d). Здесь строка после b
была бы интерпретирована как один оператор ")\*(".

Можно устранить эту проблему. К примеру мы могли бы просто дать GetOp
список допустимых символов и обрабатывать скобки как отличный от других
тип операторов. Но это хлопотное дело.

К счастью, имеется лучший способ, который решает все эти проблемы. Так
как почти все операторы одно-символьные, давайте просто позволим GetOp
получать только один символ одновременно. Это не только упрощает GetOp,
но также немного ускоряет программу. У нас все еще остается проблема
операторов отношений, но мы в любом случае обрабатывали их как
специальные случаи.

Так что вот финальная версия GetOp:

    { Get an Operator } 
    procedure GetOp; 
    begin 
       SkipWhite; 
       Token := Look; 
       Value := Look; 
       GetChar; 
    end;


Обратите внимание, что я все еще присваиваю Value значение. Если вас
действительно затрагивает эффективность, вы могли бы это опустить. Когда
мы ожидаем оператор, мы в любом случае будем проверять только Token, так
что значение этой строки не будет иметь значение. Но мне кажется хорошая
практика дать ей значение на всякий случай.

Испытайте эту версию с каким-нибудь реалистично выглядящим кодом. Вы
должны быть способны разделять любую программу на ее индивидуальные
токены, но предупреждаю, что двух символьные операторы отношений будут
отсканированы как два раздельных токена. Это нормально... мы будем
выполнять их синтаксический анализ таким способом.

Теперь, в главе 7 функция Next была объединена с процедурой Scan,
которая также сверяла каждый идентификатор со списком ключевых слов и
кодировала каждый найденный. Как я упомянул тогда, последнее, что мы
захотели бы сделать - использовать такую процедуру в местах, где
ключевые слова не должны появляться, таких как выражения. Если бы мы
сделали это, список ключевых слов просматривался бы для каждого
идентификатора, появляющегося в коде. Нехорошо.

Правильней было бы в этом случае просто разделить функции выборки
токенов и поиска ключевых слов. Версия Scan, показанная ниже, только
проверяет ключевые слова. Обратите внимание, что она оперирует текущим
токеном и не продвигает входной поток.

    { Scan the Current Identifier for Keywords } 
    procedure Scan; 
    begin 
       if Token = 'x' then 
          Token := KWcode[Lookup(Addr(KWlist), Value, NKW) + 1]; 
    end; 


Последняя деталь. В компиляторе есть несколько мест, в которых мы должны
фактически проверить строковое значение токена. В основном это сделано
для того, чтобы различать разные END, но есть и пара других мест. (Я
должен заметить, между прочим, что мы могли бы навсегда устранить
потребность в сравнении символов END кодируя каждый из них различными
символами. Прямо сейчас мы определенно идем маршрутом ленивого
человека.)

Следующая версия MatchString замещает символьно-ориентированную Match.
Заметьте, что как и Match она не продвигает входной поток.

    { Match a Specific Input String }
    procedure MatchString(x: string);
    begin
       if Value <> x then Expected('''' + x + '''');
       Next;

    end;


**ИСПРАВЛЕНИЕ КОМПИЛЯТОРА**

Вооружившись этими новыми процедурами лексического анализа мы можем
теперь начать исправлять компилятор. Изменения весьма незначительные, но
есть довольно много мест, где они необходимы. Вместо того, чтобы
показывать вам каждое место я дам вам общую идею а затем просто покажу
готовый продукт.

Прежде всего, код процедуры Block не изменяется, но меняется ее
назначение:

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
          else Assignment; 
          end; 
          Scan; 
       end; 
    end; 


Не забудьте, что новая версия Scan не продвигает входной поток, она
только сканирует ключевые слова. Входной поток должен продвигаться
каждой процедурой, которую вызывает Block.

В общих чертах, мы должны заменить каждую проверку Look на аналогичную
проверку Token. Например:

    {---------------------------------------------------------------} 
    { Parse and Translate a Boolean Expression } 
    procedure BoolExpression; 
    begin 
       BoolTerm; 
       while IsOrOp(Token) do begin 
          Push; 
          case Token of 
           '|': BoolOr; 
           '~': BoolXor; 
          end; 
       end; 
    end;  


В процедурах типа Add мы больше не должны использовать Match. Нам
необходимо только вызывать Next для продвижения входного потока:

    { Recognize and Translate an Add } 
    procedure Add; 
    begin 
       Next; 
       Term; 
       PopAdd; 
    end; 


Управляющие структуры фактически более простые. Мы просто вызываем Next
для продвижения через ключевые слова управляющих конструкций:

    { Recognize and Translate an IF Construct } 
    procedure Block; Forward; 
    procedure DoIf; 
    var L1, L2: string; 
    begin 
       Next; 
       BoolExpression; 
       L1 := NewLabel; 
       L2 := L1; 
       BranchFalse(L1); 
       Block; 
       if Token = 'l' then begin 
          Next; 
          L2 := NewLabel; 
          Branch(L2); 
          PostLabel(L1); 
          Block; 
       end; 
       PostLabel(L2); 
       MatchString('ENDIF'); 
    end; 


Это все необходимые изменения. В листинге Tiny Version 1.1, данном ниже,
я также сделал ряд других "усовершенствований", которые в
действительности не нужны. Позвольте мне кратко разъяснить их:

1.   Я удалил две процедуры Prog и Main и объединил их функции в основной программе. Они кажется не добавляли ясности... фактически они просто немного загрязняли программу.

2.   Я удалил ключевые слова PROGRAM и BEGIN из списка ключевых слов. Каждое из них появляется в одном месте, так что нет необходимости искать его.

3.   Обжегшись однажды на чрезмерной дозе сообразительности, я напомнил себе, что TINY  предназначен быть минималистским языком. Поэтому я заменил причудливую обработку унарного минуса на самую простую какую мог придумать. Гигантский шаг назад в качестве кода, но огромное упрощение компилятора. Для использования другой версии правильным местом был бы KISS.

4.   Я добавил несколько подпрограмм проверок ошибок типа CheckTable и CheckDup и заменил встроенный код на их вызовы. Это навело порядок во многих подпрограммах.

5.   Я убрал проверку ошибок из подпрограмм генерации кода типа Store и поместил их в подпрограммы анализа, к которым они относятся. Смотрите например Assignment.

6.   Существовала ошибка в InTable и Locate которая заставляла их проверять все позиции вместо позиций только с достоверными данными. Теперь они проверяют только допустимые ячейки. Это позволяет нам устранить необходимость инициализации таблицы идентификаторов, которая была в Init.

7.   Процедура AddEntry теперь имеет два параметра, что помогает сделать программу немного более модульной.

8.   Я подчистил код для операторов отношений добавив новые процедуры CompareExpression и  NextExpression.

9.   Я устранил ошибку в подпрограмме Read... старая версия не выполняла проверку на правильность имени переменной.

**ЗАКЛЮЧЕНИЕ**

Полученный компилятор Tiny показан ниже. Не считая удаленного ключевого
слова PROGRAM он анализирует тот же самый язык что и раньше. Он просто
немного чище и, что более важно, значительно более надежный. Он мне
нравится.

В следующей главе будет другое отклонение: с начала обсуждение точек с
запятой и все, что привело меня такому беспорядку. Затем мы займемся
процедурами и типами. Добавление этих возможностей далеко продвинет нас
на пути к выведению KISS из категории "игрушечных языков". Мы
подобрались очень близко к возможности написать серьезный компилятор.

**TINY VERSION 1.1**

    program Tiny11; 
     
    { Constant Declarations } 
    const TAB = ^I; 
          CR  = ^M; 
          LF  = ^J; 
          LCount: integer = 0; 
          NEntry: integer = 0; 
      
     
    { Type Declarations } 
    type Symbol = string[8]; 
         SymTab = array[1..1000] of Symbol; 
         TabPtr = ^SymTab; 
      
     
    { Variable Declarations } 
    var Look : char;             { Lookahead Character } 
        Token: char;             { Encoded Token       } 
        Value: string[16];       { Unencoded Token     } 
      
    const MaxEntry = 100; 
    var ST   : array[1..MaxEntry] of Symbol; 
        SType: array[1..MaxEntry] of char; 
      
     
    { Definition of Keywords and Token Types } 
    const NKW =   9; 
          NKW1 = 10; 
    const KWlist: array[1..NKW] of Symbol = 
                  ('IF', 'ELSE', 'ENDIF', 'WHILE', 'ENDWHILE', 
                   'READ', 'WRITE', 'VAR', 'END'); 
    const KWcode: string[NKW1] = 'xileweRWve'; 
      
     
    { Read New Character From Input Stream } 
    procedure GetChar; 
    begin 
       Read(Look); 
    end; 
     
    { Report an Error } 
    procedure Error(s: string); 
    begin 
       WriteLn; 
       WriteLn(^G, 'Error: ', s, '.'); 
    end; 
     
    { Report Error and Halt } 
    procedure Abort(s: string); 
    begin 
       Error(s); 
       Halt; 
    end; 
     
    { Report What Was Expected } 
    procedure Expected(s: string); 
    begin 
       Abort(s + ' Expected'); 
    end; 
     
    { Report an Undefined Identifier } 
    procedure Undefined(n: string); 
    begin 
       Abort('Undefined Identifier ' + n); 
    end; 
     
    { Report a Duplicate Identifier } 
    procedure Duplicate(n: string); 
    begin 
       Abort('Duplicate Identifier ' + n); 
    end; 
     
    { Check to Make Sure the Current Token is an Identifier } 
    procedure CheckIdent; 
    begin 
       if Token <> 'x' then Expected('Identifier'); 
    end; 
     
    { Recognize an Alpha Character } 
    function IsAlpha(c: char): boolean; 
    begin 
       IsAlpha := UpCase(c) in ['A'..'Z']; 
    end; 
     
    { Recognize a Decimal Digit } 
    function IsDigit(c: char): boolean; 
    begin 
       IsDigit := c in ['0'..'9']; 
    end; 
     
    { Recognize an AlphaNumeric Character } 
    function IsAlNum(c: char): boolean; 
    begin 
       IsAlNum := IsAlpha(c) or IsDigit(c); 
    end; 
     
    { Recognize an Addop } 
    function IsAddop(c: char): boolean; 
    begin 
       IsAddop := c in ['+', '-']; 
    end; 
     
    { Recognize a Mulop } 
    function IsMulop(c: char): boolean; 
    begin 
       IsMulop := c in ['*', '/']; 
    end; 
     
    { Recognize a Boolean Orop } 
    function IsOrop(c: char): boolean; 
    begin 
       IsOrop := c in ['|', '~']; 
    end; 
     
    { Recognize a Relop } 
    function IsRelop(c: char): boolean; 
    begin 
       IsRelop := c in ['=', '#', '<', '>']; 
    end; 
     
    { Recognize White Space } 
    function IsWhite(c: char): boolean; 
    begin 
       IsWhite := c in [' ', TAB, CR, LF]; 
    end; 
     
    { Skip Over Leading White Space } 
    procedure SkipWhite; 
    begin 
       while IsWhite(Look) do 
          GetChar; 
    end; 
     
    { Table Lookup } 
    function Lookup(T: TabPtr; s: string; n: integer): integer; 
    var i: integer; 
        found: Boolean; 
    begin 
       found := false; 
       i := n; 
       while (i > 0) and not found do 
          if s = T^[i] then 
             found := true 
          else 
             dec(i); 
       Lookup := i; 
    end; 
     
    { Locate a Symbol in Table } 
    { Returns the index of the entry.  Zero if not present. } 
    function Locate(N: Symbol): integer; 
    begin 
       Locate := Lookup(@ST, n, NEntry); 
    end; 
     
    { Look for Symbol in Table } 
    function InTable(n: Symbol): Boolean; 
    begin 
       InTable := Lookup(@ST, n, NEntry) <> 0; 
    end; 
     
    { Check to See if an Identifier is in the Symbol Table         } 
    { Report an error if it's not. } 
      
    procedure CheckTable(N: Symbol); 
    begin 
       if not InTable(N) then Undefined(N); 
    end; 
     
    { Check the Symbol Table for a Duplicate Identifier } 
    { Report an error if identifier is already in table. } 
    procedure CheckDup(N: Symbol); 
    begin 
       if InTable(N) then Duplicate(N); 
    end; 
     
    { Add a New Entry to Symbol Table } 
    procedure AddEntry(N: Symbol; T: char); 
    begin 
       CheckDup(N); 
       if NEntry = MaxEntry then Abort('Symbol Table Full'); 
       Inc(NEntry); 
       ST[NEntry] := N; 
       SType[NEntry] := T; 
    end; 
      
     
    { Get an Identifier } 
    procedure GetName; 
    begin 
       SkipWhite; 
       if Not IsAlpha(Look) then Expected('Identifier'); 
       Token := 'x'; 
       Value := ''; 
       repeat 
          Value := Value + UpCase(Look); 
          GetChar; 
       until not IsAlNum(Look); 
    end; 
     
    { Get a Number } 
    procedure GetNum; 
    begin 
       SkipWhite; 
       if not IsDigit(Look) then Expected('Number'); 
       Token := '#'; 
       Value := ''; 
       repeat 
          Value := Value + Look; 
          GetChar; 
       until not IsDigit(Look); 
    end; 
     
    { Get an Operator } 
    procedure GetOp; 
    begin 
       SkipWhite; 
       Token := Look; 
       Value := Look; 
       GetChar; 
    end; 
     
    { Get the Next Input Token } 
    procedure Next; 
    begin 
       SkipWhite; 
       if IsAlpha(Look) then GetName 
       else if IsDigit(Look) then GetNum 
       else GetOp; 
    end; 
     
    { Scan the Current Identifier for Keywords } 
    procedure Scan; 
    begin 
       if Token = 'x' then 
          Token := KWcode[Lookup(Addr(KWlist), Value, NKW) + 1]; 
    end; 
     
    { Match a Specific Input String } 
    procedure MatchString(x: string); 
    begin 
       if Value <> x then Expected('''' + x + ''''); 
       Next; 
    end; 
     
    { Output a String with Tab } 
    procedure Emit(s: string); 
    begin 
       Write(TAB, s); 
    end; 
     
    { Output a String with Tab and CRLF } 
    procedure EmitLn(s: string); 
    begin 
       Emit(s); 
       WriteLn; 
    end; 
     
    { Generate a Unique Label } 
    function NewLabel: string; 
    var S: string; 
    begin 
       Str(LCount, S); 
       NewLabel := 'L' + S; 
       Inc(LCount); 
    end; 
     
    { Post a Label To Output } 
    procedure PostLabel(L: string); 
    begin 
       WriteLn(L, ':'); 
    end; 
    {---------------------------------------------------------------} 
    { Clear the Primary Register } 
    procedure Clear; 
    begin 
       EmitLn('CLR D0'); 
    end; 
    {---------------------------------------------------------------} 
    { Negate the Primary Register } 
    procedure Negate; 
    begin 
       EmitLn('NEG D0'); 
    end; 
    {---------------------------------------------------------------} 
    { Complement the Primary Register } 
    procedure NotIt; 
    begin 
       EmitLn('NOT D0'); 
    end; 
    {---------------------------------------------------------------} 
    { Load a Constant Value to Primary Register } 
    procedure LoadConst(n: string); 
    begin 
       Emit('MOVE #'); 
       WriteLn(n, ',D0'); 
    end; 
    {---------------------------------------------------------------} 
    { Load a Variable to Primary Register } 
    procedure LoadVar(Name: string); 
    begin 
       if not InTable(Name) then Undefined(Name); 
       EmitLn('MOVE ' + Name + '(PC),D0'); 
    end; 
    {---------------------------------------------------------------} 
    { Push Primary onto Stack } 
    procedure Push; 
    begin 
       EmitLn('MOVE D0,-(SP)'); 
    end; 
    {---------------------------------------------------------------} 
    { Add Top of Stack to Primary } 
    procedure PopAdd; 
    begin 
       EmitLn('ADD (SP)+,D0'); 
    end; 
    {---------------------------------------------------------------} 
    { Subtract Primary from Top of Stack } 
    procedure PopSub; 
    begin 
       EmitLn('SUB (SP)+,D0'); 
       EmitLn('NEG D0'); 
    end; 
    {---------------------------------------------------------------} 
    { Multiply Top of Stack by Primary } 
    procedure PopMul; 
    begin 
       EmitLn('MULS (SP)+,D0'); 
    end; 
    {---------------------------------------------------------------} 
    { Divide Top of Stack by Primary } 
    procedure PopDiv; 
    begin 
       EmitLn('MOVE (SP)+,D7'); 
       EmitLn('EXT.L D7'); 
       EmitLn('DIVS D0,D7'); 
       EmitLn('MOVE D7,D0'); 
    end; 
    {---------------------------------------------------------------} 
    { AND Top of Stack with Primary } 
    procedure PopAnd; 
    begin 
       EmitLn('AND (SP)+,D0'); 
    end; 
    {---------------------------------------------------------------} 
    { OR Top of Stack with Primary } 
    procedure PopOr; 
    begin 
       EmitLn('OR (SP)+,D0'); 
    end; 
    {---------------------------------------------------------------} 
    { XOR Top of Stack with Primary } 
    procedure PopXor; 
    begin 
       EmitLn('EOR (SP)+,D0'); 
    end; 
    {---------------------------------------------------------------} 
    { Compare Top of Stack with Primary } 
    procedure PopCompare; 
    begin 
       EmitLn('CMP (SP)+,D0'); 
    end; 
    {---------------------------------------------------------------} 
    { Set D0 If Compare was = } 
    procedure SetEqual; 
    begin 
       EmitLn('SEQ D0'); 
       EmitLn('EXT D0'); 
    end; 
    {---------------------------------------------------------------} 
    { Set D0 If Compare was != } 
    procedure SetNEqual; 
    begin 
       EmitLn('SNE D0'); 
       EmitLn('EXT D0'); 
    end; 
    {---------------------------------------------------------------} 
    { Set D0 If Compare was > } 
    procedure SetGreater; 
    begin 
       EmitLn('SLT D0'); 
       EmitLn('EXT D0'); 
    end; 
    {---------------------------------------------------------------} 
    { Set D0 If Compare was < } 
    procedure SetLess; 
    begin 
       EmitLn('SGT D0'); 
       EmitLn('EXT D0'); 
    end; 
    {---------------------------------------------------------------} 
    { Set D0 If Compare was <= } 
    procedure SetLessOrEqual; 
    begin 
       EmitLn('SGE D0'); 
       EmitLn('EXT D0'); 
    end; 
    {---------------------------------------------------------------} 
    { Set D0 If Compare was >= } 
    procedure SetGreaterOrEqual; 
    begin 
       EmitLn('SLE D0'); 
       EmitLn('EXT D0'); 
    end; 
    {---------------------------------------------------------------} 
    { Store Primary to Variable } 
    procedure Store(Name: string); 
    begin 
       EmitLn('LEA ' + Name + '(PC),A0'); 
       EmitLn('MOVE D0,(A0)') 
    end; 
    {---------------------------------------------------------------} 
    { Branch Unconditional  } 
    procedure Branch(L: string); 
    begin 
       EmitLn('BRA ' + L); 
    end; 
    {---------------------------------------------------------------} 
    { Branch False } 
    procedure BranchFalse(L: string); 
    begin 
       EmitLn('TST D0'); 
       EmitLn('BEQ ' + L); 
    end; 
    {---------------------------------------------------------------} 
    { Read Variable to Primary Register } 
    procedure ReadIt(Name: string); 
    begin 
       EmitLn('BSR READ'); 
       Store(Name); 
    end; 
    { Write from Primary Register } 
    procedure WriteIt; 
    begin 
       EmitLn('BSR WRITE'); 
    end; 
     
    { Write Header Info } 
    procedure Header; 
    begin 
       WriteLn('WARMST', TAB, 'EQU $A01E'); 
    end; 
     
    { Write the Prolog } 
    procedure Prolog; 
    begin 
       PostLabel('MAIN'); 
    end; 
     
    { Write the Epilog } 
    procedure Epilog; 
    begin 
       EmitLn('DC WARMST'); 
       EmitLn('END MAIN'); 
    end; 
    {---------------------------------------------------------------} 
    { Allocate Storage for a Static Variable } 
    procedure Allocate(Name, Val: string); 
    begin 
       WriteLn(Name, ':', TAB, 'DC ', Val); 
    end; 
    {---------------------------------------------------------------} 
    { Parse and Translate a Math Factor } 
    procedure BoolExpression; Forward; 
    procedure Factor; 
    begin 
       if Token = '(' then begin 
          Next; 
          BoolExpression; 
          MatchString(')'); 
          end 
       else begin 
          if Token = 'x' then 
             LoadVar(Value) 
          else if Token = '#' then 
             LoadConst(Value) 
          else Expected('Math Factor'); 
          Next; 
       end; 
    end; 
     
    { Recognize and Translate a Multiply } 
    procedure Multiply; 
    begin 
       Next; 
       Factor; 
       PopMul; 
    end; 
    {-------------------------------------------------------------} 
    { Recognize and Translate a Divide } 
    procedure Divide; 
    begin 
       Next; 
       Factor; 
       PopDiv; 
    end; 
    {---------------------------------------------------------------} 
    { Parse and Translate a Math Term } 
    procedure Term; 
    begin 
       Factor; 
       while IsMulop(Token) do begin 
          Push; 
          case Token of 
           '*': Multiply; 
           '/': Divide; 
          end; 
       end; 
    end; 
     
    { Recognize and Translate an Add } 
    procedure Add; 
    begin 
       Next; 
       Term; 
       PopAdd; 
    end; 
    {-------------------------------------------------------------} 
    { Recognize and Translate a Subtract } 
    procedure Subtract; 
    begin 
       Next; 
       Term; 
       PopSub; 
    end; 
    {---------------------------------------------------------------} 
    { Parse and Translate an Expression } 
    procedure Expression; 
    begin 
       if IsAddop(Token) then 
          Clear 
       else 
          Term; 
       while IsAddop(Token) do begin 
          Push; 
          case Token of 
           '+': Add; 
           '-': Subtract; 
          end; 
       end; 
    end; 
    {---------------------------------------------------------------} 
    { Get Another Expression and Compare } 
    procedure CompareExpression; 
    begin 
       Expression; 
       PopCompare; 
    end; 
    {---------------------------------------------------------------} 
    { Get The Next Expression and Compare } 
    procedure NextExpression; 
    begin 
       Next; 
       CompareExpression; 
    end; 
    {---------------------------------------------------------------} 
    { Recognize and Translate a Relational "Equals" } 
    procedure Equal; 
    begin 
       NextExpression; 
       SetEqual; 
    end; 
    {---------------------------------------------------------------} 
    { Recognize and Translate a Relational "Less Than or Equal" } 
    procedure LessOrEqual; 
    begin 
       NextExpression; 
       SetLessOrEqual; 
    end; 
    {---------------------------------------------------------------} 
    { Recognize and Translate a Relational "Not Equals" } 
    procedure NotEqual; 
    begin 
       NextExpression; 
       SetNEqual; 
    end; 
    {---------------------------------------------------------------} 
    { Recognize and Translate a Relational "Less Than" } 
    procedure Less; 
    begin 
       Next; 
       case Token of 
         '=': LessOrEqual; 
         '>': NotEqual; 
       else begin 
               CompareExpression; 
               SetLess; 
            end; 
       end; 
    end; 
    {---------------------------------------------------------------} 
    { Recognize and Translate a Relational "Greater Than" } 
    procedure Greater; 
    begin 
       Next; 
       if Token = '=' then begin 
          NextExpression; 
          SetGreaterOrEqual; 
          end 
       else begin 
          CompareExpression; 
          SetGreater; 
       end; 
    end; 
    {---------------------------------------------------------------} 
    { Parse and Translate a Relation } 
    procedure Relation; 
    begin 
       Expression; 
       if IsRelop(Token) then begin 
          Push; 
          case Token of 
           '=': Equal; 
           '<': Less; 
           '>': Greater; 
          end; 
       end; 
    end; 
    {---------------------------------------------------------------} 
    { Parse and Translate a Boolean Factor with Leading NOT } 
    procedure NotFactor; 
    begin 
       if Token = '!' then begin 
          Next; 
          Relation; 
          NotIt; 
          end 
       else 
          Relation; 
    end; 
    {---------------------------------------------------------------} 
    { Parse and Translate a Boolean Term } 
    procedure BoolTerm; 
    begin 
       NotFactor; 
       while Token = '&' do begin 
          Push; 
          Next; 
          NotFactor; 
          PopAnd; 
       end; 
    end; 
     
    { Recognize and Translate a Boolean OR } 
    procedure BoolOr; 
    begin 
       Next; 
       BoolTerm; 
       PopOr; 
    end; 
     
    { Recognize and Translate an Exclusive Or } 
    procedure BoolXor; 
    begin 
       Next; 
       BoolTerm; 
       PopXor; 
    end; 
    {---------------------------------------------------------------} 
    { Parse and Translate a Boolean Expression } 
    procedure BoolExpression; 
    begin 
       BoolTerm; 
       while IsOrOp(Token) do begin 
          Push; 
          case Token of 
           '|': BoolOr; 
           '~': BoolXor; 
          end; 
       end; 
    end; 
     
    { Parse and Translate an Assignment Statement } 
    procedure Assignment; 
    var Name: string; 
    begin 
       CheckTable(Value); 
       Name := Value; 
       Next; 
       MatchString('='); 
       BoolExpression; 
       Store(Name); 
    end; 
    {---------------------------------------------------------------} 
    { Recognize and Translate an IF Construct } 
    procedure Block; Forward; 
    procedure DoIf; 
    var L1, L2: string; 
    begin 
       Next; 
       BoolExpression; 
       L1 := NewLabel; 
       L2 := L1; 
       BranchFalse(L1); 
       Block; 
       if Token = 'l' then begin 
          Next; 
          L2 := NewLabel; 
          Branch(L2); 
          PostLabel(L1); 
          Block; 
       end; 
       PostLabel(L2); 
       MatchString('ENDIF'); 
    end; 
     
    { Parse and Translate a WHILE Statement } 
    procedure DoWhile; 
    var L1, L2: string; 
    begin 
       Next; 
       L1 := NewLabel; 
       L2 := NewLabel; 
       PostLabel(L1); 
       BoolExpression; 
       BranchFalse(L2); 
       Block; 
       MatchString('ENDWHILE'); 
       Branch(L1); 
       PostLabel(L2); 
    end; 
     
    { Read a Single Variable } 
    procedure ReadVar; 
    begin 
       CheckIdent; 
       CheckTable(Value); 
       ReadIt(Value); 
       Next; 
    end; 
     
    { Process a Read Statement } 
    procedure DoRead; 
    begin 
       Next; 
       MatchString('('); 
       ReadVar; 
       while Token = ',' do begin 
          Next; 
          ReadVar; 
       end; 
       MatchString(')'); 
    end; 
     
    { Process a Write Statement } 
    procedure DoWrite; 
    begin 
       Next; 
       MatchString('('); 
       Expression; 
       WriteIt; 
       while Token = ',' do begin 
          Next; 
          Expression; 
          WriteIt; 
       end; 
       MatchString(')'); 
    end; 
     
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
          else Assignment; 
          end; 
          Scan; 
       end; 
    end; 
     
    { Allocate Storage for a Variable } 
    procedure Alloc; 
    begin 
       Next; 
       if Token <> 'x' then Expected('Variable Name'); 
       CheckDup(Value); 
       AddEntry(Value, 'v'); 
       Allocate(Value, '0'); 
       Next; 
    end; 
     
    { Parse and Translate Global Declarations } 
    procedure TopDecls; 
    begin 
       Scan; 
       while Token = 'v' do 
          Alloc; 
          while Token = ',' do 
             Alloc; 
    end; 
     
    { Initialize } 
    procedure Init; 
    begin 
       GetChar; 
       Next; 
    end; 
     
    { Main Program } 
    begin 
       Init; 
       MatchString('PROGRAM'); 
       Header; 
       TopDecls; 
       MatchString('BEGIN'); 
       Prolog; 
       Block; 
       MatchString('END'); 
       Epilog; 
    end. 


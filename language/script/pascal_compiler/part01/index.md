---
Title: 1. Введение
Date: 01.01.2007
---


1\. Введение
========

[Лекции по построению компилятора на Pascal](../)

Эта серия статей является руководством по теории и практике разработки
синтаксических анализаторов и компиляторов языков программирования.
Прежде чем вы закончите чтение этой книги, мы раскроем все аспекты
конструирования компиляторов, создадим новый язык программирования, и
построим работающий компилятор.

Хотя я по образованию и не специалист в компьютерах, я интересовался
компиляторами в течение многих лет. Я покупал и старался разобраться с
содержимым практически каждой выпущенной на эту тему книги. И, должен
признаться, это был долгий путь. Эти книги написаны для специалистов в
компьютерной науке и  слишком трудны для понимания большинству из нас.
Но с течением лет часть из прочитанного начала доходить до меня.
Закрепить полученное позволило то, что я начал самостоятельно пробовать
это на своем собственном компьютере. Сейчас я хочу поделиться с вами
своими знаниями. После прочтения этой книги вы не станете ни
специалистом, ни узнаете всех секретов теории конструирования
компиляторов. Я намеренно полностью игнорирую большинство теоретических
аспектов этой темы. Вы изучите только практические аспекты, необходимые
для создания работающей системы.

В течение всей книги я буду проводить эксперименты на компьютере, а вы
будете повторять их за мной и ставить свои собственные эксперименты. Я
буду использовать Turbo Pascal 4.0 и периодически буду включать примеры,
написанные в TP. Эти примеры вы будете копировать себе в компьютер и
выполнять. Если у вас не установлен Turbo Pascal вам будет трудно
следить за ходом обучения, поэтому я настоятельно рекомендую его
поставить. Кроме того, это просто замечательный продукт и для множества
других задач!

Некоторые тексты программ будут показаны как примеры или как законченные
продукты, которые вы можете копировать без необходимости понимания
принципов их работы. Но я надеюсь сделать гораздо больше: я хочу научить
вас КАК это делается, чтобы вы могли делать это самостоятельно, и не
только повторять то, что я делаю, но и улучшать.

Такую задачу не решить на одной странице. Я попытаюсь сделать это в
нескольких статьях. Каждая статья раскрывает один аспект теории создания
компиляторов и может быть изучена в отдельности от всех других. Если вас
в настоящее время интересует только какой-то определенный аспект, тогда
вы можете обратиться к нужной статье. Каждая статья будет появляться по
мере завершения, так что вы должны дождаться последней для того, чтобы
считать себя закончившими обучение. Пожалуйста, будьте терпеливы.

В общем, каждая книга по теории создания компиляторов раскрывает
множество основ, которые мы не будем рассматривать. Типичная
последовательность:

- вступление, в котором описывается что такое компилятор.

- одна или две главы, описывающие задание синтаксиса с использованием формы Бэкуса-Наура (БНФ).

- одна или две главы с описанием лексического анализа, с акцентом на детерминированных и недетерминированных конечных автоматах.

- несколько глав по теории синтаксического анализа, начиная с рекурсивного спуска и заканчивая LALR анализаторами.

- глава, посвященная промежуточным языкам, с акцентом на P-код и обратную польскую запись.

- множество глав об альтернативных путях для поддержки подпрограмм и передачи параметров, описания типов, и т.д.

- завершающая глава по генерации кода, обычно для какого-нибудь воображаемого процессора с простым набором команд.

- финальная глава или две, посвященные оптимизации. Эта глава часто остается непрочитанной, очень часто.

В этой серии я буду использовать совсем другой подход. Для начала, я не
остановлюсь долго на выборе. Я покажу вам путь, который работает. Если
же вы хотите изучить возможности, хорошо... я поддержу вас... но я буду
держаться того, что я знаю. Я также пропущу большинство тех теорий,
которые заставляют людей засыпать. Не поймите меня неправильно: я не
преуменьшаю важность теоретических знаний, они жизненно необходимы,
когда приходится иметь дело с более сложными элементами какого либо
языка. Но необходимо более важные вещи ставить на первое место. Мы же
будем иметь дело с методами, 95% которых не требуют много теории для
работы.

Я также буду рассматривать только один метод синтаксического анализа:
рекурсивный спуск, который является единственным полностью пригодным
методом при ручном написании компилятора. Другие методы полезны только в
том случае, если у вас есть инструменты типа Yacc, и вам совсем неважно,
сколько памяти будет использовать готовый продукт.

Я также возьму страницу из работы Рона Кейна, автора Small C. Поскольку
почти все другие авторы компиляторов исторически использовали
промежуточный язык подобно P-коду и разделяли компилятор на две части
(«front end», который производит P-код, и «back end», который
обрабатывает P-код, для получения выполняемого объектного кода), Рон
показал нам, что очень просто заставить компилятор непосредственно
производить выполняемый объектный код в форме языковых утверждений
ассемблера. Такой код не самый компактный в мире код... генерация
оптимизированного кода - гораздо более трудная работа. Но этот метод
работает и работает достаточно хорошо. И чтобы не оставить вас с мыслью,
что наш конечный продукт не будет представлять никакой ценности, я
собираюсь показать вам как создать компилятор с небольшой оптимизацией.

Наконец, я собираюсь использовать некоторые приемы, которые мне
показались наиболее полезными для того, чтобы понимать, что происходит,
не продираясь сквозь дремучий лес. Основным из них является
использование одно-символьных токенов, не содержащих пробелов, на ранней
стадии разработки. Я считаю, что если я могу создать синтаксический
анализатор для распознавания и обработки I-T-L, то я смогу сделать тоже
и с IF-THEN-ELSE. На втором уроке я покажу вам, как легко расширить
простой синтаксический анализатор для поддержки токенов произвольной
длины. Следующий прием состоит в том, что я полностью игнорирую файловый
ввод/вывод, показывая этим, что если я могу считывать данные с
клавиатуры и выводить результат на экран я могу также делать это и с
файлами на диске. Опыт показывает, что как только транслятор заработает
правильно очень просто перенаправить ввод/вывод на файлы. Последний
прием заключается в том, что я не пытаюсь выполнять
коррекцию/восстановление после ошибок. Программа, которую мы будем
создавать, будет распознавать ошибки и просто остановится на первой из
них, точно также как это происходит в Turbo Pascal. Будут и некоторые
другие приемы, которые вы увидите по ходу дела. Большинство из них вы не
найдете в каком либо учебнике по компиляторам, но они работают.

Несколько слов о стиле программирования и эффективности. Как вы увидите,
я стараюсь писать программы в виде маленьких, легко понятных фрагментов.
Ни одна из процедур, с которыми мы будем работать, не будет состоять
более чем из 15-20 строк. Я горячий приверженец принципа KISS (Keep It
Simple, Sidney - Делай это проще, Сидней) в программировании. Я никогда
не пытаюсь сделать что-либо сложное, когда можно сделать просто.
Неэффективно? Возможно, но вам понравится результат. Как сказал Брайан
Керниган, сначала заставьте программу работать, затем заставьте
программу работать быстро. Если позднее вы захотите вернуться и
подправить что-либо в вашем продукте, вы сможете сделать это т.к. код
будет совершенно понятным. Если вы поступаете так, я, тем не менее,
убеждаю вас подождать пока программа не будет выполнять все, что вы от
нее хотите.

Я также имею тенденцию не торопиться с созданием модулей до тех пор,
пока не обнаружу, что они действительно нужны мне. Попытка предусмотреть
все необходимое в будущем может свести вас с ума. В наши время, время
экранных редакторов и быстрых компиляторов  я буду менять модули тогда,
когда почувствую необходимость в более мощном. До тех пор я буду писать
только то, что мне нужно.

Заключительный аспект: Один из принципов, который мы будем применять
здесь, заключается в том, что мы не будем никого вводить в заблуждение с
P-кодом или воображаемыми ЦПУ, но мы начнем с получения работающего,
выполнимого объектного кода, по крайней мере, в виде программы на
ассемблере. Тем не менее, вам может не понравиться выбранный мной
ассемблер... это - ассемблер для микропроцессора 68000, используемый в
моей системе (под SK\*DOS). Я думаю, что вы найдете, тем не менее, что
трансляция для любого другого ЦПУ, например 80x86, совершенно очевидна,
так что я не вижу здесь проблемы. Фактически, я надеюсь что кто-то, кто
знает язык 8086 лучше, чем я, предоставит нам эквивалент объектного
кода.

**ОСНОВА**

Каждая программа нуждается в некоторых шаблонах ... подпрограммы
ввода/вывода, подпрограммы сообщений об ошибках и т.д. Программы,
которые мы будем разрабатывать, не составляют исключения. Я попытался
выполнить их на минимальном уровне, чтобы мы могли сконцентрироваться на
более важных вещах и не заблудиться. Код, размещенный ниже, представляет
собой минимум, необходимый нам, чтобы что-нибудь сделать. Он состоит из
нескольких подпрограмм ввода/вывод, подпрограммы обработки ошибок  и
скелета - пустой основной программы. Назовем ее Cradle. По мере
создания других подпрограмм, мы будем добавлять их к Cradle и добавлять
вызовы этих подпрограмм.  Скопируйте Cradle и сохраните его, потому что
мы будем использовать его неоднократно.

Существует множество различных путей для организации процесса
сканирования в синтаксическом анализаторе. В Unix системах авторы обычно
используют getc и ungetc. Удачный метод, примененный мной, заключается в
использовании одиночного, глобального упреждающего символа. Части
процедуры инициализации служит для «запуска помпы», считывая первый
символ из входного потока. Никаких других специальных методов не
требуется, каждый удачный вызов GetChar считывает следующий символ из
потока.

    program Cradle; 
     
    { Constant Declarations } 
    const TAB = ^I; 
     
    { Variable Declarations } 
    var Look: char;              { Lookahead Character } 
     
     
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
     
     
    { Match a Specific Input Character } 
    procedure Match(x: char); 
    begin 
       if Look = x then GetChar 
       else Expected('''' + x + ''''); 
    end; 
     
     
    { Recognize an Alpha Character } 
    function IsAlpha(c: char): boolean; 
    begin 
       IsAlpha := upcase(c) in ['A'..'Z']; 
    end; 
     
     
    { Recognize a Decimal Digit } 
    function IsDigit(c: char): boolean; 
    begin 
       IsDigit := c in ['0'..'9']; 
    end; 
     
     
    { Get an Identifier } 
    function GetName: char; 
    begin 
       if not IsAlpha(Look) then Expected('Name'); 
       GetName := UpCase(Look); 
       GetChar; 
    end; 
     
     
    { Get a Number } 
    function GetNum: char; 
    begin 
       if not IsDigit(Look) then Expected('Integer'); 
       GetNum := Look; 
       GetChar; 
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
     
     
    { Initialize } 
    procedure Init; 
    begin 
       GetChar; 
    end; 
     
     
    { Main Program } 
    begin 
       Init; 
    end. 


Скопируйте код, представленный выше, в TP и откомпилируйте.
Удостоверьтесь, что программа откомпилировалась и запустилась корректно.
Затем переходим к первому уроку, синтаксическому анализу выражений.

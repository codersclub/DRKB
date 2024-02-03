---
Title: Форматы кодирования файлов Интернет
Date: 01.01.2007
---


Форматы кодирования файлов Интернет
===================================

::: {.date}
01.01.2007
:::

1. Форматы кодирования файлов Интернет

Форматы файлов Интернет можно разделить на несколько групп. Во первых
форматы передачи файлов по FTP, для чего очень давно была разработана
схема uuencode/decode, замененная затем на xxencode/decode. В дальнейшем
произошел отказ в пользу Base64 и MIME, которая сейчас используется
большинством почтовых программ. Второй тип  Интернет форматов это HTML,
который со всеми его версиями (часто специфичными для конкретного
браузера) и улучшениями сам в себе. Третий тип Интернет форматов это
больше интерфейс или протокол связи: CGI, который может быть или
стандартный CGI (консольный, или Windows CGI или WinCGI.).

1.1. Передача файлов через Интернет

Дельфи имеет сильный набор средств для написания новых компонентов и для
иллюстрации мы напишем кодирование с помощью uuencode/uudecode,
xxencode/xxdecode и Base64. Мы напишем достаточно мощный компонент,
который реализует данные алгоритмы. Новый компонент реализует uuencode и
uudecode алгоритмы, которые могут быть использованы для передачи файлов
через Интернет (ранее использовались для передачи файлов между Unix
системами).

Для более утонченного способа передачи файлов смотри главу об WinInet и
FTP компонентах. Эти алгоритмы кодирования файлов д в основном
используются для передачи файлов в почте и группах новостей

1.1.1. UUEncode и UUDecode

Необходимость кодирование файлов при передаче является то, что ф файле
могут находиться любые двоичные данные, для это файл преобразовывается в
"читаемую" или "печатаемую" форму в набор из 64 символов:
[\`!"#$%&\'()*+,-./0123456789:;\<=?\@ABC...XYZ[\\]\^\_], что бы
кодированный фал прошел через различные сети и почтовые шлюзы. Эти 64
печатных символа представлены в следующей таблице.

Набор символов UUEncode

0 \`

8 (

16 0

24 8

32 @

40 H

48 P

56 X

1 !

9 )

17 1

25 9

33 A

41 I

49 Q

57 Y

2 "

10 *

18 2

26 :

34 B

42 J

50 R

58 Z

3 #

11 +

19 3

27 ;

35 C

43 K

51 S

59 [

4 $

12,

20 4

28 \<

36 D

44 L

52 T

60 \

5 %

13 -

21 5

29 =

37 E

45 M

53 U

61 ]

6 &

14 .

22 6

30 \>

38 F

46 N

54 V

62 \^

7 \'

15 /

23 7

31 ?

39 G

47 O

55 W

63 \_

Алгоритм выдает файл состоящий из строки заголовка, за ней несколько
кодированных строк и в конце завершающая строка.

Любые строки до строки заголовка или после завершающей строки
игнорируются (так как они не содержат специальных ключевых слов
"begin" или "end", которые однозначно определяют заголовок и
завершающую строку).

Строка заголовка начинается с ключевого слова "begin", за который
следует режим файла (четыре восьмеричных цифры) и имя файла, разделенные
пробелом.

Завершающая строка начинается с ключевого слова "end"

Кодированные строки располагаются между заголовком и завершающей
строкой, и могут содержать максимум 61 символ, первый символ указывает
размер строки и максимум 60 символов сама строка.

Первый символ строки содержит длину строки из набора символов UUEncode,
для получения подлинной длины строки из кода символов вычитается 32
($20).

Строки данных могут содержать максимум 60 символов, это означает, что
первый символ строки (длина) может быть \'M\' (60 символ набора символов
UUEncode).

Действительные данные группируются по четыре байта.

Три символа из входного фала (3 * 8 = 24 бита) кодируются в четыре
символа, так что каждый из них содержит только 6 бит, то есть значения
от 0 до 63.

Результат затем используется как индекс в таблицу набора символов
UUEncode.

Так как каждый кодированный символ представляет из себя простой символ
таблицы ASCII начинающийся с позиции 33 и до позиции 64 + 32 = 96, то мы
можем просто прибавить ASCII значение символа пробела, что бы получить
требуемый UUкодированный символ.

Алгоритм преобразовывает три двоичных символа (Triplet) в четыре
(Kwartet) UUкодированных символа и может быть реализован в Паскале
следующим образом.

    procedure Triplet2Kwartet(const Triplet: TTriplet;
                                var Kwartet: TKwartet);
     var
       i: Integer;
     begin
       Kwartet[0] := (Triplet[0]  SHR 2);
       Kwartet[1] := ((Triplet[0] SHL 4) AND $30) +
                     ((Triplet[1] SHR 4) AND $0F);
       Kwartet[2] := ((Triplet[1] SHL 2) AND $3C) +
                     ((Triplet[2] SHR 6) AND $03);
       Kwartet[3] := (Triplet[2] AND $3F);
       for i:=0 to 3 do
         if Kwartet[i] = 0 then
           Kwartet[i] := $40 + Ord(SP)
         else Inc(Kwartet[i], Ord(SP))
     end {Triplet2Kwartet};

Данная процедура состоит из двух частей: в первой части 24 бита (3 * 8)
из триплета преобразовываются в 24 бита (4 * 6) квартета. Во второй
части алгоритма, мы добавляем ASCII код символа пробела к каждому
квартету. ASCII код символа пробела закодирован как Ord(SP), где SP
определен как символ пробела или #32. Заметим, что для случая когда
квартет равен 0, то мы не добавляем значение  #32, поскольку многие
почтовые программы имеют проблемы с этим символом, просто в этом случае
добавляем код со значением 64 ($40)., в результате получаем вместо
пробела код обратного апострофа, который нейтрален к алгоритму
декодирования, одинаково работающий как для пробела так и для апострофа.

Говоря о декодировании, реализация его в Паскале преобразования
квартетов обратно в триплеты следующая:

    procedure Kwartet2Triplet(const Kwartet: TKwartet;
                               var Triplet: TTriplet);
     var
       i: Integer;
     begin
       Triplet[0] :=  ((Kwartet[0] - Ord(SP)) SHL 2) +
                     (((Kwartet[1] - Ord(SP)) AND $30) SHR 4);
       Triplet[1] := (((Kwartet[1] - Ord(SP)) AND $0F) SHL 4) +
                     (((Kwartet[2] - Ord(SP)) AND $3C) SHR 2);
       Triplet[2] := (((Kwartet[2] - Ord(SP)) AND $03) SHL 6) +
                      ((Kwartet[3] - Ord(SP)) AND $3F)
     end {Kwartet2Triplet};

Если размер триплета в файле менее 3 байт (4 байта в квартете), то
производится добавление структуры нулями при кодировании и
декодировании.

1.1.2. XXEncode и XXDecode

UUкодирование было наиболее популярным форматом 64 битного кодирования.
Ограничение состояло в том, что набор символов не мог транслироваться
между наборами ASCII и EBCDIC (IBM мейнфреймы). XXencode очень похож на
UUEncode, просто используется другой набор символов, что более удобно
между различными типами систем, например как указано выше между EBCDIC и
ASCII.



Набор символов XXEncode

0 +

8 6

16 E

24 M

32 U

40 c

48 k

56 s



1 -

9 7

17 F

25 N

33 V

41 d

49 l

57 t



2 0

10 8

18 G

26 O

34 W

42 e

50 m

58 u



3 1

11 9

19 H

27 P

35 X

43 f

51 n

59 v



4 2

12 A

20 I

28 Q

36 Y

44 g

52 o

60 w



5 3

13 B

21 J

29 R

37 Z

45 h

53 p

61 x



6 4

14 C

22 K

30 S

38 a

46 i

54 q

62 y



7 5

15 D

23 L

31 T

39 b

47 j

55 r

63 z



Заметим что если для UUEncode используется подмножество набора символов
ASCII (32..96), то для XXEncode это не так.

Для преобразования процедур Triplet2Kwartet и Kwartet2Triplet для
поддержки мы вводим дополнительный массив из 64 символов.

Нам также необходимо модифицировать процедуры Triplet2Kwartet и
Kwartet2Triplet следующим образом.

    const
       XX: Array[0..63] of Char =
          '+-0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
     
     procedure Triplet2Kwartet(const Triplet: TTriplet;
                               var Kwartet: TKwartet);
     var
       i: Integer;
     begin
       Kwartet[0] := (Triplet[0] SHR 2);
       Kwartet[1] := ((Triplet[0] SHL 4) AND $30) +
                     ((Triplet[1] SHR 4) AND $0F);
       Kwartet[2] := ((Triplet[1] SHL 2) AND $3C) +
                     ((Triplet[2] SHR 6) AND $03);
       Kwartet[3] := (Triplet[2] AND $3F);
       for i:=0 to 3 do
         if Kwartet[i] = 0 then
           Kwartet[i] := $40 + Ord(SP)
         else Inc(Kwartet[i],Ord(SP));
       if XXCode then
         for i:=0 to 3 do
           Kwartet[i] := Ord(XX[(Kwartet[i] - Ord(SP)) mod $40])
     end {Triplet2Kwartet};

Последние несколько строк новые для процедуры Triplet2Kwartet и мы
используем набор символов XXencode для возврата правильно закодированных
символов. Помните, что UUEncode возвращает индекс  кодированного
символа, после чего мы к нему добавляем код #32, так что если XXencode
используется после преобразования в UUEncode, то мы должны вычесть 32 и
использовать результат как индекс в таблицу символов XXencode.

То же самое относится и к процедуре Kwartet2Triplet, где мы должны
преобразовать XXencode  символы перед использованием алгоритма UUdecode
(заметим, что мы теперь не передаем Kwartet как const).

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 19px;"}
    procedure Kwartet2Triplet(Kwartet: TKwartet;
                               var Triplet: TTriplet);
     var
       i: Integer;
     begin
       if XXCode then
       begin
         for i:=0 to 3 do
         begin
           case Chr(Kwartet[i]) of
                 '+': Kwartet[i] := 0 + Ord(SP);
                 '-': Kwartet[i] := 1 + Ord(SP);
            '0'..'9': Kwartet[i] := 2 + Kwartet[i]
                                      - Ord('0') + Ord(SP);
            'A'..'Z': Kwartet[i] := 12 + Kwartet[i]
                                       - Ord('A') + Ord(SP);
            'a'..'z': Kwartet[i] := 38 + Kwartet[i]
                                       - Ord('a') + Ord(SP)
           end
         end
       end;
       Triplet[0] :=  ((Kwartet[0] - Ord(SP)) SHL 2) +
                     (((Kwartet[1] - Ord(SP)) AND $30) SHR 4);
       Triplet[1] := (((Kwartet[1] - Ord(SP)) AND $0F) SHL 4) +
                     (((Kwartet[2] - Ord(SP)) AND $3C) SHR 2);
       Triplet[2] := (((Kwartet[2] - Ord(SP)) AND $03) SHL 6) +
                      ((Kwartet[3] - Ord(SP)) AND $3F)
     end {Kwartet2Triplet};

 

Заметим, что в новой версии этих процедур используется глобальная
переменная XXCode логического типа для определения типа кодирования.

1.1.3. Base64

Алгоритм кодирования Base64 отличается от алгоритмов UUencode и XXencode
тем, что в нем не используется первый символ как индикатор длины. Общее
то что используется алгоритм преобразования триплетов в квартеты с
помощью 64 байтной таблицы преобразования.


:::

Набор символов Base64

0 A

8 I

16 Q

24 Y

32 g

40 o

48 w

56 4



1 B

9 J

17 R

25 Z

33 h

41 p

49 x

57 5



2 C

10 K

18 S

26 a

34 I

42 q

50 y

58 6



3 D

11 L

19 T

27 b

35 j

43 r

51 z

59 7



4 E

12 M

20 U

28 c

36 k

44 s

52 0

60 8



5 F

13 N

21 V

29 d

37 l

45 t

53 1

61 9



6 G

14 O

22 W

30 e

38 m

46 u

54 2

62 +



7 H

15 P

23 X

31 f

39 n

47 v

55 3

63 /



Подобно набору символов XXencode, набор символов Base64 не является
подмножеством набора символов ASCII.

Это означает, что мы должны добавить массив преобразования в набор
символов Base64 и также преобразовать процедуры Triplet2Kwartet и
Kwartet2Triplet для поддержки данного алгоритма:

     const
       B64: Array[0..63] of Char =
          'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';
     
     procedure Triplet2Kwartet(Const Triplet: TTriplet;
                               var Kwartet: TKwartet);
     var
       i: Integer;
     begin
       Kwartet[0] := (Triplet[0] SHR 2);
       Kwartet[1] := ((Triplet[0] SHL 4) AND $30) +
                     ((Triplet[1] SHR 4) AND $0F);
       Kwartet[2] := ((Triplet[1] SHL 2) AND $3C) +
                     ((Triplet[2] SHR 6) AND $03);
       Kwartet[3] := (Triplet[2] AND $3F);
       for i:=0 to 3 do
         if Kwartet[i] = 0 then
           Kwartet[i] := $40 + Ord(SP)
         else Inc(Kwartet[i],Ord(SP));
       if Base64 then
         for i:=0 to 3 do
           Kwartet[i] := Ord(B64[(Kwartet[i] - Ord(SP)) mod $40])
       else
         if XXCode then
           for i:=0 to 3 do
             Kwartet[i] := Ord(XX[(Kwartet[i] - Ord(SP)) mod $40])
     end {Triplet2Kwartet};
     
     procedure Kwartet2Triplet(Kwartet: TKwartet;
                               var Triplet: TTriplet);
     var
       i: Integer;
     begin
       if Base64 then
       begin
         for i:=0 to 3 do
         begin
           case Chr(Kwartet[i]) of
            'A'..'Z': Kwartet[i] := 0 + Kwartet[i]
                                      - Ord('A') + Ord(SP);
            'a'..'z': Kwartet[i] := 26+ Kwartet[i]
                                      - Ord('a') + Ord(SP);
            '0'..'9': Kwartet[i] := 52+ Kwartet[i]
                                      - Ord('0') + Ord(SP);
                 '+': Kwartet[i] := 62+ Ord(SP);
                 '/': Kwartet[i] := 63+ Ord(SP);
           end
         end
       end
       else
       if XXCode then
       begin
         for i:=0 to 3 do
         begin
           case Chr(Kwartet[i]) of
                 '+': Kwartet[i] := 0 + Ord(SP);
                 '-': Kwartet[i] := 1 + Ord(SP);
            '0'..'9': Kwartet[i] := 2 + Kwartet[i]
                                      - Ord('0') + Ord(SP);
            'A'..'Z': Kwartet[i] := 12 + Kwartet[i]
                                       - Ord('A') + Ord(SP);
            'a'..'z': Kwartet[i] := 38 + Kwartet[i]
                                       - Ord('a') + Ord(SP)
           end
         end
       end;
       Triplet[0] :=  ((Kwartet[0] - Ord(SP)) SHL 2) +
                     (((Kwartet[1] - Ord(SP)) AND $30) SHR 4);
       Triplet[1] := (((Kwartet[1] - Ord(SP)) AND $0F) SHL 4) +
                     (((Kwartet[2] - Ord(SP)) AND $3C) SHR 2);
       Triplet[2] := (((Kwartet[2] - Ord(SP)) AND $03) SHL 6) +
                      ((Kwartet[3] - Ord(SP)) AND $3F)
     end {Kwartet2Triplet};

 

Заметим, что в новой версии появилась новая глобальная переменная,
которая используется для определения формата кодирования.

1.1.4. MIME

MIME означает Multipurpose Internet Mail Extensions (Расширение форматов
Интернет почты), в котором международным стандартом является кодирование
Base64. Данное расширение было разработано для многоязычной поддержки и
преобразования символов между системами (такими как IBM мейнфреймы,
системы на базе UNIX, Macintosh и IBM PC).

MIME алгоритм кодирования базируется на RFC1341 как MIME Base64. Подобно
UUencode, назначение MIME кодировать двоичные файлы так, что бы они
смогли пройти через различные почтовые системы, и MIME использует для
этого алгоритм кодирования Base64, плюс набор специальных ключевых слов
и опций, которые используются для более детализированной информации о
содержимом MIME.

1.1.5. TBUUCode компонент

Определение интерфейса компонента TUUCode, базируется на ранее
приведенных и объясненных процедур Triplet2Kwartet и Kwartet2Triplet,
заметим, что ниже приведенный код использует условное компилирование в
зависимости от версий Delphi и C++Builder.

    unit UUCode;
     interface
     uses
     {$IFDEF WIN32}
       Windows,
     {$ELSE}
       WinTypes, WinProcs,
     {$ENDIF}
       SysUtils, Messages, Classes, Graphics, Controls, Forms;
     
     {$IFNDEF WIN32}
     type
       ShortString = String;
     {$ENDIF}
     
     type
       EUUCode = class(Exception);
     
       TAlgorithm = (filecopy, uuencode, uudecode,
                               xxencode, xxdecode,
                               Base64encode, Base64decode);
       TUnixCRLF = (CRLF, LF);
     
       TProgressEvent = procedure(Percent:Word) of Object;
     
       TBUUCode = class(TComponent)
       public
       { Public class declarations (override) }
         constructor Create(AOwner: TComponent); override;
     
       private
       { Private field declarations }
         FAbout: ShortString;
         FActive: Boolean;
         FAlgorithm: TAlgorithm;
         FFileMode: Word;
         FHeaders: Boolean;
         FInputFileName: TFileName;
         FOutputFileName: TFileName;
         FOnProgress: TProgressEvent;
         FUnixCRLF: TUnixCRLF;
       { Dummy method to get read-only About property }
         procedure Dummy(Ignore: ShortString);
     
       protected
       { Protected Activate method }
         procedure Activate(GoActive: Boolean);
     
       public
       { Public UUCode interface declaration }
         procedure UUCode;
     
       published
       { Published design declarations }
         property About: ShortString read FAbout write Dummy;
         property Active: Boolean read FActive write Activate;
         property Algorithm: TAlgorithm read Falgorithm
                                        write FAlgorithm;
         property FileMode: Word read FFileMode write FFileMode;
         property Headers: Boolean read FHeaders write FHeaders;
         property InputFile: TFileName read FInputFileName
                                       write FInputFileName;
         property OutputFile: TFileName read FOutputFileName
                                        write FOutputFileName;
         property UnixCRLF: TUnixCRLF read FUnixCRLF write FUnixCRLF;
     
       published
       { Published Event property }
         property OnProgress: TProgressEvent read FOnProgress
                                             write FOnProgress;
       end {TUUCode};

1.1.6. Свойства

TUUCode компонент имеет восемь опубликованных свойств (мы здесь опустим
описание обработчиков событий):

Свойство About содержит информацию о правах и версии.

Свойство Active может использоваться для вызова преобразования UUCode во
время разработки (design time), подобно свойству Active у TTables и
Tquery компонент.

Свойство Algorithm содержит информацию об алгоритме кодирования для
метода UUCode. Реализованы следующие алгоритмы:

::: {style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 4px 24px;"}
  --- ------------------------------------------------------------------
  ·   filecopy - простое копирование файла InputFile в файл OutputFile
  --- ------------------------------------------------------------------
:::

::: {style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 4px 24px;"}
  --- -----------------------------------------------------------------------------------------------------------
  ·   uuencode - копирование файла с помощью алгоритма uuencode из файла InputFile и генерация файла OutputFile
  --- -----------------------------------------------------------------------------------------------------------
:::

::: {style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 4px 24px;"}
  --- -------------------------------------------------------------------------------------------------------------------------------------------
  ·   uudecode - копирование файла с помощью алгоритма uudecode из файла InputFile (и генерация файла OutputFile, если не используется Headers)
  --- -------------------------------------------------------------------------------------------------------------------------------------------
:::

::: {style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 4px 24px;"}
  --- -----------------------------------------------------------------------------------------------------------
  ·   xxencode - копирование файла с помощью алгоритма xxencode из файла InputFile и генерация файла OutputFile
  --- -----------------------------------------------------------------------------------------------------------
:::

::: {style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 4px 24px;"}
  --- -------------------------------------------------------------------------------------------------------------------------------------------
  ·   xxdecode - копирование файла с помощью алгоритма xxdecode из файла InputFile (и генерация файла OutputFile, если не используется Headers)
  --- -------------------------------------------------------------------------------------------------------------------------------------------
:::

::: {style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 4px 24px;"}
  --- -----------------------------------------------------------------------------------------------------------
  ·   Base64encode - копирование файла с помощью алгоритма Base64 encode InputFile и генерация файла OutputFile
  --- -----------------------------------------------------------------------------------------------------------
:::

::: {style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 4px 24px;"}
  --- -------------------------------------------------------------------------------------------------------------------------------------------
  ·   Base64decode - копирование файла с помощью алгоритма Base64 decode InputFile (и генерация файла OutputFile, если не используется Headers)
  --- -------------------------------------------------------------------------------------------------------------------------------------------
:::

Свойство FileMode содержит шестнадцатеричное значение режима файла
(обычно 0644 или  0755). Заметим, что режим задается с помощью
десятичных цифр.

Свойство Headers может быть использовано для указания должны или нет
использоваться заголовки begin-end в алгоритме кодирования или ожидаются
в алгоритме декодирования. Значение по умолчанию True.

Свойство InputFile содержит имя входного файла для
кодирования/декодирования.

Свойство OutputFile содержит имя выходного файла, в который будет
записан результат кодирования. Заметим, что свойство OutputFile
игнорируется при декодировании, если входной файл имеет заголовки,
которые определяют имя файла для декодирования.

Свойство UnixCRLF используется для указания разделителей строк
специфичных для Unix систем, только Line Feed (перевод строки) или
DOS/Windows, где используется пара Carriage Return/Line Feed (возврат
каретки/ перевод строки). По умолчанию CRLF, но как минимум вы имеете
возможность кодировать и декодировать файлы для Unix систем.

1.1.7. Методы

Компонент TUUCode имеет три метода; один public конструктор, один
protected метод и один public метод:

Конструктор Create используется для создания компонента и инициализации
свойств ао умолчанию (default) для Active, FileMode, Headers и About.

Метод Activate используется для вызова метода UUCode во время
разработки, когда вы изменяете состояние свойства в True. При
необходимости вы можете вызвать этот метод напрямую, так как это проще
вызова метода UUCode.

Метод UUCode это метод, в котором в действительности производится
кодирование/декодирование входного файла (InputFile), базируясь на
состоянии других свойств компонента TUUCode.

1.1.8. События

Компонент TUUCode имеет только одно такое свойство:

Событие OnProgress может использоваться как callback функция,
позволяющая компоненту TUUCode выдавать текущий процент обработки
входного файла. Использовать эту информацию вы можете с компонентами
16-битным TGauge или 32-битным TprogressBar, для примера показывая
прогресс выполнения кодирования/декодирования от 0 до 100%.

Кодирование/декодирование больших документов может занимать значительное
время даже при использовании быстрой машины и быстрых дисков. Поэтому
приятно иметь такую возможность показывать процесс выполнения. Для
реализации вам нужно создать обработчик события.

Обработчик состоит из двух частей, сигнализатора и обработчика события.
Сигнализатор должен быть уверен, что компонент в состоянии  принять
сообщение определенного типа и сгенерировать событие. Обработчик события
с другой стороны начинает работать только при поступлении события.

Сигнализатор типично виртуальный или динамический метод самого класса
(подобно методу Click) или сообщению Windows, такому как оповещение
(notification) или callback сообщения. Обработчик события типично
присваивается свойству, такому как OnClick, OnChange или  OnProgress.
Если обработчик события опубликован, то конечный пользователь компонента
может написать любой код для обработки события.

1.1.9. Обработчики событий

Обработчики события методы объекта. Это означает, что они должны быть
методами класса, а не обычной процедурой или функцией (первый параметр
должен быть Self). Для наиболее употребимых обработчиков предназначен
следующий тип:

TNotifyEvent = procedure(Sender: TObject) of object;

Тип TNotifyEvent для обработчиков, в которые передается только один
параметр sender. Эти события просто оповещают компонент о возникновении
специфического события у объекта sender. Например, OnClick, типа
TNotifyEvent, указывает органу, что произошло событие click у
конкретного органа. Если бы параметр Sender отсутствовал, то мы бы знали
только, то, что произошло определенное событие, но не знали бы у какого
органа. Обычно нам требуется знать, у какого конкретно органа произошло
данное событие, что бы мы могли работать с этим органом или его
данными..

Как было указано ранее, Обработчики событий присваиваются свойствам типа
событие (event), и они появляются как отдельная закладка в инспекторе
объектов (Object Inspector), для различения их от обычных свойств.
Основой для помещения этого свойства на закладку события является то,
что они должны быть типа "procedure/function of Object". Фраза "of
Object" обязательна, иначе мы получим сообщение об ошибке "cannot
publish property".

Компоненту TUUCode требуется событие типа TProgressEvent. Данному
событию реально не требуется параметр sender (это всегда можно добавить
позже), но ему необходим процент выполнения операции, для цели опишем
следующий прототип:

TProgressEvent = procedure(Percent: Word) of object;

1.1.10. Сигнализаторы событий

Сигнализаторы событий требуются для указания обработчику события, что
возникло указанное событие, что бы обработчик события смог бы выполнить
свои действия. Сигнализаторы обычно виртуальные или динамические методы
класса (подобно методу Click) или сообщения Windows, такие как callback
ил notification сообщения.

В случае с компонентом TUUCode, сигнализатор интегрирован
непосредственно в метод UUCode. После кодирования каждой строки,
вызывается обработчик события назначенный OnProgress, реализация этого
следующая:

if Assigned(FOnProgress) then

FOnProgress(trunc((100.0 * Size) / OutputBufSize))

Где Size это текущий размер или позиция в выходном буфере, и
OutputBufSize это размер выходного файла. Size увеличивается от нуля до
OutputBufSize, что означает, что обработчик события FOnProgress
вызывается с аргументом от 0 до 100.

1.1.11. Регистрация компонента

При регистрации компонента TUUCode, полезно добавить редактор свойства
FileName (InputFile), что обеспечит дополнительный комфорт для конечного
пользователя. Редактор этого свойства реализован в модуле UUReg, который
регистрирует компонент TUUCode в палитре компонентов Дельфи.

    unit UUReg;
     interface
     {$IFDEF WIN32}
       {$R UUCODE.D32}
     {$ELSE}
       {$R UUCODE.D16}
     {$ENDIF}
     uses
       DsgnIntf;
     type
       TFileNameProperty = class(TStringProperty)
       public
         function GetAttributes: TPropertyAttributes; override;
         procedure Edit; override;
       end;
     
     procedure Register;
     
     implementation
     uses
       UUCode, Classes, Dialogs, Forms, SysUtils;
     
       function TFileNameProperty.GetAttributes: TPropertyAttributes;
       begin
         Result := [paDialog]
       end {GetAttributes};
     
       procedure TFileNameProperty.Edit;
       begin
         with TOpenDialog.Create(Application) do
         try
           Title := GetName; { name of property as OpenDialog caption }
           Filename := GetValue;
           Filter := 'All Files (*.*)|*.*';
           HelpContext := 0;
           Options := Options +
                     [ofShowHelp, ofPathMustExist, ofFileMustExist];
           if Execute then SetValue(Filename);
         finally
           Free
         end
       end {Edit};
     
       procedure Register;
       begin
         { component }
         RegisterComponents('DrBob42', [TUUCode]);
         { property editor }
         RegisterPropertyEditor(TypeInfo(TFilename), nil,
                               'InputFile', TFilenameProperty);
       end {Register};
     end.

 

Если вы желаете использовать компонент TUUCode  в составе, какого либо
пакета, то вы должны поместить компонент UUCode в пакет времени
выполнения (runtime package), и модуль UUReg в пакет разработки
(design-time), который требует пакет времени выполнения. В
действительности, для использования пакетов вы можете использовать
UUCode Wizard из следующей главы в пакет времени разработки и сделать
его доступным в IDE Delphi для всех пользователей!

1.1.12. UUCode Example Wizard

Для показа прогресса 16-битный пример использует TGauge компонент, в то
же время 32-битная версия использует Windows 95 Progress Control.

Во время исполнения программы могут возникнуть два исключения. Если
входной файл пуст и во время кодирования, если выходной файл пуст. Для
16 битной версии может возникнуть третье исключение, если входной или
выходной файл больше 65000 байт (16-битная версия данного компонента
может обрабатывать входные и выходные файлы до 64 килобайт). На практике
это означает, не может быть более 48 килобайт. 32-битная версия не имеет
такого ограничения).

1.1.13. Заключение

В этой главе мы рассмотрели uuencode/uudecode, xxencode/xxdecode, и
Base64 алгоритмы кодирования/декодирования. Мы также разработали простой
VCL компонент, который поддерживает эти алгоритмы в дополнение к
простому копированию. Свойства, методы и события делают данный компонент
пригодным для построения Интернет приложений нуждающихся в подобном
преобразовании.

Компонент TBUUCode сейчас часть пакета "DrBob42 component package for
Delphi and C++Builder".

 

Интернет решения от доктора Боба (http://www.drbob42.com)

(c) 2000, Анатолий Подгорецкий, перевод на русский язык
(http://nps.vnet.ee/ftp)

 

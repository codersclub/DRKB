---
Title: PGPSDK - легкий путь к шифрованию
Author: Евгений Дадыков
Date: 01.01.2007
---


PGPSDK - легкий путь к шифрованию
==================================

Иногда бывает нужно прикрутить к своей программе какое-нибудь
шифрование. Для этих целей разработаны кучи алгоритмов шифрования,
дешифрования, электронной подписи и т.п., основанных на различных
математических аппаратах. Мало того - необходимо реализовать этот
алгоритм. Но мы как кульные программеры не будем этого делать - а
возьмем готовую библиотеку PGPsdk. Я не буду повторять классиков [2],
что для реальных приложений использовать самодельные шифры не
рекомендуется, если вы не являетесь экспертом и не уверены на 100
процентов в том, что делаете. Отговаривать же Вас от разработки
собственных шифров или реализации какого-либо стандарта тоже не суть
этой статьи, здесь пойдет речь о том, как быстро и правильно реализовать
в своих приложениях защиту от посторонних глаз и, самое главное - не
обмануться.

В моем приложении уже использовалось шифрование от PGP, ДОСовская,
работало через командные файлы (\*.bat), что явилось весомым аргументом
для выбора средства шифрования, все работало, но меня это не устраивало:
ДОСовская версия PGP (5.0) затрудняла инсталляцию программы,
поддержку и не имеет некоторых полезных вещей, нужных для расширения
системы в будущем. Еще чем привлекала PGP - бесплатная для
некоммерческих программ, генерация произвольного количества ключей и то
что пакет PGP очень популярен и им пользуются большое количество людей,
и Вам легко будет решить проблему защиты информации от посторонних глаз
в своих приложениях и по моему защита с помощью PGP дает большое
преимущество.

## Небольшая справка по PGP:

Pretty Good Privacy (PGP) выпущено фирмой Phil\'s Pretty Good Software и
является криптографической системой с высокой степенью секретности для
операционных систем MS-DOS, Unix, VAX/VMS и других. PGP позволяет
пользователям обмениваться файлами или сообщениями с использованием
функций секретности, установлением подлинности, и высокой степенью
удобства. Секретность означает, что прочесть сообщение сможет только
тот, кому оно адресовано. Установление подлинности позволяет установить,
что сообщение, полученное от какого-либо человека было послано именно
им. Нет необходимости использовать секретные каналы связи, что делает
PGP простым в использовании программным обеспечением. Это связано с тем,
что PGP базируется на мощной новой технологии, которая называется
шифрованием с "открытым ключом".

## Поддерживаемые алгоритмы:

- Deiffie-Hellman
- CAST
- IDEA
- 3DES
- DSS
- MD5
- SHA1
- RIPEMD-160

## Реализуемые функции

- Шифрование и аутентификация (с использованием перечисленных алгоритмов);
- Управление ключами (создание, сертификация, добавление/удаление из
  связки, проверка действительности, определения уровня надежности);
- Интерфейс с сервером открытых ключей (запрос, подгрузка, удаление и
  отзыв ключа с удаленного сервера);
- Случайные числа (генерация криптографически стойких псевдослучайных
  чисел и случайных чисел, базируясь на внешних источниках);
- Поддержка PGP/MIME;
- Вспомогательные функции.

## Обзор существующих библиотек

Первое что я сделал - сходил на torry.ru и был удивлен обилием
библиотек и функций для разного рода шифрования. Функциональность их я
проверять не стал, а остановился на PGP-пишных компонентах.

PGPComp - ДОСовская, работает по принципу запуска внешнего exe-файла,
сразу отпала по той причине - что нужно будет устанавливать MSDOS версию
PGP (Кроме того библиотека только под 1 и 2 Delphi). Вспомнил что в моей
любимой почтовой программе The Bat встроена поддержка PGP, зашел на их
сайт - скачал библиотеку dklib.dll, любезно предоставленную ими, но
почему-то у меня ни один из примеров не пошел, а за отсутствием
исходников, я не мог понять почему. Пробовал обраться к автору - в ответ
тишина, уже больше года не отвечает он. А неплохая библиотека, по
крайней мере по тому что написано в документации присутствует тот
необходимый минимум функций для шифрования-дешифрования, проверки ключа
и сама библиотека весит не очень много - 184\'832 Байт.

Т.е. меня не устроили эти библиотеки и я пошел на http://www.pgpi.org, в
поисках истины. Нашел там упоминание про библиотеку для разработчиков -
**PGPsdk**.

## Собственно сам PGPsdk

28 октября 1997 г. PGP, Inc. объявила о поставке PGPsdk сторонним
производителям программного обеспечения. PGPsdk - это средство
разработки для программистов на С, позволяющее разработчикам
программного обеспечения встраивать в него стойкие криптографические
функции. Можно сказать что в PGPsdk реализованы все функции пакета PGP,
мало того - версия PGP начиная с 5.0 хранит криптографические функции в
динамических библиотеках - dll (о том насколько это не безопасно -
вопрос к Крису Касперски, я лишь скажу что насколько я силен в
математике).

PGPsdk - это динамическая библиотека, состоящая из трех файлов [табл. 1],
поддерживающая базовые алгоритмы криптования (перечислены выше),
гибкое управление ключами, сетевой интерфейс и др. (можно использовать
одну библиотеку - PGP\_sdk.dll, если Вы не будите использовать фирменный
интерфейс пользователя от NAI и сетевую библиотеку).

### Установка

Скачайте архив с PGPsdk [9], на момент написания статьи доступна
версия 1.7.2 (должен заметить что архив занимает 3 с лишним мегабайт),
необходимо его разархивировать и из каталога \\Libraries\\DLL\\Release
взять следующие файлы - табл. 1

Табл.1

| PGP\_SDK.dll | для криптования, управление ключами и т.д.
| PGPsdkUI.dll | (UI= user interface) интерфейсные штучки, если Вам нужно будет только шифровать/расшифровывать, то этот файл необязателен. Но очень полезен для ввода пароля, выбора получателей сообщений, генерации ключей и другое. |
| PGPsdkNL.dll | (NL= network library) сетевая библиотека для работы с сервером ключей или для transport layer security. Ее мы рассматривать не будем, но в ближайшем будущем я попытаюсь ее описать. |

Собственно распространять Вам приложение придется с этими файлами,
подложить их необходимо или в системный каталог WINDOWS или в каталог
вместе с приложением - механизм стандартный как и для всех dll, главное
чтоб библиотеку было видно Вашему приложению.

Переходим к делу.

Для работы система предоставляет ряд низкоуровневых PGP API (Application
Programmig Interface) функций. Заголовки (хеадеры, описания) этих
функций поставляются вместе с пакетом на Ц и лежат в каталоге Headers.
Если Вы как и я пишите на Delphi, можете сами сконвертировать их, а
можете взять готовые тут [10]. Это проект по переводу Ц-ных хеадеров
на любимый мною язык программирования. Занимается всем этим делом Стивен
Хейлер (Steven R. Heller ).

Описатели переведены на Delphi по принципу как это сделано для Ц -
разбросаны на кучи модулей (листинг 1). Все названия модулей аналогичны
Ц-ным заголовкам, за исключением pgpEncode - переименовано в
pgpEncodePas, из-за особенностей объявления в Delphi (нельзя чтоб имя
процедуры совпадало с названием модуля).

Листинг 1. Объявление используемых библиотек.

    uses
      // PGPsdk
      pgpEncodePas, pgpOptionList, pgpBase, pgpPubTypes,
      pgpUtilities, pgpKeys, pgpErrors,
      // always last
      pgpSdk;

Единственная трудность, которая возникает на пути включения криптования
в Ваше приложение - это использование слишком уж низкоуровневых PGP API
функций. Для того что бы сделать какую-нибудь операцию - будь то подсчет
публичных ключей в связке или просто зашифровать файл - необходимо
создавать контекст, указать где находятся ключи, создать фильтр ключей,
подготовить файловые дескрипторы, если с памятью - выделить ее (в случае
шифрования-/-расшифрования), затем все это в обратном порядке освободить
(если контекст неправильно освобождается - файлы с резервными ключиками
не удалятся). И все это при том что в системном каталоге WINDOWS
создается файл, в котором содержится информация где находятся файлы с
публичными и секретными ключами (о нем будет подробно сказано ниже). Для
сравнения работы через PGP API предоставлен листинг2.

Листинг 2. Пример использования PGPsdk через PGP API

    var
      context: pPGPContext;
      keyFileRef: pPGPKeySet;
      defaultKeyRing: pPGPKeySet;
      foundUserKeys: pPGPKeySet;
      filter: pPGPFilter;
      countKeys: PGPUInt32;
      keyFileName: PChar;
      userID: PChar;
      inFileRef,
        outFileRef: pPGPFileSpec;
      inFileName,
        outFileName: PChar;
    begin
      // Init от C++
      context := nil;
      keyFileName := 'pubring.pgp';
      userID := '';
      inFileName := 'myInFile.txt';
      outFileName := 'myOutFile.txt.asc';
     
      // Begin
      PGPCheckResult('sdkInit', PGPsdkInit);
     
      PGPCheckResult('PGPNewContext',
        PGPNewContext(
        kPGPsdkAPIVersion,
        context
        ));
     
      PGPCheckResult('PGPNewFileSpecFromFullPath',
        PGPNewFileSpecFromFullPath(
        context,
        keyFileName,
        keyFileRef
        ));
     
      PGPCheckResult('PGPOpenKeyRing',
        PGPOpenKeyRing(
        context,
        kPGPKeyRingOpenFlags_None,
        keyFileRef,
        defaultKeyRing
        ));
     
      PGPCheckResult('PGPNewUserIDStringFilter',
        PGPNewUserIDStringFilter(context, userID, kPGPMatchSubString, filter));
     
      PGPCheckResult('PGPFilterKeySet',
        PGPFilterKeySet(defaultKeyRing, filter, foundUserKeys));
     
      // Открываем файловые манипуляторы
      PGPCheckResult('PGPNewFileSpecFromFullPath',
        PGPNewFileSpecFromFullPath(context, inFileName, inFileRef));
     
      PGPCheckResult('PGPNewFileSpecFromFullPath',
        PGPNewFileSpecFromFullPath(context, outFileName, outFileRef));
     
      //
      // А вот здесь уже идет кодирование.
      //
      PGPCheckResult('PGPEncode',
        PGPEncode(
        context,
        [
        PGPOEncryptToKeySet(context, foundUserKeys),
          PGPOInputFile(context, inFileRef),
          PGPOOutputFile(context, outFileRef),
          PGPOArmorOutput(context, 1),
          PGPOCommentString(context, PChar('Comments')),
          PGPOVersionString(context,
            PChar('Version 5.0 assembly by Evgeny Dadgoff')),
          PGPOLastOption(context)
          ]
          ));
     
      //
      // Освобождаем занимаемые ресурсы и контекст PGP
      //
      if (inFileRef <> nil) then
        PGPFreeFileSpec(inFileRef);
      if (outFileRef <> nil) then
        PGPFreeFileSpec(outFileRef);
      if (filter <> nil) then
        PGPFreeFilter(filter);
      if (foundUserKeys <> nil) then
        PGPFreeKeySet(foundUserKeys);
      if (defaultKeyRing <> nil) then
        PGPFreeKeySet(defaultKeyRing);
      if (keyFileRef <> nil) then
        PGPFreeKeySet(keyFileRef);
      if (context <> nil) then
        PGPFreeContext(context);
      PGPsdkCleanup;
    end;

Здесь реализован пример из [9] со страницы 39. Функция PGPCheckResult
позаимствована у Стивена из его примеров - принимает два параметра -
строковую и код выполнения функции PGP API, если была ошибка -
генерируется исключение и на экран выводится описание ошибки с именем
функции (Очень помогает для ловли ошибок, а при вызове dll-библиотеки,
тем более написанной на другом языке - помогает избавиться от Access
violation).

Листинг 3. Функция PGPCheckResult.

    procedure PGPCheckResult(const ErrorContext: shortstring; const TheError:
      PGPError);
    var
      s: array[0..1024] of Char;
    begin
      if (TheError <> kPGPError_NoError) then
      begin
        PGPGetErrorString(TheError, 1024, s);
        if (PGPGetErrorString(TheError, 1024, s) = kPGPError_NoError) then
          raise exception.create(ErrorContext + ' [' + IntToStr(theError) + '] : ' +
            StrPas(s))
        else
          raise exception.create(ErrorContext +
            ': Error retrieving error description');
      end;
    end;

Там же у Стивена я нашел еще один проект - написанная на Delphi
библиотека для VB, проект под названием SimplePGP (SPGP). Дело в том,
что VB не может использовать библиотеку PGPsdk из-за ограничения
импортирования библиотек dll [9, раздел FAQ]. Сам Стивен предложил мне
добавить к проекту еще одну dll, тем самым забыть про PGP API, и
использовать облегченную модель вызова функций криптований.

Сам интерфейс к доступу функциям выполнен не плохо, продуманно и вызов
их не должен вызвать затруднений у Вас.

Открыв ее я подумал - а не убрать ли мне все эти "stdcall;export;" и
просто присоединить библиотеку к ехе-файлу (ну не устраивает меня
хитросплетение dll). Сказано сделано.

Итак, поехали!

Создадим подкаталог для объявления функций PGPsdk, скопировав туда
файлики DELPHI PGP API - pgp*.pas и spgp*.pas. Удалим в файлах
spgp*.pas - "stdcall;export;"(уже полученные в итоге заголовочные
файлы можно взять тут [12]. Теперь к Вашему проекту нужно приписать
использование библиотек (это там где uses):

    uses
      // PGPsdk
      pgpEncodePas, pgpOptionList, pgpBase, pgpPubTypes,
      pgpUtilities, pgpKeys, pgpErrors,
      // SPGP
      spgpGlobals, spgpEncrypt, spgpKeyUtil, spgpUtil, spgpKeyMan,
      spgpPreferences, spgpKeyProp, spgpKeyIO, spgpKeyGen, spgpMisc,
      spgpUIDialogs,
      // always last
      pgpSdk;

Можно использовать только необходимые модули.

Первое что мы попробуем сделать - это зашифровать и подписать
произвольный файл и получить зашифрованный в текстовом виде (ASC). Здесь
следует отметить что PGPsdk может работать не только с файлами, но и с
памятью, а также комбинировать - память - файл, файл - память.

    PGPCheckResult
    (
      'Ошибка при шифровании файла',
      spgpencodefile(
      PChar(edtFileIn.Text),
      PChar(edtFileOut.Text),
      1, // Encrypt.Value
      1, // Sign.Value
      kPGPHashAlgorithm_MD5,
      0,
      kPGPCipherAlgorithm_CAST5,
      1,
      0,
      0,
      'Steven R. Heller', // Кто может расшифровать
      'Evgeny Dadgoff', // Чем подписывать
      'MyPassPhrase', // Хех, это пароль
      '',
      PChar(edtComment.Text)
      )
    );

Сравним что получится если переделать пример [9,стр. 18] на Delphi -
на чистом API.

Лично для меня проще было использовать spgp-модель чем тяжелые PGPAPI
вызовы.

### Про преференс

Для работы библиотеке необходимо знать где лежат файлы с ключиками
(pubring.prk и secring.prk). PGP API позволяет сохранять свои настройки
в файле PGPsdk.dat (почему то он всегда сохраняется в каталоге с
виндами). Для работы с этим файлом предназначены следующие функции:

    spgpgetpreferences(Prefs: pPreferenceRec; Flags: Longint):LongInt;
    spgpsetpreferences(Prefs: pPreferenceRec; Flags: Longint):LongInt;

Соответственно для получения преференса и установки его (кстати ключики
могут лежать не только в файлах). Замечу что это не единственный способ -
PGP API позволяет напрямую указывать где расположены ключи, но тогда
Вам придется отказаться от SPGP, или поправлять SPGP под себя.

### Как получить список всех имеющихся ключей

Здесь я покажу как получить список всех ключей - заполнение
LVKeys:TListView именами ключей и шестнадцатеричными ID-значениями
ключей, используя SPGP-модель.

    var
      P: TPreferenceRec;
      Flags: LongInt;
      outBuf: array[1..30000] of Char;
      i, KeyCount: Integer;
      TempStr, StrKeys: AnsiString;
    begin
      LVKeys.Items.Clear;
      FillChar(P, 1024, 0);
      FillChar(outbuf, 30000, 0);
      Flags := PGPPrefsFlag_PublicKeyring or
        PGPPrefsFlag_PrivateKeyring or
        PGPPrefsFlag_RandomSeedFile;
      if (spgpGetPreferences(@P, Flags) <> 0) then
        ShowEvent('Error!', 1);
      // GetWindowsDirectory
      if (LowerCase(WinDir + 'pubring.pkr') = LowerCase(StrPas(P.PublicKeyring))) or
        not (FileExists(StrPas(P.PublicKeyring))) then
      begin
        StrPCopy(P.PublicKeyring, ExtractFilePath(Application.ExeName) +
          'KEYS\pubring.pgp');
        StrPCopy(P.PrivateKeyring, ExtractFilePath(Application.ExeName) +
          'KEYS\secring.pgp');
        StrPCopy(P.RandomSeedFile, ExtractFilePath(Application.ExeName) +
          'KEYS\randseed.bin');
        if (CreateDir(ExtractFilePath(Application.ExeName) + 'KEYS')) then
          ShowEvent('Каталог ключей ' + ExtractFilePath(Application.ExeName) + 'KEYS'
            +
            ' -- не существует, Будет создан заново... ', 0);
        spgpSetPreferences(@P, Flags);
     
        //Создать файлы с ключами - такой хитрый прием.
        spgpSubKeyGenerate('mmmh', 'sssl', 'ssss', 1, 1024, 0, 0, 0, 0);
      end;
      btnPubKeys.Caption := StrPas(P.PublicKeyring);
      btnSecKeys.Caption := StrPas(P.PrivateKeyring);
      btnRndBin.Caption := StrPas(P.RandomSeedFile);
      PGPCheckResult('Ошибка при инициализации PGP-SDK, убедитесь что все DLL
        установленны правильно', Init(FContext, PubKey, false, false));
      spgpKeyRingID(@outBuf, 30000);
      KeyCount := spgpkeyringcount;
      StrKeys := StrPas(@outBuf);
      for i := 1 to KeyCount do
      begin
        TempStr := Copy(StrKeys, 1, Pos(#13 + #10, StrKeys));
        Delete(StrKeys, 1, Pos(#13 + #10, StrKeys) + 1);
        with (LVKeys.Items.Add) do
        begin
          Caption := Copy(TempStr, 14, Length(TempStr) - 14);
          SubItems.Add(TempStr[1]);
          SubItems.Add(Copy(TempStr, 3, 10));
        end;
      end;
      QuitIt(FContext, PubKey);
    end;

### Про то, как вычисляется размер зашифрованного текста.

Не всегда можно предположить какой размер будет выходного шифрованного
текста, а функции проводящие преобразование требуют что бы память под
него была уже выделена (разработчики PGPsdk почему-то это не
предусмотрели), и если памяти не хватает - возникает исключение о
нехватки памяти. Мною опытным путем была установлена формула для
вычисления размера блока:

    outBufLen := inBufLen * 5;
    if (outBufLen < 10000) then
      outBufLen := 10000;
    outBufRef := StrAlloc(outBufLen);

### Временные ключики

В процессе работы программы появляются резервные файлы ключей, имеющие
следующий вид - (pub\|sec)ring-bak-##.pgp - предусмотрен откат от
изменений. В принципе, если Вы правильно используете контекст и
правильно его закрываете, этот файл корректно удаляется при освобождение
контекста. Но на всякий случай можно его удалять следующим образом
(повесить можно на закрытие формы или вызывать принудительно):

    procedure DeleteBakPGPFiles;
    var
      P: TPreferenceRec;
      FileSearch: string;
      SearchRec: TSearchRec;
    begin
      spgpGetPreferences(@P, PGPPrefsFlag_PublicKeyring or
        PGPPrefsFlag_PrivateKeyring);
      FileSearch := P.PublicKeyring;
      Insert('-bak-*', FileSearch, Pos('.', FileSearch));
      FindFirst(FileSearch, faAnyFile, SearchRec);
      if (SearchRec.Name <> '') then
        if not (DeleteFile(ExtractFilePath(FileSearch) + SearchRec.Name)) then
          ShowEvent('Not delete file::' +
            ExtractFilePath(FileSearch) + SearchRec.Name, 0);
      while (FindNext(SearchRec) = 0) do
        if not (DeleteFile(ExtractFilePath(FileSearch) + SearchRec.Name)) then
          ShowEvent('Not delete file::' +
            ExtractFilePath(FileSearch) + SearchRec.Name, 0);
      FindClose(SearchRec);
    end;

### Интерфейс пользователя

PGP\_sdkUI.dll - это библиотека пользовательских интерфейсов, фирменные
штучки от Network Associates, использовав их у Вас будут диалоги такие
же как у фирменного пакета PGP. Вам уже не нужно будет строить диалоги
самому:

- Для Генерации ключей;
- При выборе получателей сообщений;
- При запросе пароля и т.п.

## Вывод:

Если Вы читаете эту статью - то Вы наверное уже знаете где в своих
приложениях можно применить криптование, PGP это позволит сделать
быстро, надежно, открыто и самое главное - переносимо. Но я могу
посоветовать еще одно применение - это защита Ваших программ от
несанкционированного копирования. Зашить открытый ключ в exe-файл, и
рассылать секретный, нужным людям. Вот тут то и появляется поле для
простора.

### Перечень функций SPGP

      { spgpDecrypt - decryption & signature verification functions            }
      function spgpdecode(BufferIn, BufferOut: PChar; BufferOutLen: LongInt; Pass,
        SigProps: PChar): LongInt;
      function spgpdecodefile(FileIn, FileOut, Pass, SigProps: PChar): LongInt;
      function spgpdetachedsigverify(SigFile, SignedFile, SigProps: PChar):LongInt;
     
      { spgpEncrypt - encryption & signing functions                           }
      function spgpencode(BufferIn, BufferOut: PChar; BufferOutLen: LongInt;
               Encrypt, Sign, SignAlg, ConventionalEncrypt, ConventionalAlg, Armor,
               TextMode, Clear: LongInt; CryptKeyID, SignKeyID, SignKeyPass,
               ConventionalPass, Comment: PChar): LongInt;
      function spgpencodefile(FileIn, FileOut: PChar; Encrypt, Sign, SignAlg,
               ConventionalEncrypt, ConventionalAlg, Armor, TextMode,
               Clear: LongInt; CryptKeyID, SignKeyID, SignKeyPass, ConventionalPass,
               Comment: PChar): LongInt;
     
      { spgpFeatures - functions to determine PGPsdk version and availability  }
      { of PGPsdk features                                                     }
      function spgpsdkapiversion: Longint;
      function spgppgpinfo(Info: pPGPInfoRec): LongInt;
      function countkeyalgs: LongInt;
      function countcipheralgs: LongInt;
     
      { spgpKeyGen - key-generation functions                                  }
      function spgpkeygenerate(UserID, PassPhrase, NewKeyHexID: PChar;
               KeyAlg, CipherAlg, Size, ExpiresIn, FastGeneration, FailWithoutEntropy,
               WinHandle: Longint): LongInt; 
      function spgpsubkeygenerate(MasterKeyHexID, MasterKeyPass, NewSubKeyHexID: PChar;
               KeyAlg, Size: Longint; ExpiresIn, FastGeneration, FailWithoutEntropy,
               WinHandle: Longint): LongInt;
     
      { spgpKeyIO - Key import/export functions                                }
      function spgpkeyexport(pKeyID,BufferOut: PChar;BufferOutLen,ExportPrivate,
        ExportCompatible: LongInt):LongInt;
      function spgpkeyexportfile(pKeyID,FileOut: PChar; ExportPrivate,ExportCompatible:
        LongInt):LongInt;
      function spgpkeyimport(BufferIn,KeyProps: PChar; KeyPropsLen: LongInt):LongInt;
      function spgpkeyimportfile(FileIn,KeyProps: PChar; KeyPropsLen: LongInt):LongInt;

## Список используемой литературы и интернет ресурсы

- Владимир Жельников "Криптография от папируса до компьютера" М:ABF, 1996
- Tatu Ylonen "Introduction to Cryptography" <http://www.cs.hut.fi/ssh/crypto/intro.html>
- Брюс Шнайер "Прикладная криптография" <http://www.ssl.stu.neva.ru/psw/crypto/appl_rus/appl_cryp.html>
- [https://www.ssl.stu.neva.ru/psw/crypto.htm](https://www.ssl.stu.neva.ru/psw/crypto.htm)
- <https://pgp2all.org.ru/>
- <https://www.pgpi.org/cgi/download.cgi?filename=pgp50ibi.zip>
- <ftp://ftp.no.pgpi.org/pub/pgp/sdk/>
- PGP Software Developer\'s Kit "PGPsdk, Reference Guide Version 1.7"
- PGP Software Developer\'s Kit "PGPsdk, Users Guide Version 1.7"
- <https://www.oz.net/~srheller/dpgp/sdk/>
- <https://www.oz.net/~srheller/spgp/>
- <https://mymesi.pp.ru/programs/keyprop.zip>
- <https://delphiworld.narod.ru/>

---
Title: Таблицы строк
Date: 01.01.2007
Source: Советы по Delphi от [Валентина Озерова](mailto:webmaster@webinspector.com) Сборник Kuliba
---

Таблицы строк
=============

Ресурсы в виде таблиц строк (Stringtable) являются очень полезным
подспорьем, когда ваше приложение должно хранить большое количество
строк для их вывода во время выполнения приложения. Вы должны побороть
искушение непосредственной вставки строк в вашу программу, поскольку
использование таблиц строк имеет два неоспоримых преимущества:

1) Строки, хранимые в ресурсах, не занимают память до тех пор, пока они
не будут загружены вашим приложением.

2) Stringtables легко редактировать, создавая таким образом
локализованные (переведенные) версии вашего приложения.

Таблицы строк компилируются в ".res"-файл, который включается в
exe-файл приложения во время сборки. Даже после того, как вы
распространите ваше приложение, таблицы строк, содержащиеся в вашем
приложении могут редактироваться редактором ресурсов. Моим любимым
редактором ресурсов является Borland Resource Workshop, поставляемый в
комплекте с Delphi. Он позволяет в режиме WYSIWYG редактировать как 16-,
так и 32-битные ресурсы, как автономные, так и имплантированные в exe
или dll-файлы. Тем более это удобно, если учесть что вместе со всеми
версиями Delphi поставляется компилятор
ресурсов из командной строки (Borland Resource Command Line Compiler)
(BRCC.EXE и BRCC32.EXE), расположенный в Delphi-директории Bin.

В нашем примере мы создадим интернациональное приложение, отображающее
всего две кнопки. Кнопки будут иметь заголовки "Да" и "Нет", имеющие
представления для английского, испанского и шведского языков.

Если вы вознамерились создавать мультиязыковые приложения с помощью
Delphi, вам просто необходимо взглянуть на другие продукты фирмы
Borland - Delphi Translation Suite и Language Pack software.
Данные продукты позволяют изменять язык приложения одним щелчком!

**Пример:**

Для начала в каталоге с исходным кодом приложения мы должны
создать текстовый файл, содержащий строковые ресурсы. Пока вы можете
создать файл с любым именем (главное, чтобы он имел расширение ".rc")
и файл без разширения - главное, чтобы их имя не совпадало с именами
файлов модулей и

файла проекта. Это очень важно, поскольку Delphi автоматически создает
множество файлов с ресурсами для вашего приложения с теми же именами и
переписывает их, не заботясь о наличии таких же файлов, но созданных
вашими руками.

Вот содержание .rc-файла для нашего примера. Файл содержит слова "Yes"
и "No" на английском, испанском и шведских языках:

    STRINGTABLE
    {
      1, "&Yes"
      2, "&No"
      17, "&Si"
      18, "&No"
      33, "&Ja"
      34, "&Nej"
    }

Файл начинается с ключевого слова stringtable, обозначая, что следом
располагается таблица строк. Сами строки находятся внутри скобок, таким
образом таблица должна быть обрамлена двумя скобками -
открывающей и закрывающей. Каждая строка должна содержать идентификатор,
сопровождаемый строкой,
заключенной в кавычки. Строка может содержать вплоть до 255 символов.
Если вам нужно вставить
нестандартный символ, напишите его восьмиричный код и предварите его
обратной косой чертой.

Единственное исключение - когда вам нужно вставить саму обратную черту -
в этом случае понадобиться
использование двух таких символов. Вот два примера:

1. "A two012line string"
2. "c:\\BorlandDelphi"

Используемый номер индекса абсолютно не важен для компилятора. Вы должны
иметь в виду, что таблицы
строк располагаются в памяти в 16 битных сегментах (Win 3.xx).

Для компиляции .rc-файла в .res-файл, который можно прилинковать к
вашему приложению, вы должны
набрать в командной строке полный путь к компилятору ресурсов и полный
путь к компилируемому .rc-файлу. Вот пример:

    c:\Delphi\Bin\brcc32.exe c:\Delphi\strtbl32.rc

После окончания процесса компиляции в указанном каталоге появляется файл
с тем же именем, что и у .rc-файла, но имеющий расширение ".res".

Для включения ресурсов в ваше приложение необходимо в коде программы
добавить следующую директиву
компилятора, указывающую на файл с ресурсами:

    {$R ResFileName.RES}

После того, как .res-файл прилинкуется к приложению, вы можете
воспользоваться связанными ресурсами из любого модуля вашего проекта,
даже если вы определили директиву `$R` в секции реализации
(implementation) другого модуля.

Вот пример использования Windows API функции LoadString() для загрузки в
массив символов третьей строки из таблицы строк:

    if LoadString(hInstance, 3, @a, sizeof(a)) <> 0 then ....

В этом примере функция LoadString() передает дескриптор (hInstance)
модуля, содержащего ресурс,
индекс требуемой строки, адрес массива символов, куда будет передана
строка и размер самого массива.

Функция LoadString возвращает количество реально переданных символов без
учета терминатора. Будьте
внимательны: при использовании UNICODE количество загружаемых байт будет
другим.

Ниже приведен исчерпывающий пример создания многоязыкового приложения с
помощью Delphi. Приложение совместимо как с 16, так и с 32-битными версиями Delphi.

Для этого вам придется создать два идентичных .rc-файла, один для
16-битной версии, второй для
32-битной, т.к. используемые ресурсы для каждой платформы свои.

В данном примере мы создадим один файл с именем STRTBL16.rc,
а другой с именем STRTBL32.rc.

Скомпилируйте файл STRTBL16.rc с помощью
16-битного компилятора BRCC.exe (расположен в каталоге BIN Delphi 1) и
файл STRTBL32.rc с помощью
BRCC32.exe (расположен в той же директории 32-битной версии Delphi).

Во время работы приложения мы выясняем язык операционной системы,
установленный по умолчанию.

Метод получения такой информации отличается для 16- и 32-битной версии Windows.
Чтобы сделать код более читабельным, мы позаимствовали "языковые" константы из файла
Windows.pas, применяемого в 32-битной версии Delphi.

    {$IFDEF WIN32}
      {$R STRTBL32.RES}
    {$ELSE}
      {$R STRTBL16.RES}
      const LANG_ENGLISH = $09;
      const LANG_SPANISH = $0a;
      const LANG_SWEDISH = $1d;
    {$ENDIF}
     
     
    function GetLanguage : word;
    {$IFDEF WIN32}
    {$ELSE}
     
      var
        s : string;
        i : integer;
    {$ENDIF}
    begin
    {$IFDEF WIN32}
      GetLanguage := GetUserDefaultLangID and $3ff;
    {$ELSE}
     
      s[0] := Char(GetProfileString('intl', 'sLanguage', 'none', @s[1], sizeof(s)-2));
      for i := 1 to length(s) do
        s[i] := UpCase(s[i]);
      if s = 'ENU' then GetLanguage := LANG_ENGLISH else
      if s = 'ESN' then GetLanguage := LANG_SPANISH else
      if s = 'SVE' then GetLanguage := LANG_SWEDISH else
        GetLanguage := LANG_ENGLISH;
    {$ENDIF}
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    var
      a : array[0..255] of char;
      StrTblOfs : integer;
    begin
      {Получаем текущий язык системы и начало соответствующих строк в таблице}
      case GetLanguage of
        LANG_ENGLISH : StrTblOfs := 0;
        LANG_SPANISH : StrTblOfs := 16;
        LANG_SWEDISH : StrTblOfs := 32;
      else
        StrTblOfs := 0;
      end;
     
      {Загружаем и устанавливаем заголовок кнопки "Yes" в соответствии с языком}
      if LoadString(hInstance, StrTblOfs + 1, @a, sizeof(a)) <> 0 then
        Button1.Caption := StrPas(a);
     
      {Загружаем и устанавливаем заголовок кнопки "No" в соответствии с языком}
      if LoadString(hInstance, StrTblOfs + 2, @a, sizeof(a)) <> 0 then
        Button2.Caption := StrPas(a);
    end; 


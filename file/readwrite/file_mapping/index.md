---
Title: Отображение файлов в память
Date: 01.01.2007
Source: http://www.delphi.h5.ru/
---


Отображение файлов в память
===========================

Для работы с файлом динамической подкачки страниц виртуальной памяти в
windows 32 используется механизм отображения файлов в адресное
пространство приложения. Соответствующие функции api доступны любому
приложению и могут применяться к любому файлу (кстати, таким способом
загружаются в адресное пространство процесса исполняемые файлы и dll). В
результате отображения приложение может работать с файловыми данными как
с размещенными в динамической памяти. В большинстве случаев такая
возможность не только повышает скорость работы с данными, но и
предоставляет программисту уникальные средства обработки сразу всех
записей файла. Например, он может с помощью единственного оператора
проверить, входит ли заданный образец поиска в какую-либо строку
текстового файла.

Отображение файла осуществляется в три приема. Вначале файл создается
обращением к функции:

    function filecreate (filename: string): integer;

или открывается с помощью:

    function fileopen (const filename: string; mode: longword): integer;

В обеих функциях filename - имя файла, возможно, с маршрутом доступа.
Параметр mode определяет режим доступа к файлу и может принимать одно из
следующих значений: fmopenread - только чтение; fmopenwrite - только
запись; fmopenreadwrite - чтение и запись. С помощью операции or эти
константы можно комбинировать с одной из следующих нескольких функций,
регулирующих совместный доступ к файлу: fmshareexclusive - совместный
доступ запрещен; fmsharedenywrite - другим приложениям запрещается
запись; fmsharedenyread - другим приложениям запрещается чтение;
fmscharedenynone - совместный доступ неограничен. Обе функции
возвращают дескриптор созданного (открытого) файла или 0, если операция
оказалась неудачной.

На втором этапе создается объект отображения в память. Для этого
используется функция:

    function createfilemapping (
                   hfile: thandle;
                   lpfilemappingattributes: psecurityattributes;
                   flprotect,
                   dwmaximumsizehigh,
                   dwmaximumsizelow: dword;
                   lpname: pchar
             ): thandle;

Здесь hfile - дескриптор файла; lpfilemappingattributes - указатель
на структуру, в которой определяется, может ли создаваемый объект
порождать дочерние объекты (обычно не может - nil); flprotect -
определяет тип защиты, применяемый к окну отображения файла (см. об этом
ниже); dwmaximumsizehigh, dwmaximumsizelow - соответственно старшие и
младшие 32 разряда числа, содержащего размер файла (если вы будете
отображать файлы длиной до 4 Гбайт, поместите в dwmaximumsizehigh 0,
если в dwmaximumsizelow - длину файла; а если оба параметра равны 0,
то размер окна отображения равен размеру файла); lpname - имя объекта
отображения или nil.

Параметр flprotect задает тип защиты, применяемый к окну просмотра
файла, и может иметь одно из следующих значений: page\_readonly - файл
можно только читать (файл должен быть создан или открыт в режиме
fmopenread); page\_readwrite - файл можно читать и записывать в него
новые данные (файл открывается в режиме fmopenreadwrite);
page\_writecopy - файл открыт для записи и чтения, однако обновленные
данные сохраняются в отдельной защищенной области памяти (отображенные
файлы могут разделяться приложениями, в этом режиме каждое приложение
сохраняет изменения в отдельной области памяти или участке файла
подкачки); файл открывается в режиме fmopenreadwrite или fmopenwrite;
(этот тип защиты нельзя использовать в windows 95/98). С помощью
операции or к параметру flprotect можно присоединить такие атрибуты:
sec\_commit - выделяет для отображения физическую память или участок
файла подкачки; sec\_image - информация об атрибутах отображения
берется из образа файла; sec\_nocashe - отображаемые данные не
кэшируются и записываются непосредственно на диск; sec\_reserve -
резервируются страницы раздела без выделения физической памяти.

Функция возвращает дескриптор объекта отображения или 0, если обращение
было неудачным.

Наконец, на третьем этапе создается окно просмотра, то есть собственно
отображение данных в адресное пространство программы.

    function mapviewoffile(
                  hfilemappingobject: thandle;
                  dwdesiresaccess: dword;
                  dwfileoffsethigh,
                  dwfileiffsetlow,
                  dwnumberofbytestomap: dword
             ): pointer;

Здесь hfilemappingobject - дескриптор объекта отображения;
dwdesiresaccess - определяет способ доступа к данным и может иметь
одно из следующих значений: file\_map\_write - разрешает чтение и
запись (при этом в функции createfilemapping должен использоваться
атрибут page\_readwrite); file\_map\_read - разрешает только чтение (в
функции createfilemapping должен использоваться атрибут page\_readonly
или page\_readwrite); file\_map\_all\_access - то же, что и
file\_map\_write; file\_map\_copy - данные доступны для записи и
чтения, однако обновленные данные сохраняются в отдельной защищенной
области памяти (в функции createfilemapping должен использоваться
атрибут page\_writecopy); dwfileoffsethigh, dwfileiffsetlow -
определяют соответственно старшие и младшие разряды смещения от начала
файла, начиная с которого осуществляется отображение;
dwnumberofbytestomap - определяет длину окна отображения (0 - длина
равна длине файла). Функция возвращает указатель на первый байт
отображенных данных или nil, если обращение к функции оказалось
безуспешным.

После использования отображенных данных ресурсы окна отображения нужно
освободить функцией:

    function unmapviewoffile(lpbaseaddress: pointer): bool;

единственный параметр обращения к которой должен содержать адрес первого
отображенного байта, то есть адрес, возвращаемый функцией mapviewoffile.
Закрытие объекта отображения и самого файла осуществляется обращением к
функции:

    function closehandle(hobject: thandle).

В листинге 3 приводится текст модуля (file­­inmemory.dpr), который
создает окно.

Листинг 3

    unit unit1; 
     
    interface 
     
    uses 
      windows, messages, sysutils, classes, graphics, controls,
      forms, dialogs, stdctrls, comctrls, spin; 
     
    type 
      tform1 = class(tform) 
        btmem: tbutton; 
        btfile: tbutton; 
        se: tspinedit; 
        label1: tlabel; 
        pb: tprogressbar; 
        label2: tlabel; 
        lbmem: tlabel; 
        lbfile: tlabel; 
        procedure btmemclick(sender: tobject); 
        procedure btfileclick(sender: tobject); 
        private 
        { private declarations } 
        public 
        { public declarations } 
      end; 
     
    var 
      form1: tform1; 
     
    implementation 
     
    {$r *.dfm} 
     
    procedure tform1.btmemclick(sender: tobject); 
    // Создание файла методом его отображения 
    type 
      preal = ^real; 
    var 
      hfile, hmap: thandle; 
      adrbase, adrreal: preal; 
      k: integer; 
      fsize: cardinal; 
      begtime: tdatetime; 
    begin 
      begtime := time; // Засекаем время пуска 
      // Готовим progressbar: 
      pb.max := se.value; 
      pb.position := 0; 
      pb.show; 
      fsize := se.value * sizeof(real); // Длина файла 
      hfile := filecreate('test.dat'); // Создаем файл 
      if hfile = 0 then // Ошибка: возбуждаем исключение 
        raise exception.create('Ошибка создания файла'); 
      try 
        // Отображаем файл в память 
        hmap := createfilemapping(hfile, nil, page_readwrite, 0, fsize, nil); 
        if hmap = 0 then // Ошибка: возбуждаем исключение 
          raise exception.create('Ошибка отображения файла'); 
        try 
          // Создаем окно просмотра: 
          adrbase := mapviewoffile(hmap, file_map_write, 0, 0, fsize); 
          if adrbase = nil then // Ошибка: возбуждаем исключение 
            raise exception.create('Невозможно просмотреть файл'); 
          // Сохраняем начальный адрес для правильной ликвидации 
          // окна просмотра: 
          adrreal := adrbase; 
          for k := 1 to se.value do 
          begin 
            adrreal^ := random; // Помещаем в файл новое число 
            // Перед наращиванием текущего адреса необходимо 
            // привести его к типу integer или cardinal: 
            adrreal := pointer(integer(adrreal) + sizeof(real)); 
            lbmem.caption := inttostr(k); 
            pb.position := k; 
            application.processmessages; 
          end; 
          // Освобождаем окно просмотра: 
          unmapviewoffile(adrbase) 
        finally 
          // Освобождаем отображение 
          closehandle(hmap) 
        end

      finally 
        // Закрываем файл 
        closehandle(hfile) 
      end;

      // Сообщаем время счета 
      pb.hide; 
      lbmem.caption := timetostr(time-begtime) 
    end; 
       
    procedure tform1.btfileclick(sender: tobject); 
    // Создание файла обычным методом 
    var 
      f: file of real; 
      k: integer; 
      begtime: tdatetime; 
      r: real; // Буферная переменная для обращения к write 
    begin 
      begtime := time; // Засекаем начальное время счета 
      // Готовим progressbar: 
      pb.max := se.value; 
      pb.position := 0; 
      pb.show; 
      // Создаем файл: 
      assignfile(f, 'test.dat'); 
      rewrite(f); 
      for k := 1 to se.value do 
      begin 
        r := random; // Параметрами обращения к write 
        write(f, r); // могут быть только переменные 
        lbfile.caption := inttostr(k); 
        pb.position := k; 
        application.processmessages; 
      end; 
      closefile(f); 
      pb.hide; 
      lbfile.caption := timetostr(time-begtime) 
    end; 
     
    end. 

Проект создает дисковый файл, состоящий из 100 тыс. случайных
вещественных чисел (можно выбрать другую длину файла, если изменить
значение редактора Длина массива). Файл с именем test.dat создается
путем отображения файла в память (кнопка Память) и традиционным способом
(кнопка Файл). В обоих случаях показывается время счета. Чем больше
частота процессора и объем свободной оперативной памяти, тем больше
будет разница во времени (листинг 3).


---
Title: RAS API для непродвинутых
Author: Александр Терехов
Date: 01.01.2007
---


RAS API для непродвинутых
=========================

::: {.date}
01.01.2007
:::

Автор: Александр Терехов

Особые благодарности Королеве дельфийского королевства Елене Филипповой,
которая подвигла меня на ваяние сего опуса.

Вместо предисловия

Я не являюсь профессиональным программистом и никогда не писал статьей
по программированию. Поэтому \"продвинутых\" специалистов прошу не
утруждать себя чтением ниже изложенного дабы избежать обструкции по
поводу допущенных мною в настоящей статье ошибок и вольностей.

Итак. Многие из \"непродвинутых\" дельфийцев, пытаясь использовать
интернет-компоненты, сталкиваются с проблемой \"удаленного соединения\"
(\*) . Собственно подключаться не трудно - чаще всего такие компоненты с
помощью системной библиотеки wsock32.dll сами инициализируют подключение
к Интернет по \"удаленному соединению\". Гораздо труднее бывает после
интернет-сессии отключить \"удаленное соединение\". Поэтому на Круглом
столе \"Королевства Дельфи\" с регулярностью наступления \"критических
дней\" появляются вопросы (в том числе и мои):

\"как после \.... завершить соединение по удаленному доступу?\"

А \"продвинутые гуру\" от программирования с завидным постоянством на
них отвечают:

\"смотри Ras API\...\"

Давайте и посмотрим, что такое Ras API и с чем его едят :)

Ras API - Remote Access Service Application Programming Interface.
По-русски: \"интерфейс программирования приложений, использующих службу
удаленного доступа\". Этот интерфейс как раз и служит для соединения по
\"удаленному доступу\", а также отслеживания его состояния, отсоединения
от телефонной линии, создания новых \"удаленных соединений\", изменения
свойств уже созданных \"соединений\" и многого, многого другого. В
библиотеку rasapi32.dll включено 97 экспортируемых функций. Даже в Help
для Дельфи Microsoft любезно включило описание работы с функциями этой
библиотеки. Напечатайте где-нибудь в проекте, например, RasDial и
нажмите F1 - убедитесь сами. Казалось бы в чем проблемы? Ан нет! В
поставке Дельфи нет интерфейсного модуля для работы с этой библиотекой.
Что такое интерфейсный модуль? Это Pascal Unit - \*.pas или \*.dcu, в
котором описаны используемые в DLL константы, типы переменных, функции и
процедуры, порядок обращения к ним и др. Например, Windows.pas (обратите
внимание на самую первую запись, включаемую в клаузу Uses) - это
интерфейсный модуль для системных библиотек kernel32.dll, user32.dll и
gdi32.dll и др., который позволяет Pascal-программам обращаться к
процедурам и функциям этих библиотек.

После некоторого скитания по Интернет мне удалось обнаружить столь
нужный нам всем интерфейсный модуль для rasapi.dll - называется он
RasUnit.pas.

Весь модуль описывать здесь я не буду. Опишу только пять функций,
позволяющих соединиться с Интернет по телефонной линии с помощью модема,
отследить состояние \"удаленного соединения\" и отключиться от
телефонной линии по завершению интернет-сеанса.

1\. Получение сведений о всех зарегистрированных в системе \"удаленных
соединениях\".

Для получения сведений о всех зарегистрированных в системе \"удаленных
соединений\" используется библиотечная функция (\*\*) RasEnumEntries

Рассмотрим работу этой функции. Прежде всего определим переменные:

BuffSize: Integer;

размер массива из AnsiChar, в который будут помещаться cведения об
\"удаленных соединениях\"

Entries: Integer;

количество зарегистрированных \"удаленных соединений\"

Entry : Array\[1..MaxEntries\] of TRasEntryName;

массив состоящий из переменных, в которые будут помещены сведения об
\"удаленных соединениях\", где константа MaxEntries - количество
возможных соединений, TRasEntryName - определение (type) записи
состоящей из двух полей dwSize и szEntryName (определены в RasUnit.pas)

X, Result\_ : Integer;

необходимые процедурные переменные

AllEntries: TStrings;

сюда мы поместим названия \"удаленных соединений\" для дальнейшей работы
с ними

Перейдем к описанию работы функции RasEnumEntries.

1\. Определим размер переменной типа TRasEntryName и инициализируем
переменную Entry, поместив в поле dwSize полученный размер.

    Entry[1].dwSize := SizeOf(TRasEntryName);

2\. Определим размер AnsiChar-массива, в который поместим сведения обо
всех \"удаленных соединениях\"

    BuffSize := SizeOf(TRasEntryName) * MaxEntries;

3\. Вызовем функцию RasEnumEntries в результате чего получим искомые
результаты:

Result\_:=RasEnumEntries(nil, nil, \@Entry\[1\], BuffSize, Entries), где

Result\_- в случае успешного выполнения возвращает 0, в противном случае
получим ERROR\_BUFFER\_TOO\_SMALL (буфер слишком маленький) или
ERROR\_NOT\_ENOUGH\_MEMORY(не хватает памяти).

BuffSize - указанный нами размер AnsiChar-массива.

\@Entry\[1\]- получим указатель на первый элемент массива, в который
поместились необходимые нам сведения.

Entries - получим количество зарегистрированных в системе \"удаленных
доступов\".

Дальше уже просто.

В случае успешного выполнения функции и существования хотя бы одного
зарегистрированного \"удаленного соединения\" заполним нашу переменную

    if (Result_ = 0) and (Entries > 0) then
    begin
      AllEntries := TStringList.Create;
      for X := 1 to Entries do
      begin
        AllEntries.Add(Entry[x].szEntryName);
      end;
     
      {.....здесь мы работает со своей переменной, например,
        помещаем сведения об "удаленных соединениях" в ListBox......}
     
      AllEntries.Free;
    end;

2\. Соединение с интернет-сервером через выбранный \"удаленный доступ\" и
получение статуса соединения

Для соединения с интернет-сервером используются две библиотечные функции
RasGetEntryDialParams и RasDial. Для обработки ошибок, возникших в
процессе соединения, используется еще одна библиотечная функция
RasGetErrorString.

Определим необходимые переменные.

Глобальные:

MyDialParam : TMyDialParam

переменная состояния соединения, где

TMyDialParam = Record

AMsg : Integer; - код сообщения

AState : TRasConnState; - статус соединения (тип переменной определен в
 RasUnit.pas)

AError : Integer; - код ошибки

hRas: ThRASConn

в эту переменную будет помещен handle (так сказать \"ИНН\") \"удаленного
соединения\", к этой переменной будет обращаться функция RasHangUp для
завершения соединения, тип переменной описан в RasUnit.pas

Локальные:

Fp:LongBool

если в \"удаленном доступе\" не указан пароль пользователя, то эта
переменная устанавливается в False и появляется приглашение ввести
пароль, если пароль указан, то переменная устанавливается в True и
приглашение не появляется.

DialParams: TRasDialParams

переменная, в которую будут переданы параметры \"удаленного
соединения\", описывать тип этой переменной я не буду - он хорошо описан
в Win32 Programmer\'s Reference (кто не знает - это один из разделов
Help\'а, поставляемого вместе с Delphi) и определен в RasUnit.pas

AEntryDial:String

переменная, в которую поместим название \"удаленного соединения\"

R: Integer

результат выполнения библиотечных функций

C : Array\[0..100\] of Char

переменная, в которую записывается текст сообщения об ошибке

Кроме переменных необходимо также определить CallBack-процедуру, которая
будет использована в функции RasDial (\*\*\*).

    procedure RasCallBack(msg: Integer;
      state: TRasConnState;
      error: Integer); stdcall
     
    {****}
     
    {где
      msg: Integer - код сообщения
      state: TRasConnState - состояние соединения
      error: Integer - код ошибки}

В этой процедуре передадим глобальной переменной MyDialParam значения
указанных переменных.

    MyDialParam.AMsg := msg;
    MyDialParam.AState := state;
    MyDialParam.AError := error;

А также вызовем функцию GetStatusString (будет описана ниже), которая
сообщит нам в Label1.Caption о состоянии соединения.

    Form1.Label1.Caption := GetStatusString(MyDialParam.AState, MyDialParam.AError);
    Form1.Label1.Update; {на всякий случай}

Все, на этом с CallBack процедурой закончено.

Переходим к описанию процесса подключения к \"удаленному соединения\".

Получим название выбранного нами \"удаленного соединения\"

AEntryDial:=ListBox1.Items.Strings\[ListBox1.ItemIndex\];

Заполним все поля переменной DialParams нолями.

FillChar(DialParams, SizeOf(TRasDialParams), 0);

Инициализируем переменную DialParams и поместим в поле szEntryName этой
переменной название выбранного \"удаленного соединения\"

    With DialParams Do
    Begin
        dwSize:=Sizeof(TRasDialParams);
        StrPCopy(szEntryName, FEntry2Dial);
    End;

Вызовем библиотечную функцию RasGetEntryDialParams, которая заполнит
оставшиеся незаполненными поля переменной DialParams

R:=RasGetEntryDialParams(nil, DialParams, Fp);

Далее, если все удачно (см. значение переменной R), вызываем
библиотечную функцию RasDial, поместив в нее переменную DialParams и
указав на описанную выше CallBack-процедуру RasCallBack. В случае ошибок
в работе функции RasDial вызовем библиотечную функцию обработки ошибок
RasGetErrorString

, которая даст нам текст сообщения об ошибке, и выйдем из процедуры.

    if R = 0 then
    begin
      Application.ProcessMessages; {*****}
      R := RasDial(nil, nil, DialParams, 0, @RasCallback, hRAS);
      if R <> 0 then
      begin
        RasGetErrorString(R, C, 100);
        MessageBox(0, C, 'Ошибка!', MB_OK);
        Exit;
      end;
    end;

6\. На этом все!

Напоследок опишем

Function GetStatusString(State: TRasConnState; Error: Integer): String

которая даст нам состояние соединения. Думаю, что переменные State и
Error уже не требуют объяснения.

    if Error <> 0 then
    begin
      RasGetErrorString(Error, C, 100);
      Result := C;
    end
    else
    begin
      S := '';
      case State of
        RASCS_OpenPort:
          S := 'Opening port';
          // .................................
          // вырезано ....
          // .................................
          RASCS_Disconnected:
          S := 'Disconnected';
      end;
      Result := S;
    end;

Теперь уже совсем все с подключением \"удаленного соединения\" и
получением его статуса!

3\. Завершение удаленного соединения.

Самый распространенный вопрос по рассматриваемой нами теме это -

\"как после \.... завершить соединение по удаленному доступу?\"

После того, что мы уже рассмотрели, ответ на этот вопрос покажется очень
простым - надо вызвать библиотечную функцию RasHangUp с одной
единственной уже описанной нами переменной hRas: ThRASConn.

RasHangUp(hRas)

Удачи!

Интерфейсный модуль RasUnit.pas и проект, использующий рассмотренные
нами функции библиотеки rasapi32.dll, прилагается: Файлы проекта +
RasUnit : RasAPI.zip (23 K)

Примечания:

\* - В настоящей статье под \"удаленным соединением\" подразумевается
подключение к интернет-провайдеру по телефонной сети с помощью модема.

\*\* - Далее под \"библиотечной функцией\" будем понимать функцию
библиотеки rasapi32.dll

\*\*\* - Для не посвященных в дебри программирования от Microsoft.
CallBack-функция - это функция \"обратного вызова\". Служит для
обработки некоторых функций и процедур созданных компанией Microsoft. В
Pascal\'е не применяется. С CallBack-функциями приходится часто
сталкиваться при попытках программирования внутри Delphi на API
(Application Programming Interface - интерфейс программирования
приложений). К чему такие сложности? Не знаю. Возможно это такой стиль
программирования от Microsoft. J Т.к. в нашем примере возвращать никаких
\"CallBack-данных\" не требуется, поэтому вместо CallBack-функции
определим CallBack-процедуру, да простит меня за это Билл Гейтс (кто не
знает - это отец-основатель Microsoft). Библиотечная функция RasDial,
вызывая эту процедуру помещает в переменную state код состояния
соединения.

\*\*\*\* - Stdcall - это способ передачи данных через стек CPU (справа -
налево). Зарезервированное слово stdcall необходимо применять при
обращении к находящимся в DLL (Dynamic Link Library - динамически
подключаемая библиотека) процедурам и функциям, написанных на другом
языке программирования - это из Help\'а. Я однажды забыл указать этот
параметр при обращении к DLL написанной на Pascal и в результате
\"подвесил\" компьютер. Поэтому, всегда при обращении к библиотекам
указывайте - stdcall.

\*\*\*\*\* - Это для того, чтобы в процессе соединения с сервером наше
приложение могло реагировать на сообщения Windows, например, на нажатие
кнопок.

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
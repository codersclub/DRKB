---
Title: Потоки и DLL
Author: Charles Calvert
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Потоки и DLL
============

Приведенный ниже текст подразумевает, что вы обладаете базовыми знаниями
о принципе работы потоков и умеете создавать DLL.

Техническая сторона вопроса будет сфокусирована на потоках и функции
DllEntryPoint. Функция DllEntryPoint не должна объявляться в ваших
Delphi DLL. Фактически, большую часть, если не всю, Delphi DLL будет
правильно работать и без вашего явного объявления DllEntryPoint. Тем не
менее, я включил данный совет для тех Win32-программистов, которые
понимают эту функцию и хотят связать с ней свое функциональное
назначение, чтобы оно являлось частью DLL. Чтобы быть более конкрентым,
это будет интересно тем программистам, которые хотят вызывать одну и ту
же DLL из многочисленных потоков одной программы.

Исходный код данного проекта находится на FTP компании Borland. Данный
код также доступен на Compuserve в секции Borland в виде файла BI42.ZIP.

При первом вызове DLL сначала выполняется секция инициализации,
расположенная в нижней части кода. При загрузке двух модулей, каждый из
которых использует DLL, секция инициализации будет вызвана дважды, для
каждого модуля. Вот пример минимального кода Delphi DLL, который
компилируется, но пока ничего не делает:

    library MyDll;
     
    // Здесь код
    // экспорта
     
    begin
    // Расположенный здесь код выполняется в первую
    // очередь при каждом вызове DLL любым exe-файлом.
    end.

Как вы можете здесь увидеть, здесь нет традиционного DLLEntryPoint,
имеющегося в стандартных C/C++ DLL. Для тех, кто только начал изучать
Win32, я сообщу, что DLLEntryPoint берет начало от функций LibMain и
WEP, работающих в Windows 3.1. LibMain и WEP теперь считаются
устаревшими, вместо них необходимо использовать DLLEntryPoint.

Для явной установки DLLEntryPoint в Delphi, используйте следующий
код-скелет, имеющий преимущество перед переменной DLLProc, объявленной
глобально в SYSTEM.PAS:

    library DllEntry;
     
    procedure DLLEntryPoint(Reason: DWORD);
    begin
    // Здесь организуется блок Case для Dll_Process_Attach, и др.
    end;
     
    // Здесь реализация экспортируемых функций
     
    // экспорт
     
    begin
      if DllProc = nil then begin
        DllProc := @DLLEntryPoint;
        DllEntryPoint(Dll_Process_Attach);
      end;
    end.

Данный код назначает объявленный пользователей метод с именем
DLLEntryPoint объявленной глобально переменной Delphi с именем DllProc,
в свою очередь объявленой в SYSTEM.PAS следующим образом:

    var
      DllProc: Pointer; { Вызывается каждый раз при вызове точки входа DLL }

Вы можете имитировать стандартную функциональность DLLEntryPoint,
вызывая объявленный к тому времени локально DLLEntryPoint, и передавая
ему Dll\_Process\_Attach в качестве переменной. В C/C++ DLL эта
переменная должна передаваться определенной пользователем функции с
именем DllEntryPoint автоматически при первом доступе к DLL из первой
обратившейся к ней программы. В Delphi первый вызов этой функции может
быть произведен вручную пользователем, но последующие вызовы происходят
автоматически до тех пор, пока вы не назначите первый раз функцию
переменной DllProc. Другими словами, вы можете форсировать первый вызов
DllEntryPoint как показано выше, но последующие вызовы будут сделаны
системой автоматически.

Dll\_Process\_Attach - одна из четырех возможных констант, которые
система можете передавать функции DllEntryPoint. Эти константы объявлены
в WINDOWS.PAS следующим образом:

    DLL_PROCESS_ATTACH = 1; // Программа подключается к DLL
    DLL_THREAD_ATTACH = 2;  // Поток программы подключается к DLL
    DLL_THREAD_DETACH = 3;  // Поток "оставляет" DLL
    DLL_PROCESS_DETACH = 0; // Exe "отсоединяется" от DLL

Более детальная скелетная конструкция DllEntryPoint с использованием
приведенных констант:

    procedure DLLEntryPoint(Reason: DWORD);
    begin
      case Reason of
        Dll_Process_Attach:
          MessageBox(DLLHandle, 'Подключение процесса', 'Инфо', mb_Ok);
        Dll_Thread_Attach:
          MessageBox(DLLHandle, 'Подключение потока', 'Инфо', mb_Ok);
        Dll_Thread_Detach:
          MessageBox(DLLHandle, 'Отключение потока', 'Инфо', mb_Ok);
        Dll_Process_Detach:
          MessageBox(DLLHandle, 'Отключение процесса', 'Инфо', mb_Ok);
      end; // case
    end;

В приведенном примере я просто вызываю диалог MessageBox в ответ на
возможные параметры, передаваемые DLLEntryPoint. Тем не менее, вы могли
бы найти более достойное применение данным константам или вовсе
игнорировать их.

**Работа с потоками**

Приведенный ниже небольшой фрагмент кода достоин занять место в
программе, вызывающей DLL. Он показывает как можно объявить функцию,
экспортируемую из DLL, и как вызвать эту функцию из потока. Конечно,
обычно нет необходимости вызывать функцию DLL из потока, я делаю это
просто для того, чтобы показать функциональное назначение, связанное с
обсуждаемыми выше константами Dll\_Thread\_Attach и Dll\_Thread\_Detach.

    function MyFunc: ShortString; external 'DLLENTRY1' name 'MyFunc';
     
    procedure ThreadFunc(P: Pointer); stdcall;
    var
      S: array[0..255] of Char;
    begin
      StrPCopy(S, MyFunc);
      MessageBox(Form1.Handle, S, 'Инфо', mb_Ok);
    end;
     
    procedure TForm1.UseThreadClick(Sender: TObject);
    var
      ThreadID: DWORD;
      HThread: THandle;
    begin
      HThread := CreateThread(nil, 0, @ThreadFunc,
        nil, 0, ThreadID);
      if HThread = 0 then ShowMessage('Нет потоков');
    end;

Приведенный здесь код делится на три секции. В первой декларируется
MyFunc, являющаяся простой реализацией функции в DLL. ThreadFunc сама
располагается в отдельном потоке, создаваемом программой. Процедура
UseThreadClick создает поток. Сразу после создания потока система
вызывает процедуру ThreadFunc.

Вот декларация CreateThread:

    var
     
    DWORD = Integer;
     
    function CreateThread(
    lpThreadAttributes: Pointer; // атрибуты безопасности потока
    dwStackSize: DWORD;          // размер стека для потока
    lpStartAddress: TFNThreadStartRoutine; // функция потока
    lpParameter: Pointer;        // аргумент для нового потока 
    dwCreationFlags: DWORD;      // флаги создания
    var lpThreadId: DWORD):      // Возвращаемый идентификатор потока
    THandle;                     // Возвращаемый дескриптор потока

В нормальной ситуации большинство параметров, передаваемых CreateThread,
могут быть установлены в 0 или nil. Показан типичный пример вызова
данной функции, но во многих случаях использование lpParameter
неоправданно тяжело. Разумеется, любые переменные, установленные в
данном параметре, передаются ThreadFunc в виде единственного аргумента.

Фактически, реализация функции потока очень проста, происходит вызов DLL
и показывается информационный диалог, демонстрирующий строку,
возвращаемую DLL.

Если вы создали программу с потоковой функцией как было показано выше, и
создали DLL с функцией DLLEntryPoint, тоже показанной выше, то можно
получить визуальное подтверждение того, как работает функция
DLLEntryPoint. Поясняю: когда ваша программа загружается в память, DLL
также должна быть автоматически загружена, тем самым вызывая MessageBox
с текстом \`Процесс подключен\'. Диалоги появляются в зависимости от
причины (Reason) вызова функции DllEntryPoint:

    procedure DLLEntryPoint(Reason: DWORD);
    begin
      case Reason of
        Dll_Process_Attach:
          MessageBox(DLLHandle, 'Процесс подключен', 'Инфо', mb_Ok);
        Dll_Thread_Attach:
          MessageBox(DLLHandle, 'Поток подключен', 'Инфо', mb_Ok);
        Dll_Thread_Detach:
          MessageBox(DLLHandle, 'Поток отключен', 'Инфо', mb_Ok);
        Dll_Process_Detach:
          MessageBox(DLLHandle, 'Процесс отключен', 'Инфо', mb_Ok);
      end; // case
    end;

Если вы создали процедуру ThreadFunc, показанную выше, то должно
появиться диалоговое окно (MessageBox) с надписью "Поток подключен".
При завершении работы подпрограммы ThreadFunc появится окошко с надписью
"Поток отключен". Наконец, при закрытии программы должна появиться
надпись "Процесс отключен". Пример, демонстрирующий процесс, доступен
в сети.

Довольно сложно иллюстрировать технические возможности Delphi. Не все
программисты Delphi захотят так глубоко вникать в дебри Windows API. Тем
не менее, те, которые хотят воспользоваться мощью Windows 95 и Windows
NT на полную катушку, могут видеть, что все современные технологии
доступны всем без исключения программистам на Delphi. Приведенный выше
пример доступен в Compuserve в виде файла DLLENT.ZIP и также размещен на
Интернет-сервере Borland по адресу www.borland.com.


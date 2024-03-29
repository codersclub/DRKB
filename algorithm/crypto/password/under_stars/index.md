---
Title: Увидеть пароль, скрытый за звездочками
Date: 01.01.2007
---


Увидеть пароль, скрытый за звездочками
======================================

Вариант 1.

Создание и использование DLL:

Благодаря твоим просьбам и запросам из HackFaq мне приходится отходить
от плана согласованного с главредом. С одной стороны, ты толкаешь меня
под окровавленный кровью авторов Х нож главреда. С другой стороны ты мне
усложняешь жизнь по самые «не хочу». В любом случае, ничего хорошего.
Если так пойдёт и дальше, то на ноже SinTEZа появится моя свежая кровь.
И следующий репортаж о кодинге мне придётся вести уже из морга.

Но что поделаешь. Сегодня мне приходится корректировать свой план и
выполнять твои просьбы. В этом номере обе статьи кодинга построены по
самым многочисленным просьбам.

Эта статья отвечает на наиболее часто задаваемый вопрос из HackFaq: «Как
увидеть пароль спрятанный под звёздочками?». Для этого есть куча разных
прог. Но мы же с тобой совместимые челы, поэтому не юзаем чужие
творения. Вот поэтому мы создадим такую прогу сами. Тем более, что сам
попросил объяснить, как это работает.

Шкодинг:

Для этого примера я написал DLL файл, который будет сейчас расписан
перед твоими глазами. Ничего особо визуального мы сегодня делать не
будем. Только кодинг и ничего больше. Кстати, я уже перешёл на Delphi 6,
так что все исходники теперь будут писаться в нём. Если ты до сих пор
застрял в Delphi 5, то бегом на рынок за свеженьким диском.

Для начала создадим новый проект. Но не тот, который использовали до
этого, а проект DLL библиотеки. Для этого выбирай меню
File-\>New-\>Other ... (для Delphi 5 это просто File-\>New). Перед тобой
откроется окно. Найди здесь пункт DLL Wizard и дважды кликни по нему.
Delphi создаст пустой проект DLL библиотеки. Сразу нажми пимпу «Save»,
чтобы сохранить проект. В качестве имени введи «hackpass», это же и
будет именем dll файла.

Теперь сотри весь текст, который написал Delphi и напиши:

    library hackpass;
     
    uses Windows, Messages;
    var
     SysHook : HHook = 0;
     Wnd : Hwnd = 0;
     
    function SysMsgProc(code : integer; wParam : word;
     lParam : longint) : longint; stdcall;
    begin
     // Передать сообщение другим ловушкам в системе
     CallNextHookEx(SysHook, Code, wParam, lParam);
     // Проверяю сообщение
     if code = HC_ACTION then
     begin
       // Получаю идентификатор окна сгенерировавшего сообщение
       Wnd := TMsg(Pointer(lParam)^).hwnd;
     
       // Проверяю тип сообщения.
       // Если была нажата левая кнопка мыши
       // и удержана кнопка Control, то …
       if TMsg(Pointer(lParam)^).message = WM_LBUTTONDOWN then
         if ((TMsg(Pointer(lParam)^).wParam and MK_CONTROL) = MK_CONTROL) then
         begin
           // Убрать в окне отправившем сообщение зв?здочки
           SendMessage(Wnd, em_setpasswordchar, 0, 0);
           // Перерисовать окно.
           InvalidateRect(Wnd, nil, true);
          end;
      end;
    end;
     
    // Процедура запуска.
    procedure RunStopHook(State : Boolean) export; stdcall;
    begin
     // Если State = true, то...
     if State=true then
     begin
       // Запускаем ловушку.
       SysHook := SetWindowsHookEx(WH_GETMESSAGE,
          @SysMsgProc, HInstance, 0);
     end
     else// Иначе
     begin
       // Отключить ловушку.
       UnhookWindowsHookEx(SysHook);
       SysHook := 0;
     end;
    end;
     
    exports RunStopHook index 1;
     
    begin
    end.

Теория:

Самое основное в нашей DLL - это процедура RunStopHook. Ей передаётся
один только параметр. Если он равен true, то я регистрирую ловушку,
которая будет ловить все сообщения Windows на себя. Для этого
используется функция SetWindowsHookEx. У этой функции четыре параметра:

- Тип ловушки. Я указал WH\_GETMESSAGE, которая ловит все сообщения.
- Указатель на функцию, которой будут пересылаться сообщения Windows.
- Указатель на приложение.
- Идентификатор потока. Если ноль, то используется текущий.

В качестве второго параметра я указал имя функции SysMsgProc. Она так же
описана в этой dll. Давай на неё посмотрим.

Ловушка для сообщений:

В первой строке я передаю пойманное сообщение остальным ловушкам
установленным в системе с помощью CallNextHookEx. После этого я получаю
окно сгенерировавшее событие и проверяю тип события. Если была кликнута
левая кнопка крысы и удержана пимпа Control, то убрать звёздочки.

Я не могу больше останавливаться на этой DLL потому что моя рубрика не
резиновая. Придётся тебе разбираться с происходящим по комментариям.

Юзаем DLL:

Теперь напишем прогу, которая будет загружать DLL и запускать ловушку.
Для этого создай новый проект (такие мы уже создавали). Перейди в
исходник, и найди раздел var. Рядом должно быть написано что-то типа
«Form1: TForm1». Допиши сюда строку:

    procedure RunStopHook(State : Boolean) stdcall; external 'hackpass.dll' index 1;

В этой строке я объясняю Delphi, что есть такая функция RunStopHook,
которая находится в написанной мной библиотеке hackpass.dll и её индекс
= 1. Вот по этому индексу Delphi и будет вызывать функцию. Можно конечно
же и по имени, но это будет немного медленней.

Теперь создай обработчик события для формы OnShow и напиши там:

    RunStopHook(true);

И наконец создай обработчик события OnClose и напиши:

    RunStopHook(false);

Кранты паролям:

Всё наше приложение готово. Запусти его. Потом перейди в окно со строкой
ввода и кликни там левой кнопкой крысы удерживая Control. Звёздочки
моментально превратятся в реальный текст.

Для большего эффекта можешь бросить на форму проги загружающей DLL,
какую-нибудь картинку. Ну а если что-то не понятно, то просто
тренируйся. Со временем всё само придёт. Главное практика.

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

------------------------------------------------------------------------

Вариант 2.

Наверно так: хотя классов может быть больше

    procedure TForm1.Timer1Timer(Sender: TObject);
    var
      Wnd: HWND;
      lpClassName: array[0..$FF] of Char;
    begin
      Wnd := WindowFromPoint(Mouse.CursorPos);
      GetClassName(Wnd, lpClassName, $FF);
      if ((strpas(lpClassName) = 'TEdit') or (strpas(lpClassName) = 'EDIT')) then
        PostMessage(Wnd, EM_SETPASSWORDCHAR, 0, 0);
    end;

**Дополнение от: Mikel**

Здесь проблема: если страница памяти защищена, то её нельзя прочитать
таким способом, но можно заменить PasswordChar(пример: поле ввода пароля
в удаленном соединении)

Взято с Vingrad.ru <https://forum.vingrad.ru>

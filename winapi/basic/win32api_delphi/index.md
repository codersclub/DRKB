---
Title: Как писать Win32 API приложения на Delphi?
Date: 01.01.2007
---


Как писать Win32 API приложения на Delphi?
==========================================

::: {.date}
01.01.2007
:::

Главная пробема, возникающая при написании WinAPI приложений - это
неудобство ручного создания всех окон приложения. Требуется вызывать
функцию CreateWindow для каждого (в том числе и дочернго) окна
программы, а затем еще и менять шрифт в некоторых из них. Лучшим на мой
взгляд выходом из этой ситуации является использование ресурсов
диалоговых окон (dialog box resources) для соэдания всех окон
приложения. В этой статье я расскажу как это делается в Delphi на
примере простоо приложения с одним главным и двумя (модальными) окнами.

Шаг 1. Создание ресурсов диалоговых окон

Для создания ресурсов я использовал редактор ресурсов из состава Borland
C++ 5.02, и поэтому все скриншоты сделаны с него. В Borland Resource
Workshop 4.5 все почти аналогично. Создаем главное окно, вот его код:

    500 DIALOGEX 0, 0, 240, 117
    EXSTYLE WS_EX_DLGMODALFRAME | WS_EX_APPWINDOW | WS_EX_CLIENTEDGE
    STYLE DS_MODALFRAME | DS_3DLOOK | DS_CENTER | WS_OVERLAPPED | WS_VISIBLE | WS_CAPTION | 
    WS_SYSMENU | WS_MINIMIZEBOX
    class "WndClass1"
    CAPTION "Главное окно приложения"
    MENU 300
    FONT 8, "MS Sans Serif", 400, 0
    LANGUAGE LANG_RUSSIAN, 0
    {
    CONTROL "OK", IDOK, "BUTTON", BS_DEFPUSHBUTTON | BS_CENTER | WS_CHILD | WS_VISIBLE | WS_TABSTOP, 
    19, 94, 50, 14, WS_EX_CLIENTEDGE
    CONTROL "Cancel", IDCANCEL, "BUTTON", BS_PUSHBUTTON | BS_CENTER | WS_CHILD | WS_VISIBLE | WS_TABSTOP, 
    96, 94, 50, 14, WS_EX_CLIENTEDGE
    CONTROL "Help", IDHELP, "BUTTON", BS_PUSHBUTTON | BS_CENTER | WS_CHILD | WS_VISIBLE | WS_TABSTOP, 
    172, 94, 50, 14, WS_EX_CLIENTEDGE
    CONTROL "Группа", -1, "button", BS_GROUPBOX | BS_RIGHT | WS_CHILD | WS_VISIBLE | WS_GROUP, 
    20, 9, 100, 76
    CONTROL "Кнопка 1", 105, "button", BS_AUTORADIOBUTTON | WS_CHILD | WS_VISIBLE | WS_TABSTOP, 
    28, 21, 60, 12
    CONTROL "Кнопка 2", 106, "button", BS_AUTORADIOBUTTON | WS_CHILD | WS_VISIBLE | WS_TABSTOP, 
    28, 37, 60, 12
    CONTROL "Кнопка 3", 107, "button", BS_AUTORADIOBUTTON | WS_CHILD | WS_VISIBLE | WS_TABSTOP, 
    28, 53, 60, 12
    CONTROL "ListBox1", 108, "listbox", LBS_NOTIFY | LBS_SORT | LBS_NOINTEGRALHEIGHT | WS_CHILD | 
    WS_VISIBLE | WS_BORDER | WS_TABSTOP, 
    132, 13, 92, 72
    }

Обратите внимание на поле CLASS. В нем должно стоять то же значение, что
и в поле lpszClassName записи TWndClassEx основной программы. В
редакторе ресурсов значение этого поля можно изменить в окне свойств
ресурса. В Borland C++ оно выглядит так:

Два других окна создаются как обычные ресурсы, поэтому их код я здесь не
привожу - вы можете его посмотреть самостоятельно в исходниках (см. в
конце статьи).

Шаг 2. Основная программа

Текст программы в нашем случае несколько отличается от текста, например,
winmin. Регистрация оконного класса:

    wc.cbSize:=sizeof(wc);
    wc.style:=cs_hredraw or cs_vredraw;
    wc.lpfnWndProc:=@WindowProc;
    wc.cbClsExtra:=0;
    wc.cbWndExtra:=DLGWINDOWEXTRA;
    wc.hInstance:=HInstance;
    wc.hIcon:=LoadIcon(hInstance, 'MAINICON');
    wc.hCursor:=LoadCursor(0,idc_arrow);
    wc.hbrBackground:=COLOR_BTNFACE+1;
    wc.lpszMenuName:=nil;
    wc.lpszClassName:='WndClass1';
     
    RegisterClassEx(wc);

Обратите внимание, что в поле cbWindowExtra стоит константа
DLGWINDOWEXTRA, если бы её там не было, нам не удалось бы создать
главное окно, основанное на ресурсе Dialog Box. Кроме того, в поле
lpszClassName стоит то же значение, что и в соответствующем поле
описания ресурса окна.

Итак, класс создан и зарегистрирован, теперь создаем главное окно из
ресурса:

    MainWnd:=CreateDialog(hInstance, '#500', 0, nil);

Напоминаю, что \'\#500\' значит имя ресурса окна. Не забудьте подключить
откомпилированный файл сценария ресурса к программе при помощи директивы

    {$r ...}

Шаг 3. Оконная функция

Оконная функция ничем не отличается от обычной:

    function WindowProc(wnd:HWND; Msg : Integer; Wparam:Wparam;
             Lparam: Lparam): Lresult; stdcall;
    var
      nCode, ctrlID, size: word;
      pt: TPoint;
      s: string;
    begin
      case msg of
      wm_command:
      begin
        nCode:=hiWord(wParam);
        ctrlID:=loWord(wParam);
        case ctrlID of
          IDHELP:
          begin
            DialogBox(hInstance,'#501',wnd,@DialogFunc);
          end;
          IDOK:
          begin
            DialogBoxParam(hInstance,'#503',wnd,@DialogFunc2, Integer(pd));
            s := 'Login: '+pd^.login;
            s := s + ' ' + 'Pass: '+pd^.pass;
            ListBox_AddString(lb, s);
          end;
          IDCANCEL:
          begin
            DestroyWindow(wnd);
          end;
        end;
      end;
     
      wm_destroy :
      begin
        Dispose(pd);
        postquitmessage(0); exit;
        Result:=0;
      end;
      else
        Result := DefWindowProc(wnd, msg, wparam, lparam);
      end;
    end;

Шаг 4. Цикл сбора сообщений

Цикл сбора сообщений следует изменить следующим образом, как при
использовании немодальных диалоговых окон. Можно, правда, оставить все
как есть, но тогда вы не сможете использовать клавиатуру для перемещения
между дочерними окнами, использования кнопок \"по умолчанию\" и т.д.

    while GetMessage(Mesg, 0, 0, 0) do
    begin
      if mainWnd<>0 then
        if IsDialogMessage(mainWnd,Mesg) then
          continue;
      TranslateMessage(Mesg);
      DispatchMessage(Mesg);
    end;

После нажатия кнопки \"ОК\" появляется еще одно окно. Если в нем ввести
текст и нажать \"ОК\", этот текст будет добавлен в Listbox.

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

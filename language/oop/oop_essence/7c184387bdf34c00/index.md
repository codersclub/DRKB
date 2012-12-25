---
Title: Сабклассинг и суперклассинг в Delphi для начинающих
Date: 01.01.2007
---


Сабклассинг и суперклассинг в Delphi для начинающих
===================================================

::: {.date}
01.01.2007
:::

В данной статье я постараюсь рассказать об использовании двух мощных
средств технологии Windows API - сабклассинга и суперклассинга. Все
примеры к статье были составлены мною. Вы найдете их в прикрепленном к
статье файле.

Сабклассинг

Сабклассинг (subclassing) - контроль сообщений окон путем модификации
оконной процедуры последних. Сабклассинг подразумевает использование
изменённой оконной процедуры до оригинальной (а её можно вовсе и не
использовать), позволяя нам создать сколь угодно заготовок оконных
процедур для данного объекта. Хотя на практике обычно используется
только одна.

Оконная процедура

Оконная процедура (window procedure) - специальная функция любого окна,
имеющего дескриптор, которая принимает и обрабатывает все поступающие
окну сообщения (от других программ или от Windows). Оконная процедура
является косвенно вызываемой (callback) пользовательской (user-defined)
функцией. Соответственно, реакцию на сообщения задаёт программист.

Оконная процедура - самое существенное из всего того, что принадлежит
окну, поэтому сабклассинг является очень мощной технологией, необходимой
для полноценной работы с Windows API. Важно уметь правильно обрабатывать
сообщения, чтобы использовать сабклассинг.

Оконная процедура обычно назначается при создании окна, когда
заполняется структура класса последнего TWndClass(Ex).

Оконная процедура имеет такой прототип:

    function XWindowProc(HWnd: THandle; Msg: Cardinal; 
      WParam, LParam: Integer): Integer; Stdcall;

Где X - любой префикс (можно и опустить), по которому можно
идентифицировать

нужную оконную процедуру (например, Edit или New).

Рассмотрим, какие параметры передаются при вызове оконной процедуры. В
параметре HWnd передаётся дескриптор окна, классу которого принадлежит
оконная процедура. В параметре Msg передаётся идентификатор поступившего
сообщения. В параметрах WParam и LParam передаётся дополнительная
информация, которая зависит от типа посланного сообщения.

Возвращаемый функцией результат должен определить программист.

Рекомендуется обрабатывать сообщения через оператор Case:

    case Msg of
      WM_DESTROY:
    end;

Чтобы сообщение не обрабатывалось оригинальной оконной процедурой,
необходимо после своих действий осуществить выход из блока Case:

    case Msg of
      WM_CLOSE:
        begin
          MessageBox(0, 'WM_CLOSE', 'Caption', MB_OK);
          { Осуществляем выход из текущей процедуры }  
          Exit;
        end;
    end; 

Этот способ применяется также для того, чтобы функция DefWindowProc не
обрабатывала сообщение. Данная функция предназначена для выполнения
стандартных действий системы при поступлении очередного сообщения. В
сабклассинге она практически не используется (её роль выполняет
оригинальная оконная процедура, в которой, быть может, и находится вызов
DefWindowProc).

Для вызова оконной процедуры по её адресу используется функция
CallWindowProc. По параметрам она аналогична любой оконной процедуре, но
помимо этого она имеет еще один параметр, определяющий адрес требуемой
оконной процедуры для вызова (параметр первый).

     ...
    { Тип первого параметра представляет собой простой указатель }
    TFarProc = Pointer; 
    TFNWndProc = TFarProc;
    ...
    function CallWindowProc(lpPrevWndFunc: TFNWndProc; HWnd: HWND; Msg: Cardinal;
      WParam: Integer; LParam: Integer): Integer; Stdcall;

Функция CallWindowProc позволяет нам, по сути, менять поведение окна,
ведь мы можем сабклассировать его множество раз с сохранением адресов
оконных процедур, а потом вызывать нужные оконные процедуры по
надобности. Но на практике эта функция используется для вызова одной
оригинальной оконной процедуры окна, которая была до его
сабклассирования.

После детального рассмотрения основ сабклассинга непосредственно
перейдём к его реализации в Delphi.

Примечание

Суперклассинг, как один из видов сабклассинга, будет описан далее
отдельно!

Примечание

Сабклассинг для окон, принадлежащих чужим процессам, в данной статье не
рассматривается! В частности, для начинающих программистов он достаточно
сложен.

Основная функция сабклассирования окна: SetWindowLong. Вообще, эта
функция предназначена для изменения определённого атрибута окна (функция
может изменять атрибут как самого окна, так и атрибут его класса).
Рассмотрим её параметры.

Объявление функции:

     function SetWindowLong(HWnd: HWND; nIndex: Integer;
      dwNewLong: LongInt): LongInt; Stdcall;

Параметр HWnd определяет окно, с которым будет производиться работа.
Параметр nIndex определяет индекс аттрибута, который мы хотим изменить.
Пока нас будут интересовать значения GWL\_WNDPROC и GWL\_USERDATA.
Первый индекс определяет, что изменения затронут оконную процедуру окна,
второй - то, что будет изменена специальная внутренняя четырёхбайтовая
переменная, которой обладает каждое окно. В ней удобно хранить адрес
старой оконной процедуры при сабклассинге.

Рассмотрим, как по шагам засабклассировать окно.

Создаём заготовку новой оконной процедуры;

Помещаем в переменную GWL\_USERDATA адрес старой оконной процедуры;

Изменяем адрес оконной процедуры на новый.

Последние два действия можно объединить в одно, так как функция
SetWindowLong возвращает предыдущее значение изменённого параметра.

Далее я публикую примеры кода, в которых будут рассмотрены способы
сабклассирования окон как средствами VCL, так и средствами WinAPI. Все
примеры кода хорошо комментированы.

Сабклассинг окон на VCL

В VCL на компонентном уровне сабклассинг реализуется достаточно просто и
быстро. Его использование предпочтительней, чем использование
сабклассинга на WinAPI (разумеется, при программировании с VCL) -
всегда, если возможно, делайте сабклассинг именно через VCL. Для
сабклассирования оконного компонента необходимо расширить его
функциональность путём добавления обработчика желаемого сообщения, либо
через перекрытие оконной процедуры компонента.

Ниже приведен пример сабклассирования компонента TEdit таким образом,
чтобы последний не реагировал на вставку текста:

    unit UMain;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes,
      Graphics, Controls, Forms, Dialogs,
      StdCtrls;
     
    type
      TMainForm = Class(TForm)
        procedure FormCreate(Sender: TObject);
        procedure FormDestroy(Sender: TObject);
      private
        { private declarations }
      public
        { public declarations }
      end;
     
      { Новый класс с дополнительным методом,
       который вызвается при сообщении WM_PASTE }
     
      TNewEdit = Class(TEdit)
      protected
        { Обработчик сообщения } 
        procedure WMCopy(var Msg: TWMPaste); Message WM_PASTE;
      end;
     
    var
      MainForm: TMainForm;
      { Экземпляр нового класса }
      Edit: TNewEdit;
     
    implementation
     
    {$R *.dfm}
     
    { TNewEdit }
     
    procedure TNewEdit.WMCopy(var Msg: TWMPaste);
    begin
      { Игнорируем сообщение }
      Msg.Result := 0;
    end;
     
    procedure TMainForm.FormCreate(Sender: TObject);
    begin
      { Создание и размещение компонента на форме }
      Edit := TNewEdit.Create(Self);
      Edit.Parent := Self;
      Edit.Left := 8;
      Edit.Top := 8;
      Edit.Width := MainForm.Width - 23;
      { Следующий метод работать не будет }
      Edit.PasteFromClipboard;
    end;
     
    procedure TMainForm.FormDestroy(Sender: TObject);
    begin
      Edit.Free;
    end;
     
    end. 

Таким образом, чтобы засабклассировать оконный компонент, нужно просто
реализовать свой обработчик сообщений. Есть еще один способ, который
заключается в модификации оконной процедуры компонента на VCL-уровне:

     unit UMain;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes,
      Graphics, Controls, Forms, Dialogs,
      StdCtrls;
     
    type
      TMainForm = Class(TForm)
        procedure FormCreate(Sender: TObject);
        procedure FormDestroy(Sender: TObject);
      private
        { private declarations }
      public
        { public declarations }
      end;
     
      TNewEdit = Class(TEdit)  
      protected
        { Перекрытая оконная процедура компонента }
        procedure WndProc(var Msg: TMessage); Override;
      end;
     
    var
      MainForm: TMainForm;
      { Экземпляр нового класса }
      Edit: TNewEdit;
     
    implementation
     
    {$R *.dfm}
     
    { TNewEdit }
     
    procedure TNewEdit.WndProc(var Msg: TMessage);
    begin
      case Msg.Msg of
        WM_PASTE:
          begin
            Msg.Result := 0;
            { Звуковой сигнал, оповещающий пользователя о
              невозможности вставки текста }
            MessageBeep(0);
            { Выход после обработки необходим, чтобы
              оригинальная оконная процедура не имела
              возможности обработать WM_PASTE; в противном
              случае вставка текста всё равно произойдёт }
            Exit;
          end;
      end;
      { Не забывайте вызывать унаследованную оконную процедуру }
      inherited WndProc(Msg);
    end;
     
    procedure TMainForm.FormCreate(Sender: TObject);
    begin
      { Создание и размещение компонента на форме }
      Edit := TNewEdit.Create(Self);
      Edit.Parent := Self;
      Edit.Left := 8;
      Edit.Top := 8;
      Edit.Width := MainForm.Width - 23;
      { Следующий метод работать не будет }
      Edit.PasteFromClipboard;
    end;
     
    procedure TMainForm.FormDestroy(Sender: TObject);
    begin
      Edit.Free;
    end;
     
    end. 

Этот способ по функциональности ничем не отличается от первого (только
озвучкой).

Вот и всё! Думаю, что Вы разобрались в примерах и мы можем переходить к
сабклассингу средствами Windows API. Ту часть кода примеров, которые не
относятся к теме статьи, я снабдил краткими комментариями.

Сабклассинг окон с помощью Windows API

В следующем примере будет показано, как усовершенствовать кнопку
(Button) и поле ввода (Edit). Вот список усовершенствований:

1\) Для кнопки: создать такую кнопку, которая при нажатии левой кнопки
мыши отображала бы текущую дату;

2\) Для поля ввода: запретить контекстное меню; установить шрифт для
текста синего цвета

Разберем, как это выглядит в теории. Для создания кнопки, отображающей
дату, мы должны получить текущую дату функцией GetLocalTime. В
переданной функции структуре будет находиться текущая дата. Нас
интересует только текущие час, минута и секунда. Мы преобразуем
полученные значения в строковый формат и дополняем нулями слева, если
это необходимо. После этого отображаем дату на кнопке, по срабатыванию
таймера.

Что касается поля ввода, то для запрета контекстного меню необходимо
проигнорировать сообщение WM\_CONTEXTMENU, после чего осуществить выход
из оконной процедуры. Для изменения цвета текста необходимо использовать
функция SetTextColor для контекста Edit\'а. Этот контекст можно
получить, обрабатывая сообщение WM\_CTLCOLOREDIT (обратите внимание, что
это сообщение посылается родительскому окну поля ввода). Данное
сообщение посылается при каждой отрисовке Edit\'а, передавая в параметре
WParam контекст для рисования. Не следует забывать включить прозрачность
фона функцией SetBkMode (хотя для нашего примера эта функция ничего не
изменяет, попробуйте использовать другие цвета, чтобы убедиться в её
надобности).

    program SampleProject03;
     
    {$R *.res}
    {$R WinXP.res} 
     
    uses
      Windows,
      Messages,
      SysUtils;
     
    procedure InitCommonControls; Stdcall; External 'comctl32.dll';  
     
    const
      { Идентификатор таймера }
      BtnTimer = 450;
      { Константы с заголовками дочерних окон }
      StaticInfoText = 'Метка без сабклассирования';
      BtnText = 'Кнопка для сабклассирования';
     
    var
      { Главное окно }
      HWnd: THandle;
      { Три дочерних компонента для сабклассирования }
      Btn, Edit, InfoStatic: THandle;  
     
    { Устанавливает для окна AWindow шрифт для контролов по умолчанию }
    procedure SetDefFont(AWindow: THandle);
    begin
      SendMessage(AWindow, WM_SETFONT, GetStockObject(DEFAULT_GUI_FONT), 1);
    end;
     
    { Косвенно-вызваемая процедура сообщений таймера }
    { Эта процедура выполняется при каждом срабатывании таймера }
    procedure BtnTimerProc(HWnd: THandle; Msg: Cardinal;
      IDEvent, DWTime: Cardinal); Stdcall;
    var
      { Переменная, куда будет помещено текущее время }
      Time: TSystemTime;
      { Для анализа времени }
      Hour, Minute, Second: String;
    begin
      { Получаем время }
      GetLocalTime(Time);
      { Инициализируем переменные }
      Hour := IntToStr(Time.wHour);
      Minute := IntToStr(Time.wMinute);
      Second := IntToStr(Time.wSecond);
      { Добавляем нули при необходимости }
      if Length(Hour) = 1 Then Hour := '0' + Hour;
      if Length(Minute) = 1 Then Minute := '0' + Minute;
      if Length(Second) = 1 Then Second := '0' + Second;
      { Отображаем дату }
      SetWindowText(HWnd, PChar(Hour + ':' + Minute + ':' + Second));
    end;
     
    { Модифицированная оконная процедура поля ввода }
    function EditWinProc(HWnd: THandle; Msg: Cardinal;
      WParam, LParam: Integer): Cardinal; Stdcall;
    begin  
      case Msg of
        { Запрещаем показ контекстного меню }
        WM_CONTEXTMENU:
          begin
            Result := 0;
            MessageBeep(0);
            Exit;
          end;
      end;
     { Не забываем вызвать оригинальную оконную процедуру }
      Result := CallWindowProc(Pointer(GetWindowLong(HWnd, GWL_USERDATA)),
        Hwnd, Msg, WParam, LParam);
    end;
     
    { Модифицированная оконная процедура кнопки }
    function BtnWinProc(HWnd: THandle; Msg: Cardinal;
      WParam, LParam: Integer): Cardinal; Stdcall;
    begin
      case Msg of
        { При нажатии мыши запускаем таймер, интервал - 10 миллисекунд }
        WM_LBUTTONDOWN: SetTimer(HWnd, BtnTimer, 10, @BtnTimerProc);
     
        { При отпускании мыши уничтожаем таймер }
        WM_LBUTTONUP:
          begin
            KillTimer(HWnd, BtnTimer);
            { Восстанавливаем прежний текст }
            SetWindowText(HWnd, BtnText); 
          end;  
      end;
      { Не забываем вызвать оригинальную оконную процедуру }
      Result := CallWindowProc(Pointer(GetWindowLong(HWnd, GWL_USERDATA)),
        HWnd, Msg, WParam, LParam);
    end;
     
    { Оконная процедура главного окна }
    function MainWinProc(HWnd: THandle; Msg: Cardinal;
      WParam, LParam: Integer): Cardinal; Stdcall;
     
      { Конвертирует сроку PChar в String }
      function StrPas(const AStr: PChar): String;
      begin
        Result := AStr;
      end; 
     
    begin  
      case Msg of
     
        { Здесь будет произведено создание дочерних окон }
        WM_CREATE:
          begin
            InfoStatic := CreateWindowEx(0, 'Static', StaticInfoText,
              WS_CHILD Or WS_VISIBLE Or SS_LEFT,
                8, 8, 270, 16, HWnd, 0, HInstance, NIL);
            SetDefFont(InfoStatic);
     
            Edit := CreateWindowEx(WS_EX_CLIENTEDGE, 'Edit', NIL,
              WS_CHILD Or WS_VISIBLE Or ES_LEFT,
              8, 28, 300, 21, HWnd, 0, HInstance, NIL);
            SetDefFont(Edit);
            { Выделяем весь текст }
            SendMessage(Edit, EM_SETSEL, 0, -1);
            { Далее делаем сабклассинг поля ввода }
            SetWindowLong(Edit, GWL_USERDATA,
              SetWindowLong(Edit, GWL_WNDPROC, LongInt(@EditWinProc)));
     
            Btn := CreateWindowEx(0, 'Button', BtnText, WS_CHILD Or WS_VISIBLE
               Or BS_PUSHBUTTON, 8, 52, 300, 25, HWnd, 0,
                 HInstance, NIL);
            SetDefFont(Btn); 
            { Далее делаем сабклассинг кнопки }
            SetWindowLong(Btn, GWL_USERDATA,
              SetWindowLong(Btn, GWL_WNDPROC, LongInt(@BtnWinProc)));
          end;
     
        WM_KEYDOWN:
          { Закрытие окна по нажатию Enter'а }
          if WParam = VK_RETURN Then PostQuitMessage(0);
     
        {Данное сообщение посылается при отрисовке Edit'a;
         вы можете использовать переданный контекст для рисования
         фона, либо для смены цвета текста; после завершения рисования
         верните модифицированный контекст как результат сообщения и не
         забудьте сделать выход из оконной процедуры, так как в противном
         случае DefWindowProc снова разукрасит Edit в стандартный системный цвет }
        WM_CTLCOLOREDIT:
          begin 
            { Устанавливаем прозрачность фона }
            SetBkMode(WParam, TRANSPARENT);
            { Устанавливаем цвет шрифта }
            SetTextColor(WParam, $FF0000);
            { Возвращаем нужный нам контекст }
            Result := WParam;
            Exit;
          end;
     
        WM_DESTROY:
          begin
            { Выход для освобождения памяти }
            PostQuitMessage(0);
          end;
      end;
      { Обработка всех остальных сообщений по умолчанию }
      Result := DefWindowProc(HWnd, Msg, WParam, LParam);
    end;
     
    procedure WinMain;
    var
      Msg: TMsg;
      { Оконный класс }
      WndClassEx: TWndClassEx;
    begin
      { Подготовка структуры класса окна }
      ZeroMemory(@WndClassEx, SizeOf(WndClassEx));
     
      {************* Заполнение структуры нужными значениями ******************* }
     
      { Размер структуры }
      WndClassEx.cbSize := SizeOf(TWndClassEx);
      { Имя класса окна }
      WndClassEx.lpszClassName := 'SubclassSampleWnd';
      { Стиль класса, не окна }
      WndClassEx.style := CS_VREDRAW Or CS_HREDRAW;
      { Дескриптор программы (для доступа к сегменту данных) }
      WndClassEx.hInstance := HInstance;
      { Адрес оконной процедуры }
      WndClassEx.lpfnWndProc := @MainWinProc;
      { Иконки }
      WndClassEx.hIcon :=  LoadIcon(HInstance, MakeIntResource('MAINICON'));
      WndClassEx.hIconSm := LoadIcon(HInstance, MakeIntResource('MAINICON'));
      { Курсор }
      WndClassEx.hCursor := LoadCursor(0, IDC_ARROW);
      { Кисть для заполнения фона }
      WndClassEx.hbrBackground := COLOR_BTNFACE + 1;
      { Меню }
      WndClassEx.lpszMenuName := NIL;
     
      { Регистрация оконного класса в Windows }
      if RegisterClassEx(WndClassEx) = 0 Then
        MessageBox(0, 'Невозможно зарегистрировать класс окна',
          'Ошибка', MB_OK Or MB_ICONHAND)
      Else
      begin
        { Создание окна по зарегистрированному классу }
        HWnd := CreateWindowEx(0, WndClassEx.lpszClassName,
            'Subclassing Sample by Rrader', WS_OVERLAPPEDWINDOW And Not WS_BORDER
             And Not WS_MAXIMIZEBOX And Not WS_SIZEBOX,
             Integer(CW_USEDEFAULT), Integer(CW_USEDEFAULT), 320, 116, 0, 0,
             HInstance, NIL);
     
        if HWnd = 0 Then 
          MessageBox (0, 'Окно не создалось!',
            'Ошибка', MB_OK Or MB_ICONHAND)
        Else
        begin
          { Показ окна }
          ShowWindow(HWnd, SW_SHOWNORMAL);
          { Обновление окна }
          UpdateWindow(HWnd); 
     
          { Цикл обработки сообщений }
          While GetMessage(Msg, 0, 0, 0) Do
          begin
            TranslateMessage(Msg);
            DispatchMessage(Msg);
          end;
          { Выход по прерыванию цикла }
          Halt(Msg.WParam);
        end;
      end;
    end;
     
    begin
      InitCommonControls;
      { Создание окна } 
      WinMain;
    end. 

Все примеры очень простые, они должны дать Вам базовое представление о
сабклассинге.

Теперь можно переходить к суперклассингу.

Суперклассинг

Сабклассинг особенно удобен, когда дело касается изменения одного окна,
класс которого не совпадает с другими окнами, подлежащими
сабклассированию. А что, если нам нужно засабклассировать сотню
Edit\'ов? Сабклассинг здесь будет громоздким. Решением этой проблемы
является суперклассинг.

Суперклассинг (superclassing) - создание и регистрация нового класса
окна в системе. После чего этот класс окна готов к использованию.

VCL-суперклассинг мы рассматривать не будем. Думаю, Вам понятно, что
реализация суперклассинга на VCL - это создание компонентов. При
создании оконного компонента в Delphi вы неявно создаёте подобие
суперкласса. После этого вы можете использовать хоть сотню таких
компонентов (например, создать из них массив). Заметьте, что такой
компонент будет, как правило не стандартным, например, кнопка TBitBtn.
Чтобы Вам было понятней, почему это суперкласс, можете посмотреть имя
класса окна компонента через любой сканер окон (я использовал InqSoft
Window Scanner) - это имя будет совпадать с тем именем, которое
обозначает имя компонента в Delphi (например, TBitBtn или TLabeledEdit).
Из этого мы можем сделать вывод, что суперклассинг прекрасно прижился в
Delphi и широко там используется.

У каждого потомка класса TWinControl в Delphi есть метод CreateParams.
Можете воспользоваться им, чтобы изменить название класса окна.

Гораздо более интересен суперклассинг на WinAPI. Необходимо уметь его
использовать.

Рассмотрим, как по шагам создать суперкласс.

Вызываем функцию GetClassInfoEx, чтобы получить информацию о классе
окна, который мы будем далее модернизировать. Эта функция заполнит
переданную ей запись TWndClassEx параметрами класса;

Изменяем всё, что нам нужно в полученной записи. Нужно задать свое имя
класса, размер структуры, а также дескриптор HInstance, также нас будет
интересовать оконная процедура - мы также изменим её у класса;

Регистрируем новый класс при помощи функции RegisterClassEx;

По окончании работы программы освобождаем класс функцией
UnregisterClass.

Далее новый класс можно использовать. В примерах я буду делать простые
изменения в классах окон.

Давайте рассмотрим функции для суперклассинга более подробно.

Суперклассинг начинается с функции GetClassInfoEx.

Объявление функции:

     function GetClassInfoEx(Instance: Cardinal; Classname: PChar; 
      var WndClass: TWndClassEx): LongBool; Stdcall;

Первый параметр функции - дескриптор приложения, которое создало класс.
Если же Вы желаете модифицировать предопределённые класс окон Windows
(например, классы \'Button\', \'Edit\', \'ListBox\' и т. п.), то
передайте нуль в параметре.

Следующий параметр - собственно название интересующего Вас класса. Сюда
можно передать атом (см. ниже)

В последнем параметре передается структура типа TWndClassEx, в которую в
случае успешного вызова функции будет помещена информация о классе.

Когда информация о классе получена, можно изменить его (что обязательно
к этому, сказано выше).

После подготовки класса окна Вы регистрируете его в Windows с помощью
функции RegisterClassEx.

     function RegisterClassEx(const WndClass: TWndClassEx): Word; Stdcall;

Функция возвращает атом, который по сути есть числовое уникальное
значение. Это будет идентификатор класса окна в системе.

По завершению работы приложения желательно уничтожить класс. В противном
случае - \"утечка памяти\".

Для этого существует функция UnregisterClass:

     function UnregisterClass(lpClassName: PChar; hInstance: Cardinal): LongBool; Stdcall;

Эта функция уничтожает класс окна из Windows, освобождая память, ранее
под него выделенную.

Первый параметр функции - имя класса для деинсталляции. Обратите
внимание, что эта функция сможет уничтожить только класс, который был
зарегистрирован приложением, чей дескриптор передан во втором параметре.
Глобальные предопределённые классы (см. выше) Windows (например, класс
Edit) не могут быть уничтожены. В первом параметре также разрешается
передавать атом-идентификатор класса.

Для полного ознакомления с суперклассингом следует обобщить знания о
самом классе окна.

Класс окна

Вообще, класс окна - объемная тема. Мы рассмотрим её самые главные
особенности.

Класс окна (window class) - набор свойств, который используются как
шаблон для создания окон. Класс окна всегда можно расширить, изменить.
Давайте подробнее разберем атрибуты класса.

Первый атрибут - имя класса. Оно позволяет отличать одни классы от
других. Классы с одинаковыми именами считаются идентичными. После
создания окна по классу это окно может подвергнуться сабклассингу.
Сабклассинг не изменяет класс окна. Не делайте имена классов длиннее 64
символов.

Второй атрибут - это адрес оконной процедуры для окна. Об оконной
процедуре подробно рассказано выше.

Третий атрибут - дескриптор приложения (или DLL), которое
зарегистрировало класс.

Четвёртый - курсор окна при создании.

Пятый - дескриптор большой иконки для окна.

Шестой - тоже дескриптор иконки, но маленькой. Этого атрибута нет у
структуры типа TWndClass (поняли, в чем отличие TWndClass от
TWndClassEx?).

Седьмой - дескриптор кисти, которой будет зарисована клиентская область
окна.

Восьмой - дескриптор меню, которое присваивается окну при создании.

Девятый - стили класса (см. ниже)

Десятый - дополнительная память, выделяемая классу (тип Integer).

Одиннадцатый - дополнительная память (Integer), выделяемая под каждое
окно класса.

Напоследок рассмотрим стили класса. Стили класса - это комбинация
значений, которые определяют поведение класса.

Вот они:

CS\_BYTEALIGNCLIENT - выстраивает клиентскую часть окна на границу
байта, что позволяет достичь большей производительности при отрисовке;

CS\_BYTEALIGNWINDOW - то же, что и CS\_BYTEALIGNCLIENT, только
увеличивает производительность при перемещении окна;  

CS\_CLASSDC - создает контекст устройства, который разделяется между
всеми наследниками этого класса - общий контекст для рисования;  

CS\_DBLCLKS - разрешает обработку сообщений при двойном щелчке мыши;  

CS\_GLOBALCLASS - разрешает создание окон с независимыми
идентификаторами (HInstance) приложений. Создаётся глобальный класс.
Если этот флаг не указан, то значение HInstance при создании окна должно
быть таким же как и при регистрации класса RegisterClass(Ex).

CS\_HREDRAW - перерисовывает окно при его перемещении по горизонтали (и
при изменении горизонтальных размеров);  

CS\_VREDRAW - перерисовывает окно при его перемещении по вертикали (и
при изменении вертикальных размеров);  

CS\_NOCLOSE - убирает команду \"Закрыть\" из системного меню окна;  

CS\_OWNDC - создает уникальный контекст устройства для каждого вновь
создаваемого окна.

На суперклассинг я публикую один пример, в котором на главном окне будет
создано 10 \"измененных\" Edit\'ов. Каждый такой Edit при клике на нём
мышки уничтожит себя сам.

    program SampleProject04;
     
    {$R *.res}
    {$R WinXP.res} 
     
    uses
      Windows, Messages;
     
    procedure InitCommonControls; Stdcall; External 'comctl32.dll';  
     
    var
      { Главное окно }
      HWnd: THandle;
      { Массив Edit'ов }
      Edits: Array[0..9] of THandle;
      { Сюда будет помещено значение оригинальной оконной процедуры класса Edit }
      OldProc: Pointer;
     
    { Устанавливает для окна AWindow шрифт для контролов по умолчанию }
    procedure SetDefFont(AWindow: THandle);
    begin
      SendMessage(AWindow, WM_SETFONT, GetStockObject(DEFAULT_GUI_FONT), 1);
    end;
     
    { Модифицированная оконная процедура каждого поля ввода }
    function EditWinProc(HWnd: THandle; Msg: Cardinal;
      WParam, LParam: Integer): Cardinal; Stdcall;
    begin
      case Msg of
        {Уничтожение Edit'а }
        WM_LBUTTONDOWN: DestroyWindow(HWnd);
      end;
      { Вызов оригинальной оконной процедуры }
      Result := CallWindowProc(OldProc,
        HWnd, Msg, WParam, LParam);
    end;
     
    { Оконная процедура главного окна }
    function MainWinProc(HWnd: THandle; Msg: Cardinal;
      WParam, LParam: Integer): Cardinal; Stdcall;
    var
      TmpEdit: TWndClassEx;
      I: Integer;
    begin
      case Msg of 
        { Здесь будет произведено создание дочерних окон }
        WM_CREATE:
          begin
            { Начало суперклассинга }
            if Not GetClassInfoEx(0, 'Edit', TmpEdit) Then Halt;
            { Запоминаем оконную процедуры для правильной работы окна }
            OldProc := TmpEdit.lpfnWndProc;
            { Модификация класса }
            TmpEdit.cbSize := SizeOf(TWndClassEx);
            TmpEdit.lpfnWndProc := @EditWinProc;
            TmpEdit.lpszClassName := 'Sample04EditWindowClass';
            TmpEdit.hInstance := GetModuleHandle(NIL);
            { Регистрация класса }
            if RegisterClassEx(TmpEdit) = 0 Then Halt;
            { Подготовка массива }
            FillChar(Edits, SizeOf(Edits), 0);
            For I := Low(Edits) To High(Edits) Do
            begin
              Edits[I] := CreateWindowEx(WS_EX_CLIENTEDGE,
                'Sample04EditWindowClass', 'Sample',
                WS_CHILD Or WS_VISIBLE Or ES_LEFT,
                8, 28, 300, 21, HWnd, 0, HInstance, NIL);
              SetDefFont(Edits[I]);   
            end;
          end;
     
        WM_KEYDOWN:
          { Закрытие окна по нажатию Enter'а }
          if WParam = VK_RETURN Then PostQuitMessage(0);
     
        WM_DESTROY:
          begin
            { Уничтожение классов}
            UnregisterClass('Sample04EditWindowClass', HInstance);
            { Выход для освобождения памяти }
            PostQuitMessage(0);
          end;
      end;
      { Обработка всех остальных сообщений по умолчанию }
      Result := DefWindowProc(HWnd, Msg, WParam, LParam);
    end;
     
    procedure WinMain;
    var
      Msg: TMsg;
      { Оконный класс }
      WndClassEx: TWndClassEx;
    begin
      { Подготовка структуры класса окна }
      ZeroMemory(@WndClassEx, SizeOf(WndClassEx));
     
      {************* Заполнение структуры нужными значениями ******************* }
     
      { Размер структуры }
      WndClassEx.cbSize := SizeOf(TWndClassEx);
      { Имя класса окна }
      WndClassEx.lpszClassName := 'SuperclassSampleWnd';
      { Стиль класса, не окна }
      WndClassEx.style := CS_VREDRAW Or CS_HREDRAW;
      { Дескриптор программы (для доступа к сегменту данных) }
      WndClassEx.hInstance := HInstance;
      { Адрес оконной процедуры }
      WndClassEx.lpfnWndProc := @MainWinProc;
      { Иконки }
      WndClassEx.hIcon :=  LoadIcon(HInstance, MakeIntResource('MAINICON'));
      WndClassEx.hIconSm := LoadIcon(HInstance, MakeIntResource('MAINICON'));
      { Курсор }
      WndClassEx.hCursor := LoadCursor(0, IDC_ARROW);
      { Кисть для заполнения фона }
      WndClassEx.hbrBackground := COLOR_BTNFACE + 1;
      { Меню }
      WndClassEx.lpszMenuName := NIL;
     
      { Регистрация оконного класса в Windows }
      if RegisterClassEx(WndClassEx) = 0 Then
        MessageBox(0, 'Невозможно зарегистрировать класс окна',
          'Ошибка', MB_OK Or MB_ICONHAND)
      Else
      begin
        { Создание окна по зарегистрированному классу }
        HWnd := CreateWindowEx(0, WndClassEx.lpszClassName,
            'Superclassing Sample by Rrader', WS_OVERLAPPEDWINDOW And Not WS_BORDER
             And Not WS_MAXIMIZEBOX And Not WS_SIZEBOX,
             Integer(CW_USEDEFAULT), Integer(CW_USEDEFAULT), 320, 116, 0, 0,
             HInstance, NIL);
     
        if HWnd = 0 Then 
          MessageBox (0, 'Окно не создалось!',
            'Ошибка', MB_OK Or MB_ICONHAND)
        Else
        begin
          { Показ окна }
          ShowWindow(HWnd, SW_SHOWNORMAL);
          { Обновление окна }
          UpdateWindow(HWnd); 
     
          { Цикл обработки сообщений }
          While GetMessage(Msg, 0, 0, 0) Do
          begin
            TranslateMessage(Msg);
            DispatchMessage(Msg);
          end;
          { Выход по прерыванию цикла }
          Halt(Msg.WParam);
        end;
      end;
    end;
     
    begin
      InitCommonControls;
      { Создание окна } 
      WinMain;
    end.

Это было базовое знакомство с сабклассингом и суперклассингом. Надеюсь,
материал данной статьи поможет Вам при программировании!

Автор:Rrader

Взято с Vingrad.ru <https://forum.vingrad.ru>
